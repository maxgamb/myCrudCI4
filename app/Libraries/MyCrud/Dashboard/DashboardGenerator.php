<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Dashboard;

use App\Libraries\MyCrud\Core\CrudConfigurationService;
use App\Libraries\MyCrud\Generators\GeneratorTrait;
use RuntimeException;

final class DashboardGenerator
{
    use GeneratorTrait;

    public function generate(array $dashboard, bool $force = false): array
    {
        $name = (string) ($dashboard['name'] ?? 'main');
        $title = (string) ($dashboard['title'] ?? 'Application Dashboard');
        $route = trim((string) ($dashboard['route'] ?? 'dashboard'), '/');
        $globalFilters = $this->resolveGlobalFilters((array) ($dashboard['globalFilters'] ?? []));
        $widgets = $this->resolveWidgets(
            (array) ($dashboard['widgets'] ?? []),
            $globalFilters
        );

        if ($route === '' || preg_match('#^[A-Za-z0-9/_-]+$#D', $route) !== 1) {
            throw new RuntimeException('Invalid Dashboard route.');
        }

        $dashboardCode = var_export([
            'name' => $name,
            'title' => $title,
            'route' => $route,
            'globalDateFilter' => [
                'enabled' => !empty($dashboard['globalDateFilter']['enabled']),
                'label' => trim((string) ($dashboard['globalDateFilter']['label'] ?? 'Period')) ?: 'Period',
            ],
            'globalFilters' => $globalFilters,
            'widgets' => $widgets,
        ], true);

        $files = [];
        $files[] = $this->writeGenerated('Generated/DTO/Dashboard/Kpi.php', $this->kpiDto(), $force);
        $files[] = $this->writeGenerated('Generated/DTO/Dashboard/SeriesPoint.php', $this->seriesDto(), $force);
        $files[] = $this->writeGenerated('Generated/DTO/Dashboard/RecentRecord.php', $this->recentRecordDto(), $force);
        $files[] = $this->writeGenerated('Generated/DTO/Dashboard/DashboardWidget.php', $this->dashboardWidgetDto(), $force);
        $files[] = $this->writeGenerated('Generated/DTO/Dashboard/DashboardData.php', $this->dashboardDataDto(), $force);
        $files[] = $this->writeGenerated('Generated/Libraries/Dashboard/DashboardQuery.php', $this->queryClass(), $force);
        $files[] = $this->writeGenerated('Generated/Services/DashboardService.php', $this->serviceClass($dashboardCode, $widgets), $force);
        $files[] = $this->writeGenerated('Generated/Controllers/DashboardController.php', $this->controllerClass($title), $force);
        $files[] = $this->writeGenerated('Generated/Views/dashboard/index.php', $this->viewFile(), $force);
        $files[] = $this->writeGenerated('Generated/Routes/dashboard.php', $this->routeFile($route), $force);

        return [
            'name' => $name,
            'route' => $route,
            'widgets' => count($widgets),
            'files' => $files,
        ];
    }

