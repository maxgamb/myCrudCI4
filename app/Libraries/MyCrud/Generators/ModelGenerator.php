<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\Naming;

/**
 * Genera il Model e concentra nel livello dati tutte le query SQL.
 */
final class ModelGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $primaryKey = (string) $config['primaryKey'];
        $class = (string) $config['classes']['model'];
        $entity = (string) $config['classes']['entity'];
        $usesEntity = !empty($config['features']['entity']);
        $softDeleteEnabled = !empty($config['features']['softDeletes']);
        $deletedField = (string) ($config['softDelete']['field'] ?? 'deleted_at');
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);
        $managedFields = array_filter([
            $timestampsEnabled ? 'created_at' : null,
            $timestampsEnabled ? 'updated_at' : null,
            $softDeleteEnabled ? $deletedField : null,
        ]);

        $allowed = [];
        $searchable = [];
        $sortable = [];
        $fieldNames = [];

        foreach ($config['fields'] as $field) {
            $name = (string) $field['name'];
            $fieldNames[] = $name;

            if (
                (empty($field['primary']) || empty($field['autoIncrement']))
                && !in_array($name, $managedFields, true)
            ) {
                $allowed[] = $name;
            }

            $type = strtolower((string) ($field['type'] ?? ''));
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
            $ui = (array) ($field['ui'] ?? []);
            $isSensitive = !empty($ui['sensitive'])
                || preg_match('/password|passwd|secret|token|pin|api[_-]?key|private[_-]?key|chiave|cvv/i', $name) === 1;
            $isLarge = in_array($type, ['text', 'mediumtext', 'longtext', 'blob', 'mediumblob', 'longblob'], true);
            $isBinary = in_array($inputType, ['file', 'image'], true);

            $canSearch = array_key_exists('searchable', $ui)
                ? !empty($ui['searchable'])
                : !$isSensitive && !$isLarge && !$isBinary;
            $canSort = array_key_exists('sortable', $ui)
                ? !empty($ui['sortable'])
                : !$isLarge && !$isBinary;

            if ($canSearch && !$isSensitive && !$isLarge && !$isBinary) {
                $searchable[] = $name;
            }
            if ($canSort && !$isLarge && !$isBinary) {
                $sortable[] = $name;
            }
        }

        if (!in_array($primaryKey, $sortable, true)) {
            $sortable[] = $primaryKey;
        }

        $selects = ["'{$table}.*'"];
        $joinLines = [];
        $modelJoinLines = [];
        $optionMethods = [];
        $optionMapLines = [];

        foreach ($config['relations']['belongsTo'] ?? [] as $field => $relation) {
            $parentTable = (string) $relation['parentTable'];
            $parentKey = (string) $relation['parentKey'];
            $displayField = (string) $relation['displayField'];
            $alias = (string) ($relation['alias'] ?? ($parentTable . '_' . $displayField));

            $joinAlias = preg_replace('/[^a-zA-Z0-9_]/', '_', $parentTable . '__' . $field)
                ?: $parentTable;

            $selects[] = "'{$joinAlias}.{$displayField} AS {$alias}'";
            $joinLines[] = "        \$builder->join('{$parentTable} AS {$joinAlias}', '{$joinAlias}.{$parentKey} = {$table}.{$field}', 'left');";
            $modelJoinLines[] = "        \$this->join('{$parentTable} AS {$joinAlias}', '{$joinAlias}.{$parentKey} = {$table}.{$field}', 'left');";

            // La FK rende univoco il metodo anche con due relazioni alla stessa tabella.
            $method = 'get' . Naming::singularStudly($parentTable) . Naming::singularStudly((string) $field) . 'Options';
            $optionMethods[] = <<<PHP
    /** Restituisce le opzioni della relazione {$field}. */
    public function {$method}(): array
    {
        return \$this->db->table('{$parentTable}')
            ->select(['{$parentKey}', '{$displayField}'])
            ->orderBy('{$displayField}', 'ASC')
            ->get()
            ->getResult();
    }

PHP;
            $optionMapLines[] = "            '{$field}' => \$this->toOptions(\$this->{$method}(), '{$parentKey}', '{$displayField}'),";
        }

        $childMethods = [];
        $childLoaderLines = [];
        foreach ($config['relationsConfig']['hasMany'] ?? [] as $relationKey => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }

            $childTable = (string) $relation['childTable'];
            $foreignKey = (string) $relation['foreignKey'];
            $childPk = (string) ($relation['primaryKey'] ?? 'id');
            $methodSuffix = Naming::singularStudly($childTable) . Naming::singularStudly($foreignKey);
            $getMethod = 'get' . $methodSuffix;
            $countMethod = 'count' . $methodSuffix;
            $limit = max(1, min(200, (int) ($relation['limit'] ?? 20)));

            $childMethods[] = <<<PHP
    /** Restituisce i record figli dalla tabella {$childTable}. */
    public function {$getMethod}(int|string \$parentId, int \$limit = {$limit}): array
    {
        return \$this->db->table('{$childTable}')
            ->where('{$foreignKey}', \$parentId)
            ->orderBy('{$childPk}', 'DESC')
            ->limit(max(1, min(200, \$limit)))
            ->get()
            ->getResult();
    }

    /** Conta i record figli dalla tabella {$childTable}. */
    public function {$countMethod}(int|string \$parentId): int
    {
        return \$this->db->table('{$childTable}')
            ->where('{$foreignKey}', \$parentId)
            ->countAllResults();
    }

