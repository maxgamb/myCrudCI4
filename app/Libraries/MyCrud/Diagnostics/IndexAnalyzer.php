<?php

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Schema\DbSchema;

/** Analyzes indexes, filterable fields, and relation size. */
final class IndexAnalyzer
{
    public function __construct(
        private readonly ?DbSchema $schema = null,
        private readonly ?ConfigBuilder $builder = null,
        private readonly ?CrudConfigRepository $repository = null,
    ) {
    }

    /** @return list<DiagnosticResult> */
    public function analyze(string $table): array
    {
        $schema = $this->schema ?? new DbSchema();
        $info = $schema->getTableInfo($table);
        $builder = $this->builder ?? new ConfigBuilder($schema);
        $config = $builder->buildFromTable($table);

        $repository = $this->repository ?? new CrudConfigRepository();
        $saved = $repository->load($table);
        if (is_array($saved)) {
            $config = $builder->mergeSavedConfiguration($config, $saved);
        }

        $results = [];
        $rowEstimate = max(0, (int) ($info['rowEstimate'] ?? 0));
        $results[] = new DiagnosticResult(
            'Table ' . $table,
            DiagnosticResult::PASS,
            'Righe stimate: ' . number_format($rowEstimate, 0, ',', '.') . '.',
            [
                'rowEstimate' => $rowEstimate,
                'dataLength' => (int) ($info['dataLength'] ?? 0),
                'indexLength' => (int) ($info['indexLength'] ?? 0),
            ]
        );

        $primaryKey = (string) ($info['primaryKey'] ?? '');
        $results[] = new DiagnosticResult(
            'Primary key',
            $primaryKey !== '' ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $primaryKey !== '' ? $primaryKey : 'Primary key non rilevata.'
        );

        $grouped = $this->groupIndexes((array) ($info['indexes'] ?? []));
        foreach ($grouped as $name => $index) {
            $columns = implode(', ', $index['columns']);
            $kind = $name === 'PRIMARY' ? 'PRIMARY' : ($index['unique'] ? 'UNIQUE' : 'INDEX');
            $results[] = new DiagnosticResult(
                'Indice ' . $name,
                DiagnosticResult::PASS,
                $kind . ' (' . $columns . ')',
                $index
            );
        }

        foreach ((array) ($config['fields'] ?? []) as $name => $field) {
            $ui = (array) ($field['ui'] ?? []);
            $index = (array) ($field['index'] ?? []);
            $leading = !empty($index['primary']) || !empty($index['unique']) || !empty($index['leading']);

            if ((!empty($ui['searchable']) || !empty($ui['sortable'])) && !$leading) {
                $results[] = new DiagnosticResult(
                    'Field ' . $name,
                    DiagnosticResult::WARN,
                    'Configured for search/sorting but does not lead an index.',
                    ['searchable' => !empty($ui['searchable']), 'sortable' => !empty($ui['sortable'])]
                );
            }
        }

        foreach ((array) ($config['relations']['belongsTo'] ?? []) as $field => $relation) {
            $estimate = max(0, (int) ($relation['rowEstimate'] ?? 0));
            $mode = (string) ($config['fields'][$field]['relationMode'] ?? $relation['optionMode'] ?? 'select');
            $threshold = max(1, (int) (config('MyCrud')->relationAjaxThreshold ?? 5000));
            $status = $estimate >= $threshold && $mode !== 'ajax'
                ? DiagnosticResult::WARN
                : DiagnosticResult::PASS;

            $results[] = new DiagnosticResult(
                'Relation ' . $field,
                $status,
                sprintf(
                    '%s → %s.%s, ~%s righe, modalità %s.',
                    $field,
                    (string) ($relation['parentTable'] ?? ''),
                    (string) ($relation['parentKey'] ?? ''),
                    number_format($estimate, 0, ',', '.'),
                    strtoupper($mode)
                ),
                ['rowEstimate' => $estimate, 'mode' => $mode]
            );
        }

        return $results;
    }

    /** @return array<string, array{columns:list<string>,unique:bool,type:string}> */
    private function groupIndexes(array $indexes): array
    {
        $grouped = [];
        foreach ($indexes as $index) {
            $name = (string) ($index['indexName'] ?? '');
            $column = (string) ($index['columnName'] ?? '');
            if ($name === '' || $column === '') {
                continue;
            }
            if (!isset($grouped[$name])) {
                $grouped[$name] = [
                    'columns' => [],
                    'unique' => ((int) ($index['nonUnique'] ?? 1)) === 0,
                    'type' => (string) ($index['indexType'] ?? ''),
                ];
            }
            $grouped[$name]['columns'][] = $column;
        }
        return $grouped;
    }
}