    /**
     * @return list<array{id:string,label:string,operator:string,inputType:string}>
     */
    private function resolveGlobalFilters(array $filters): array
    {
        $resolved = [];
        $used = [];

        foreach ($filters as $filter) {
            if (!is_array($filter) || (array_key_exists('enabled', $filter) && empty($filter['enabled']))) {
                continue;
            }

            $id = trim((string) ($filter['id'] ?? ''));
            if (
                $id === ''
                || isset($used[$id])
                || preg_match('/^[A-Za-z][A-Za-z0-9_]*$/D', $id) !== 1
            ) {
                continue;
            }

            $operator = (string) ($filter['operator'] ?? 'eq');
            if (!in_array($operator, ['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'contains', 'starts_with'], true)) {
                $operator = 'eq';
            }

            $inputType = (string) ($filter['inputType'] ?? 'text');
            if (!in_array($inputType, ['text', 'number'], true)) {
                $inputType = 'text';
            }

            $resolved[] = [
                'id' => $id,
                'label' => trim((string) ($filter['label'] ?? '')) ?: $id,
                'operator' => $operator,
                'inputType' => $inputType,
            ];
            $used[$id] = true;
        }

        return array_slice($resolved, 0, 3);
    }

    private function resolveWidgets(array $widgets, array $globalFilters = []): array
    {
        if ($widgets === []) {
            return [];
        }

        $configuration = new CrudConfigurationService();
        $resolved = [];

        foreach ($widgets as $widget) {
            if (!is_array($widget)) {
                continue;
            }

            $table = trim((string) ($widget['table'] ?? ''));
            if ($table === '') {
                continue;
            }

            try {
                $resolvedCrud = $configuration->resolve($table, true);
                if (empty($resolvedCrud['saved'])) {
                    continue;
                }
                $crud = (array) ($resolvedCrud['config'] ?? []);
            } catch (\Throwable) {
                continue;
            }

            $model = trim((string) ($crud['classes']['model'] ?? ''));
            if ($model === '') {
                continue;
            }

            $fieldMap = [];
            $numericFields = [];
            $fieldLabels = [];
            $recentFields = [];
            $dateFields = [];
            $recentRelations = [];

            foreach ((array) ($crud['fields'] ?? []) as $fieldName => $field) {
                $fieldName = (string) ($field['name'] ?? $fieldName);
                if ($fieldName === '' || !empty($field['ui']['sensitive'])) {
                    continue;
                }

                $fieldMap[$fieldName] = true;
                $fieldLabels[$fieldName] = trim((string) ($field['label'] ?? ''))
                    ?: ucwords(str_replace('_', ' ', $fieldName));

                if (!empty($field['ui']['visibleIndex'])) {
                    $recentFields[] = $fieldName;
                }

                $type = strtolower((string) ($field['type'] ?? ''));

                if (in_array($type, ['date', 'datetime', 'timestamp'], true)) {
                    $dateFields[$fieldName] = true;
                }

                if (in_array($type, [
                    'tinyint', 'smallint', 'mediumint', 'int', 'integer', 'bigint',
                    'decimal', 'numeric', 'float', 'double', 'real',
                ], true)) {
                    $numericFields[$fieldName] = true;
                }
            }

            foreach ((array) ($crud['relations']['belongsTo'] ?? []) as $foreignKey => $relation) {
                $foreignKey = (string) $foreignKey;
                if ($foreignKey === '' || !isset($fieldMap[$foreignKey])) {
                    continue;
                }

                $relationLabel = (string) ($fieldLabels[$foreignKey] ?? ucwords(str_replace('_', ' ', $foreignKey)));
                $relationLabel = preg_replace('/\s+Id$/i', '', $relationLabel) ?: $relationLabel;
                $fieldLabels[$foreignKey] = $relationLabel;
                $methodSuffix = str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $foreignKey)));
                $recentRelations[$foreignKey] = [
                    'alias' => (string) ($relation['alias'] ?? ($foreignKey . '__label')),
                    'label' => $relationLabel,
                    'findMethod' => 'find' . $methodSuffix . 'Option',
                ];
            }

            $type = (string) ($widget['type'] ?? 'kpi_count');
            if (!in_array($type, ['kpi_count', 'kpi_aggregate', 'grouped_chart', 'recent', 'quick_link'], true)) {
                $type = 'kpi_count';
            }

            $operation = strtoupper(trim((string) ($widget['operation'] ?? 'COUNT')));
            if (!in_array($operation, ['COUNT', 'SUM', 'AVG', 'MIN', 'MAX'], true)) {
                $operation = 'COUNT';
            }

            $valueField = trim((string) ($widget['valueField'] ?? ''));
            $groupField = trim((string) ($widget['groupField'] ?? ''));
            $chartType = (string) ($widget['chartType'] ?? 'bar');
            if (!in_array($chartType, ['bar', 'line', 'doughnut'], true)) {
                $chartType = 'bar';
            }

            if ($type === 'kpi_aggregate') {
                if ($operation === 'COUNT') {
                    $operation = 'SUM';
                }
                if ($valueField === '' || !isset($numericFields[$valueField])) {
                    continue;
                }
            }

            if ($type === 'grouped_chart') {
                if ($groupField === '' || !isset($fieldMap[$groupField])) {
                    continue;
                }
                if ($operation !== 'COUNT' && ($valueField === '' || !isset($numericFields[$valueField]))) {
                    continue;
                }
                if ($operation === 'COUNT') {
                    $valueField = '';
                }
            }

            if ($recentFields === []) {
                $recentFields = array_slice(array_keys($fieldMap), 0, 4);
            }

            $requestedRecentFields = is_array($widget['recentFields'] ?? null)
                ? $widget['recentFields']
                : [];
            $requestedRecentFields = array_values(array_filter(
                array_map(static fn ($field): string => trim((string) $field), $requestedRecentFields),
                static fn (string $field): bool => $field !== '' && isset($fieldMap[$field])
            ));

            if ($type === 'recent' && $requestedRecentFields !== []) {
                $recentFields = array_values(array_unique($requestedRecentFields));
            }

            $selectedRecentRelations = [];
            if ($type === 'recent') {
                foreach ($recentFields as $recentField) {
                    if (isset($recentRelations[$recentField])) {
                        $selectedRecentRelations[$recentField] = $recentRelations[$recentField];
                    }
                }
            }

            $dateGroup = (string) ($widget['dateGroup'] ?? 'raw');
            if (!in_array($dateGroup, ['raw', 'day', 'month', 'year'], true)) {
                $dateGroup = 'raw';
            }
            if (
                $type !== 'grouped_chart'
                || $groupField === ''
                || !isset($dateFields[$groupField])
            ) {
                $dateGroup = 'raw';
            }

            $filterField = trim((string) ($widget['filterField'] ?? ''));
            $filterOperator = (string) ($widget['filterOperator'] ?? 'eq');
            $filterValue = trim((string) ($widget['filterValue'] ?? ''));

            if (!in_array(
                $filterOperator,
                ['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'contains', 'starts_with'],
                true
            )) {
                $filterOperator = 'eq';
            }

            if ($filterField === '' || !isset($fieldMap[$filterField]) || $filterValue === '') {
                $filterField = '';
                $filterValue = '';
                $filterOperator = 'eq';
            }

            $globalDateField = trim((string) ($widget['globalDateField'] ?? ''));
            if ($globalDateField === '' || !isset($dateFields[$globalDateField])) {
                $globalDateField = '';
            }

            $widgetGlobalFilterFields = is_array($widget['globalFilterFields'] ?? null)
                ? $widget['globalFilterFields']
                : [];
            $resolvedGlobalFilters = [];

            foreach ($globalFilters as $globalFilter) {
                $filterId = (string) ($globalFilter['id'] ?? '');
                $mappedField = trim((string) ($widgetGlobalFilterFields[$filterId] ?? ''));

                if ($filterId === '' || $mappedField === '' || !isset($fieldMap[$mappedField])) {
                    continue;
                }

                $resolvedGlobalFilters[] = [
                    'id' => $filterId,
                    'label' => (string) ($globalFilter['label'] ?? $filterId),
                    'operator' => (string) ($globalFilter['operator'] ?? 'eq'),
                    'inputType' => (string) ($globalFilter['inputType'] ?? 'text'),
                    'field' => $mappedField,
                    'fieldLabel' => (string) ($fieldLabels[$mappedField] ?? $mappedField),
                ];
            }

            $tableLabel = ucwords(str_replace(['_', '-'], ' ', $table));
            $valueLabel = $valueField !== '' ? (string) ($fieldLabels[$valueField] ?? ucwords(str_replace('_', ' ', $valueField))) : '';
            $groupLabel = $groupField !== '' ? (string) ($fieldLabels[$groupField] ?? ucwords(str_replace('_', ' ', $groupField))) : '';
            $operationLabel = match ($operation) {
                'SUM' => 'Total',
                'AVG' => 'Average',
                'MIN' => 'Minimum',
                'MAX' => 'Maximum',
                default => 'Count',
            };

            $automaticTitle = match ($type) {
                'kpi_count' => $tableLabel . ' Count',
                'kpi_aggregate' => trim($operationLabel . ' ' . $valueLabel),
                'grouped_chart' => $operation === 'COUNT'
                    ? trim($tableLabel . ' Count by ' . $groupLabel)
                    : trim($operationLabel . ' ' . $valueLabel . ' by ' . $groupLabel),
                'recent' => 'Recent ' . $tableLabel . ' records',
                'quick_link' => $tableLabel,
                default => $tableLabel,
            };

            $resolved[] = [
                'id' => (string) ($widget['id'] ?? ''),
                'type' => $type,
                'title' => trim((string) ($widget['title'] ?? '')) ?: $automaticTitle,
                'table' => $table,
                'modelClass' => 'App\\Models\\' . $model,
                'modelShort' => $model,
                'primaryKey' => (string) ($crud['primaryKey'] ?? 'id'),
                'operation' => $operation,
                'valueField' => $valueField,
                'groupField' => $groupField,
                'chartType' => $chartType,
                'dateGroup' => $dateGroup,
                'decimals' => max(0, min(4, (int) ($widget['decimals'] ?? ($type === 'kpi_aggregate' ? 2 : 0)))),
                'prefix' => mb_substr(trim((string) ($widget['prefix'] ?? '')), 0, 12),
                'suffix' => mb_substr(trim((string) ($widget['suffix'] ?? '')), 0, 12),
                'filter' => [
                    'field' => $filterField,
                    'label' => $filterField !== '' ? (string) ($fieldLabels[$filterField] ?? $filterField) : '',
                    'operator' => $filterOperator,
                    'value' => $filterValue,
                ],
                'globalDateField' => $globalDateField,
                'globalDateLabel' => $globalDateField !== ''
                    ? (string) ($fieldLabels[$globalDateField] ?? $globalDateField)
                    : '',
                'globalFilters' => $resolvedGlobalFilters,
                'fieldLabels' => $fieldLabels,
                'recentFields' => array_slice(array_values(array_unique($recentFields)), 0, 6),
                'recentRelations' => $selectedRecentRelations,
                'limit' => max(1, min(50, (int) ($widget['limit'] ?? 5))),
                'width' => max(1, min(12, (int) ($widget['width'] ?? 4))),
                'recommendedWidth' => $type === 'recent'
                    ? (count($recentFields) >= 6 ? 12 : (count($recentFields) >= 4 ? 8 : (count($recentFields) >= 3 ? 6 : 4)))
                    : max(1, min(12, (int) ($widget['width'] ?? 4))),
            ];
        }

        return $resolved;
    }

