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
        // Carica soltanto la tabella corrente e le tabelle realmente collegate.
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
                // Tabelle escluse dal filtro o non accessibili: la relazione
                // resta rilevata ma verranno usati i fallback dei nomi campo.
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
                    // Elenco whitelist dei campi che il Builder può usare per
                    // costruire la descrizione leggibile della relazione.
                    'availableDisplayFields' => $this->availableDisplayFields($parentInfo, $parentColumn),
                    // Alias del risultato: usa la FK del record corrente;
                    // l'alias SQL del JOIN resta tecnico e separato.
                    'alias' => $childColumn . '__label',
                    'rowEstimate' => $rowEstimate,
                    // Lato generatore: proponiamo AJAX soltanto per relazioni
                    // grandi; lo sviluppatore può cambiare modalità nel Builder.
                    'optionMode' => $rowEstimate >= $ajaxThreshold ? 'ajax' : 'select',
                    // Creazione inline del record padre: disponibile solo quando
                    // la FK punta alla PK singola di una BASE TABLE e tutti i
                    // campi obbligatori sono rappresentabili in un normale form.
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
                    // Anche una tabella con PK composta può essere creata in
                    // sicurezza: solo View/Edit/Delete richiedono ancora una
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
     * Metadati per la creazione atomica di un nuovo record padre nello stesso
     * form del record corrente. Il primo passo resta volutamente conservativo:
     * niente VIEW, niente PK composta del padre e niente campi obbligatori non
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
            $unsupported = FieldPolicy::isSpatial($type)
                || str_contains($type, 'blob')
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
            // La creazione inline usa una query DB generica e non il Service del
            // parent: per non rischiare credenziali in chiaro, i password field
            // restano fuori da questo primo livello. Se sono obbligatori, la
            // funzione viene dichiarata non disponibile per quella relazione.
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
                'unique' => in_array((string) ($column['columnKey'] ?? ''), ['PRI', 'UNI'], true),
                'inputType' => $inputType,
                'foreignKey' => $foreignKeys[$name] ?? null,
                'attributes' => [
                    'boolean' => $required ? ['required'] : [],
                    'values' => !empty($column['maxLength'])
                        ? ['maxlength' => (string) $column['maxLength']]
                        : [],
                ],
            ];
        }

        if (!$parentKeyAutoIncrement && !isset($fields[$parentKey])) {
            $available = false;
        }
        if ($requiredUnsupported !== []) {
            $available = false;
        }

        return [
            'available' => $available,
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

        // La preview hasMany rappresenta integralmente la tabella figlia:
        // nessun limite numerico e nessuna esclusione automatica di colonne.
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
