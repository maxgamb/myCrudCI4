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
        // Loads only the current table and genuinely related tables.
        // La versione precedente rileggeva l'intero schema per ogni CRUD.
        $schemaInfo = $this->schema->getSchemaInfo($table);
        $tables = $schemaInfo['tables'] ?? [];
        $relations = $schemaInfo['relations'] ?? [];

        $relatedTables = [];
        foreach ($relations as $relation) {
            $relatedTables[] = (string) ($relation['childTable'] ?? '');
            $relatedTables[] = (string) ($relation['parentTable'] ?? '');
        }

        foreach (array_values(array_unique(array_filter($relatedTables))) as $relatedTable) {
            if (isset($tables[$relatedTable])) {
                continue;
            }

            try {
                $tables[$relatedTable] = $this->schema->getTableInfo($relatedTable);
            } catch (\Throwable) {
                // Tables excluded by filters or inaccessible: the relation
                // remains detected but field-name fallbacks will be used.
            }
        }

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

                $parentInfo = $tables[$parentTable] ?? [];
                $rowEstimate = max(0, (int) ($parentInfo['rowEstimate'] ?? 0));
                $ajaxThreshold = max(1, (int) ($this->config->relationAjaxThreshold ?? 5000));

                $relatedCreate = $this->relatedCreateDefinition($parentInfo, $parentTable, $parentColumn);

                $belongsTo[$childColumn] = [
                    'type' => 'belongsTo',
                    'field' => $childColumn,
                    'childTable' => $childTable,
                    'parentTable' => $parentTable,
                    'parentKey' => $parentColumn,
                    'displayField' => $displayField,
                    'displayTemplate' => '',
                    // Whitelist of fields the Builder may use to
                    // build the human-readable relation description.
                    'availableDisplayFields' => $this->availableDisplayFields($parentInfo, $parentColumn),
                    // Alias del risultato: usa la FK del record corrente;
                    // l'alias SQL del JOIN resta tecnico e separato.
                    'alias' => $childColumn . '__label',
                    'rowEstimate' => $rowEstimate,
                    // On the generator side, AJAX is proposed only for relations
                    // grandi; lo sviluppatore può cambiare modalità nel Builder.
                    'optionMode' => $rowEstimate >= $ajaxThreshold ? 'ajax' : 'select',
                    // Inline parent-record creation: available only when
                    // la FK punta alla PK singola di una BASE TABLE e tutti i
                    // required fields can be represented in a standard form.
                    'relatedCreate' => $relatedCreate,
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
                    'childPrimaryKeys' => array_values((array) ($childInfo['primaryKeys'] ?? [])),
                    'childRecordDetail' => empty($childInfo['isView']) && count((array) ($childInfo['primaryKeys'] ?? [])) === 1,
                    // Even a table with a composite primary key can be created
                    // safely: only View/Edit/Delete still require a
                    // identità singola nelle route della linea 2.8.
                    'childCreateAllowed' => empty($childInfo['isView']) && (array) ($childInfo['primaryKeys'] ?? []) !== [],
                    'foreignKey' => $childColumn,
                    'parentTable' => $parentTable,
                    'parentKey' => $parentColumn,
                    'displayField' => $this->detectDisplayField($childInfo, $childColumn),
                    'columns' => $this->displayColumns($childInfo, $childColumn),
                    'columnTypes' => $this->columnTypes($childInfo),
                ];
            }
        }

        return [
            'belongsTo' => $belongsTo,
            'hasMany' => $hasMany,
            'manyToMany' => $this->resolveManyToMany($table, $relations, $tables),
            'self' => $self,
        ];
    }

    /**
     * Riconosce pivot N:N semplici. Una pivot viene considerata "pure" quando
     * contains exactly two foreign keys and any extra fields are technical
     * gestiti dal database (es. last_update CURRENT_TIMESTAMP).
     *
     * Le pivot arricchite restano normali hasMany: myCrudCI4 non nasconde
     * application fields such as price, quantity, role, notes, and so on.
     */
    private function resolveManyToMany(string $table, array $relations, array $tables): array
    {
        // relationsFor($table) restituisce soltanto le FK che coinvolgono
        // directly to the current table. To recognize a many-to-many pivot
        // we need to know BOTH foreign keys of the bridge table.
        //
        // Esempio film:
        //   relationsFor('resource_a') sees resource_link.resource_a_id -> resource_a
        //   but it does not see resource_link.resource_b_id -> resource_b.
        //
        // Le FK complete della candidata pivot sono gia disponibili in
        // getTableInfo($pivot)['foreignKeys'], caricato dal resolver tra le
        // tabelle collegate. Ricostruiamo quindi da quelle la definizione N:N.
        $candidatePivots = [];
        foreach ($relations as $relation) {
            if ((string) ($relation['parentTable'] ?? '') !== $table) {
                continue;
            }

            $pivot = (string) ($relation['childTable'] ?? '');
            if ($pivot !== '' && $pivot !== $table) {
                $candidatePivots[$pivot] = true;
            }
        }

        $result = [];
        foreach (array_keys($candidatePivots) as $pivot) {
            $pivotInfo = (array) ($tables[$pivot] ?? []);
            $pivotForeignKeys = (array) ($pivotInfo['foreignKeys'] ?? []);

            if (count($pivotForeignKeys) !== 2) {
                continue;
            }

            $foreignKeys = [];
            foreach ($pivotForeignKeys as $fk) {
                $childColumn = (string) ($fk['childColumn'] ?? '');
                $parentTable = (string) ($fk['parentTable'] ?? '');
                $parentColumn = (string) ($fk['parentColumn'] ?? '');
                if ($childColumn === '' || $parentTable === '' || $parentColumn === '') {
                    continue 2;
                }

                $foreignKeys[] = [
                    'childTable' => $pivot,
                    'childColumn' => $childColumn,
                    'parentTable' => $parentTable,
                    'parentColumn' => $parentColumn,
                ];
            }

            $ownIndexes = [];
            foreach ($foreignKeys as $index => $fk) {
                if ((string) $fk['parentTable'] === $table) {
                    $ownIndexes[] = $index;
                }
            }

            // Classic pivot: one foreign key to the current table and one to
            // il target. I self many-to-many richiedono una semantica esplicita
            // and remain outside automatic many-to-many scaffolding.
            if (count($ownIndexes) !== 1) {
                continue;
            }

            $ownIndex = $ownIndexes[0];
            $otherIndex = $ownIndex === 0 ? 1 : 0;
            $own = $foreignKeys[$ownIndex];
            $other = $foreignKeys[$otherIndex];

            $pivotColumns = (array) ($pivotInfo['columns'] ?? []);
            $pivotFkNames = array_values(array_map(
                static fn (array $fk): string => (string) $fk['childColumn'],
                $foreignKeys
            ));

            $extraColumns = [];
            $pure = true;
            foreach ($pivotColumns as $column) {
                $columnName = (string) ($column['name'] ?? '');
                if ($columnName === '' || in_array($columnName, $pivotFkNames, true)) {
                    continue;
                }

                $extraColumns[] = $columnName;
                if (!FieldPolicy::isDatabaseManagedTimestamp($column)) {
                    $pure = false;
                }
            }

            // Una pivot con dati applicativi propri non viene nascosta come
            // N:N: resta una normale entita/hasMany modificabile a mano.
            if (!$pure) {
                continue;
            }

            $relatedTable = (string) $other['parentTable'];
            $relatedKey = (string) $other['parentColumn'];
            $relatedInfo = (array) ($tables[$relatedTable] ?? []);

            // Il target non era necessariamente coinvolto direttamente nella
            // query relationsFor($table), quindi puo non essere ancora caricato.
            if ($relatedInfo === []) {
                try {
                    $relatedInfo = $this->schema->getTableInfo($relatedTable);
                } catch (\Throwable) {
                    $relatedInfo = [];
                }
            }

            $displayField = $this->detectDisplayField($relatedInfo, $relatedKey);
            $displayFields = $this->detectDisplayFields($relatedInfo, $relatedKey, $displayField);
            $relatedCreate = $this->relatedCreateDefinition($relatedInfo, $relatedTable, $relatedKey);
            $relatedCreateSimple = !empty($relatedCreate['available']);
            $relatedCreateReason = (string) ($relatedCreate['unavailableReason'] ?? '');

            foreach ((array) ($relatedCreate['fields'] ?? []) as $relatedCreateField) {
                $nestedForeignKey = (array) ($relatedCreateField['foreignKey'] ?? []);
                if ($nestedForeignKey === []) {
                    continue;
                }

                // A target FK is safe for inline N:N creation when it can be
                // resolved with a generated select. Do not confuse the
                // technical pivot with a nested-create requirement.
                $nestedTable = trim((string) ($nestedForeignKey['parentTable'] ?? ''));
                $nestedKey = trim((string) ($nestedForeignKey['parentKey'] ?? ''));
                $nestedDisplay = trim((string) ($nestedForeignKey['displayField'] ?? ''));
                $nestedMode = (string) ($nestedForeignKey['optionMode'] ?? 'select');

                if (
                    $nestedTable === ''
                    || $nestedKey === ''
                    || $nestedDisplay === ''
                    || $nestedMode !== 'select'
                ) {
                    $relatedCreateSimple = false;
                    $relatedCreateReason = 'nested_foreign_key';
                    break;
                }
            }

            if ($relatedCreateSimple && (array) ($relatedCreate['fields'] ?? []) === []) {
                $relatedCreateSimple = false;
                $relatedCreateReason = 'no_writable_fields';
            }
            $key = 'many__' . $this->relationKey($pivot, (string) $own['childColumn']);

            $result[$key] = [
                'key' => $key,
                'type' => 'manyToMany',
                'purePivot' => true,
                'pivotTable' => $pivot,
                'pivotExtraColumns' => $extraColumns,
                'ownPivotField' => (string) $own['childColumn'],
                'ownParentField' => (string) $own['parentColumn'],
                'relatedTable' => $relatedTable,
                'relatedPivotField' => (string) $other['childColumn'],
                'relatedKey' => $relatedKey,
                'relatedDisplayField' => $displayField,
                'relatedDisplayFields' => $displayFields,
                'relatedColumns' => $this->displayColumns($relatedInfo, $relatedKey),
                'relatedColumnTypes' => $this->columnTypes($relatedInfo),
                'relatedRecordDetail' => empty($relatedInfo['isView'])
                    && count((array) ($relatedInfo['primaryKeys'] ?? [])) === 1,
                'relatedCreate' => $relatedCreate,
                'relatedCreateSimple' => $relatedCreateSimple,
                'relatedCreateUnavailableReason' => $relatedCreateSimple ? '' : $relatedCreateReason,
            ];
        }

        return $result;
    }

    private function relationKey(string $table, string $field): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '_', $table . '__' . $field) ?: 'relation';
    }

    /** @return list<string> */
    private function detectDisplayFields(array $tableInfo, string $excludedField, string $fallback): array
    {
        $preferred = [];
        foreach ($tableInfo['columns'] ?? [] as $column) {
            $name = (string) ($column['name'] ?? '');
            $type = strtolower((string) ($column['type'] ?? ''));
            if ($name === '' || $name === $excludedField) {
                continue;
            }
            if (FieldPolicy::isDatabaseManagedTimestamp($column)) {
                continue;
            }
            if (!in_array($type, ['varchar', 'char', 'text', 'tinytext', 'mediumtext'], true)) {
                continue;
            }
            if (in_array($name, ['first_name', 'last_name', 'name', 'title', 'code'], true)) {
                $preferred[] = $name;
            }
        }

        if (count($preferred) >= 2 && in_array('first_name', $preferred, true) && in_array('last_name', $preferred, true)) {
            return ['first_name', 'last_name'];
        }
        if ($preferred !== []) {
            return [reset($preferred) ?: $fallback];
        }
        return [$fallback];
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


    /** @return list<string> */
    private function availableDisplayFields(array $tableInfo, string $keyField): array
    {
        $fields = [];

        foreach ($tableInfo['columns'] ?? [] as $column) {
            $name = (string) ($column['name'] ?? '');
            $type = strtolower((string) ($column['type'] ?? ''));

            if ($name === '' || $name === 'deleted_at') {
                continue;
            }

            if (str_contains($type, 'blob') || str_contains($type, 'binary')) {
                continue;
            }

            $fields[] = $name;
        }

        if ($keyField !== '' && !in_array($keyField, $fields, true)) {
            array_unshift($fields, $keyField);
        }

        return array_values(array_unique($fields));
    }


    /**
     * Metadata for atomic creation of a new parent record in the same
     * form del record corrente. Il primo passo resta volutamente conservativo:
     * no VIEW, no composite parent primary key, and no unsupported required fields
     * rappresentabili (BLOB/BINARY/SPATIAL).
     */
    private function relatedCreateDefinition(array $parentInfo, string $parentTable, string $parentKey): array
    {
        $primaryKeys = array_values((array) ($parentInfo['primaryKeys'] ?? []));
        $available = empty($parentInfo['isView'])
            && count($primaryKeys) === 1
            && $primaryKeys[0] === $parentKey;

        $foreignKeys = [];
        foreach ((array) ($parentInfo['foreignKeys'] ?? []) as $foreignKey) {
            $field = (string) ($foreignKey['childColumn'] ?? '');
            if ($field === '') {
                continue;
            }
            $foreignKeys[$field] = [
                'parentTable' => (string) ($foreignKey['parentTable'] ?? ''),
                'parentKey' => (string) ($foreignKey['parentColumn'] ?? ''),
            ];
        }

        $fields = [];
        $requiredUnsupported = [];
        $parentKeyAutoIncrement = false;

        foreach ((array) ($parentInfo['columns'] ?? []) as $column) {
            $name = (string) ($column['name'] ?? '');
            if ($name === '') {
                continue;
            }

            $type = strtolower((string) ($column['type'] ?? ''));
            $columnType = strtolower((string) ($column['columnType'] ?? ''));
            $autoIncrement = str_contains(strtolower((string) ($column['extra'] ?? '')), 'auto_increment');
            $databaseManaged = FieldPolicy::isDatabaseManagedTimestamp($column);
            $required = ($column['nullable'] ?? 'YES') === 'NO'
                && ($column['defaultValue'] ?? null) === null
                && !$autoIncrement
                && !$databaseManaged;
            // Spatial values can be entered as WKT (for example POINT(0 0))
            // and are converted by the generated Model with ST_GeomFromText().
            // Binary/BLOB values still require a dedicated editor and remain unsupported.
            $spatial = FieldPolicy::isSpatial($type);
            $unsupported = str_contains($type, 'blob')
                || str_contains($type, 'binary');

            if ($name === $parentKey && $autoIncrement) {
                $parentKeyAutoIncrement = true;
            }

            if ($autoIncrement || $databaseManaged || $unsupported) {
                if ($required && $unsupported) {
                    $requiredUnsupported[] = $name;
                }
                continue;
            }

            $inputType = $this->relatedInputType($name, $type, $columnType);
            // Inline creation uses a generic DB query rather than the Service of the
            // parent: per non rischiare credenziali in chiaro, i password field
            // restano fuori da questo primo livello. Se sono obbligatori, la
            // feature is marked unavailable for that relation.
            if (FieldPolicy::isPassword($name, $inputType)) {
                if ($required) {
                    $requiredUnsupported[] = $name;
                }
                continue;
            }
            if (FieldPolicy::isSensitive($name, $inputType)) {
                if ($required) {
                    $requiredUnsupported[] = $name;
                }
                continue;
            }

            $relatedForeignKey = $foreignKeys[$name] ?? null;
            if (is_array($relatedForeignKey) && !empty($relatedForeignKey['parentTable'])) {
                try {
                    $relatedParentInfo = $this->schema->getTableInfo((string) $relatedForeignKey['parentTable']);
                } catch (\Throwable) {
                    $relatedParentInfo = [];
                }
                $relatedParentKey = (string) ($relatedForeignKey['parentKey'] ?? 'id');
                $relatedDisplayField = $this->detectDisplayField($relatedParentInfo, $relatedParentKey);
                $relatedForeignKey['displayField'] = $relatedDisplayField;
                $relatedForeignKey['rowEstimate'] = max(0, (int) ($relatedParentInfo['rowEstimate'] ?? 0));
                $relatedForeignKey['optionMode'] = $relatedForeignKey['rowEstimate'] >= max(1, (int) ($this->config->relationAjaxThreshold ?? 5000))
                    ? 'ajax'
                    : 'select';
            }

            $attributeValues = [];
            if (!empty($column['maxLength'])) {
                $attributeValues['maxlength'] = (string) $column['maxLength'];
            }
            if ($spatial) {
                $attributeValues['placeholder'] = strtoupper($type) === 'POINT' ? 'POINT(0 0)' : 'WKT geometry';
            }
            $scale = (int) ($column['numericScale'] ?? 0);
            if (preg_match('/decimal|numeric|float|double|real/', $type) === 1) {
                $attributeValues['step'] = $scale > 0 ? '0.' . str_repeat('0', max(0, $scale - 1)) . '1' : '1';
            }
            if (str_contains($columnType, 'unsigned')) {
                $attributeValues['min'] = '0';
            }

            $fields[$name] = [
                'name' => $name,
                'type' => $type,
                'columnType' => $columnType,
                'nullable' => ($column['nullable'] ?? 'YES') === 'YES',
                'default' => $column['defaultValue'] ?? null,
                'hasDefault' => array_key_exists('defaultValue', $column) && $column['defaultValue'] !== null,
                'maxLength' => $column['maxLength'] ?? null,
                'numericPrecision' => $column['numericPrecision'] ?? null,
                'numericScale' => $column['numericScale'] ?? null,
                'primary' => in_array($name, $primaryKeys, true),
                'autoIncrement' => false,
                'databaseManaged' => false,
                'spatial' => $spatial,
                'unique' => in_array((string) ($column['columnKey'] ?? ''), ['PRI', 'UNI'], true),
                'inputType' => is_array($relatedForeignKey) ? 'select' : $inputType,
                'foreignKey' => $relatedForeignKey,
                'attributes' => [
                    'boolean' => $required ? ['required'] : [],
                    'values' => $attributeValues,
                ],
            ];
        }

        $unavailableReason = '';
        if (!$parentKeyAutoIncrement && !isset($fields[$parentKey])) {
            $available = false;
            $unavailableReason = 'primary_key_not_writable';
        }
        if ($requiredUnsupported !== []) {
            $available = false;
            $unavailableReason = 'required_unsupported_fields';
        }
        if (!empty($parentInfo['isView'])) {
            $available = false;
            $unavailableReason = 'target_is_view';
        } elseif (count($primaryKeys) !== 1 || ($primaryKeys[0] ?? '') !== $parentKey) {
            $available = false;
            $unavailableReason = 'target_requires_single_primary_key';
        }

        return [
            'available' => $available,
            'unavailableReason' => $available ? '' : $unavailableReason,
            'table' => $parentTable,
            'key' => $parentKey,
            'keyAutoIncrement' => $parentKeyAutoIncrement,
            'fields' => $fields,
            'blockedRequiredFields' => array_values(array_unique($requiredUnsupported)),
        ];
    }

    private function relatedInputType(string $name, string $type, string $columnType): string
    {
        $lowerName = strtolower($name);
        if (str_contains($lowerName, 'email')) {
            return 'email';
        }
        if (FieldPolicy::isPassword($lowerName)) {
            return 'password';
        }
        if (str_contains($lowerName, 'url') || str_contains($lowerName, 'website')) {
            return 'url';
        }

        return match (true) {
            $type === 'text' || in_array($type, ['tinytext', 'mediumtext', 'longtext'], true) => 'textarea',
            $type === 'date' => 'date',
            in_array($type, ['datetime', 'timestamp'], true) => 'datetime-local',
            $type === 'time' => 'time',
            $type === 'bool' || $type === 'boolean' || preg_match('/^tinyint\(1\)/', $columnType) === 1 => 'checkbox',
            preg_match('/int|decimal|float|double|numeric|real/', $type) === 1 => 'number',
            default => 'text',
        };
    }

    private function displayColumns(array $tableInfo, string $foreignKey): array
    {
        unset($foreignKey);
        $columns = [];

        // The hasMany preview represents the child table in full:
        // no numeric limit and no automatic column exclusion.
        // Eventuali riduzioni restano una scelta esplicita del programmatore.
        foreach ($tableInfo['columns'] ?? [] as $column) {
            $name = (string) ($column['name'] ?? '');
            if ($name === '') {
                continue;
            }
            $columns[] = $name;
        }

        return array_values(array_unique($columns));
    }

    /** @return array<string,string> */
    private function columnTypes(array $tableInfo): array
    {
        $types = [];
        foreach ($tableInfo['columns'] ?? [] as $column) {
            $name = (string) ($column['name'] ?? '');
            if ($name !== '') {
                $types[$name] = strtolower((string) ($column['type'] ?? ''));
            }
        }
        return $types;
    }
}
