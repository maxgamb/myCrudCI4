<?php

namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Schema\DbSchema;
use Config\MyCrud;

final class RelationResolver
{
    private DbSchema $schema;
    private MyCrud $config;

    public function __construct(?DbSchema $schema = null, ?MyCrud $config = null)
    {
        $this->schema = $schema ?? new DbSchema();
        $this->config = $config ?? config('MyCrud');
    }

    public function resolve(string $table): array
    {
        $schemaInfo = $this->schema->getSchemaInfo();
        $tables = $schemaInfo['tables'] ?? [];
        $relations = $schemaInfo['relations'] ?? [];

        $belongsTo = [];
        $hasMany = [];
        $self = [];

        foreach ($relations as $relation) {
            $childTable = (string) ($relation['childTable'] ?? '');
            $childColumn = (string) ($relation['childColumn'] ?? '');
            $parentTable = (string) ($relation['parentTable'] ?? '');
            $parentColumn = (string) ($relation['parentColumn'] ?? '');

            if ($childTable === '' || $childColumn === '' || $parentTable === '' || $parentColumn === '') {
                continue;
            }

            if ($childTable === $table && $parentTable === $table) {
                $self[$childColumn] = [
                    'type' => 'self',
                    'table' => $table,
                    'childColumn' => $childColumn,
                    'parentColumn' => $parentColumn,
                    'displayField' => $this->detectDisplayField($tables[$table] ?? [], $parentColumn),
                ];
                continue;
            }

            if ($childTable === $table) {
                $displayField = $this->detectDisplayField(
                    $tables[$parentTable] ?? [],
                    $parentColumn
                );

                $belongsTo[$childColumn] = [
                    'type' => 'belongsTo',
                    'field' => $childColumn,
                    'childTable' => $childTable,
                    'parentTable' => $parentTable,
                    'parentKey' => $parentColumn,
                    'displayField' => $displayField,
                    'alias' => $parentTable . '_' . $displayField,
                ];
            }

            if ($parentTable === $table && $childTable !== $table) {
                $key = $this->relationKey($childTable, $childColumn);
                $childInfo = $tables[$childTable] ?? [];

                $hasMany[$key] = [
                    'key' => $key,
                    'type' => 'hasMany',
                    'childTable' => $childTable,
                    'childPrimaryKey' => (string) ($childInfo['primaryKey'] ?? 'id'),
                    'foreignKey' => $childColumn,
                    'parentTable' => $parentTable,
                    'parentKey' => $parentColumn,
                    'displayField' => $this->detectDisplayField($childInfo, $childColumn),
                    'columns' => $this->displayColumns($childInfo, $childColumn),
                ];
            }
        }

        return [
            'belongsTo' => $belongsTo,
            'hasMany' => $hasMany,
            'manyToMany' => $this->resolveManyToMany($table, $relations),
            'self' => $self,
        ];
    }

    private function resolveManyToMany(string $table, array $relations): array
    {
        $groups = [];
        foreach ($relations as $relation) {
            $groups[$relation['childTable']][] = $relation;
        }

        $result = [];
        foreach ($groups as $pivot => $foreignKeys) {
            if (count($foreignKeys) !== 2) {
                continue;
            }

            $parentTables = array_column($foreignKeys, 'parentTable');
            if (!in_array($table, $parentTables, true)) {
                continue;
            }

            foreach ($foreignKeys as $own) {
                if ($own['parentTable'] !== $table) {
                    continue;
                }

                $other = $foreignKeys[0] === $own ? $foreignKeys[1] : $foreignKeys[0];
                $key = $this->relationKey($pivot, $own['childColumn']);

                $result[$key] = [
                    'type' => 'manyToMany',
                    'pivotTable' => $pivot,
                    'ownPivotField' => $own['childColumn'],
                    'ownParentField' => $own['parentColumn'],
                    'relatedTable' => $other['parentTable'],
                    'relatedPivotField' => $other['childColumn'],
                    'relatedKey' => $other['parentColumn'],
                ];
            }
        }

        return $result;
    }

    private function relationKey(string $table, string $field): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '_', $table . '__' . $field) ?: 'relation';
    }

    private function detectDisplayField(array $tableInfo, string $excludedField): string
    {
        $columns = $tableInfo['columns'] ?? [];
        $names = array_column($columns, 'name');

        foreach ($this->config->displayFieldCandidates as $candidate) {
            if (in_array($candidate, $names, true)) {
                return $candidate;
            }
        }

        foreach ($columns as $column) {
            $name = (string) ($column['name'] ?? '');
            $type = strtolower((string) ($column['type'] ?? ''));

            if ($name !== ''
                && $name !== $excludedField
                && !in_array($name, ['created_at', 'updated_at', 'deleted_at'], true)
                && in_array($type, ['varchar', 'char', 'text', 'tinytext', 'mediumtext'], true)
            ) {
                return $name;
            }
        }

        return (string) ($tableInfo['primaryKey'] ?? $excludedField);
    }

    private function displayColumns(array $tableInfo, string $foreignKey): array
    {
        $columns = [];
        $primaryKey = (string) ($tableInfo['primaryKey'] ?? 'id');

        foreach ($tableInfo['columns'] ?? [] as $column) {
            $name = (string) ($column['name'] ?? '');

            if ($name === '' || $name === $foreignKey || $name === 'deleted_at') {
                continue;
            }

            $columns[] = $name;
            if (count($columns) >= 6) {
                break;
            }
        }

        if (!in_array($primaryKey, $columns, true)) {
            array_unshift($columns, $primaryKey);
        }

        return array_values(array_unique($columns));
    }
}