    private function kpiDto(): string
    {
        return <<<'PHP'
<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

final class Kpi
{
    public function __construct(
        public readonly string $label,
        public readonly int|float $value,
        public readonly string $formattedValue
    ) {
    }
}
PHP;
    }

    private function seriesDto(): string
    {
        return <<<'PHP'
<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

/**
 * Generic aggregate point used by grouped statistics and chart widgets.
 */
final class SeriesPoint
{
    public function __construct(
        public readonly string $label,
        public readonly int|float $value
    ) {
    }
}
PHP;
    }

    private function recentRecordDto(): string
    {
        return <<<'PHP'
<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

/**
 * Entity-aware projection used by recent-record Dashboard widgets.
 *
 * The DTO accepts generated Entities, generic objects, or arrays and exposes
 * only the fields selected by the Dashboard configuration.
 */
final class RecentRecord
{
    /** @param array<string,scalar|null> $values */
    public function __construct(
        public readonly int|string|null $id,
        public readonly array $values
    ) {
    }

    /** @param list<string> $fields */
    public static function from(object|array $record, array $fields, string $primaryKey): self
    {
        if (is_array($record)) {
            $source = $record;
        } elseif (method_exists($record, 'toRawArray')) {
            $source = $record->toRawArray();
        } elseif (method_exists($record, 'toArray')) {
            $source = $record->toArray();
        } else {
            $source = get_object_vars($record);
        }

        $values = [];
        foreach ($fields as $field) {
            $value = $source[$field] ?? null;
            $values[$field] = is_scalar($value) || $value === null ? $value : null;
        }

        $id = $source[$primaryKey] ?? null;
        if (!is_int($id) && !is_string($id)) {
            $id = null;
        }

        return new self($id, $values);
    }

    /**
     * @param list<object|array> $records
     * @param list<string> $fields
     * @return list<self>
     */
    public static function collection(array $records, array $fields, string $primaryKey): array
    {
        return array_map(
            static fn (object|array $record): self => self::from($record, $fields, $primaryKey),
            $records
        );
    }

    public function value(string $field): int|float|string|bool|null
    {
        return $this->values[$field] ?? null;
    }

    /** @return array<string,scalar|null> */
    public function toArray(): array
    {
        return $this->values;
    }
}
PHP;
    }

    private function dashboardWidgetDto(): string
    {
        return <<<'PHP'
<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

/**
 * Immutable Dashboard widget view-model.
 *
 * Payload keys remain widget-specific, while the widget envelope is typed and
 * shared by KPI, chart, recent-record, and quick-link widgets.
 */
final class DashboardWidget
{
    /** @param array<string,mixed> $payload */
    public function __construct(
        public readonly string $type,
        public readonly string $title,
        public readonly int $width,
        public readonly array $payload = []
    ) {
    }

    public function get(string $key, mixed $default = null): mixed
    {
        return $this->payload[$key] ?? $default;
    }

    public function has(string $key): bool
    {
        return array_key_exists($key, $this->payload);
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return array_merge([
            'type' => $this->type,
            'title' => $this->title,
            'width' => $this->width,
        ], $this->payload);
    }
}
PHP;
    }

