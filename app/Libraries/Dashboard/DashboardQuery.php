<?php

declare(strict_types=1);

namespace App\Libraries\Dashboard;

use App\DTO\Dashboard\SeriesPoint;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use InvalidArgumentException;

/**
 * Dashboard-only aggregate query layer.
 *
 * Normal record retrieval stays in generated CRUD Models/Entities.
 */
final class DashboardQuery
{
    public function __construct(private ?BaseConnection $db = null)
    {
        $this->db ??= db_connect();
    }

    public function count(
        string $table,
        array $filter = [],
        array $dateRange = [],
        array $globalFilters = []
    ): int {
        $this->assertIdentifier($table);

        $builder = $this->db->table($table);
        $this->applyFilter($builder, $filter);
        $this->applyDateRange($builder, $dateRange);
        $this->applyFilters($builder, $globalFilters);

        return (int) $builder->countAllResults();
    }

    public function aggregate(
        string $table,
        string $field,
        string $operation,
        array $filter = [],
        array $dateRange = [],
        array $globalFilters = []
    ): float {
        $this->assertIdentifier($table);
        $this->assertIdentifier($field);

        $operation = strtoupper($operation);
        if (!in_array($operation, ['SUM', 'AVG', 'MIN', 'MAX'], true)) {
            throw new InvalidArgumentException('Unsupported Dashboard aggregate.');
        }

        $builder = $this->db->table($table);
        $this->applyFilter($builder, $filter);
        $this->applyDateRange($builder, $dateRange);
        $this->applyFilters($builder, $globalFilters);

        $alias = 'dashboard_value';

        match ($operation) {
            'SUM' => $builder->selectSum($field, $alias),
            'AVG' => $builder->selectAvg($field, $alias),
            'MIN' => $builder->selectMin($field, $alias),
            'MAX' => $builder->selectMax($field, $alias),
        };

        $row = $builder->get()->getRowArray();

        return (float) ($row[$alias] ?? 0);
    }

    /**
     * @return list<SeriesPoint>
     */
    public function grouped(
        string $table,
        string $groupField,
        string $operation = 'COUNT',
        string $valueField = '',
        string $dateGroup = 'raw',
        int $limit = 20,
        array $filter = [],
        array $dateRange = [],
        array $globalFilters = []
    ): array {
        $this->assertIdentifier($table);
        $this->assertIdentifier($groupField);

        $operation = strtoupper($operation);
        if (!in_array($operation, ['COUNT', 'SUM', 'AVG', 'MIN', 'MAX'], true)) {
            throw new InvalidArgumentException('Unsupported Dashboard grouped operation.');
        }

        if ($operation !== 'COUNT') {
            $this->assertIdentifier($valueField);
        }

        if (!in_array($dateGroup, ['raw', 'day', 'month', 'year'], true)) {
            $dateGroup = 'raw';
        }

        $builder = $this->db->table($table);
        $this->applyFilter($builder, $filter);
        $this->applyDateRange($builder, $dateRange);
        $this->applyFilters($builder, $globalFilters);

        $groupExpression = $this->groupExpression($groupField, $dateGroup);
        $builder->select($groupExpression . ' AS dashboard_label', false);

        if ($operation === 'COUNT') {
            $builder->select('COUNT(*) AS dashboard_value', false);
        } else {
            $alias = 'dashboard_value';
            match ($operation) {
                'SUM' => $builder->selectSum($valueField, $alias),
                'AVG' => $builder->selectAvg($valueField, $alias),
                'MIN' => $builder->selectMin($valueField, $alias),
                'MAX' => $builder->selectMax($valueField, $alias),
            };
        }

        $builder->groupBy($groupExpression, false);

        if ($dateGroup !== 'raw') {
            $builder->orderBy('dashboard_label', 'ASC', false);
        } else {
            $builder->orderBy('dashboard_value', 'DESC', false);
        }

        $rows = $builder
            ->limit(max(1, min(100, $limit)))
            ->get()
            ->getResultArray();

        $points = [];
        foreach ($rows as $row) {
            $label = $row['dashboard_label'] ?? null;
            $points[] = new SeriesPoint(
                $label === null || $label === '' ? '(empty)' : (string) $label,
                (float) ($row['dashboard_value'] ?? 0)
            );
        }

        return $points;
    }

    private function groupExpression(string $field, string $dateGroup): string
    {
        $protected = $this->db->protectIdentifiers($field);

        if ($dateGroup === 'raw') {
            return $protected;
        }

        $driver = strtolower((string) $this->db->DBDriver);

        if (str_contains($driver, 'mysql')) {
            return match ($dateGroup) {
                'day' => 'DATE(' . $protected . ')',
                'month' => "DATE_FORMAT(" . $protected . ", '%Y-%m')",
                'year' => 'YEAR(' . $protected . ')',
                default => $protected,
            };
        }

        if (str_contains($driver, 'postgre')) {
            return match ($dateGroup) {
                'day' => 'CAST(' . $protected . ' AS DATE)',
                'month' => "TO_CHAR(" . $protected . ", 'YYYY-MM')",
                'year' => "TO_CHAR(" . $protected . ", 'YYYY')",
                default => $protected,
            };
        }

        if (str_contains($driver, 'sqlite')) {
            return match ($dateGroup) {
                'day' => "strftime('%Y-%m-%d', " . $protected . ')',
                'month' => "strftime('%Y-%m', " . $protected . ')',
                'year' => "strftime('%Y', " . $protected . ')',
                default => $protected,
            };
        }

        return $protected;
    }

    private function applyFilters(BaseBuilder $builder, array $filters): void
    {
        foreach ($filters as $filter) {
            if (is_array($filter)) {
                $this->applyFilter($builder, $filter);
            }
        }
    }

    private function applyFilter(BaseBuilder $builder, array $filter): void
    {
        $field = trim((string) ($filter['field'] ?? ''));
        $operator = (string) ($filter['operator'] ?? 'eq');
        $value = $filter['value'] ?? null;

        if ($field === '' || $value === null || $value === '') {
            return;
        }

        $this->assertIdentifier($field);

        match ($operator) {
            'eq' => $builder->where($field, $value),
            'neq' => $builder->where($field . ' !=', $value),
            'gt' => $builder->where($field . ' >', $value),
            'gte' => $builder->where($field . ' >=', $value),
            'lt' => $builder->where($field . ' <', $value),
            'lte' => $builder->where($field . ' <=', $value),
            'contains' => $builder->like($field, (string) $value, 'both'),
            'starts_with' => $builder->like($field, (string) $value, 'after'),
            default => throw new InvalidArgumentException('Unsupported Dashboard filter operator.'),
        };
    }

    private function applyDateRange(BaseBuilder $builder, array $dateRange): void
    {
        $field = trim((string) ($dateRange['field'] ?? ''));
        $from = trim((string) ($dateRange['from'] ?? ''));
        $to = trim((string) ($dateRange['to'] ?? ''));

        if ($field === '') {
            return;
        }

        $this->assertIdentifier($field);

        if ($from !== '') {
            $builder->where($field . ' >=', $from . ' 00:00:00');
        }

        if ($to !== '') {
            $builder->where($field . ' <=', $to . ' 23:59:59');
        }
    }

    private function assertIdentifier(string $identifier): void
    {
        if ($identifier === '' || preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $identifier) !== 1) {
            throw new InvalidArgumentException('Invalid Dashboard SQL identifier.');
        }
    }
}