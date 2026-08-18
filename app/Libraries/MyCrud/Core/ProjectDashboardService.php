<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\Schema\TableFilter;
use CodeIgniter\Database\BaseConnection;
use Config\Database;
use Throwable;

/**
 * Costruisce una vista sintetica dell'intero progetto myCrudCI4.
 *
 * La Dashboard deve essere leggera: evita di ricostruire ConfigBuilder per
 * each table and uses aggregate information_schema queries for counts,
 * row estimates, and relations. More expensive operations (diff/doctor/generate)
 * vengono eseguite solo quando lo sviluppatore le richiede esplicitamente.
 */
final class ProjectDashboardService
{
    public function __construct(
        private readonly ?BaseConnection $db = null,
        private readonly ?CrudConfigRepository $repository = null,
    ) {
    }

    /** @return array<string,mixed> */
    public function build(): array
    {
        $db = $this->db ?? Database::connect();
        $repository = $this->repository ?? new CrudConfigRepository();

        $dbTables = TableFilter::validTables($db);
        $dbLookup = array_fill_keys($dbTables, true);
        $configuredTables = $repository->tables();
        $configuredLookup = array_fill_keys($configuredTables, true);

        $rowEstimates = $this->rowEstimates($db);
        $relationCounts = $this->relationCounts($db);

        $allTables = array_values(array_unique(array_merge($dbTables, $configuredTables)));
        sort($allTables, SORT_NATURAL | SORT_FLAG_CASE);

        $rows = [];
        $architectureCounts = [
            'basic' => 0,
            'standard' => 0,
            'full' => 0,
        ];

        foreach ($allTables as $table) {
            $dbExists = isset($dbLookup[$table]);
            $configured = isset($configuredLookup[$table]);
            $config = null;
            $configError = null;

            if ($configured) {
                try {
                    $config = $repository->load($table);
                } catch (Throwable $e) {
                    $configError = $e->getMessage();
                }
            }

            $architecture = strtolower((string) ($config['architecture'] ?? ''));
            if (isset($architectureCounts[$architecture])) {
                $architectureCounts[$architecture]++;
            }

            $class = Naming::tableClass($table);
            $operational = is_file(APPPATH . 'Controllers/' . $class . 'Controller.php')
                && is_file(APPPATH . 'Routes/' . $table . '.php');
            $staged = is_file(APPPATH . 'Generated/Controllers/' . $class . 'Controller.php')
                && is_file(APPPATH . 'Generated/Routes/' . $table . '.php');

            $meta = is_array($config) ? (array) ($config['_meta'] ?? []) : [];

            $rows[] = [
                'table' => $table,
                'class' => $class,
                'dbExists' => $dbExists,
                'configured' => $configured && $configError === null,
                'configError' => $configError,
                'architecture' => $architecture,
                'savedVersion' => (string) ($meta['generatorVersion'] ?? ''),
                'savedAt' => (string) ($meta['savedAt'] ?? ''),
                'rowEstimate' => (int) ($rowEstimates[$table] ?? 0),
                'relationCount' => (int) ($relationCounts[$table] ?? 0),
                'operational' => $operational,
                'staged' => $staged,
            ];
        }

        return [
            'version' => (string) config('MyCrud')->version,
            'summary' => [
                'dbTables' => count($dbTables),
                'configured' => count($configuredTables),
                'basic' => $architectureCounts['basic'],
                'standard' => $architectureCounts['standard'],
                'full' => $architectureCounts['full'],
                'operational' => count(array_filter($rows, static fn (array $row): bool => $row['operational'])),
                'staged' => count(array_filter($rows, static fn (array $row): bool => $row['staged'])),
            ],
            'rows' => $rows,
        ];
    }

    /** @return array<string,int> */
    private function rowEstimates(BaseConnection $db): array
    {
        $rows = $db->query(<<<SQL
SELECT TABLE_NAME AS tableName, TABLE_ROWS AS rowEstimate
FROM information_schema.TABLES
WHERE TABLE_SCHEMA = DATABASE()
SQL
        )->getResultArray();

        $result = [];
        foreach ($rows as $row) {
            $table = (string) ($row['tableName'] ?? '');
            if ($table !== '') {
                $result[$table] = max(0, (int) ($row['rowEstimate'] ?? 0));
            }
        }

        return $result;
    }

    /** @return array<string,int> */
    private function relationCounts(BaseConnection $db): array
    {
        $relations = $db->query(<<<SQL
SELECT TABLE_NAME AS childTable, REFERENCED_TABLE_NAME AS parentTable
FROM information_schema.KEY_COLUMN_USAGE
WHERE TABLE_SCHEMA = DATABASE()
  AND REFERENCED_TABLE_NAME IS NOT NULL
SQL
        )->getResultArray();

        $counts = [];
        foreach ($relations as $relation) {
            $child = (string) ($relation['childTable'] ?? '');
            $parent = (string) ($relation['parentTable'] ?? '');

            if ($child !== '') {
                $counts[$child] = ($counts[$child] ?? 0) + 1;
            }
            if ($parent !== '' && $parent !== $child) {
                $counts[$parent] = ($counts[$parent] ?? 0) + 1;
            }
        }

        return $counts;
    }
}