    private function dashboardDataDto(): string
    {
        return <<<'PHP'
<?php

declare(strict_types=1);

namespace App\DTO\Dashboard;

/**
 * Typed result returned by DashboardService and passed unchanged to the View.
 */
final class DashboardData
{
    /**
     * @param array<string,mixed> $globalDateFilter
     * @param array{from:string,to:string} $activeDateRange
     * @param list<array<string,mixed>> $globalFilters
     * @param array<string,mixed> $activeGlobalValues
     * @param list<DashboardWidget> $widgets
     */
    public function __construct(
        public readonly string $title,
        public readonly array $globalDateFilter,
        public readonly array $activeDateRange,
        public readonly array $globalFilters,
        public readonly array $activeGlobalValues,
        public readonly array $widgets
    ) {
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'globalDateFilter' => $this->globalDateFilter,
            'activeDateRange' => $this->activeDateRange,
            'globalFilters' => $this->globalFilters,
            'activeGlobalValues' => $this->activeGlobalValues,
            'widgets' => array_map(
                static fn (DashboardWidget $widget): array => $widget->toArray(),
                $this->widgets
            ),
        ];
    }
}
PHP;
    }

    private function queryClass(): string
    {
        return <<<'PHP'
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
PHP;
    }

    private function serviceClass(string $dashboardCode, array $widgets): string
    {
        $recentWidgets = [];
        $modelImports = [];
        $recentCases = [];
        $recentMethods = [];

        foreach ($widgets as $index => $widget) {
            if (($widget['type'] ?? '') !== 'recent') {
                continue;
            }

            $model = trim((string) ($widget['modelShort'] ?? ''));
            if ($model === '' || preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $model) !== 1) {
                continue;
            }

            $modelImports[$model] = 'use App\\Models\\' . $model . ';';
            $id = (string) ($widget['id'] ?? ('recent_' . $index));
            $method = 'recentWidget' . ucfirst(preg_replace('/[^A-Za-z0-9]+/', '', $id) ?: (string) $index);
            $idLiteral = var_export($id, true);
            $relationProjectionLines = [];
            foreach ((array) ($widget['recentRelations'] ?? []) as $foreignKey => $relationMeta) {
                $foreignKey = (string) $foreignKey;
                $findMethod = (string) ($relationMeta['findMethod'] ?? '');
                if (
                    $foreignKey === ''
                    || preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $foreignKey) !== 1
                    || preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $findMethod) !== 1
                ) {
                    continue;
                }

                $cacheVar = '$relationCache' . str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $foreignKey)));
                $fkLiteral = var_export($foreignKey, true);
                $relationProjectionLines[] = "        {$cacheVar} = [];";
                $relationProjectionLines[] = "        foreach (\$recordSources as &\$recordSource) {";
                $relationProjectionLines[] = "            \$relationId = \$recordSource[{$fkLiteral}] ?? null;";
                $relationProjectionLines[] = "            if (\$relationId === null || \$relationId === '') { continue; }";
                $relationProjectionLines[] = "            \$relationKey = (string) \$relationId;";
                $relationProjectionLines[] = "            if (!array_key_exists(\$relationKey, {$cacheVar})) {";
                $relationProjectionLines[] = "                \$option = \$model->{$findMethod}(\$relationId);";
                $relationProjectionLines[] = "                {$cacheVar}[\$relationKey] = is_array(\$option) ? (string) (\$option['text'] ?? \$relationKey) : \$relationKey;";
                $relationProjectionLines[] = "            }";
                $relationProjectionLines[] = "            \$recordSource[{$fkLiteral}] = {$cacheVar}[\$relationKey];";
                $relationProjectionLines[] = "        }";
                $relationProjectionLines[] = "        unset(\$recordSource);";
            }
            $relationProjectionCode = $relationProjectionLines === []
                ? ''
                : "\n" . implode("\n", $relationProjectionLines) . "\n";
            $recentCases[] = "            {$idLiteral} => \$this->{$method}(\$filter, \$dateRange, \$globalFilters, (int) \$widget['limit'], (array) (\$widget['recentFields'] ?? []), (string) (\$widget['primaryKey'] ?? 'id')),";
            $recentMethods[] = <<<PHP
    /**
     * Reads recent records for Dashboard widget {$id} through the concrete generated Model.
     *
     * The Model class is wired at generation-time; no runtime Model resolver is used.
     *
     * @param array<string,mixed> \$filter
     * @param array<string,mixed> \$dateRange
     * @param list<array<string,mixed>> \$globalFilters
     * @param list<string> \$fields
     * @return list<RecentRecord>
     */
    private function {$method}(
        array \$filter,
        array \$dateRange,
        array \$globalFilters,
        int \$limit,
        array \$fields,
        string \$primaryKey
    ): array {
        \$model = new {$model}();
        \$this->applyModelFilter(\$model, \$filter);
        \$this->applyModelDateRange(\$model, \$dateRange);
        \$this->applyModelFilters(\$model, \$globalFilters);

        \$records = \$model
            ->orderBy(\$primaryKey, 'DESC')
            ->findAll(max(1, min(50, \$limit)));

        \$recordSources = [];
        foreach (\$records as \$record) {
            if (is_array(\$record)) {
                \$recordSources[] = \$record;
            } elseif (method_exists(\$record, 'toRawArray')) {
                \$recordSources[] = \$record->toRawArray();
            } elseif (method_exists(\$record, 'toArray')) {
                \$recordSources[] = \$record->toArray();
            } else {
                \$recordSources[] = get_object_vars(\$record);
            }
        }
{$relationProjectionCode}
        return RecentRecord::collection(\$recordSources, \$fields, \$primaryKey);
    }

PHP;
            $recentWidgets[] = $id;
        }

        ksort($modelImports);
        $modelUseCode = $modelImports === [] ? '' : implode("\n", $modelImports) . "\n";
        $recentCaseCode = $recentCases === []
            ? "            default => [],"
            : implode("\n", $recentCases) . "\n            default => [],";
        $recentMethodCode = implode("\n", $recentMethods);

        return <<<PHP
<?php

declare(strict_types=1);

namespace App\Services;

