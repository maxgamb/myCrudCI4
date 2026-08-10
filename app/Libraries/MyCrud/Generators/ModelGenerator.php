<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\FieldPolicy;
use App\Libraries\MyCrud\Core\Naming;

/** Genera il Model e concentra nel livello dati tutte le query SQL. */
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

            if (!empty($ui['searchable']) && $indexEligible && !$isSensitive && !$isLarge && !$isBinary) {
                // Lato generatore: definiamo una whitelist di operatori coerente
                // col tipo DB. La UI potrà mostrare solo questi criteri e il
                // Model li ricontrollerà prima di comporre qualsiasi query.
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

            if (!empty($ui['sortable']) && $indexEligible && !$isSensitive && !$isLarge && !$isBinary) {
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

            // Ogni FK ha un solo metodo di JOIN nel Model. L'alias SQL tecnico
            // evita collisioni (anche con due FK verso la stessa tabella), mentre
            // il risultato espone il nome più leggibile <foreign_key>__label.
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
                ];
            }

            if ($relationMode === 'select') {
                $method = 'get' . Naming::tableClass($parentTable) . Naming::studly((string) $field) . 'Options';
                $selectFields = array_values(array_unique(array_merge([$parentKey], $displayFields)));
                $selectFieldsCode = var_export($selectFields, true);
                $optionMethods[] = <<<PHP
    /** Restituisce le opzioni della relazione {$field}. */
    public function {$method}(): array
    {
        return \$this->db->table('{$parentTable}')
            ->select({$selectFieldsCode})
            ->orderBy('{$displayField}', 'ASC')
            ->get()
            ->getResultArray();
    }

PHP;
                $optionMapLines[] = "            '{$field}' => \$this->toRelationOptions(\$this->{$method}(), '{$field}'),";
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

            // Difesa ulteriore: una relazione incompleta non deve interrompere
            // l'intera generazione. Il merge 2.8 scarta già le relazioni stale,
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

            $childMethods[] = <<<PHP
    /** Carica al massimo una riga in più per determinare se esistono altri risultati. */
    public function {$getMethod}(int|string \$parentId, int \$limit = {$limit}): array
    {
        \$limit = max(1, min(200, \$limit));
        \$rows = \$this->db->table('{$childTable}')
            ->select({$childSelectCode})
            ->where('{$foreignKey}', \$parentId)
            ->orderBy('{$childPk}', 'DESC')
            ->limit(\$limit + 1)
            ->get()
            ->getResult();
        \$hasMore = count(\$rows) > \$limit;
        if (\$hasMore) {
            array_pop(\$rows);
        }

        return [
            'rows' => \$rows,
            'count' => count(\$rows),
            'hasMore' => \$hasMore,
        ];
    }

PHP;
            $childLoaderLines[] = "        \$result['{$relationKey}'] = \$this->{$getMethod}(\$parentId, {$limit});";
        }

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
        $childrenMethodsCode = implode('', $childMethods);
        $childrenLoaderCode = implode("\n\n", $childLoaderLines);
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
    /** Elenco REST paginato con whitelist di filtri e ordinamento. */
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

    private function apiLink(array \$query, int \$page): string
    {
        \$query['page'] = \$page;
        return current_url() . '?' . http_build_query(\$query);
    }

