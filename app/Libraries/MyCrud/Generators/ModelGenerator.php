<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\FieldPolicy;
use App\Libraries\MyCrud\Core\Naming;

/** Generates the Model and keeps all SQL queries in the data layer. */
final class ModelGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $primaryKey = (string) $config['primaryKey'];
        $class = (string) $config['classes']['model'];
        $entity = (string) $config['classes']['entity'];
        $useEntity = !empty($config['features']['entity']);
        $apiEnabled = !empty($config['features']['api']);
        $softDeleteEnabled = !empty($config['features']['softDeletes']);
        $createAllowed = !empty($config['features']['createAllowed']);
        $writable = !empty($config['features']['writable']);
        $serviceEnabled = !empty($config['features']['service']);
        $recordDetail = !empty($config['features']['recordDetail']);
        $isView = !empty($config['isView']);
        $hasBelongsTo = !empty($config['relations']['belongsTo']);
        if ($isView) {
            $modelDoc = 'Read-only Model for SQL VIEW `' . $table . '`. Centralizes read queries, filters, and export.';
        } elseif ($createAllowed && !$writable) {
            $modelDoc = 'Model for `' . $table . '` with Read + Create capability. Does not generate record-level update/delete.';
        } else {
            $modelDoc = 'Model for `' . $table . '`. Centralizes CRUD queries, filters, relations, and persistence.';
        }
        $primaryKeys = array_values((array) ($config['primaryKeys'] ?? [$primaryKey]));
        $compositePrimaryKey = count($primaryKeys) > 1;
        $primaryAutoIncrement = !empty($config['fields'][$primaryKey]['autoIncrement']);
        $deletedField = (string) ($config['softDelete']['field'] ?? 'deleted_at');
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);
        $myCrudConfig = config('MyCrud');
        $countCacheSeconds = max(0, min(3600, (int) ($myCrudConfig->listCountCacheSeconds ?? 60)));

        $managedFields = array_values(array_filter([
            $timestampsEnabled ? 'created_at' : null,
            $timestampsEnabled ? 'updated_at' : null,
            $softDeleteEnabled ? $deletedField : null,
        ]));

        $allowed = [];
        $detailFields = [];
        $listFields = [];
        $exportFields = [];
        $filterDefinitions = [];
        $sortable = [];
        $fieldTypes = [];

        foreach ($config['fields'] as $field) {
            $name = (string) $field['name'];
            $type = strtolower((string) ($field['type'] ?? ''));
            $fieldTypes[$name] = $type;
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
            $ui = (array) ($field['ui'] ?? []);
            $isSensitive = !empty($ui['sensitive'])
                || FieldPolicy::isSensitive($name, $inputType);
            $isLarge = in_array($type, ['text', 'mediumtext', 'longtext', 'blob', 'mediumblob', 'longblob'], true);
            $isBinary = in_array($inputType, ['file', 'image'], true) || str_contains($type, 'blob') || str_contains($type, 'binary');
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary'])
                || !empty($index['unique'])
                || !empty($index['leading']);

            if (
                (empty($field['primary']) || empty($field['autoIncrement']))
                && !in_array($name, $managedFields, true)
                && empty($field['databaseManaged'])
                && $createAllowed
                && !FieldPolicy::isSpatial($type)
                && (!$isSensitive || FieldPolicy::isPassword($name, $inputType))
            ) {
                $allowed[] = $name;
            }

            if (!$isSensitive && !str_contains($type, 'blob') && !str_contains($type, 'binary')) {
                $detailFields[] = $name;
            }

            if (!empty($ui['visibleIndex']) && !$isSensitive && !$isBinary) {
                $listFields[] = $name;
            }

            if (!empty($ui['exportable']) && !$isSensitive && !$isBinary) {
                $exportFields[] = $name;
            }

            if (!empty($ui['searchable']) && ($indexEligible || $isView) && !$isSensitive && !$isLarge && !$isBinary) {
                // Lato generatore: definiamo una whitelist di operatori coerente
                // with the DB type. The UI may expose only these criteria and the
                // Model revalidates them before composing any query.
                $isNumeric = preg_match('/int|decimal|float|double|numeric|real/', $type) === 1;
                $isDate = in_array($type, ['date', 'datetime', 'timestamp', 'time'], true);
                $isBoolean = $inputType === 'checkbox' || $type === 'bool' || $type === 'boolean'
                    || preg_match('/^tinyint\(1\)/', strtolower((string) ($field['columnType'] ?? ''))) === 1;

                if ($isBoolean) {
                    $operators = ['eq', 'neq'];
                } elseif ($isNumeric || $isDate) {
                    $operators = ['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'between', 'is_null', 'not_null'];
                } else {
                    $operators = ['eq', 'neq', 'starts_with', 'contains', 'ends_with', 'is_null', 'not_null'];
                }

                $filterDefinitions[$name] = [
                    'type' => $type,
                    'operators' => $operators,
                ];
            }

            if (!empty($ui['sortable']) && ($indexEligible || $isView) && !$isSensitive && !$isLarge && !$isBinary) {
                $sortable[] = $name;
            }
        }

        if (!in_array($primaryKey, $listFields, true)) {
            array_unshift($listFields, $primaryKey);
        }
        if (!in_array($primaryKey, $exportFields, true)) {
            array_unshift($exportFields, $primaryKey);
        }
        if (!in_array($primaryKey, $sortable, true)) {
            array_unshift($sortable, $primaryKey);
        }
        if (!isset($filterDefinitions[$primaryKey])) {
            $filterDefinitions[$primaryKey] = ['type' => 'primary', 'operators' => ['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'between']];
        }

        // Every generated Model exposes a small, safe query surface for
        // other generated resources. This keeps a query on the Model that owns
        // the queried table instead of duplicating cross-table SQL in consumers.
        $resourceFieldsCode = var_export(array_values(array_keys($fieldTypes)), true);
        $resourceFieldTypesCode = var_export($fieldTypes, true);
        $foreignKeyFieldsCode = var_export(array_values(array_keys((array) ($config['relations']['belongsTo'] ?? []))), true);
        $ownSpatialFields = [];
        foreach ((array) ($config['fields'] ?? []) as $fieldName => $fieldDefinition) {
            if (!empty($fieldDefinition['spatial'])) {
                $ownSpatialFields[] = (string) $fieldName;
            }
        }
        $ownSpatialFieldsCode = var_export(array_values(array_unique($ownSpatialFields)), true);

        $detailSelects = [];
        foreach (array_values(array_unique($detailFields)) as $field) {
            $detailSelects[] = var_export($this->selectExpression($table, $field, $fieldTypes[$field] ?? ''), true);
        }
        $listSelects = [];
        $csvSelects = [];

        foreach (array_values(array_unique($listFields)) as $field) {
            $listSelects[] = var_export($this->selectExpression($table, $field, $fieldTypes[$field] ?? ''), true);
        }
        foreach (array_values(array_unique($exportFields)) as $field) {
            $csvSelects[] = var_export($this->selectExpression($table, $field, $fieldTypes[$field] ?? ''), true);
        }
        // Le chiavi di cursore devono essere presenti nelle righe di export
        // anche se lo sviluppatore le ha escluse dalle colonne esportate.
        foreach ($primaryKeys as $cursorField) {
            if ($cursorField !== '') {
                $csvSelects[] = var_export($this->selectExpression($table, $cursorField, $fieldTypes[$cursorField] ?? ''), true);
            }
        }

        $detailJoinLines = [];
        $listJoinLines = [];
        $csvJoinLines = [];
        $parentJoinMethods = [];
        $optionMethods = [];
        $optionMapLines = [];
        $relationSearchDefinitions = [];
        $relatedCreateDefinitions = [];
        $relatedCreateRelationDefinitions = [];

        foreach ($config['relations']['belongsTo'] ?? [] as $field => $relation) {
            $parentTable = (string) $relation['parentTable'];
            $parentKey = (string) $relation['parentKey'];
            $fieldConfig = (array) ($config['fields'][$field] ?? []);
            $displayField = (string) ($fieldConfig['relationDisplayField'] ?? $relation['displayField'] ?? $parentKey);
            $displayTemplate = trim((string) ($fieldConfig['relationDisplayTemplate'] ?? $relation['displayTemplate'] ?? ''));
            $availableDisplayFields = array_values((array) ($relation['availableDisplayFields'] ?? []));
            $displayFields = $this->relationDisplayFields($displayField, $displayTemplate, $availableDisplayFields);
            $alias = (string) ($relation['alias'] ?? ($field . '__label'));
            $joinAlias = preg_replace('/[^a-zA-Z0-9_]/', '_', $parentTable . '__' . $field) ?: $parentTable;
            $displaySql = $this->relationDisplaySql($joinAlias, $displayField, $displayTemplate, $displayFields);
            $displaySelect = var_export($displaySql . ' AS ' . $alias, true);

            $detailSelects[] = $displaySelect;
            if (in_array((string) $field, $listFields, true)) {
                $listSelects[] = $displaySelect;
            }
            if (in_array((string) $field, $exportFields, true)) {
                $csvSelects[] = $displaySelect;
            }
            $joinMethod = 'join' . Naming::tableClass($parentTable) . Naming::studly((string) $field);
            $joinCall = "        \$this->{$joinMethod}(\$builder);";
            $detailJoinLines[] = $joinCall;
            if (in_array((string) $field, $listFields, true)) {
                $listJoinLines[] = $joinCall;
            }
            if (in_array((string) $field, $exportFields, true)) {
                $csvJoinLines[] = $joinCall;
            }

            // Each foreign key has a single JOIN method in the Model. The technical SQL alias
            // avoids collisions (including two foreign keys to the same table), while
            // the result exposes the more readable <foreign_key>__label name.
            $parentJoinMethods[$joinMethod] = <<<PHP
    /** FK {$table}.{$field} -> {$parentTable}.{$parentKey}; risultato: {$alias}. */
    private function {$joinMethod}(BaseBuilder \$builder): BaseBuilder
    {
        \$builder->join(
            '{$parentTable} AS {$joinAlias}',
            '{$joinAlias}.{$parentKey} = {$table}.{$field}',
            'left'
        );

        return \$builder;
    }

PHP;

            $relationMode = strtolower((string) ($config['fields'][$field]['relationMode'] ?? $relation['optionMode'] ?? 'select'));
            $relationMode = in_array($relationMode, ['select', 'ajax'], true) ? $relationMode : 'select';

            $relationSearchDefinitions[(string) $field] = [
                'table' => $parentTable,
                'key' => $parentKey,
                'displayField' => $displayField,
                'displayTemplate' => $displayTemplate,
                'displayFields' => $displayFields,
                'mode' => $relationMode,
            ];

            $relatedCreate = (array) ($fieldConfig['relationCreate'] ?? []);
            $relatedCreateSchema = (array) ($relation['relatedCreate'] ?? []);
            if (!empty($relatedCreate['enabled']) && !empty($relatedCreateSchema['available'])) {
                $relatedFields = (array) ($relatedCreateSchema['fields'] ?? []);
                $relatedCreateDefinitions[(string) $field] = [
                    'table' => $parentTable,
                    'key' => $parentKey,
                    'keyAutoIncrement' => !empty($relatedCreateSchema['keyAutoIncrement']),
                    'fields' => array_values(array_keys($relatedFields)),
                    'nullableFields' => array_values(array_keys(array_filter(
                        $relatedFields,
                        static fn (array $relatedField): bool => !empty($relatedField['nullable'])
                    ))),
                    'defaultedFields' => array_values(array_keys(array_filter(
                        $relatedFields,
                        static fn (array $relatedField): bool => !empty($relatedField['hasDefault'])
                    ))),
                    'dateTimeFields' => array_values(array_keys(array_filter(
                        $relatedFields,
                        static fn (array $relatedField): bool => in_array(
                            strtolower((string) ($relatedField['type'] ?? '')),
                            ['datetime', 'timestamp'],
                            true
                        )
                    ))),
                    'spatialFields' => array_values(array_keys(array_filter(
                        $relatedFields,
                        static fn (array $relatedField): bool => !empty($relatedField['spatial'])
                    ))),
                ];

                foreach ($relatedFields as $relatedFieldName => $relatedFieldDefinition) {
                    $nestedFk = (array) ($relatedFieldDefinition['foreignKey'] ?? []);
                    if (empty($nestedFk['parentTable']) || empty($nestedFk['parentKey'])) {
                        continue;
                    }
                    $relatedCreateRelationDefinitions[(string) $field][(string) $relatedFieldName] = [
                        'table' => (string) $nestedFk['parentTable'],
                        'key' => (string) $nestedFk['parentKey'],
                        'displayField' => (string) ($nestedFk['displayField'] ?? $nestedFk['parentKey']),
                        'mode' => (string) ($nestedFk['optionMode'] ?? 'select'),
                        // A nested FK can also be UNIQUE on the record being
                        // created (for example store.manager_staff_id). In
                        // that case values already consumed by the target
                        // table are not valid choices for a new record.
                        'uniqueConsumerTable' => !empty($relatedFieldDefinition['unique']) ? $parentTable : '',
                        'uniqueConsumerField' => !empty($relatedFieldDefinition['unique']) ? (string) $relatedFieldName : '',
                    ];
                }
            }

            if ($relationMode === 'select') {
                $method = 'get' . Naming::tableClass($parentTable) . Naming::studly((string) $field) . 'Options';
                $selectFields = array_values(array_unique(array_merge([$parentKey], $displayFields)));
                $selectFieldsCode = var_export($selectFields, true);
                $parentModelClass = Naming::tableClass($parentTable) . 'Model';
                $labelDefinitionCode = var_export([
                    'displayField' => $displayField,
                    'displayTemplate' => $displayTemplate,
                ], true);
                $optionMethods[] = <<<PHP
    /**
     * Returns ready-to-render options for the explicit {$field} belongsTo relation.
     * The parent Model is fixed at generation time; no table/model resolver runs at runtime.
     *
     * @return array<string,string>
     */
    public function {$method}(): array
    {
        \$rows = (new {$parentModelClass}())->relationOptionRows(
            '{$parentKey}',
            {$selectFieldsCode},
            '{$displayField}'
        );
        \$definition = {$labelDefinitionCode};
        \$options = [];
        foreach (\$rows as \$row) {
            if (!is_array(\$row)) {
                continue;
            }
            \$options[(string) (\$row['{$parentKey}'] ?? '')] = \$this->formatRelationLabel(\$row, \$definition);
        }
        return \$options;
    }

PHP;
                $optionMapLines[] = "            '{$field}' => \$this->{$method}(),";
            }
        }

        $childMethods = [];
        $childLoaderLines = [];
        foreach ($config['relationsConfig']['hasMany'] ?? [] as $relationKey => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }

            $childTable = trim((string) ($relation['childTable'] ?? ''));
            $foreignKey = trim((string) ($relation['foreignKey'] ?? ''));

            // Additional safeguard: an incomplete relation must not interrupt
            // the entire generation. The merge already drops stale relations,
            // ma qui evitiamo fatal/warning anche con config legacy anomale.
            if ($childTable === '' || $foreignKey === '') {
                continue;
            }

            $childPk = (string) ($relation['primaryKey'] ?? 'id');
            $methodSuffix = Naming::studly($childTable) . 'By' . Naming::studly($foreignKey);
            $getMethod = 'get' . $methodSuffix;
            $limit = max(1, min(200, (int) ($relation['limit'] ?? 20)));
            $childColumnTypes = (array) ($relation['columnTypes'] ?? []);
            $childSelects = [];
            foreach ((array) ($relation['columns'] ?? []) as $childColumn) {
                $childColumn = (string) $childColumn;
                if ($childColumn === '') {
                    continue;
                }
                $childSelects[] = $this->selectExpression($childTable, $childColumn, (string) ($childColumnTypes[$childColumn] ?? ''));
            }
            $childSelectCode = var_export(array_values(array_unique($childSelects)), true);

            $childModelClass = Naming::tableClass($childTable) . 'Model';
            $childModelFqcn = $childModelClass;
            $childColumns = array_values(array_filter(array_map('strval', (array) ($relation['columns'] ?? []))));
            $childColumnsCode = var_export($childColumns, true);
            $childMethods[] = <<<PHP
    /**
     * HasMany scaffolding delegated to the Model that owns table {$childTable}.
     * The current Model only names the relation; it no longer composes child SQL.
     */
    public function {$getMethod}(int|string \$parentId, int \$limit = {$limit}): array
    {
        return (new {$childModelFqcn}())->childrenByForeignKey(
            '{$foreignKey}',
            \$parentId,
            {$childColumnsCode},
            '{$childPk}',
            \$limit
        );
    }

PHP;
            $childLoaderLines[] = "        \$result['{$relationKey}'] = \$this->{$getMethod}(\$parentId, {$limit});";
        }

        $manyToManyMethods = [];
        $manyToManyLoaderLines = [];
        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $relationKey => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }
            $pivot = trim((string) ($relation['pivotTable'] ?? ''));
            $ownPivot = trim((string) ($relation['ownPivotField'] ?? ''));
            $relatedTable = trim((string) ($relation['relatedTable'] ?? ''));
            $relatedPivot = trim((string) ($relation['relatedPivotField'] ?? ''));
            $relatedKey = trim((string) ($relation['relatedKey'] ?? ''));
            $displayField = trim((string) ($relation['relatedDisplayField'] ?? $relatedKey));
            $displayFields = array_values(array_filter(array_map('strval', (array) ($relation['relatedDisplayFields'] ?? []))));
            if ($displayFields === []) {
                $displayFields = [$displayField];
            }
            if ($pivot === '' || $ownPivot === '' || $relatedTable === '' || $relatedPivot === '' || $relatedKey === '') {
                continue;
            }
            $limit = max(1, min(200, (int) ($relation['limit'] ?? 20)));
            $suffix = Naming::studly($relatedTable) . 'Via' . Naming::studly($pivot);
            $get = 'get' . $suffix;
            $safeKey = (string) $relationKey;
            $targetModelClass = Naming::tableClass($relatedTable) . 'Model';
            $targetFields = array_values(array_unique(array_merge([$relatedKey], $displayFields)));
            $targetFieldsCode = var_export($targetFields, true);
            $manyToManyMethods[] = <<<PHP
    /**
     * Reads the {$pivot} pivot owned by this Model, then delegates target rows
     * to {$targetModelClass}. No target-table SQL is composed here.
     */
    public function {$get}(int|string \$parentId, int \$limit = {$limit}): array
    {
        \$limit = max(1, min(200, \$limit));
        \$pivotRows = \$this->db->table('{$pivot}')
            ->select('{$relatedPivot}')
            ->where('{$ownPivot}', \$parentId)
            ->limit(\$limit + 1)
            ->get()
            ->getResultArray();
        \$hasMore = count(\$pivotRows) > \$limit;
        if (\$hasMore) {
            array_pop(\$pivotRows);
        }
        \$relatedIds = array_values(array_unique(array_map('strval', array_column(\$pivotRows, '{$relatedPivot}'))));
        \$rows = \$relatedIds === []
            ? []
            : (new {$targetModelClass}())->relationRowsByIds(
                '{$relatedKey}',
                \$relatedIds,
                {$targetFieldsCode},
                '{$displayFields[0]}',
                \$limit
            );
        return ['rows' => \$rows, 'count' => count(\$rows), 'hasMore' => \$hasMore];
    }

PHP;
            $manyToManyLoaderLines[] = "        \$result['{$safeKey}'] = \$this->{$get}(\$parentId, {$limit});";
        }

        $manyToManyDefinitions = [];
        $manyToManyRelatedCreateDefinitions = [];
        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $relationKey => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }
            $manyToManyDefinitions[(string) $relationKey] = [
                'pivotTable' => (string) ($relation['pivotTable'] ?? ''),
                'ownPivotField' => (string) ($relation['ownPivotField'] ?? ''),
                'relatedTable' => (string) ($relation['relatedTable'] ?? ''),
                'relatedPivotField' => (string) ($relation['relatedPivotField'] ?? ''),
                'relatedKey' => (string) ($relation['relatedKey'] ?? ''),
                'displayField' => (string) ($relation['relatedDisplayField'] ?? $relation['relatedKey'] ?? ''),
                'displayFields' => array_values((array) ($relation['relatedDisplayFields'] ?? [])),
                'createEnabled' => !empty($relation['createEnabled']),
                'editEnabled' => !empty($relation['editEnabled']),
                'createRelatedEnabled' => !empty($relation['createRelatedEnabled']),
            ];

            if (!empty($relation['createRelatedEnabled']) && !empty($relation['createRelatedAvailable'])) {
                $definition = (array) ($relation['relatedCreate'] ?? []);
                $relatedFields = (array) ($definition['fields'] ?? []);
                $nestedRelations = [];
                foreach ($relatedFields as $relatedFieldName => $relatedField) {
                    $nestedForeignKey = (array) ($relatedField['foreignKey'] ?? []);
                    if ($nestedForeignKey === []) {
                        continue;
                    }

                    $nestedRelations[(string) $relatedFieldName] = [
                        'table' => (string) ($nestedForeignKey['parentTable'] ?? ''),
                        'key' => (string) ($nestedForeignKey['parentKey'] ?? ''),
                        'displayField' => (string) ($nestedForeignKey['displayField'] ?? ''),
                        'mode' => (string) ($nestedForeignKey['optionMode'] ?? 'select'),
                    ];
                }

                $manyToManyRelatedCreateDefinitions[(string) $relationKey] = [
                    'table' => (string) ($definition['table'] ?? $relation['relatedTable'] ?? ''),
                    'key' => (string) ($definition['key'] ?? $relation['relatedKey'] ?? ''),
                    'keyAutoIncrement' => !empty($definition['keyAutoIncrement']),
                    'fields' => array_values(array_keys($relatedFields)),
                    'nullableFields' => array_values(array_keys(array_filter(
                        $relatedFields,
                        static fn (array $relatedField): bool => !empty($relatedField['nullable'])
                    ))),
                    'defaultedFields' => array_values(array_keys(array_filter(
                        $relatedFields,
                        static fn (array $relatedField): bool => !empty($relatedField['hasDefault'])
                    ))),
                    'dateTimeFields' => array_values(array_keys(array_filter(
                        $relatedFields,
                        static fn (array $relatedField): bool => in_array(
                            strtolower((string) ($relatedField['type'] ?? '')),
                            ['datetime', 'timestamp'],
                            true
                        )
                    ))),
                    'spatialFields' => array_values(array_keys(array_filter(
                        $relatedFields,
                        static fn (array $relatedField): bool => !empty($relatedField['spatial'])
                    ))),
                    'relations' => $nestedRelations,
                ];
            }
        }
        $manyToManyRelatedCreateCode = var_export($manyToManyRelatedCreateDefinitions, true);

        $softDeleteCode = $softDeleteEnabled
            ? "    protected \$useSoftDeletes = true;\n    protected \$deletedField = '{$deletedField}';"
            : "    protected \$useSoftDeletes = false;";
        $softDataFilter = $softDeleteEnabled
            ? "        \$builder->where('{$table}.{$deletedField}', null);\n"
            : '';
        $softCountFilter = $softDeleteEnabled
            ? "        \$builder->where('{$deletedField}', null);\n"
            : '';
        $softMethods = $softDeleteEnabled ? <<<PHP
    public function getDeletedList(): array
    {
        return \$this->onlyDeleted()->orderBy('{$primaryKey}', 'DESC')->findAll();
    }

    public function restoreRecord(int|string \$id): bool
    {
        return \$this->builder()
            ->where(\$this->primaryKey, \$id)
            ->update([\$this->deletedField => null]);
    }