PHP;
            $showCount = !empty($relation['showCount']) ? 'true' : 'false';
            $childLoaderLines[] = "        \$rows = \$this->{$getMethod}(\$parentId, {$limit});\n        \$result['{$relationKey}'] = [\n            'rows' => \$rows,\n            'count' => {$showCount} ? \$this->{$countMethod}(\$parentId) : count(\$rows),\n        ];";
        }

        $returnType = $usesEntity ? "{$entity}::class" : "'object'";
        $useEntity = $usesEntity ? "use App\\Entities\\{$entity};\n" : '';

        $softDeleteCode = $softDeleteEnabled
            ? "    protected \$useSoftDeletes = true;\n    protected \$deletedField = '{$deletedField}';"
            : "    protected \$useSoftDeletes = false;";
        $softBuilderFilter = $softDeleteEnabled
            ? "        \$builder->where('{$table}.{$deletedField}', null);\n"
            : '';
        $softTotalFilter = $softDeleteEnabled
            ? "        \$totalBuilder->where('{$deletedField}', null);\n"
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

        $selectCode = implode(",\n            ", $selects);
        $joinsCode = implode("\n", $joinLines);
        $modelJoinsCode = implode("\n", $modelJoinLines);
        $optionsMethodsCode = implode('', $optionMethods);
        $optionMapCode = implode("\n", $optionMapLines);
        $childrenMethodsCode = implode('', $childMethods);
        $childrenLoaderCode = implode("\n\n", $childLoaderLines);
        $allowedCode = var_export(array_values(array_unique($allowed)), true);
        $searchableCode = var_export(array_values(array_unique($searchable)), true);
        $sortableCode = var_export(array_values(array_unique($sortable)), true);

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Models;

{$useEntity}use CodeIgniter\Database\BaseBuilder;
use CodeIgniter\Model;

/**
 * Model per la tabella {$table}.
 * Tutte le query DB del CRUD sono centralizzate in questa classe.
 */
final class {$class} extends Model
{
    protected \$table = '{$table}';
    protected \$primaryKey = '{$primaryKey}';
    protected \$returnType = {$returnType};
{$softDeleteCode}
    protected \$protectFields = true;
    protected \$allowedFields = {$allowedCode};
{$timestampsCode}
    protected \$skipValidation = true;
    protected \$cleanValidationRules = true;

    private const SEARCHABLE_FIELDS = {$searchableCode};
    private const SORTABLE_FIELDS = {$sortableCode};

    /** Query base con tutti i LEFT JOIN verso le tabelle padre. */
    public function baseBuilder(): BaseBuilder
    {
        \$builder = \$this->db->table('{$table}');
        \$builder->select([
            {$selectCode}
        ]);
{$joinsCode}
{$softBuilderFilter}
        return \$builder;
    }

    /** Restituisce il dettaglio con i dati descrittivi dei parent. */
    public function getDetail(int|string \$id): ?object
    {
        return \$this->baseBuilder()
            ->where('{$table}.{$primaryKey}', \$id)
            ->get()
            ->getRow();
    }