PHP : '';

        $createReturnCode = $primaryAutoIncrement
            ? "        return is_int(\$id) ? \$id : (string) \$id;"
            : "        if (array_key_exists('{$primaryKey}', \$data) && (is_int(\$data['{$primaryKey}']) || is_string(\$data['{$primaryKey}']))) {\n            return \$data['{$primaryKey}'];\n        }\n        return is_int(\$id) ? \$id : (string) \$id;";

        $createRecordMethodsCode = $createAllowed ? <<<PHP
    /**
     * Inserisce il record corrente e, se richiesto dal form, crea prima i
     * record padre nella stessa transazione usando la PK generata come FK.
     */
    public function createRecord(array \$data, array \$related = []): int|string
    {
        \$transactional = \$related !== [];
        if (\$transactional) {
            \$this->db->transBegin();
        }

        try {
            foreach (\$related as \$field => \$payload) {
                if (!is_array(\$payload) || !isset(self::RELATED_CREATES[\$field])) {
                    continue;
                }
                \$data[\$field] = \$this->createRelatedRecord((string) \$field, \$payload);
            }

            \$id = \$this->insert(\$data, true);
            if (\$id === false) {
                throw new RuntimeException(implode(' ', \$this->errors()) ?: 'Inserimento non riuscito.');
            }

            if (\$transactional) {
                if (!\$this->db->transStatus()) {
                    throw new RuntimeException('Transazione di inserimento non riuscita.');
                }
                \$this->db->transCommit();
            }
        } catch (Throwable \$e) {
            if (\$transactional) {
                \$this->db->transRollback();
            }
            throw \$e;
        }

        \$this->clearListCountCache();
{$createReturnCode}
    }

    /** Crea un singolo record padre autorizzato dalla configurazione generata. */
    private function createRelatedRecord(string \$field, array \$data): int|string
    {
        \$definition = self::RELATED_CREATES[\$field] ?? null;
        if (!is_array(\$definition)) {
            throw new RuntimeException('Creazione record collegato non autorizzata per ' . \$field . '.');
        }

        \$allowed = array_fill_keys((array) (\$definition['fields'] ?? []), true);
        \$payload = array_intersect_key(\$data, \$allowed);

        // I form HTML inviano stringa vuota anche per campi opzionali. Per i
        // nullable usiamo NULL; per colonne con DEFAULT omettiamo il valore e
        // lasciamo che sia il database ad applicare la propria policy.
        \$nullable = array_fill_keys((array) (\$definition['nullableFields'] ?? []), true);
        \$defaulted = array_fill_keys((array) (\$definition['defaultedFields'] ?? []), true);
        foreach (\$payload as \$payloadField => \$payloadValue) {
            if (!is_string(\$payloadValue) || trim(\$payloadValue) !== '') {
                continue;
            }
            if (isset(\$defaulted[\$payloadField])) {
                unset(\$payload[\$payloadField]);
                continue;
            }
            if (isset(\$nullable[\$payloadField])) {
                \$payload[\$payloadField] = null;
            }
        }

        // datetime-local usa il separatore T; normalizziamo al formato SQL
        // prima dell'insert generico del record collegato.
        foreach ((array) (\$definition['dateTimeFields'] ?? []) as \$dateTimeField) {
            if (isset(\$payload[\$dateTimeField]) && is_string(\$payload[\$dateTimeField])) {
                \$payload[\$dateTimeField] = str_replace('T', ' ', \$payload[\$dateTimeField]);
            }
        }

        \$table = (string) (\$definition['table'] ?? '');
        \$key = (string) (\$definition['key'] ?? '');
        if (\$table === '' || \$key === '') {
            throw new RuntimeException('Configurazione record collegato incompleta.');
        }

        if (!\$this->db->table(\$table)->insert(\$payload)) {
            throw new RuntimeException('Inserimento record collegato non riuscito: ' . \$table . '.');
        }

        if (!empty(\$definition['keyAutoIncrement'])) {
            \$id = \$this->db->insertID();
            if (\$id === 0 || \$id === '0' || \$id === '') {
                throw new RuntimeException('Chiave generata non disponibile per ' . \$table . '.');
            }
            return is_int(\$id) ? \$id : (string) \$id;
        }

        \$id = \$payload[\$key] ?? null;
        if (!is_int(\$id) && !is_string(\$id)) {
            throw new RuntimeException('La chiave del record collegato deve essere valorizzata: ' . \$key . '.');
        }

        return \$id;
    }

PHP : '';

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Models;

{$entityUse}
use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;
use RuntimeException;
use Throwable;

/** Model per {$table}; tutte le query del CRUD sono centralizzate qui. */
final class {$class} extends Model
{
    protected \$table = '{$table}';
    protected \$primaryKey = '{$primaryKey}';
    protected \$returnType = {$returnTypeCode};
{$softDeleteCode}
    protected \$protectFields = true;
    protected \$allowedFields = {$allowedCode};
{$timestampsCode}
    protected \$skipValidation = true;
    protected \$cleanValidationRules = true;

    private const LIST_FILTERS = {$filtersCode};
    private const SORTABLE_FIELDS = {$sortableCode};
    private const EXPORT_FIELDS = {$exportFieldsCode};
    private const PRIMARY_KEYS = {$primaryKeysCode};
    private const RELATION_SEARCHES = {$relationSearchCode};
    private const RELATED_CREATES = {$relatedCreateCode};
    private const COUNT_CACHE_SECONDS = {$countCacheSeconds};

    /** Query completa per dettaglio e API. */
    public function baseBuilder(): BaseBuilder
    {
        \$builder = \$this->db->table('{$table}');
        \$builder->select([
            {$detailSelectCode}
        ]);
{$detailJoinsCode}
{$softDataFilter}        return \$builder;
    }

    /** Query leggera per la tabella Bootstrap AJAX. */
    private function listBuilder(): BaseBuilder
    {
        \$builder = \$this->db->table('{$table}');
        \$builder->select([
            {$listSelectCode}
        ]);
{$listJoinsCode}
{$softDataFilter}        return \$builder;
    }

