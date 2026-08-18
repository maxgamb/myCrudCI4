<?php

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Schema\DbSchema;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use Config\Database;
use Throwable;

/** Runs EXPLAIN on queries that actually represent the generated list. */
final class ExplainAnalyzer
{
    public function __construct(
        private readonly ?BaseConnection $db = null,
        private readonly ?DbSchema $schema = null,
    ) {
    }

    /** @return list<DiagnosticResult> */
    public function analyze(string $table, int $perPage = 50): array
    {
        $db = $this->db ?? Database::connect();
        $schema = $this->schema ?? new DbSchema($db);
        $info = $schema->getTableInfo($table);
        $primaryKey = (string) ($info['primaryKey'] ?? 'id');
        $perPage = max(1, min(100, $perPage));
        $config = $this->resolvedConfig($table, $schema);
        $results = [];

        try {
            $builder = $this->listBuilder($db, $table, $config)
                ->orderBy($table . '.' . $primaryKey, 'DESC')
                ->limit($perPage);
            $results[] = $this->explainCompiled($db, 'EXPLAIN generated list', $builder->getCompiledSelect());
        } catch (Throwable $exception) {
            $results[] = new DiagnosticResult(
                'EXPLAIN generated list',
                DiagnosticResult::FAIL,
                $exception->getMessage()
            );
        }

        $leading = $this->firstUsefulLeadingIndex((array) ($info['indexes'] ?? []), $primaryKey);
        if ($leading === null) {
            $results[] = new DiagnosticResult(
                'EXPLAIN indexed filter',
                DiagnosticResult::SKIP,
                'No leading secondary index is available.'
            );
            return $results;
        }

        try {
            $sample = $db->table($table)
                ->select($leading)
                ->where($leading . ' IS NOT NULL', null, false)
                ->limit(1)
                ->get()
                ->getRowArray();
            $sampleValue = $sample[$leading] ?? null;
            if ($sampleValue === null) {
                $results[] = new DiagnosticResult(
                    'EXPLAIN indexed filter',
                    DiagnosticResult::SKIP,
                    'No sample value is available for ' . $leading . '.'
                );
                return $results;
            }

            $builder = $this->listBuilder($db, $table, $config)
                ->where($table . '.' . $leading, $sampleValue)
                ->orderBy($table . '.' . $primaryKey, 'DESC')
                ->limit($perPage);
            $results[] = $this->explainCompiled(
                $db,
                'EXPLAIN filter ' . $leading,
                $builder->getCompiledSelect()
            );
        } catch (Throwable $exception) {
            $results[] = new DiagnosticResult(
                'EXPLAIN filter ' . $leading,
                DiagnosticResult::FAIL,
                $exception->getMessage()
            );
        }

        return $results;
    }

    private function resolvedConfig(string $table, DbSchema $schema): array
    {
        $builder = new ConfigBuilder($schema);
        $config = $builder->buildFromTable($table);
        $saved = (new CrudConfigRepository())->load($table);
        return is_array($saved) ? $builder->mergeSavedConfiguration($config, $saved) : $config;
    }

    /** Reproduces SELECT/JOIN/soft-delete behavior of the generated Bootstrap table. */
    private function listBuilder(BaseConnection $db, string $table, array $config): BaseBuilder
    {
        $builder = $db->table($table);
        $select = [];
        $joined = [];

        foreach ((array) ($config['fields'] ?? []) as $name => $field) {
            if (empty($field['ui']['visibleIndex'])) {
                continue;
            }
            $select[] = $table . '.' . $name . ' AS ' . $name;
            $relation = $config['relations']['belongsTo'][$name] ?? null;
            if (is_array($relation)) {
                $alias = preg_replace('/[^a-zA-Z0-9_]/', '_', (string) $relation['parentTable'] . '__' . $name)
                    ?: (string) $relation['parentTable'];
                $display = (string) $relation['displayField'];
                $select[] = $alias . '.' . $display . ' AS ' . (string) $relation['alias'];
                if (!isset($joined[$alias])) {
                    $builder->join(
                        (string) $relation['parentTable'] . ' AS ' . $alias,
                        $alias . '.' . (string) $relation['parentKey'] . ' = ' . $table . '.' . $name,
                        'left'
                    );
                    $joined[$alias] = true;
                }
            }
        }

        if ($select === []) {
            $select[] = $table . '.' . (string) ($config['primaryKey'] ?? 'id');
        }
        $builder->select($select);

        if (!empty($config['features']['softDeletes'])) {
            $builder->where($table . '.' . (string) ($config['softDelete']['field'] ?? 'deleted_at'), null);
        }

        return $builder;
    }

    private function explainCompiled(BaseConnection $db, string $name, string $sql): DiagnosticResult
    {
        $rows = $db->query('EXPLAIN ' . $sql)->getResultArray();
        $warning = false;
        $estimatedRows = 0;
        $keys = [];
        $types = [];
        $extras = [];

        foreach ($rows as $row) {
            $type = strtoupper((string) ($row['type'] ?? $row['TYPE'] ?? ''));
            $key = (string) ($row['key'] ?? $row['KEY'] ?? '');
            $rowEstimate = (int) ($row['rows'] ?? $row['ROWS'] ?? 0);
            $extra = (string) ($row['Extra'] ?? $row['extra'] ?? '');
            $estimatedRows += $rowEstimate;
            if ($type !== '') $types[] = $type;
            if ($key !== '') $keys[] = $key;
            if ($extra !== '') $extras[] = $extra;
            $warning = $warning
                || $type === 'ALL'
                || $key === ''
                || str_contains(strtolower($extra), 'filesort')
                || str_contains(strtolower($extra), 'temporary');
        }

        return new DiagnosticResult(
            $name,
            $warning ? DiagnosticResult::WARN : DiagnosticResult::PASS,
            sprintf(
                'type=%s, key=%s, rows≈%s%s',
                $types !== [] ? implode('/', array_unique($types)) : 'n/d',
                $keys !== [] ? implode('/', array_unique($keys)) : 'NULL',
                number_format($estimatedRows, 0, ',', '.'),
                $extras !== [] ? ', Extra=' . implode(' | ', array_unique($extras)) : ''
            ),
            ['sql' => $sql, 'plan' => $rows]
        );
    }

    private function firstUsefulLeadingIndex(array $indexes, string $primaryKey): ?string
    {
        foreach ($indexes as $index) {
            if ((int) ($index['sequence'] ?? 0) !== 1) {
                continue;
            }
            $column = (string) ($index['columnName'] ?? '');
            $name = (string) ($index['indexName'] ?? '');
            if ($column !== '' && $column !== $primaryKey && $name !== 'PRIMARY') {
                return $column;
            }
        }
        return null;
    }
}