    /** Paginazione nativa CI4 usata dall'architettura Basic. */
    public function paginateWithParents(int \$perPage = 25, string \$group = 'default', string \$search = ''): array
    {
        \$this->select([
            {$selectCode}
        ]);
{$modelJoinsCode}

        if (\$search !== '' && self::SEARCHABLE_FIELDS !== []) {
            \$this->groupStart();
            foreach (self::SEARCHABLE_FIELDS as \$index => \$field) {
                \$method = \$index === 0 ? 'like' : 'orLike';
                \$this->{\$method}('{$table}.' . \$field, \$search);
            }
            \$this->groupEnd();
        }

        \$this->orderBy('{$table}.{$primaryKey}', 'DESC');
        return \$this->paginate(max(1, min(200, \$perPage)), \$group);
    }

    /** Elabora DataTables interamente nel Model. */
    public function datatable(array \$request): array
    {
        \$draw = (int) (\$request['draw'] ?? 1);
        \$start = max(0, (int) (\$request['start'] ?? 0));
        \$length = max(1, min(500, (int) (\$request['length'] ?? 25)));
        \$search = trim((string) (\$request['search']['value'] ?? ''));
        \$builder = \$this->baseBuilder();

        if (\$search !== '' && self::SEARCHABLE_FIELDS !== []) {
            \$builder->groupStart();
            foreach (self::SEARCHABLE_FIELDS as \$index => \$field) {
                \$method = \$index === 0 ? 'like' : 'orLike';
                \$builder->{\$method}('{$table}.' . \$field, \$search);
            }
            \$builder->groupEnd();
        }

        foreach ((array) (\$request['columns'] ?? []) as \$column) {
            \$field = (string) (\$column['data'] ?? '');
            \$value = trim((string) (\$column['search']['value'] ?? ''));
            if (\$value !== '' && in_array(\$field, self::SEARCHABLE_FIELDS, true)) {
                \$builder->like('{$table}.' . \$field, \$value);
            }
        }

        \$totalBuilder = \$this->db->table('{$table}');
{$softTotalFilter}        \$recordsTotal = \$totalBuilder->countAllResults();
        \$recordsFiltered = (clone \$builder)->countAllResults(false);

        \$orderIndex = (int) (\$request['order'][0]['column'] ?? 0);
        \$requestedField = (string) (\$request['columns'][\$orderIndex]['data'] ?? '{$primaryKey}');
        \$orderField = in_array(\$requestedField, self::SORTABLE_FIELDS, true) ? \$requestedField : '{$primaryKey}';
        \$orderDirection = strtolower((string) (\$request['order'][0]['dir'] ?? 'asc')) === 'desc' ? 'DESC' : 'ASC';

        \$rows = \$builder->orderBy('{$table}.' . \$orderField, \$orderDirection)
            ->limit(\$length, \$start)
            ->get()
            ->getResult();

        return [
            'draw' => \$draw,
            'recordsTotal' => \$recordsTotal,
            'recordsFiltered' => \$recordsFiltered,
            'data' => \$rows,
        ];
    }

    /** Elenco REST paginato con whitelist di filtri e ordinamento. */
    public function apiList(array \$query, array \$filterable, array \$sortable): array
    {
        \$page = max(1, (int) (\$query['page'] ?? 1));
        \$perPage = max(1, min(100, (int) (\$query['perPage'] ?? 25)));
        \$search = trim((string) (\$query['search'] ?? ''));
        \$builder = \$this->baseBuilder();

        if (\$search !== '' && \$filterable !== []) {
            \$builder->groupStart();
            foreach (\$filterable as \$index => \$field) {
                \$method = \$index === 0 ? 'like' : 'orLike';
                \$builder->{\$method}('{$table}.' . \$field, \$search);
            }
            \$builder->groupEnd();
        }

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

{$optionsMethodsCode}    /** Restituisce tutte le opzioni belongsTo già indicizzate. */
    public function relationOptions(): array
    {
        return [
{$optionMapCode}
        ];
    }

    private function toOptions(array \$rows, string \$key, string \$label): array
    {
        \$options = [];
        foreach (\$rows as \$row) {
            \$options[(string) \$row->{\$key}] = (string) \$row->{\$label};
        }
        return \$options;
    }

{$childrenMethodsCode}    /** Carica i pannelli figli usando metodi query specifici. */
    public function loadHasMany(int|string \$parentId): array
    {
        \$result = [];
{$childrenLoaderCode}
        return \$result;
    }

{$softMethods}}

PHP;

        return $this->writeGenerated("Models/{$class}.php", $content, $force);
    }
}