    /** Conteggio senza JOIN, così i filtri indicizzati restano economici. */
    private function listCountBuilder(): BaseBuilder
    {
        \$builder = \$this->db->table('{$table}');
{$softCountFilter}        return \$builder;
    }

    public function getDetail(int|string \$id): ?object
    {
        return \$this->baseBuilder()
            ->where('{$table}.{$primaryKey}', \$id)
            ->get()
            ->getRow();
    }

    /**
     * Restituisce una pagina HTML-ready con Pager CI4.
     *
     * @return array{rows: array, total: int, page: int, perPage: int, pagerLinks: string, sort: string, direction: string}
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

    /** Legge i record di export a blocchi usando la chiave primaria come cursore. */
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

    private function countListRows(BaseBuilder \$builder, array \$filters): int
    {
        if (\$this->hasActiveFilters(\$filters) || self::COUNT_CACHE_SECONDS === 0) {
            return \$builder->countAllResults();
        }

        \$cacheKey = 'mycrud_list_total_' . md5(\$this->table);
        \$cache = service('cache');
        \$cached = \$cache->get(\$cacheKey);
        if (is_int(\$cached) || (is_string(\$cached) && ctype_digit(\$cached))) {
            return (int) \$cached;
        }

        \$total = \$builder->countAllResults();
        \$cache->save(\$cacheKey, \$total, self::COUNT_CACHE_SECONDS);

        return \$total;
    }

    private function hasActiveFilters(array \$filters): bool
    {
        foreach (\$filters as \$filter) {
            if (is_array(\$filter) && trim((string) (\$filter['field'] ?? '')) !== '') {
                return true;
            }
        }

        return false;
    }

    public function clearListCountCache(): void
    {
        service('cache')->delete('mycrud_list_total_' . md5(\$this->table));
    }

    /**
     * Applica il filtro dinamico costruito dall'interfaccia del sito.
     * Campo e operatore vengono sempre verificati contro LIST_FILTERS.
     */
    private function applyListFilters(BaseBuilder \$builder, array \$filters, bool \$qualified): void
    {
        \$applied = 0;
        \$nextLogic = 'and';
        foreach (array_values(\$filters) as \$filter) {
            if (!is_array(\$filter)) {
                continue;
            }

            \$field = trim((string) (\$filter['field'] ?? ''));
            \$operator = trim((string) (\$filter['operator'] ?? ''));
            if (\$field === '' || !isset(self::LIST_FILTERS[\$field])) {
                continue;
            }

            \$definition = self::LIST_FILTERS[\$field];
            \$allowedOperators = (array) (\$definition['operators'] ?? ['eq']);
            if (!in_array(\$operator, \$allowedOperators, true)) {
                continue;
            }

            \$column = \$qualified ? '{$table}.' . \$field : \$field;
            \$value = is_scalar(\$filter['value'] ?? null) ? trim((string) \$filter['value']) : '';
            \$valueTo = is_scalar(\$filter['value_to'] ?? null) ? trim((string) \$filter['value_to']) : '';
            // La logica appartiene alla riga precedente e collega la
            // condizione appena applicata a quella successiva nell'interfaccia.
            \$logic = \$applied > 0 ? \$nextLogic : 'and';

            if (!in_array(\$operator, ['is_null', 'not_null'], true) && \$value === '') {
                continue;
            }
            if (\$operator === 'between' && \$valueTo === '') {
                continue;
            }

            // Ogni condizione è raggruppata: AND/OR resta prevedibile anche
            // per operatori composti come BETWEEN.
            if (\$logic === 'or') {
                \$builder->orGroupStart();
            } else {
                \$builder->groupStart();
            }

            switch (\$operator) {
                case 'neq':
                    \$builder->where(\$column . ' !=', \$value);
                    break;
                case 'gt':
                    \$builder->where(\$column . ' >', \$value);
                    break;
                case 'gte':
                    \$builder->where(\$column . ' >=', \$value);
                    break;
                case 'lt':
                    \$builder->where(\$column . ' <', \$value);
                    break;
                case 'lte':
                    \$builder->where(\$column . ' <=', \$value);
                    break;
                case 'between':
                    \$builder->where(\$column . ' >=', \$value)
                        ->where(\$column . ' <=', \$valueTo);
                    break;
                case 'starts_with':
                    \$builder->like(\$column, \$value, 'after');
                    break;
                case 'contains':
                    \$builder->like(\$column, \$value, 'both');
                    break;
                case 'ends_with':
                    \$builder->like(\$column, \$value, 'before');
                    break;
                case 'is_null':
                    \$builder->where(\$column, null);
                    break;
                case 'not_null':
                    \$builder->where(\$column . ' IS NOT NULL', null, false);
                    break;
                case 'eq':
                default:
                    \$builder->where(\$column, \$value);
                    break;
            }

            \$builder->groupEnd();
            \$applied++;
            \$nextLogic = strtolower((string) (\$filter['logic'] ?? 'and')) === 'or' ? 'or' : 'and';
        }
    }

{$createRecordMethodsCode}{$parentJoinMethodsCode}{$apiMethodsCode}{$optionsMethodsCode}    public function relationOptions(): array
    {
        return [
{$optionMapCode}
        ];
    }