PHP : '';

        $timestampsCode = $timestampsEnabled
            ? "    protected \$useTimestamps = true;\n    protected \$dateFormat = 'datetime';\n    protected \$createdField = 'created_at';\n    protected \$updatedField = 'updated_at';"
            : "    protected \$useTimestamps = false;";

        $detailSelectCode = implode(",\n            ", array_values(array_unique($detailSelects)));
        $listSelectCode = implode(",\n            ", array_values(array_unique($listSelects)));
        $csvSelectCode = implode(",\n            ", array_values(array_unique($csvSelects)));
        $detailJoinsCode = implode("\n", $detailJoinLines);
        $listJoinsCode = implode("\n", $listJoinLines);
        $csvJoinsCode = implode("\n", $csvJoinLines);
        $parentJoinMethodsCode = implode('', array_values($parentJoinMethods));
        $optionsMethodsCode = implode('', $optionMethods);
        $optionMapCode = implode("\n", $optionMapLines);
        $childrenMethodsCode = $recordDetail
            ? implode('', array_merge($childMethods, $manyToManyMethods))
            : '';
        $childrenLoaderCode = $recordDetail
            ? implode("\n\n", array_merge($childLoaderLines, $manyToManyLoaderLines))
            : '';
        $allowedCode = var_export(array_values(array_unique($allowed)), true);
        $filtersCode = var_export($filterDefinitions, true);
        $sortableCode = var_export(array_values(array_unique($sortable)), true);
        $exportFieldsCode = var_export(array_values(array_unique($exportFields)), true);
        $relationSearchCode = var_export($relationSearchDefinitions, true);
        $relatedCreateCode = var_export($relatedCreateDefinitions, true);
        $primaryKeysCode = var_export($primaryKeys, true);
        $entityUse = $useEntity ? 'use App\\Entities\\' . $entity . ';' : '';
        $returnTypeCode = $useEntity ? $entity . '::class' : "'object'";

        if ($compositePrimaryKey) {
            $orderLines = [];
            foreach ($primaryKeys as $keyField) {
                $orderLines[] = "            ->orderBy('{$table}.{$keyField}', 'ASC')";
            }
            $orderCode = implode("\n", $orderLines);
            $cursorWhere = <<<'PHP'
        if ($after !== null && $after !== '') {
            $cursor = json_decode((string) $after, true);
            if (is_array($cursor)) {
                $keys = self::PRIMARY_KEYS;
                $builder->groupStart();
                foreach ($keys as $position => $key) {
                    $builder->orGroupStart();
                    for ($i = 0; $i < $position; $i++) {
                        if (array_key_exists($keys[$i], $cursor)) {
                            $builder->where($this->table . '.' . $keys[$i], $cursor[$keys[$i]]);
                        }
                    }
                    if (array_key_exists($key, $cursor)) {
                        $builder->where($this->table . '.' . $key . ' >', $cursor[$key]);
                    }
                    $builder->groupEnd();
                }
                $builder->groupEnd();
            }
        }
PHP;
            $exportOrderCode = $orderCode;
        } else {
            $cursorWhere = <<<PHP
        if (\$after !== null && \$after !== '') {
            \$builder->where('{$table}.{$primaryKey} >', \$after);
        }
PHP;
            $exportOrderCode = "            ->orderBy('{$table}.{$primaryKey}', 'ASC')";
        }

        $apiMethodsCode = $apiEnabled ? <<<PHP
    /** Paginated REST list with filter and sorting whitelists. */
    public function apiList(array \$query, array \$filterable, array \$sortable): array
    {
        \$page = max(1, (int) (\$query['page'] ?? 1));
        \$perPage = max(1, min(100, (int) (\$query['perPage'] ?? 25)));
        \$builder = \$this->baseBuilder();

        foreach ((array) (\$query['filter'] ?? []) as \$field => \$value) {
            if (is_scalar(\$value) && in_array(\$field, \$filterable, true) && (string) \$value !== '') {
                \$builder->where('{$table}.' . \$field, \$value);
            }
        }

        \$sort = (string) (\$query['sort'] ?? '{$primaryKey}');
        \$sort = in_array(\$sort, \$sortable, true) ? \$sort : '{$primaryKey}';
        \$direction = strtolower((string) (\$query['direction'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';
        \$total = (clone \$builder)->countAllResults(false);
        \$rows = \$builder->orderBy('{$table}.' . \$sort, \$direction)
            ->limit(\$perPage, (\$page - 1) * \$perPage)
            ->get()
            ->getResult();
        \$pageCount = max(1, (int) ceil(\$total / \$perPage));

        return [
            'rows' => \$rows,
            'meta' => [
                'page' => \$page,
                'perPage' => \$perPage,
                'total' => \$total,
                'pageCount' => \$pageCount,
            ],
            'links' => [
                'self' => \$this->apiLink(\$query, \$page),
                'next' => \$page < \$pageCount ? \$this->apiLink(\$query, \$page + 1) : null,
                'prev' => \$page > 1 ? \$this->apiLink(\$query, \$page - 1) : null,
            ],
        ];
    }

PHP : '';

        $createReturnCode = $primaryAutoIncrement
            ? "        return is_int(\$id) ? \$id : (string) \$id;"
            : "        if (array_key_exists('{$primaryKey}', \$data) && (is_int(\$data['{$primaryKey}']) || is_string(\$data['{$primaryKey}']))) {\n            return \$data['{$primaryKey}'];\n        }\n        return is_int(\$id) ? \$id : (string) \$id;";

        $hasRelatedCreates = $relatedCreateDefinitions !== [];
        $hasManyToManyRelatedCreates = $manyToManyRelatedCreateDefinitions !== [];
        $hasOperationalManyToMany = $manyToManyDefinitions !== [];
        $manyToManyCreateEnabled = (bool) array_filter(
            $manyToManyDefinitions,
            static fn (array $definition): bool => !empty($definition['createEnabled'])
        );
        $manyToManyEditEnabled = (bool) array_filter(
            $manyToManyDefinitions,
            static fn (array $definition): bool => !empty($definition['editEnabled'])
        );

        $relatedCreateLoopCode = ($hasRelatedCreates && !$serviceEnabled) ? <<<'PHP'
            foreach ($related as $field => $payload) {
                if (!is_array($payload) || !isset(self::RELATED_CREATES[$field])) {
                    continue;
                }
                $data[$field] = $this->createRelatedRecord((string) $field, $payload);
            }

PHP : '';
        $createManyToManyRelatedCode = ($hasManyToManyRelatedCreates && !$serviceEnabled) ? <<<'PHP'
            if ($manyToManyNew !== []) {
                $this->createManyToManyRelatedRecords($manyToManyNew, $manyToMany);
            }

PHP : '';

        $createManyToManyCode = (!$serviceEnabled && $hasOperationalManyToMany) ? <<<'PHP'
            if ($manyToMany !== []) {
                $this->applyManyToMany((string) $id, $manyToMany, 'createEnabled');
            }

PHP : '';
        $createTransactional = !$serviceEnabled && ($hasRelatedCreates || $hasOperationalManyToMany || $hasManyToManyRelatedCreates);
        $createTransactionBeginCode = $createTransactional ? <<<'PHP'
        $this->db->transBegin();

PHP : '';
        $createTransactionCheckCode = $createTransactional ? <<<'PHP'
            if (!$this->db->transStatus()) {
                throw new RuntimeException('Transazione di inserimento non riuscita.');
            }
            $this->db->transCommit();
PHP : '';
        $createTransactionCatchCode = $createTransactional ? <<<'PHP'
            $this->db->transRollback();
PHP : '';

        $modelCreateNeedsRelated = !$serviceEnabled && $hasRelatedCreates;
        $modelCreateNeedsManyToMany = !$serviceEnabled && ($manyToManyCreateEnabled || $hasManyToManyRelatedCreates);
        $modelCreateNeedsManyToManyNew = !$serviceEnabled && $hasManyToManyRelatedCreates;
        $modelCreateDataType = $useEntity ? $entity : 'array';
        $modelCreateParams = ["{$modelCreateDataType} \$data"];
        $modelCreateDocParams = $useEntity
            ? "     * @param {$entity} \$data Prepared domain record.\n"
            : "     * @param array<string,mixed> \$data Sanitized write payload.\n";
        if ($modelCreateNeedsRelated) {
            $modelCreateParams[] = "array \$related = []";
            $modelCreateDocParams .= "     * @param array<string,array<string,mixed>> \$related\n";
        }
        if ($modelCreateNeedsManyToMany) {
            $modelCreateParams[] = "array \$manyToMany = []";
            $modelCreateDocParams .= "     * @param array<string,list<int|string>> \$manyToMany\n";
        }
        if ($modelCreateNeedsManyToManyNew) {
            $modelCreateParams[] = "array \$manyToManyNew = []";
            $modelCreateDocParams .= "     * @param array<string,array<string,mixed>> \$manyToManyNew\n";
        }
        $modelCreateSignature = implode(",\n        ", $modelCreateParams);
        if ($createTransactional) {
            $modelCreateBody = <<<PHP
        \$this->db->transBegin();
        try {
{$relatedCreateLoopCode}{$createManyToManyRelatedCode}            \$id = \$this->insert(\$data, true);
            if (\$id === false) {
                throw new RuntimeException(implode(' ', \$this->errors()) ?: 'Insert failed.');
            }

{$createManyToManyCode}            if (!\$this->db->transStatus()) {
                throw new RuntimeException('Insert transaction failed.');
            }
            \$this->db->transCommit();
        } catch (Throwable \$e) {
            \$this->db->transRollback();
            throw \$e;
        }

PHP;
        } else {
            $modelCreateBody = <<<'PHP'
        $id = $this->insert($data, true);
        if ($id === false) {
            throw new RuntimeException(implode(' ', $this->errors()) ?: 'Insert failed.');
        }

PHP;
        }

        $createRecordMethodsCode = $createAllowed ? <<<PHP
    /**
     * Inserts this Model's own record and only the relation payloads that are
     * actually enabled for this resource.
     *
{$modelCreateDocParams}     * @return int|string
     * @throws RuntimeException|\Throwable If persistence cannot be completed.
     */
    public function createRecord(
        {$modelCreateSignature}
    ): int|string {
{$modelCreateBody}        \$this->clearListCountCache();
{$createReturnCode}
    }

PHP : '';

        // Generate named many-to-many relation methods. Runtime SQL never derives a
        // target/pivot table from metadata; every relation is written explicitly.
        $manyToManyExplicitMethods = [];
        $manyToManyFormOptionMapLines = [];
        $manyToManySelectedMapLines = [];
        $manyToManyApplyLines = [];
        foreach ($manyToManyDefinitions as $relationKey => $definition) {
            $relationName = (string) $relationKey;
            $enabledForForm = ($createAllowed && !empty($definition['createEnabled']))
                || ($writable && !empty($definition['editEnabled']));
            $relatedTable = (string) ($definition['relatedTable'] ?? '');
            $relatedKey = (string) ($definition['relatedKey'] ?? '');
            $pivot = (string) ($definition['pivotTable'] ?? '');
            $own = (string) ($definition['ownPivotField'] ?? '');
            $relatedPivot = (string) ($definition['relatedPivotField'] ?? '');
            $labelFields = array_values(array_filter(array_map('strval', (array) ($definition['displayFields'] ?? []))));
            $displayField = (string) ($definition['displayField'] ?? $relatedKey);
            if ($labelFields === []) {
                $labelFields = [$displayField];
            }
            if ($relatedTable === '' || $relatedKey === '' || $pivot === '' || $own === '' || $relatedPivot === '') {
                continue;
            }
            $targetModelClass = Naming::tableClass($relatedTable) . 'Model';
            $targetStem = Naming::tableClass($relatedTable);
            $suffix = Naming::studly($relationName);
            $optionsMethod = 'get' . $targetStem . 'OptionsFor' . $suffix;
            $selectedMethod = 'getSelected' . $targetStem . 'IdsFor' . $suffix;
            $syncMethod = 'sync' . $targetStem . 'IdsFor' . $suffix;
            $selectFields = array_values(array_unique(array_merge([$relatedKey], $labelFields)));
            $selectFieldsCode = var_export($selectFields, true);
            $labelFieldsCode = var_export($labelFields, true);

            if ($enabledForForm) {
                $manyToManyExplicitMethods[] = <<<PHP
    /** Returns selectable {$relatedTable} targets for relation {$relationName}. */
    public function {$optionsMethod}(): array
    {
        \$rows = (new {$targetModelClass}())->relationOptionRows(
            '{$relatedKey}',
            {$selectFieldsCode},
            '{$labelFields[0]}'
        );
        return array_map(static function (array \$row): array {
            \$parts = [];
            foreach ({$labelFieldsCode} as \$field) {
                \$value = trim((string) (\$row[\$field] ?? ''));
                if (\$value !== '') { \$parts[] = \$value; }
            }
            return [
                'id' => (string) (\$row['{$relatedKey}'] ?? ''),
                'text' => \$parts !== [] ? implode(' ', \$parts) : (string) (\$row['{$relatedKey}'] ?? ''),
            ];
        }, \$rows);
    }

PHP;
                $manyToManyFormOptionMapLines[] = "            '{$relationName}' => \$this->{$optionsMethod}(),";
            }

            if ($manyToManyEditEnabled && $writable && !empty($definition['editEnabled'])) {
                $manyToManyExplicitMethods[] = <<<PHP
    /** Returns selected {$relatedTable} IDs from pivot {$pivot}. */
    public function {$selectedMethod}(int|string \$parentId): array
    {
        \$rows = \$this->db->table('{$pivot}')
            ->select('{$relatedPivot}')
            ->where('{$own}', \$parentId)
            ->get()
            ->getResultArray();
        return array_map('strval', array_column(\$rows, '{$relatedPivot}'));
    }

PHP;
                $manyToManySelectedMapLines[] = "            '{$relationName}' => \$this->{$selectedMethod}(\$parentId),";
            }

            $createPermission = !empty($definition['createEnabled']);
            $editPermission = !empty($definition['editEnabled']);
            if (($createAllowed && $createPermission) || ($writable && $editPermission)) {
                $manyToManyExplicitMethods[] = <<<PHP
    /** Synchronizes pivot {$pivot} with explicit {$targetModelClass} validation. */
    public function {$syncMethod}(int|string \$parentId, array \$ids): void
    {
        \$ids = array_values(array_unique(array_map('strval', array_filter(
            \$ids,
            static fn (mixed \$id): bool => is_scalar(\$id) && trim((string) \$id) !== ''
        ))));
        if (count(\$ids) > 500) {
            throw new RuntimeException('Too many many-to-many associations for {$relationName}.');
        }
        if (\$ids !== []) {
            \$validRows = (new {$targetModelClass}())->relationRowsByIds(
                '{$relatedKey}', \$ids, ['{$relatedKey}'], '{$relatedKey}', count(\$ids)
            );
            \$valid = array_map(static fn (object \$row): string => (string) (\$row->{$relatedKey} ?? ''), \$validRows);
            if (count(array_unique(\$valid)) !== count(\$ids)) {
                throw new RuntimeException('One or more {$relatedTable} records do not exist for {$relationName}.');
            }
        }
        \$existingRows = \$this->db->table('{$pivot}')
            ->select('{$relatedPivot}')
            ->where('{$own}', \$parentId)
            ->get()
            ->getResultArray();
        \$existing = array_map('strval', array_column(\$existingRows, '{$relatedPivot}'));
        foreach (array_diff(\$ids, \$existing) as \$attachId) {
            if (!\$this->db->table('{$pivot}')->insert(['{$own}' => \$parentId, '{$relatedPivot}' => \$attachId])) {
                throw new RuntimeException('Attach pivot failed for {$relationName}.');
            }
        }
        \$detach = array_values(array_diff(\$existing, \$ids));
        if (\$detach !== []) {
            \$this->db->table('{$pivot}')->where('{$own}', \$parentId)->whereIn('{$relatedPivot}', \$detach)->delete();
        }
    }

PHP;
                $permissions = [];
                if ($createPermission) $permissions[] = 'createEnabled';
                if ($editPermission) $permissions[] = 'editEnabled';
                $conditions = [];
                foreach ($permissions as $perm) {
                    $conditions[] = "\$permission === '{$perm}'";
                }
                $conditionCode = implode(' || ', $conditions);
                $manyToManyApplyLines[] = <<<PHP
        if (($conditionCode) && isset(\$payload['{$relationName}']) && is_array(\$payload['{$relationName}'])) {
            \$this->{$syncMethod}(\$parentId, \$payload['{$relationName}']);
        }
PHP;
            }
        }

        $manyToManyExplicitMethodsCode = implode("\n", $manyToManyExplicitMethods);
        $manyToManyFormOptionsCode = $manyToManyFormOptionMapLines !== [] ? <<<PHP
    /** @return array<string,list<array{id:string,text:string}>> */
    public function manyToManyFormOptions(): array
    {
        return [
        ];
    }

PHP : '';
        if ($manyToManyFormOptionMapLines !== []) {
            $map = implode("\n", $manyToManyFormOptionMapLines);
            $manyToManyFormOptionsCode = "    /** @return array<string,list<array{id:string,text:string}>> */\n    public function manyToManyFormOptions(): array\n    {\n        return [\n{$map}\n        ];\n    }\n\n";
        }
        $manyToManySelectedCode = '';
        if ($manyToManySelectedMapLines !== []) {
            $map = implode("\n", $manyToManySelectedMapLines);
            $manyToManySelectedCode = "    /** @return array<string,list<string>> */\n    public function manyToManySelected(int|string \$parentId): array\n    {\n        return [\n{$map}\n        ];\n    }\n\n";
        }

        $updateManyToManyRelatedCode = ($hasManyToManyRelatedCreates && !$serviceEnabled) ? <<<'PHP'
            if ($manyToManyNew !== []) {
                $this->createManyToManyRelatedRecords($manyToManyNew, $manyToMany);
            }
PHP : '';

        $modelUpdateNeedsManyToMany = !$serviceEnabled && ($manyToManyEditEnabled || $hasManyToManyRelatedCreates);
        if ($writable && $modelUpdateNeedsManyToMany) {
            $modelUpdateParams = ["int|string \$id", "array \$data", "array \$manyToMany = []"];
            if (!$serviceEnabled && $hasManyToManyRelatedCreates) {
                $modelUpdateParams[] = "array \$manyToManyNew = []";
            }
            $modelUpdateSignature = implode(",\n        ", $modelUpdateParams);
            $updateRecordCode = <<<PHP
    /** Updates the record and synchronizes configured explicit pivots. */
    public function updateRecordWithManyToMany(
        {$modelUpdateSignature}
    ): bool {
        \$this->db->transBegin();
        try {
{$updateManyToManyRelatedCode}            if (!\$this->update(\$id, \$data)) {
                throw new RuntimeException(implode(' ', \$this->errors()) ?: 'Update failed.');
            }
            if (\$manyToMany !== []) {
                \$this->applyManyToMany((string) \$id, \$manyToMany, 'editEnabled');
            }
            if (!\$this->db->transStatus()) {
                throw new RuntimeException('Many-to-many transaction failed.');
            }
            \$this->db->transCommit();
            \$this->clearListCountCache();
            return true;
        } catch (Throwable \$e) {
            \$this->db->transRollback();
            throw \$e;
        }
    }

PHP;
        } elseif ($writable) {
            $updateDataType = $useEntity ? $entity : 'array';
            $updateDataDoc = $useEntity
                ? $entity . ' $data Prepared domain record.'
                : 'array<string,mixed> $data Sanitized write payload.';
            $updateRecordCode = <<<PHP
    /**
     * Updates only this Model's own table.
     *
     * Cross-resource and pivot orchestration is owned by the generated Service.
     *
     * @param int|string \$id Record identifier.
     * @param {$updateDataDoc}
     * @return bool True when the update succeeds.
     */
    public function updateRecord(int|string \$id, {$updateDataType} \$data): bool
    {
        if (!\$this->update(\$id, \$data)) {
            return false;
        }
        \$this->clearListCountCache();
        return true;
    }

PHP;
        } else {
            $updateRecordCode = '';
        }

        $manyToManyTargetValidatorCode = '';
        $applyManyToManyCode = (!$serviceEnabled && $manyToManyApplyLines !== []) ? "    /** Routes only to generated named pivot synchronizers; no table metadata is resolved at runtime. */\n    private function applyManyToMany(int|string \$parentId, array \$payload, string \$permission): void\n    {\n" . implode("\n", $manyToManyApplyLines) . "    }\n\n" : '';

        $manyToManyRelatedCreateOptionLines = [];
        foreach ($manyToManyRelatedCreateDefinitions as $relationKey => $definition) {
            foreach ((array) ($definition['relations'] ?? []) as $field => $relation) {
                if (($relation['mode'] ?? 'select') !== 'select') {
                    continue;
                }
                $tableName = (string) ($relation['table'] ?? '');
                $key = (string) ($relation['key'] ?? '');
                $display = (string) ($relation['displayField'] ?? '');
                if ($tableName === '' || $key === '' || $display === '') {
                    continue;
                }
                $targetModelClass = Naming::tableClass($tableName) . 'Model';
                $varSuffix = Naming::studly((string) $relationKey) . Naming::studly((string) $field);
                $rowsVar = '$rowsM2M' . $varSuffix;
                $fieldsCode = var_export(array_values(array_unique([$key, $display])), true);
                $manyToManyRelatedCreateOptionLines[] = "        {$rowsVar} = (new {$targetModelClass}())->relationOptionRows('{$key}', {$fieldsCode}, '{$display}');";
                $manyToManyRelatedCreateOptionLines[] = "        foreach ({$rowsVar} as \$row) { \$result['{$relationKey}']['{$field}'][] = ['id' => (string) (\$row['{$key}'] ?? ''), 'text' => (string) (\$row['{$display}'] ?? \$row['{$key}'] ?? '')]; }";
            }
        }
        $manyToManyRelatedCreateOptionBody = implode("\n", $manyToManyRelatedCreateOptionLines);
        $manyToManyRelatedCreateOptionsCode = $manyToManyRelatedCreateOptionBody !== '' ? <<<PHP
    /**
     * Options for foreign keys inside inline-created many-to-many targets.
     * Each target lookup is delegated statically to the owning Model.
     *
     * @return array<string,array<string,list<array{id:string,text:string}>>>
     */
    public function manyToManyRelatedCreateRelationOptions(): array
    {
        \$result = [];
{$manyToManyRelatedCreateOptionBody}
        return \$result;
    }

PHP : '';

        $createManyToManyRelatedRecordCode = ($hasManyToManyRelatedCreates && !$serviceEnabled) ? <<<'PHP'
    /**
     * Creates configured many-to-many target records and appends their IDs
     * to the association payload. The caller owns the surrounding transaction.
     *
     * @param array<string,array<string,mixed>> $newRecords
     * @param array<string,list<int|string>> $manyToMany
     */
    private function createManyToManyRelatedRecords(array $newRecords, array &$manyToMany): void
    {
        foreach ($newRecords as $relationKey => $data) {
            if (!is_array($data) || !isset(self::MANY_TO_MANY_RELATED_CREATES[$relationKey])) {
                continue;
            }

            $definition = self::MANY_TO_MANY_RELATED_CREATES[$relationKey];
            $allowed = array_fill_keys((array) ($definition['fields'] ?? []), true);
            $payload = array_intersect_key($data, $allowed);
            $nullable = array_fill_keys((array) ($definition['nullableFields'] ?? []), true);
            $defaulted = array_fill_keys((array) ($definition['defaultedFields'] ?? []), true);

            foreach ($payload as $field => $value) {
                if (!is_string($value) || trim($value) !== '') {
                    continue;
                }
                if (isset($defaulted[$field])) {
                    unset($payload[$field]);
                    continue;
                }
                if (isset($nullable[$field])) {
                    $payload[$field] = null;
                }
            }

            foreach ((array) ($definition['dateTimeFields'] ?? []) as $dateTimeField) {
                if (isset($payload[$dateTimeField]) && is_string($payload[$dateTimeField])) {
                    $payload[$dateTimeField] = str_replace('T', ' ', $payload[$dateTimeField]);
                }
            }

            $table = (string) ($definition['table'] ?? '');
            $key = (string) ($definition['key'] ?? '');
            if ($table === '' || $key === '') {
                throw new RuntimeException('Many-to-many related-create configuration is incomplete.');
            }

            foreach ((array) ($definition['relations'] ?? []) as $field => $relation) {
                if (!array_key_exists($field, $payload)) {
                    continue;
                }

                $value = $payload[$field];
                if ($value === null || (is_scalar($value) && trim((string) $value) === '')) {
                    continue;
                }

                $parentTable = (string) ($relation['table'] ?? '');
                $parentKey = (string) ($relation['key'] ?? '');
                if ($parentTable === '' || $parentKey === '') {
                    throw new RuntimeException('Nested relation configuration is incomplete for ' . $field . '.');
                }

                $exists = $this->db->table($parentTable)
                    ->select($parentKey)
                    ->where($parentKey, $value)
                    ->limit(1)
                    ->get()
                    ->getRowArray();

                if (!is_array($exists)) {
                    throw new RuntimeException('Invalid related value for ' . $field . '.');
                }
            }

            if (!$this->db->table($table)->insert($payload)) {
                throw new RuntimeException('Unable to create many-to-many related record: ' . $table . '.');
            }

            if (!empty($definition['keyAutoIncrement'])) {
                $newId = $this->db->insertID();
            } else {
                $newId = $payload[$key] ?? null;
            }

            if (!is_int($newId) && !is_string($newId)) {
                throw new RuntimeException('Created related record key is unavailable for ' . $table . '.');
            }
            if ((string) $newId === '' || (string) $newId === '0') {
                throw new RuntimeException('Created related record key is invalid for ' . $table . '.');
            }

            $manyToMany[(string) $relationKey] ??= [];
            $manyToMany[(string) $relationKey][] = $newId;
            $manyToMany[(string) $relationKey] = array_values(array_unique(
                array_map('strval', $manyToMany[(string) $relationKey])
            ));
        }
    }

PHP : '';

        if ($createAllowed && $serviceEnabled) {
            if ($ownSpatialFields !== []) {
                $insertRelatedPayloadCode = <<<'PHP'
    /**
     * Inserts this Model's own resource for reuse by another generated Service.
     *
     * Spatial columns are serialized explicitly with ST_GeomFromText(); ordinary
     * columns remain standard bound values. The caller owns any wider transaction.
     *
     * @param array<string,mixed> $data
     * @return int|string
     */
    public function insertRelatedPayload(array $data): int|string
    {
        $allowed = array_fill_keys($this->allowedFields, true);
        $payload = array_intersect_key($data, $allowed);
        $builder = $this->db->table($this->table);
        $spatialFields = array_fill_keys(self::OWN_SPATIAL_FIELDS, true);

        foreach ($payload as $field => $value) {
            if (!isset($spatialFields[$field])) {
                $builder->set($field, $value);
                continue;
            }

            $wkt = trim((string) $value);
            if ($wkt === '') {
                throw new RuntimeException('Spatial value is required for ' . $field . '.');
            }
            $builder->set($field, 'ST_GeomFromText(' . $this->db->escape($wkt) . ')', false);
        }

        if (!$builder->insert()) {
            $dbError = (array) $this->db->error();
            $dbCode = trim((string) ($dbError['code'] ?? ''));
            $dbMessage = trim((string) ($dbError['message'] ?? ''));
            $detail = $dbMessage !== ''
                ? ' Database error' . ($dbCode !== '' ? ' [' . $dbCode . ']' : '') . ': ' . $dbMessage
                : '';
            throw new RuntimeException('Unable to insert related resource: ' . $this->table . '.' . $detail);
        }

        if ($this->useAutoIncrement) {
            $id = $this->db->insertID();
            if ($id === 0 || $id === '0' || $id === '') {
                throw new RuntimeException('Generated key is unavailable for ' . $this->table . '.');
            }
            $this->clearListCountCache();
            return is_int($id) ? $id : (string) $id;
        }

        $id = $payload[$this->primaryKey] ?? null;
        if (!is_int($id) && !is_string($id)) {
            throw new RuntimeException('The related resource key must have a value: ' . $this->primaryKey . '.');
        }

        $this->clearListCountCache();
        return $id;
    }

PHP;
            } else {
                $insertRelatedPayloadCode = <<<'PHP'
    /**
     * Inserts this Model's own resource for reuse by another generated Service.
     *
     * This table has no spatial fields, so Related Create uses the normal CI4
     * insert path without GIS-specific branches. The caller owns any wider transaction.
     *
     * @param array<string,mixed> $data
     * @return int|string
     */
    public function insertRelatedPayload(array $data): int|string
    {
        $allowed = array_fill_keys($this->allowedFields, true);
        $payload = array_intersect_key($data, $allowed);
        $id = $this->insert($payload, true);
        if ($id === false) {
            $dbError = (array) $this->db->error();
            $dbCode = trim((string) ($dbError['code'] ?? ''));
            $dbMessage = trim((string) ($dbError['message'] ?? ''));
            $detail = $dbMessage !== ''
                ? ' Database error' . ($dbCode !== '' ? ' [' . $dbCode . ']' : '') . ': ' . $dbMessage
                : '';
            throw new RuntimeException('Unable to insert related resource: ' . $this->table . '.' . $detail);
        }

        if ($this->useAutoIncrement) {
            $this->clearListCountCache();
            return is_int($id) ? $id : (string) $id;
        }

        $recordId = $payload[$this->primaryKey] ?? $id;
        if (!is_int($recordId) && !is_string($recordId)) {
            throw new RuntimeException('The related resource key must have a value: ' . $this->primaryKey . '.');
        }

        $this->clearListCountCache();
        return $recordId;
    }

PHP;
            }
        } else {
            $insertRelatedPayloadCode = '';
        }

        $createRelatedRecordCode = ($createAllowed && $hasRelatedCreates && !$serviceEnabled) ? <<<'PHP'
    /**
     * Creates a single parent record authorized by generated configuration.
     *
     * @param array<string,mixed> $data
     * @return int|string
     * @throws RuntimeException
     */
    private function createRelatedRecord(string $field, array $data): int|string
    {
        $definition = self::RELATED_CREATES[$field] ?? null;
        if (!is_array($definition)) {
            throw new RuntimeException('Related-record creation is not authorized for ' . $field . '.');
        }

        $allowed = array_fill_keys((array) ($definition['fields'] ?? []), true);
        $payload = array_intersect_key($data, $allowed);
        $nullable = array_fill_keys((array) ($definition['nullableFields'] ?? []), true);
        $defaulted = array_fill_keys((array) ($definition['defaultedFields'] ?? []), true);
        foreach ($payload as $payloadField => $payloadValue) {
            if (!is_string($payloadValue) || trim($payloadValue) !== '') {
                continue;
            }
            if (isset($defaulted[$payloadField])) {
                unset($payload[$payloadField]);
                continue;
            }
            if (isset($nullable[$payloadField])) {
                $payload[$payloadField] = null;
            }
        }

        foreach ((array) ($definition['dateTimeFields'] ?? []) as $dateTimeField) {
            if (isset($payload[$dateTimeField]) && is_string($payload[$dateTimeField])) {
                $payload[$dateTimeField] = str_replace('T', ' ', $payload[$dateTimeField]);
            }
        }

        $table = (string) ($definition['table'] ?? '');
        $key = (string) ($definition['key'] ?? '');
        if ($table === '' || $key === '') {
            throw new RuntimeException('Related-record configuration is incomplete.');
        }
        $builder = $this->db->table($table);
        $spatialFields = array_fill_keys((array) ($definition['spatialFields'] ?? []), true);
        foreach ($payload as $payloadField => $payloadValue) {
            if (!isset($spatialFields[$payloadField])) {
                $builder->set($payloadField, $payloadValue);
                continue;
            }

            $wkt = trim((string) $payloadValue);
            if ($wkt === '') {
                throw new RuntimeException('Spatial value is required for ' . $payloadField . '.');
            }
            // WKT is escaped as a value; only the trusted SQL function is raw.
            $builder->set($payloadField, 'ST_GeomFromText(' . $this->db->escape($wkt) . ')', false);
        }
        if (!$builder->insert()) {
            $dbError = (array) $this->db->error();
            $dbCode = trim((string) ($dbError['code'] ?? ''));
            $dbMessage = trim((string) ($dbError['message'] ?? ''));
            $detail = $dbMessage !== ''
                ? ' Database error' . ($dbCode !== '' ? ' [' . $dbCode . ']' : '') . ': ' . $dbMessage
                : '';
            log_message('error', 'Related Create insert failed for {table}: {code} {message}', [
                'table' => $table,
                'code' => $dbCode,
                'message' => $dbMessage,
            ]);
            throw new RuntimeException('Unable to insert related record: ' . $table . '.' . $detail);
        }

        if (!empty($definition['keyAutoIncrement'])) {
            $id = $this->db->insertID();
            if ($id === 0 || $id === '0' || $id === '') {
                throw new RuntimeException('Generated key is not available for ' . $table . '.');
            }
            return is_int($id) ? $id : (string) $id;
        }

        $id = $payload[$key] ?? null;
        if (!is_int($id) && !is_string($id)) {
            throw new RuntimeException('The related-record key must have a value: ' . $key . '.');
        }

        return $id;
    }

PHP : '';

        $writeMethodsCode = $createRecordMethodsCode
            . $insertRelatedPayloadCode
            . $manyToManyExplicitMethodsCode
            . $manyToManyFormOptionsCode
            . $manyToManyRelatedCreateOptionsCode
            . $manyToManySelectedCode
            . $updateRecordCode
            . $manyToManyTargetValidatorCode
            . $applyManyToManyCode
            . $createManyToManyRelatedRecordCode
            . $createRelatedRecordCode;

        $detailMethodCode = ($recordDetail || $writable) ? <<<'PHP'
    /** Returns the detail record with belongsTo labels already resolved. */
    public function getDetail(int|string $id): ?object
    {
        return $this->baseBuilder()
            ->where($this->table . '.' . $this->primaryKey, $id)
            ->get()
            ->getRow();
    }

PHP : '';

        // List cache invalidation and shared query primitives are inherited from BaseCrudModel.

        // Cross-resource reusable query primitives are inherited from BaseCrudModel.
        // Generated Models keep only domain-specific relation methods.
        $resourceReuseMethodsCode = '';

        // Generate static cross-Model calls for nested Related Create options.
        // The consumer Model never chooses a table name at runtime.
        $relatedCreateOptionLines = [];
        foreach ($relatedCreateRelationDefinitions as $relationField => $fields) {
            foreach ($fields as $field => $definition) {
                if (($definition['mode'] ?? 'select') !== 'select') {
                    continue;
                }
                $parentModelClass = Naming::tableClass((string) $definition['table']) . 'Model';
                $key = (string) $definition['key'];
                $display = (string) $definition['displayField'];
                $varSuffix = Naming::studly((string) $relationField) . Naming::studly((string) $field);
                $rowsVar = '$rows' . $varSuffix;
                $selectFieldsCode = var_export(array_values(array_unique([$key, $display])), true);
                $relatedCreateOptionLines[] = "        {$rowsVar} = (new {$parentModelClass}())->relationOptionRows('{$key}', {$selectFieldsCode}, '{$display}');";

                $consumerTable = trim((string) ($definition['uniqueConsumerTable'] ?? ''));
                $consumerField = trim((string) ($definition['uniqueConsumerField'] ?? ''));
                if ($consumerTable !== '' && $consumerField !== '') {
                    $consumerModelClass = Naming::tableClass($consumerTable) . 'Model';
                    $usedVar = '$used' . $varSuffix;
                    $relatedCreateOptionLines[] = "        {$usedVar} = array_values(array_filter(array_map(static fn (array \$row): string => (string) (\$row['{$consumerField}'] ?? ''), (new {$consumerModelClass}())->relationOptionRows('{$consumerField}', ['{$consumerField}'], '{$consumerField}', '', null, 5000)), static fn (string \$value): bool => \$value !== ''));";
                    $relatedCreateOptionLines[] = "        if ({$usedVar} !== []) { {$rowsVar} = array_values(array_filter({$rowsVar}, static fn (array \$row): bool => !in_array((string) (\$row['{$key}'] ?? ''), {$usedVar}, true))); }";
                }
                $relatedCreateOptionLines[] = "        foreach ({$rowsVar} as \$row) { \$result['{$relationField}']['{$field}'][] = ['id' => (string) (\$row['{$key}'] ?? ''), 'text' => (string) (\$row['{$display}'] ?? \$row['{$key}'] ?? '')]; }";
            }
        }
        $relatedCreateOptionBody = implode("\n", $relatedCreateOptionLines);
        $relatedCreateOptionsCode = ($createAllowed && $hasRelatedCreates && $relatedCreateOptionBody !== '') ? <<<PHP
    /**
     * Returns nested FK options for inline-created parents.
     * Every query is delegated statically to the Model that owns the queried table.
     *
     * @return array<string,array<string,list<array{id:string,text:string}>>>
     */
    public function relatedCreateRelationOptions(): array
    {
        \$result = [];
{$relatedCreateOptionBody}
        return \$result;
    }

PHP : '';

        // Generate one named read method per belongsTo relation. The generic public
        // adapters below only route HTTP field names to these methods; no table name,
        // key, or query shape is resolved dynamically at runtime.
        $explicitRelationMethods = [];
        $relationSearchCases = [];
        $relationByIdCases = [];
        foreach ($relationSearchDefinitions as $field => $definition) {
            $parentModelClass = Naming::tableClass((string) $definition['table']) . 'Model';
            $key = (string) $definition['key'];
            $display = (string) $definition['displayField'];
            $displayFields = array_values((array) ($definition['displayFields'] ?? []));
            $selectFields = array_values(array_unique(array_merge([$key], $displayFields)));
            $selectFieldsCode = var_export($selectFields, true);
            $searchFieldsCode = var_export($displayFields, true);
            $methodSuffix = Naming::studly((string) $field);
            $searchMethod = 'search' . $methodSuffix . 'Options';
            $findMethod = 'find' . $methodSuffix . 'Option';
            $definitionCode = var_export([
                'displayField' => $display,
                'displayTemplate' => (string) ($definition['displayTemplate'] ?? ''),
            ], true);
            $explicitRelationMethods[] = <<<PHP
    /** Searches options for explicit belongsTo relation {$field}. */
    public function {$searchMethod}(string \$query, int \$limit = 20): array
    {
        \$definition = {$definitionCode};
        \$rows = (new {$parentModelClass}())->relationOptionRows(
            '{$key}', {$selectFieldsCode}, '{$display}', \$query, null, max(1, min(100, \$limit)), {$searchFieldsCode}
        );
        \$result = [];
        foreach (\$rows as \$row) {
            if (!is_array(\$row)) { continue; }
            \$result[] = [
                'id' => (string) (\$row['{$key}'] ?? ''),
                'text' => \$this->formatRelationLabel(\$row, \$definition),
            ];
        }
        return \$result;
    }

    /** Finds one option for explicit belongsTo relation {$field}. */
    public function {$findMethod}(int|string \$id): ?array
    {
        \$definition = {$definitionCode};
        \$rows = (new {$parentModelClass}())->relationOptionRows(
            '{$key}', {$selectFieldsCode}, '{$display}', '', (string) \$id, 1, {$searchFieldsCode}
        );
        \$row = \$rows[0] ?? null;
        if (!is_array(\$row)) { return null; }
        return [
            'id' => (string) (\$row['{$key}'] ?? ''),
            'text' => \$this->formatRelationLabel(\$row, \$definition),
        ];
    }

PHP;
            $relationSearchCases[] = "            case '{$field}': return \$this->{$searchMethod}(\$query, \$limit);";
            $relationByIdCases[] = "            case '{$field}': return \$this->{$findMethod}(\$id);";
        }
        $explicitRelationMethodsCode = implode("\n", $explicitRelationMethods);
        $relationSearchCasesCode = implode("\n", $relationSearchCases);
        $relationByIdCasesCode = implode("\n", $relationByIdCases);
        $relationUtilitiesCode = $hasBelongsTo ? <<<PHP
{$explicitRelationMethodsCode}    /** @return array<string,array<string,string>> */
    public function relationOptions(): array
    {
        return [
{$optionMapCode}
        ];
    }

    /** HTTP adapter over explicit generated relation methods. */
    public function searchRelationOptions(string \$field, string \$query, int \$limit = 20): array
    {
        switch (\$field) {
{$relationSearchCasesCode}
            default: return [];
        }
    }

    /** HTTP/context adapter over explicit generated relation methods. */
    public function relationOptionById(string \$field, int|string \$id): ?array
    {
        switch (\$field) {
{$relationByIdCasesCode}
            default: return null;
        }
    }

    private function formatRelationLabel(array \$row, array \$definition): string
    {
        \$template = trim((string) (\$definition['displayTemplate'] ?? ''));
        if (\$template === '') {
            return trim((string) (\$row[(string) \$definition['displayField']] ?? ''));
        }
        \$label = preg_replace_callback(
            '/\\{([a-zA-Z_][a-zA-Z0-9_]*)\\}/',
            static fn (array \$match): string => (string) (\$row[\$match[1]] ?? ''),
            \$template
        );
        return trim((string) \$label);
    }

PHP : '';

        // Transaction primitives are inherited from BaseCrudModel.
        // The Service still decides at generation time whether a transaction is needed.
        $serviceNeedsTransaction = $serviceEnabled && ((
            $createAllowed && ($hasRelatedCreates || $manyToManyCreateEnabled || $hasManyToManyRelatedCreates)
        ) || (
            $writable && ($manyToManyEditEnabled || $hasManyToManyRelatedCreates)
        ));

        $childrenLoaderMethodCode = ($recordDetail && $childrenLoaderCode !== '') ? <<<PHP
    /** @return array<string,array<string,mixed>> */
    public function loadHasMany(int|string \$parentId): array
    {
        \$result = [];
{$childrenLoaderCode}
        return \$result;
    }

PHP : '';

        $needsRuntimeImports = $createAllowed
            || $writable
            || $softDeleteEnabled
            || $manyToManyMethods !== [];
        $runtimeImports = $needsRuntimeImports ? "use RuntimeException;\n" : '';

        // Emit metadata constants only when generated methods actually consume them.
        // This keeps simple Models small and avoids carrying legacy configuration maps
        // that are already resolved at generation time.
        $primaryKeysConstantCode = $compositePrimaryKey
            ? "    private const PRIMARY_KEYS = {$primaryKeysCode};\n"
            : '';
        // BelongsTo metadata is resolved into named methods at generation time.
        // No generic RELATION_SEARCHES runtime map is emitted.
        $relationSearchConstantCode = '';
        $relatedCreatesConstantCode = ($hasRelatedCreates && !$serviceEnabled)
            ? "    private const RELATED_CREATES = {$relatedCreateCode};\n"
            : '';
        $manyToManyRelatedCreatesConstantCode = ($hasManyToManyRelatedCreates && !$serviceEnabled)
            ? "    private const MANY_TO_MANY_RELATED_CREATES = {$manyToManyRelatedCreateCode};\n"
            : '';
        $ownSpatialConstantCode = ($createAllowed && $serviceEnabled && $ownSpatialFields !== [])
            ? "    private const OWN_SPATIAL_FIELDS = {$ownSpatialFieldsCode};\n"
            : '';

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Models;

{$entityUse}
use CodeIgniter\Database\BaseBuilder;
{$runtimeImports}

/**
 * {$modelDoc}
 *
 * Convenzioni generate:
 * - no SQL query should be moved into the Controller;
 * - gli alias belongsTo leggibili sono esposti come <foreign_key>__label;
 * - hasMany e N:N dispongono di metodi dedicati facilmente personalizzabili;
 * - databaseManaged fields are not written by the application.
 */
final class {$class} extends BaseCrudModel
{

    protected \$table = '{$table}';
    protected \$primaryKey = '{$primaryKey}';
    protected \$returnType = {$returnTypeCode};

    /** Schema whitelists used by cross-resource query reuse. */
    protected const RESOURCE_FIELDS = {$resourceFieldsCode};
    protected const RESOURCE_FIELD_TYPES = {$resourceFieldTypesCode};
    protected const FOREIGN_KEY_FIELDS = {$foreignKeyFieldsCode};
{$ownSpatialConstantCode}{$softDeleteCode}
    protected \$protectFields = true;
    protected \$allowedFields = {$allowedCode};
{$timestampsCode}
    protected \$skipValidation = true;
    protected \$cleanValidationRules = true;

    protected const LIST_FILTERS = {$filtersCode};
    private const SORTABLE_FIELDS = {$sortableCode};
    private const EXPORT_FIELDS = {$exportFieldsCode};
{$primaryKeysConstantCode}{$relationSearchConstantCode}{$relatedCreatesConstantCode}{$manyToManyRelatedCreatesConstantCode}    protected const COUNT_CACHE_SECONDS = {$countCacheSeconds};

    /**
     * Builds the full query used by detail and API.
     *
     * @return BaseBuilder Builder pronto per ulteriori condizioni.
     */
    public function baseBuilder(): BaseBuilder
    {
        \$builder = \$this->db->table('{$table}');
        \$builder->select([
            {$detailSelectCode}
        ]);
{$detailJoinsCode}
{$softDataFilter}        return \$builder;
    }

    /**
     * Builds the lightweight query used by the AJAX/paginated list.
     */
    private function listBuilder(): BaseBuilder
    {
        \$builder = \$this->db->table('{$table}');
        \$builder->select([
            {$listSelectCode}
        ]);
{$listJoinsCode}
{$softDataFilter}        return \$builder;
    }

    /** Counts without JOINs so indexed filters remain inexpensive. */
    private function listCountBuilder(): BaseBuilder
    {
        \$builder = \$this->db->table('{$table}');
{$softCountFilter}        return \$builder;
    }

{$detailMethodCode}    /**
     * Returns an HTML-ready page with the CI4 Pager.
     *
     * @param array<int, array<string, mixed>> \$filters
     * @return array{rows: array<int, object>, total: int, page: int, perPage: int, pagerLinks: string, sort: string, direction: string}
     */
    public function getListPage(
        array \$filters,
        int \$page = 1,
        int \$perPage = 25,
        string \$sort = '{$primaryKey}',
        string \$direction = 'desc'
    ): array {
        \$page = max(1, \$page);
        \$perPage = max(25, min(100, \$perPage));
        \$sort = in_array(\$sort, self::SORTABLE_FIELDS, true) ? \$sort : '{$primaryKey}';
        \$direction = strtolower(\$direction) === 'asc' ? 'ASC' : 'DESC';

        \$dataBuilder = \$this->listBuilder();
        \$countBuilder = \$this->listCountBuilder();
        \$this->applyListFilters(\$dataBuilder, \$filters, true);
        \$this->applyListFilters(\$countBuilder, \$filters, false);

        \$total = \$this->countListRows(\$countBuilder, \$filters);
        \$rows = \$dataBuilder
            ->orderBy('{$table}.' . \$sort, \$direction)
            ->limit(\$perPage, (\$page - 1) * \$perPage)
            ->get()
            ->getResult();

        \$pagerLinks = service('pager')->makeLinks(
            \$page,
            \$perPage,
            \$total,
            'bootstrap_full'
        );

        return [
            'rows' => \$rows,
            'total' => \$total,
            'page' => \$page,
            'perPage' => \$perPage,
            'pagerLinks' => \$pagerLinks,
            'sort' => \$sort,
            'direction' => strtolower(\$direction),
        ];
    }

    /**
     * Reads export records in chunks using the primary key as a stable cursor.
     *
     * @param array<int, array<string, mixed>> \$filters
     * @return array<int, array<string, mixed>>
     */
    public function getExportRows(array \$filters, int \$limit = 2000, int|string|null \$after = null): array
    {
        \$builder = \$this->db->table('{$table}');
        \$builder->select([
            {$csvSelectCode}
        ]);
{$csvJoinsCode}
{$softDataFilter}        \$this->applyListFilters(\$builder, \$filters, true);

{$cursorWhere}

        return \$builder
{$exportOrderCode}
            ->limit(max(1, min(5000, \$limit)))
            ->get()
            ->getResultArray();
    }

    public function countExportRows(array \$filters): int
    {
        \$builder = \$this->listCountBuilder();
        \$this->applyListFilters(\$builder, \$filters, false);

        return \$this->countListRows(\$builder, \$filters);
    }

    /** @return list<string> */
    public function exportFields(): array
    {
        return self::EXPORT_FIELDS;
    }

{$resourceReuseMethodsCode}{$writeMethodsCode}{$parentJoinMethodsCode}{$apiMethodsCode}{$optionsMethodsCode}{$relatedCreateOptionsCode}{$relationUtilitiesCode}{$childrenMethodsCode}{$childrenLoaderMethodCode}{$softMethods}}

PHP;

        return $this->writeGenerated("Generated/Models/{$class}.php", $content, $force);
    }

    /** @return list<string> */
    private function relationDisplayFields(string $displayField, string $template, array $availableFields): array
    {
        $template = preg_replace('/\{\{([a-zA-Z_][a-zA-Z0-9_]*)\}\}/', '{$1}', $template) ?? $template;
        $allowed = array_fill_keys(array_values(array_filter(
            $availableFields,
            static fn ($value): bool => is_string($value) && $value !== ''
        )), true);
        $fields = [];

        if ($template !== '') {
            preg_match_all('/\{\{?([a-zA-Z_][a-zA-Z0-9_]*)\}\}?/', $template, $matches);
            foreach ($matches[1] ?? [] as $name) {
                if (isset($allowed[$name])) {
                    $fields[] = (string) $name;
                }
            }
        }

        if ($displayField !== '' && ($allowed === [] || isset($allowed[$displayField]))) {
            array_unshift($fields, $displayField);
        }

        return array_values(array_unique(array_filter($fields)));
    }

    private function relationDisplaySql(string $alias, string $displayField, string $template, array $displayFields): string
    {
        $template = preg_replace('/\{\{([a-zA-Z_][a-zA-Z0-9_]*)\}\}/', '{$1}', $template) ?? $template;
        if ($template === '') {
            return $alias . '.' . $displayField;
        }

        $allowed = array_fill_keys($displayFields, true);
        $parts = preg_split(
            '/(\{[a-zA-Z_][a-zA-Z0-9_]*\})/',
            $template,
            -1,
            PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY
        ) ?: [];
        $sqlParts = [];
        $hasColumn = false;

        foreach ($parts as $part) {
            if (preg_match('/^\{([a-zA-Z_][a-zA-Z0-9_]*)\}$/', $part, $match) === 1) {
                $column = (string) $match[1];
                if (isset($allowed[$column])) {
                    $sqlParts[] = "COALESCE(CAST({$alias}.{$column} AS CHAR), '')";
                    $hasColumn = true;
                }
                continue;
            }

            $literal = str_replace("'", "''", $part);
            if ($literal !== '') {
                $sqlParts[] = "'{$literal}'";
            }
        }

        if (!$hasColumn || $sqlParts === []) {
            return $alias . '.' . $displayField;
        }

        return 'TRIM(CONCAT(' . implode(', ', $sqlParts) . '))';
    }

    private function selectExpression(string $table, string $field, string $type): string
    {
        if (FieldPolicy::isSpatial($type)) {
            return "ST_AsText({$table}.{$field}) AS {$field}";
        }

        return "{$table}.{$field} AS {$field}";
    }


}
