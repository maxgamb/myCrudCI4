<?php

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Schema\DbSchema;
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Database\BaseConnection;
use Config\Database;
use Throwable;

/** Synthetic, non-destructive benchmark of the real CRUD list. */
final class CrudBenchmarkRunner
{
    public function __construct(
        private readonly ?BaseConnection $db = null,
        private readonly ?DbSchema $schema = null,
    ) {
    }

    /** @return list<DiagnosticResult> */
    public function run(string $table, int $iterations = 5, int $perPage = 50): array
    {
        $db = $this->db ?? Database::connect();
        $schema = $this->schema ?? new DbSchema($db);
        $info = $schema->getTableInfo($table);
        $config = $this->resolvedConfig($table, $schema);
        $pk = (string) ($info['primaryKey'] ?? 'id');
        $iterations = max(1, min(20, $iterations));
        $perPage = max(1, min(100, $perPage));
        $results = [];

        try {
            [$total, $countMs] = $this->measureOne(function () use ($db, $table, $config): int {
                $builder = $db->table($table);
                if (!empty($config['features']['softDeletes'])) {
                    $builder->where((string) ($config['softDelete']['field'] ?? 'deleted_at'), null);
                }
                return $builder->countAllResults();
            });
            $results[] = $this->metric('Benchmark COUNT(*)', $countMs, ['total' => $total]);

            $firstPageMs = $this->measureAverage($iterations, function () use ($db, $table, $pk, $perPage, $config): void {
                $this->listBuilder($db, $table, $config)
                    ->orderBy($table . '.' . $pk, 'DESC')
                    ->limit($perPage)
                    ->get()
                    ->getResultArray();
            });
            $results[] = $this->metric('Benchmark pagina iniziale', $firstPageMs, ['perPage' => $perPage]);

            $deepOffset = max(0, $total - $perPage);
            if ($deepOffset > 0) {
                $deepMs = $this->measureAverage($iterations, function () use ($db, $table, $pk, $perPage, $deepOffset, $config): void {
                    $this->listBuilder($db, $table, $config)
                        ->orderBy($table . '.' . $pk, 'DESC')
                        ->limit($perPage, $deepOffset)
                        ->get()
                        ->getResultArray();
                });
                $results[] = $this->metric(
                    'Benchmark pagina profonda',
                    $deepMs,
                    ['offset' => $deepOffset, 'perPage' => $perPage]
                );
            }

            $leading = $this->firstUsefulLeadingIndex((array) ($info['indexes'] ?? []), $pk);
            if ($leading !== null) {
                $sample = $db->table($table)
                    ->select($leading)
                    ->where($leading . ' IS NOT NULL', null, false)
                    ->limit(1)
                    ->get()
                    ->getRowArray();
                $sampleValue = $sample[$leading] ?? null;
                if ($sampleValue !== null) {
                    $filterMs = $this->measureAverage($iterations, function () use ($db, $table, $pk, $leading, $sampleValue, $perPage, $config): void {
                        $this->listBuilder($db, $table, $config)
                            ->where($table . '.' . $leading, $sampleValue)
                            ->orderBy($table . '.' . $pk, 'DESC')
                            ->limit($perPage)
                            ->get()
                            ->getResultArray();
                    });
                    $results[] = $this->metric('Filter benchmark ' . $leading, $filterMs, ['sample' => $sampleValue]);
                }
            }
        } catch (Throwable $exception) {
            $results[] = new DiagnosticResult(
                'Benchmark',
                DiagnosticResult::FAIL,
                $exception->getMessage(),
                ['exception' => $exception::class]
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
                $select[] = $alias . '.' . (string) $relation['displayField'] . ' AS ' . (string) $relation['alias'];
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

    /** @return array{0:mixed,1:float} */
    private function measureOne(callable $callback): array
    {
        $start = hrtime(true);
        $value = $callback();
        $ms = (hrtime(true) - $start) / 1_000_000;
        return [$value, round($ms, 2)];
    }

    private function measureAverage(int $iterations, callable $callback): float
    {
        $times = [];
        for ($i = 0; $i < $iterations; $i++) {
            $start = hrtime(true);
            $callback();
            $times[] = (hrtime(true) - $start) / 1_000_000;
        }
        return round(array_sum($times) / count($times), 2);
    }

    private function metric(string $name, float $ms, array $context = []): DiagnosticResult
    {
        $status = $ms <= 100 ? DiagnosticResult::PASS : DiagnosticResult::WARN;
        return new DiagnosticResult(
            $name,
            $status,
            number_format($ms, 2, ',', '.') . ' ms medi.',
            ['milliseconds' => $ms] + $context
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