    /**
     * Ricerca server-side delle opzioni per relazioni grandi.
     * Tabella, chiave e campi descrittivi arrivano solo dalla whitelist generata.
     *
     * @return list<array{id:string,text:string}>
     */
    public function searchRelationOptions(string \$field, string \$query, int \$limit = 20): array
    {
        if (!isset(self::RELATION_SEARCHES[\$field])) {
            return [];
        }

        \$definition = self::RELATION_SEARCHES[\$field];
        \$key = (string) \$definition['key'];
        \$displayFields = array_values((array) (\$definition['displayFields'] ?? []));
        \$selectFields = array_values(array_unique(array_merge([\$key], \$displayFields)));
        \$limit = max(1, min(100, \$limit));
        \$builder = \$this->db->table((string) \$definition['table'])
            ->select(\$selectFields)
            ->orderBy((string) \$definition['displayField'], 'ASC')
            ->limit(\$limit);

        \$query = trim(\$query);
        if (\$query !== '' && \$displayFields !== []) {
            \$builder->groupStart();
            foreach (\$displayFields as \$index => \$displayColumn) {
                if (\$index === 0) {
                    \$builder->like((string) \$displayColumn, \$query, 'after');
                } else {
                    \$builder->orLike((string) \$displayColumn, \$query, 'after');
                }
            }
            \$builder->groupEnd();
        }

        \$rows = \$builder->get()->getResultArray();
        \$result = [];
        foreach (\$rows as \$row) {
            \$result[] = [
                'id' => (string) (\$row[\$key] ?? ''),
                'text' => \$this->formatRelationLabel(\$row, \$definition),
            ];
        }

        return \$result;
    }

    /** Restituisce una FK valida e la sua descrizione; usato dal Create contestuale. */
    public function relationOptionById(string \$field, int|string \$id): ?array
    {
        if (!isset(self::RELATION_SEARCHES[\$field])) {
            return null;
        }

        \$definition = self::RELATION_SEARCHES[\$field];
        \$key = (string) \$definition['key'];
        \$displayFields = array_values((array) (\$definition['displayFields'] ?? []));
        \$selectFields = array_values(array_unique(array_merge([\$key], \$displayFields)));
        \$row = \$this->db->table((string) \$definition['table'])
            ->select(\$selectFields)
            ->where(\$key, \$id)
            ->limit(1)
            ->get()
            ->getRowArray();

        if (!is_array(\$row)) {
            return null;
        }

        return [
            'id' => (string) (\$row[\$key] ?? ''),
            'text' => \$this->formatRelationLabel(\$row, \$definition),
        ];
    }

    private function toRelationOptions(array \$rows, string \$field): array
    {
        if (!isset(self::RELATION_SEARCHES[\$field])) {
            return [];
        }

        \$definition = self::RELATION_SEARCHES[\$field];
        \$key = (string) \$definition['key'];
        \$options = [];
        foreach (\$rows as \$row) {
            if (!is_array(\$row)) {
                continue;
            }
            \$options[(string) (\$row[\$key] ?? '')] = \$this->formatRelationLabel(\$row, \$definition);
        }
        return \$options;
    }

    private function formatRelationLabel(array \$row, array \$definition): string
    {
        \$template = trim((string) (\$definition['displayTemplate'] ?? ''));
        if (\$template === '') {
            return trim((string) (\$row[(string) \$definition['displayField']] ?? ''));
        }

        \$label = preg_replace_callback(
            '/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/',
            static fn (array \$match): string => (string) (\$row[\$match[1]] ?? ''),
            \$template
        );

        return trim((string) \$label);
    }

{$childrenMethodsCode}    public function loadHasMany(int|string \$parentId): array
    {
        \$result = [];
{$childrenLoaderCode}
        return \$result;
    }

{$softMethods}}

PHP;

        return $this->writeGenerated("Generated/Models/{$class}.php", $content, $force);
    }

    /** @return list<string> */
    private function relationDisplayFields(string $displayField, string $template, array $availableFields): array
    {
        $allowed = array_fill_keys(array_values(array_filter(
            $availableFields,
            static fn ($value): bool => is_string($value) && $value !== ''
        )), true);
        $fields = [];

        if ($template !== '') {
            preg_match_all('/\{([a-zA-Z_][a-zA-Z0-9_]*)\}/', $template, $matches);
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
