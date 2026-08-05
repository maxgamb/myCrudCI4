<?php

namespace App\Libraries\MyCrud\Core;

use App\Libraries\MyCrud\Schema\DbSchema;
use Config\MyCrud;

class RelationResolver
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
        $info      = $this->schema->getTableInfo($table);
        $belongsTo = [];

        foreach ($info['foreignKeys'] as $foreignKey) {
            $displayField = $this->detectDisplayField($foreignKey['parentTable']);

            $belongsTo[$foreignKey['childColumn']] = [
                'type'          => 'belongsTo',
                'field'         => $foreignKey['childColumn'],
                'parentTable'   => $foreignKey['parentTable'],
                'parentKey'     => $foreignKey['parentColumn'],
                'displayField'  => $displayField,
                'alias'         => $foreignKey['parentTable'] . '_' . $displayField,
            ];
        }

        return [
            'belongsTo'  => $belongsTo,
            'hasMany'    => $this->resolveHasMany($table),
            'manyToMany' => $this->resolveManyToMany($table),
        ];
    }

    private function resolveHasMany(string $table): array
    {
        $schema = $this->schema->getSchemaInfo();
        $items  = [];

        foreach ($schema['relations'] as $relation) {
            if ($relation['parentTable'] !== $table) {
                continue;
            }

            $items[] = [
                'type'        => 'hasMany',
                'childTable'  => $relation['childTable'],
                'childField'  => $relation['childColumn'],
                'parentField' => $relation['parentColumn'],
            ];
        }

        return $items;
    }

    private function resolveManyToMany(string $table): array
    {
        $schema = $this->schema->getSchemaInfo();
        $groups = [];

        foreach ($schema['relations'] as $relation) {
            $groups[$relation['childTable']][] = $relation;
        }

        $relations = [];

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

                $relations[] = [
                    'type'              => 'manyToMany',
                    'pivotTable'        => $pivot,
                    'ownPivotField'     => $own['childColumn'],
                    'ownParentField'    => $own['parentColumn'],
                    'relatedTable'      => $other['parentTable'],
                    'relatedPivotField' => $other['childColumn'],
                    'relatedKey'        => $other['parentColumn'],
                    'displayField'      => $this->detectDisplayField($other['parentTable']),
                ];
            }
        }

        return $relations;
    }

    private function detectDisplayField(string $table): string
    {
        $info  = $this->schema->getTableInfo($table);
        $names = array_column($info['columns'], 'name');

        foreach ($this->config->displayFieldCandidates as $candidate) {
            if (in_array($candidate, $names, true)) {
                return $candidate;
            }
        }

        foreach ($names as $name) {
            if ($name !== $info['primaryKey']) {
                return $name;
            }
        }

        return $info['primaryKey'];
    }
}