use App\DTO\Dashboard\DashboardData;
use App\DTO\Dashboard\DashboardWidget;
use App\DTO\Dashboard\Kpi;
use App\DTO\Dashboard\RecentRecord;
use App\Libraries\Dashboard\DashboardQuery;
{$modelUseCode}
/**
 * Read-only Dashboard composition service.
 *
 * Aggregate/statistical reads are delegated to DashboardQuery. Recent-record
 * reads reuse concrete generated CRUD Models wired at generation-time. Entities
 * returned by those Models are normalized through RecentRecord DTOs before the
 * View boundary. Selected belongsTo values are projected through explicit generated
 * Model option methods wired at generation-time; no runtime relation resolver is used.
 */
final class DashboardService
{
    private const CONFIG = {$dashboardCode};

    public function __construct(private ?DashboardQuery \$query = null)
    {
        \$this->query ??= new DashboardQuery();
    }

    /** @param array{from?:string,to?:string} \$runtimeDateRange */
    public function build(
        array \$runtimeDateRange = [],
        array \$runtimeGlobalValues = []
    ): DashboardData {
        \$widgets = [];
        \$from = trim((string) (\$runtimeDateRange['from'] ?? ''));
        \$to = trim((string) (\$runtimeDateRange['to'] ?? ''));

        foreach ((array) self::CONFIG['widgets'] as \$widget) {
            \$type = (string) (\$widget['type'] ?? '');
            \$filter = (array) (\$widget['filter'] ?? []);
            \$title = (string) (\$widget['title'] ?? '');
            \$width = (int) (\$widget['width'] ?? 4);

            \$dateRange = [];
            \$dateField = trim((string) (\$widget['globalDateField'] ?? ''));
            if (!empty(self::CONFIG['globalDateFilter']['enabled']) && \$dateField !== '') {
                \$dateRange = [
                    'field' => \$dateField,
                    'label' => (string) (\$widget['globalDateLabel'] ?? \$dateField),
                    'from' => \$from,
                    'to' => \$to,
                ];
            }

            \$globalFilters = \$this->runtimeGlobalFilters(
                (array) (\$widget['globalFilters'] ?? []),
                \$runtimeGlobalValues
            );

            if (\$type === 'kpi_count') {
                \$value = \$this->query->count((string) (\$widget['table'] ?? ''), \$filter, \$dateRange, \$globalFilters);
                \$widgets[] = new DashboardWidget('kpi', \$title, \$width, [
                    'data' => new Kpi(
                        \$title,
                        \$value,
                        \$this->formatNumber(
                            \$value,
                            (int) (\$widget['decimals'] ?? 0),
                            (string) (\$widget['prefix'] ?? ''),
                            (string) (\$widget['suffix'] ?? '')
                        )
                    ),
                    'filter' => \$filter,
                    'dateRange' => \$dateRange,
                    'globalFilters' => \$globalFilters,
                ]);
                continue;
            }

            if (\$type === 'kpi_aggregate') {
                \$operation = (string) (\$widget['operation'] ?? 'COUNT');
                \$value = \$this->query->aggregate(
                    (string) (\$widget['table'] ?? ''),
                    (string) \$widget['valueField'],
                    \$operation,
                    \$filter,
                    \$dateRange,
                    \$globalFilters
                );

                \$widgets[] = new DashboardWidget('kpi', \$title, \$width, [
                    'data' => new Kpi(
                        \$title,
                        \$value,
                        \$this->formatNumber(
                            \$value,
                            (int) (\$widget['decimals'] ?? 2),
                            (string) (\$widget['prefix'] ?? ''),
                            (string) (\$widget['suffix'] ?? '')
                        )
                    ),
                    'operation' => \$operation,
                    'field' => (string) \$widget['valueField'],
                    'fieldLabel' => (string) ((\$widget['fieldLabels'][\$widget['valueField']] ?? \$widget['valueField'])),
                    'filter' => \$filter,
                    'dateRange' => \$dateRange,
                    'globalFilters' => \$globalFilters,
                ]);
                continue;
            }

            if (\$type === 'grouped_chart') {
                \$points = \$this->query->grouped(
                    (string) (\$widget['table'] ?? ''),
                    (string) \$widget['groupField'],
                    (string) (\$widget['operation'] ?? 'COUNT'),
                    (string) \$widget['valueField'],
                    (string) ((\$widget['dateGroup'] ?? 'raw') ?? 'raw'),
                    (int) \$widget['limit'],
                    \$filter,
                    \$dateRange,
                    \$globalFilters
                );

                \$widgets[] = new DashboardWidget('chart', \$title, \$width, [
                    'chartType' => (string) \$widget['chartType'],
                    'operation' => (string) (\$widget['operation'] ?? 'COUNT'),
                    'dateGroup' => (string) ((\$widget['dateGroup'] ?? 'raw') ?? 'raw'),
                    'groupField' => (string) \$widget['groupField'],
                    'groupLabel' => (string) ((\$widget['fieldLabels'][\$widget['groupField']] ?? \$widget['groupField'])),
                    'valueField' => (string) \$widget['valueField'],
                    'valueLabel' => (string) ((\$widget['fieldLabels'][\$widget['valueField']] ?? \$widget['valueField'])),
                    'points' => \$points,
                    'filter' => \$filter,
                    'dateRange' => \$dateRange,
                    'globalFilters' => \$globalFilters,
                ]);
                continue;
            }

            if (\$type === 'recent') {
                \$records = match ((string) (\$widget['id'] ?? '')) {
{$recentCaseCode}
                };

                \$widgets[] = new DashboardWidget('recent', \$title, \$width, [
                    'table' => (string) (\$widget['table'] ?? ''),
                    'records' => \$records,
                    'fields' => (array) (\$widget['recentFields'] ?? []),
                    'labels' => (array) (\$widget['fieldLabels'] ?? []),
                    'filter' => \$filter,
                    'dateRange' => \$dateRange,
                    'globalFilters' => \$globalFilters,
                ]);
                continue;
            }

            if (\$type === 'quick_link') {
                \$widgets[] = new DashboardWidget('quick_link', \$title, \$width, [
                    'table' => (string) (\$widget['table'] ?? ''),
                ]);
            }
        }

        return new DashboardData(
            (string) self::CONFIG['title'],
            (array) (self::CONFIG['globalDateFilter'] ?? []),
            ['from' => \$from, 'to' => \$to],
            (array) (self::CONFIG['globalFilters'] ?? []),
            \$runtimeGlobalValues,
            \$widgets
        );
    }

    private function runtimeGlobalFilters(array \$mappings, array \$values): array
    {
        \$filters = [];

        foreach (\$mappings as \$mapping) {
            if (!is_array(\$mapping)) {
                continue;
            }

            \$id = (string) (\$mapping['id'] ?? '');
            \$field = trim((string) (\$mapping['field'] ?? ''));
            \$value = \$values[\$id] ?? null;

            if (\$id === '' || \$field === '' || \$value === null || \$value === '') {
                continue;
            }

            \$inputType = (string) (\$mapping['inputType'] ?? 'text');
            if (\$inputType === 'number' && !is_numeric(\$value)) {
                continue;
            }

            \$filters[] = [
                'id' => \$id,
                'label' => (string) (\$mapping['label'] ?? \$id),
                'field' => \$field,
                'fieldLabel' => (string) (\$mapping['fieldLabel'] ?? \$field),
                'operator' => (string) (\$mapping['operator'] ?? 'eq'),
                'value' => \$value,
            ];
        }

        return \$filters;
    }

    private function applyModelFilters(object \$model, array \$filters): void
    {
        foreach (\$filters as \$filter) {
            if (is_array(\$filter)) {
                \$this->applyModelFilter(\$model, \$filter);
            }
        }
    }

    private function formatNumber(int|float \$value, int \$decimals, string \$prefix, string \$suffix): string
    {
        \$number = number_format(\$value, max(0, min(4, \$decimals)), '.', ',');

        return trim(\$prefix . \$number . \$suffix);
    }

    private function applyModelFilter(object \$model, array \$filter): void
    {
        \$field = trim((string) (\$filter['field'] ?? ''));
        \$operator = (string) (\$filter['operator'] ?? 'eq');
        \$value = \$filter['value'] ?? null;

        if (\$field === '' || \$value === null || \$value === '') {
            return;
        }

        match (\$operator) {
            'eq' => \$model->where(\$field, \$value),
            'neq' => \$model->where(\$field . ' !=', \$value),
            'gt' => \$model->where(\$field . ' >', \$value),
            'gte' => \$model->where(\$field . ' >=', \$value),
            'lt' => \$model->where(\$field . ' <', \$value),
            'lte' => \$model->where(\$field . ' <=', \$value),
            'contains' => \$model->like(\$field, (string) \$value, 'both'),
            'starts_with' => \$model->like(\$field, (string) \$value, 'after'),
            default => null,
        };
    }

    private function applyModelDateRange(object \$model, array \$dateRange): void
    {
        \$field = trim((string) (\$dateRange['field'] ?? ''));
        \$from = trim((string) (\$dateRange['from'] ?? ''));
        \$to = trim((string) (\$dateRange['to'] ?? ''));

        if (\$field === '') {
            return;
        }

        if (\$from !== '') {
            \$model->where(\$field . ' >=', \$from . ' 00:00:00');
        }

        if (\$to !== '') {
            \$model->where(\$field . ' <=', \$to . ' 23:59:59');
        }
    }

{$recentMethodCode}}
PHP;
    }

    private function controllerClass(string $title): string
    {
        return <<<PHP
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\DashboardService;
use DateTimeImmutable;

final class DashboardController extends BaseController
{
    public function index(): string
    {
        \$dateRange = [
            'from' => \$this->validDate((string) \$this->request->getGet('from')),
            'to' => \$this->validDate((string) \$this->request->getGet('to')),
        ];

        if (\$dateRange['from'] !== '' && \$dateRange['to'] !== '' && \$dateRange['from'] > \$dateRange['to']) {
            [\$dateRange['from'], \$dateRange['to']] = [\$dateRange['to'], \$dateRange['from']];
        }

        \$dashboard = (new DashboardService())->build(
            \$dateRange,
            \$this->globalValues()
        );

        return view('dashboard/index', [
            'title' => \$dashboard->title,
            'dashboard' => \$dashboard,
        ]);
    }

    /** @return array<string,string> */
    private function globalValues(): array
    {
        \$values = [];

        foreach ((array) \$this->request->getGet() as \$key => \$value) {
            \$key = (string) \$key;

            if (!str_starts_with(\$key, 'gf_') || !is_scalar(\$value)) {
                continue;
            }

            \$id = substr(\$key, 3);
            if (\$id === '' || preg_match('/^[A-Za-z][A-Za-z0-9_]*$/D', \$id) !== 1) {
                continue;
            }

            \$values[\$id] = mb_substr(trim((string) \$value), 0, 255);
        }

        return \$values;
    }

    private function validDate(string \$value): string
    {
        \$value = trim(\$value);
        if (\$value === '') {
            return '';
        }

        \$date = DateTimeImmutable::createFromFormat('!Y-m-d', \$value);
        \$errors = DateTimeImmutable::getLastErrors();

        if (\$date === false) {
            return '';
        }

        if (is_array(\$errors) && ((\$errors['warning_count'] ?? 0) > 0 || (\$errors['error_count'] ?? 0) > 0)) {
            return '';
        }

        return \$date->format('Y-m-d') === \$value ? \$value : '';
    }
}
PHP;
    }

    private function viewFile(): string
    {
        return <<<'PHP'
<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <?php
    $globalDateFilter = $dashboard->globalDateFilter;
    $activeDateRange = $dashboard->activeDateRange;
    $globalDateEnabled = !empty($globalDateFilter['enabled']);
    $globalFilters = $dashboard->globalFilters;
    $activeGlobalValues = $dashboard->activeGlobalValues;
    $hasGlobalControls = $globalDateEnabled || $globalFilters !== [];
    ?>

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="text-muted small text-uppercase">Dashboard</div>
            <h1 class="h3 mb-0"><?= esc($dashboard->title) ?></h1>
        </div>

        <?php if ($hasGlobalControls): ?>
            <form method="get" class="card shadow-sm">
                <div class="card-body py-2">
                    <div class="d-flex flex-wrap align-items-end gap-2">
                        <?php if ($globalDateEnabled): ?>
                            <div>
                                <label class="form-label small mb-1">
                                    <?= esc((string) ($globalDateFilter['label'] ?? 'Period')) ?> — From
                                </label>
                                <input
                                    type="date"
                                    class="form-control form-control-sm"
                                    name="from"
                                    value="<?= esc((string) ($activeDateRange['from'] ?? '')) ?>"
                                >
                            </div>
                            <div>
                                <label class="form-label small mb-1">
                                    <?= esc((string) ($globalDateFilter['label'] ?? 'Period')) ?> — To
                                </label>
                                <input
                                    type="date"
                                    class="form-control form-control-sm"
                                    name="to"
                                    value="<?= esc((string) ($activeDateRange['to'] ?? '')) ?>"
                                >
                            </div>
                        <?php endif ?>

                        <?php foreach ($globalFilters as $globalFilter): ?>
                            <?php
                            $globalId = (string) ($globalFilter['id'] ?? '');
                            if ($globalId === '') {
                                continue;
                            }
                            ?>
                            <div>
                                <label class="form-label small mb-1">
                                    <?= esc((string) ($globalFilter['label'] ?? $globalId)) ?>
                                </label>
                                <input
                                    type="<?= ($globalFilter['inputType'] ?? 'text') === 'number' ? 'number' : 'text' ?>"
                                    class="form-control form-control-sm"
                                    name="gf_<?= esc($globalId) ?>"
                                    value="<?= esc((string) ($activeGlobalValues[$globalId] ?? '')) ?>"
                                >
                            </div>
                        <?php endforeach ?>

                        <button class="btn btn-sm btn-primary" type="submit">
                            <i class="bi bi-funnel me-1"></i>Apply
                        </button>
                        <a class="btn btn-sm btn-outline-secondary" href="<?= current_url() ?>">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        <?php endif ?>
    </div>

    <div class="row g-3 align-items-stretch">
        <?php foreach ($dashboard->widgets as $index => $widget): ?>
            <?php
            $width = max(1, min(12, $widget->width));
            $filter = (array) $widget->get('filter', []);
            $hasFilter = trim((string) ($filter['field'] ?? '')) !== '';
            $dateRange = (array) $widget->get('dateRange', []);
            $hasDateRange = trim((string) ($dateRange['field'] ?? '')) !== ''
                && (
                    trim((string) ($dateRange['from'] ?? '')) !== ''
                    || trim((string) ($dateRange['to'] ?? '')) !== ''
                );
            $widgetGlobalFilters = (array) $widget->get('globalFilters', []);
            $hasWidgetGlobalFilters = $widgetGlobalFilters !== [];
            ?>
            <div class="col-12 col-lg-<?= $width ?> d-flex dashboard-widget-column">
                <?php if ($widget->type === 'kpi'): ?>
                    <?php $kpi = $widget->get('data'); ?>
                    <div class="card shadow-sm h-100 w-100 dashboard-widget-card">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <div class="text-muted small"><?= esc($kpi->label) ?></div>
                                    <div class="h2 fw-semibold mb-0 mt-1"><?= esc($kpi->formattedValue) ?></div>
                                </div>
                                <i class="bi bi-speedometer2 text-muted fs-4"></i>
                            </div>

                            <?php if (!empty($widget->get('operation'))): ?>
                                <div class="small text-muted mt-2">
                                    <?= esc((string) $widget->get('operation')) ?>
                                    <?= esc((string) $widget->get('fieldLabel', $widget->get('field', ''))) ?>
                                </div>
                            <?php endif ?>

                            <?php if ($hasFilter || $hasDateRange || $hasWidgetGlobalFilters): ?>
                                <div class="small text-muted mt-2">
                                    <?php if ($hasFilter): ?>
                                        <span class="me-2">
                                            <i class="bi bi-funnel me-1"></i>
                                            <?= esc((string) ($filter['label'] ?? $filter['field'])) ?>
                                            <?= esc((string) $filter['operator']) ?>
                                            <?= esc((string) $filter['value']) ?>
                                        </span>
                                    <?php endif ?>
                                    <?php if ($hasDateRange): ?>
                                        <span>
                                            <i class="bi bi-calendar-range me-1"></i>
                                            <?= esc((string) ($dateRange['label'] ?? $dateRange['field'])) ?>
                                            <?= esc((string) ($dateRange['from'] ?? '')) ?>
                                            <?= ($dateRange['from'] ?? '') !== '' && ($dateRange['to'] ?? '') !== '' ? ' → ' : '' ?>
                                            <?= esc((string) ($dateRange['to'] ?? '')) ?>
                                        </span>
                                    <?php endif ?>
                                    <?php foreach ($widgetGlobalFilters as $globalFilter): ?>
                                        <span class="me-2">
                                            <i class="bi bi-funnel-fill me-1"></i>
                                            <?= esc((string) ($globalFilter['label'] ?? $globalFilter['id'] ?? 'Filter')) ?>
                                            <?= esc((string) ($globalFilter['value'] ?? '')) ?>
                                        </span>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                <?php elseif ($widget->type === 'chart'): ?>
                    <?php
                    $points = (array) $widget->get('points', []);
                    $labels = array_map(static fn ($point): string => (string) $point->label, $points);
                    $values = array_map(static fn ($point): int|float => $point->value, $points);
                    ?>
                    <div class="card shadow-sm h-100 w-100 dashboard-widget-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <strong><?= esc((string) $widget->title) ?></strong>
                                    <div class="small text-muted">
                                        <?= esc((string) ($widget->get('operation') ?? 'COUNT')) ?>
                                        by <?= esc((string) $widget->get('groupLabel', $widget->get('groupField', ''))) ?>
                                        <?php if ($widget->get('dateGroup', 'raw') !== 'raw'): ?>
                                            · <?= esc((string) $widget->get('dateGroup')) ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <?php if ($hasFilter): ?>
                                        <span class="badge text-bg-light border">
                                            <i class="bi bi-funnel me-1"></i>
                                            <?= esc((string) ($filter['label'] ?? $filter['field'])) ?>
                                        </span>
                                    <?php endif ?>
                                    <?php if ($hasDateRange): ?>
                                        <span class="badge text-bg-light border">
                                            <i class="bi bi-calendar-range me-1"></i>
                                            <?= esc((string) ($dateRange['label'] ?? $dateRange['field'])) ?>
                                        </span>
                                    <?php endif ?>
                                    <?php foreach ($widgetGlobalFilters as $globalFilter): ?>
                                        <span class="badge text-bg-light border">
                                            <i class="bi bi-funnel-fill me-1"></i>
                                            <?= esc((string) ($globalFilter['label'] ?? $globalFilter['id'] ?? 'Filter')) ?>
                                        </span>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas
                                    data-dashboard-chart
                                    data-chart-type="<?= esc((string) $widget->get('chartType', 'bar')) ?>"
                                    data-labels="<?= esc(json_encode($labels, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>"
                                    data-values="<?= esc(json_encode($values, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>"
                                    aria-label="<?= esc((string) $widget->title) ?>"
                                    role="img"
                                ></canvas>
                            </div>
                        </div>
                    </div>

                <?php elseif ($widget->type === 'recent'): ?>
                    <?php
                    $recentFields = (array) $widget->get('fields', []);
                    $fieldLabels = (array) $widget->get('labels', []);
                    ?>
                    <div class="card shadow-sm h-100 w-100 dashboard-widget-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= esc((string) $widget->title) ?></strong>
                                <?php if ($hasFilter || $hasDateRange || $hasWidgetGlobalFilters): ?>
                                    <div class="small text-muted">
                                        <?php if ($hasFilter): ?>
                                            <span class="me-2">
                                                <i class="bi bi-funnel me-1"></i>
                                                <?= esc((string) ($filter['label'] ?? $filter['field'])) ?>
                                                <?= esc((string) $filter['operator']) ?>
                                                <?= esc((string) $filter['value']) ?>
                                            </span>
                                        <?php endif ?>
                                        <?php if ($hasDateRange): ?>
                                            <span>
                                                <i class="bi bi-calendar-range me-1"></i>
                                                <?= esc((string) ($dateRange['label'] ?? $dateRange['field'])) ?>
                                            </span>
                                        <?php endif ?>
                                        <?php foreach ($widgetGlobalFilters as $globalFilter): ?>
                                            <span class="me-2">
                                                <i class="bi bi-funnel-fill me-1"></i>
                                                <?= esc((string) ($globalFilter['label'] ?? $globalFilter['id'] ?? 'Filter')) ?>
                                                <?= esc((string) ($globalFilter['value'] ?? '')) ?>
                                            </span>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                            </div>
                            <a class="btn btn-sm btn-outline-primary" href="<?= site_url((string) $widget->get('table')) ?>">
                                View all
                            </a>
                        </div>

                        <div class="table-responsive dashboard-recent-table">
                            <table class="table table-sm align-middle mb-0">
                                <thead>
                                    <tr>
                                        <?php foreach ($recentFields as $field): ?>
                                            <th scope="col" class="text-nowrap"><?= esc((string) ($fieldLabels[$field] ?? $field)) ?></th>
                                        <?php endforeach ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ((array) $widget->get('records', []) as $record): ?>
                                        <tr>
                                            <?php foreach ($recentFields as $field): ?>
                                                <?php
                                                $value = $record->value((string) $field);
                                                $displayValue = is_scalar($value) || $value === null ? trim((string) $value) : '';
                                                ?>
                                                <td>
                                                    <span
                                                        class="dashboard-cell-text d-inline-block text-truncate align-middle"
                                                        title="<?= esc($displayValue) ?>"
                                                    ><?= esc($displayValue) ?></span>
                                                </td>
                                            <?php endforeach ?>
                                        </tr>
                                    <?php endforeach ?>

                                    <?php if ($widget->get('records', []) === []): ?>
                                        <tr>
                                            <td colspan="<?= max(1, count($recentFields)) ?>" class="text-muted text-center py-3">
                                                No records.
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($widget->type === 'quick_link'): ?>
                    <a href="<?= site_url((string) $widget->get('table')) ?>" class="card shadow-sm h-100 w-100 dashboard-widget-card text-decoration-none">
                        <div class="card-body py-3 d-flex align-items-center justify-content-between">
                            <strong><?= esc((string) $widget->title) ?></strong>
                            <i class="bi bi-arrow-right fs-4"></i>
                        </div>
                    </a>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    </div>
</div>

<style>
.dashboard-widget-column {
    min-width: 0;
}
.dashboard-widget-card {
    min-width: 0;
}
.dashboard-recent-table th,
.dashboard-recent-table td {
    vertical-align: middle;
}
.dashboard-recent-table th {
    font-size: .78rem;
    color: var(--bs-secondary-color);
    font-weight: 600;
}
.dashboard-recent-table td {
    min-width: 6.5rem;
}
.dashboard-cell-text {
    max-width: 14rem;
}
@media (max-width: 1199.98px) {
    .dashboard-cell-text {
        max-width: 10rem;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-dashboard-chart]').forEach((canvas) => {
        const labels = JSON.parse(canvas.dataset.labels || '[]');
        const values = JSON.parse(canvas.dataset.values || '[]');
        const type = canvas.dataset.chartType || 'bar';

        new Chart(canvas, {
            type,
            data: {
                labels,
                datasets: [{
                    label: canvas.getAttribute('aria-label') || 'Dashboard',
                    data: values
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
});
</script>
<?= $this->endSection() ?>
PHP;
    }

    private function routeFile(string $route): string
    {
        return <<<PHP
<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection \$routes */
\$routes->get('{$route}', 'DashboardController::index');
PHP;
    }
}
