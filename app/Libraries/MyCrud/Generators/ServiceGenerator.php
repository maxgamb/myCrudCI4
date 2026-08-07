<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\FieldPolicy;

/** Genera un Service privo di query SQL. */
final class ServiceGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $class = (string) $config['classes']['service'];
        $modelClass = (string) $config['classes']['model'];
        $entity = (string) $config['classes']['entity'];
        $primaryKey = (string) $config['primaryKey'];
        $useEntity = !empty($config['features']['entity']);
        $apiEnabled = !empty($config['features']['api']);
        $entityUse = $useEntity ? "use App\\Entities\\{$entity};\n" : '';
        $passwordFields = [];
        $automaticDateFields = [];
        foreach ((array) ($config['fields'] ?? []) as $field) {
            $name = (string) ($field['name'] ?? '');
            $inputType = (string) ($field['inputType'] ?? 'text');
            $type = strtolower((string) ($field['type'] ?? ''));
            if (FieldPolicy::isPassword($name, $inputType)) {
                $passwordFields[] = $name;
            }
            if (
                preg_match('/(?:^|_)(?:data_record|recorded_at)(?:$|_)/i', $name) === 1
                && in_array($type, ['date', 'datetime', 'timestamp'], true)
            ) {
                $automaticDateFields[$name] = $type === 'date' ? 'Y-m-d' : 'Y-m-d H:i:s';
            }
        }
        $passwordFieldsCode = var_export(array_values(array_unique($passwordFields)), true);
        $automaticDateFieldsCode = var_export($automaticDateFields, true);
        $createBody = $useEntity
            ? "        \$id = \$this->model->insert(new {$entity}(\$data), true);"
            : "        \$id = \$this->model->insert(\$data, true);";

        $primaryAutoIncrement = false;
        foreach ($config['fields'] as $field) {
            if ((string) ($field['name'] ?? '') === $primaryKey) {
                $primaryAutoIncrement = !empty($field['autoIncrement']);
                break;
            }
        }

        $returnCreatedId = $primaryAutoIncrement
            ? "        return is_int(\$id) ? \$id : (string) \$id;"
            : "        if (array_key_exists('{$primaryKey}', \$data) && (is_int(\$data['{$primaryKey}']) || is_string(\$data['{$primaryKey}']))) {\n            return \$data['{$primaryKey}'];\n        }\n        return is_int(\$id) ? \$id : (string) \$id;";

        $softMethods = !empty($config['features']['softDeletes']) ? <<<PHP
    public function deletedList(): array
    {
        return \$this->model->getDeletedList();
    }

    public function restore(int|string \$id): void
    {
        if (!\$this->model->restoreRecord(\$id)) {
            throw new RuntimeException('Ripristino non riuscito.');
        }
        \$this->model->clearListCountCache();
    }

    public function forceDelete(int|string \$id): void
    {
        if (!\$this->model->delete(\$id, true)) {
            throw new RuntimeException('Eliminazione definitiva non riuscita.');
        }
        \$this->model->clearListCountCache();
    }

PHP : '';

        $modelUse = "use App\\Models\\{$modelClass};";
        $apiMethodsCode = $apiEnabled ? <<<PHP
    /** Elenco REST paginato con filtri e ordinamento autorizzati. */
    public function apiList(array \$query, array \$filterable, array \$sortable): array
    {
        return \$this->model->apiList(\$query, \$filterable, \$sortable);
    }

PHP : '';

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Services;

{$entityUse}{$modelUse}
use RuntimeException;

/** Coordina la logica applicativa senza comporre query SQL. */
final class {$class}
{
    private const PASSWORD_FIELDS = {$passwordFieldsCode};
    private const AUTOMATIC_DATE_FIELDS = {$automaticDateFieldsCode};

    public function __construct(private readonly {$modelClass} \$model = new {$modelClass}())
    {
    }

    public function find(int|string \$id): object
    {
        \$record = \$this->model->getDetail(\$id);
        if (!is_object(\$record)) {
            throw new RuntimeException('Record non trovato.');
        }
        return \$record;
    }

    public function listPage(
        array \$filters,
        int \$page,
        int \$perPage,
        string \$sort,
        string \$direction
    ): array {
        return \$this->model->getListPage(\$filters, \$page, \$perPage, \$sort, \$direction);
    }

    public function exportRows(array \$filters, int \$limit, int|string|null \$after = null): array
    {
        return \$this->model->getExportRows(\$filters, \$limit, \$after);
    }

    public function countExportRows(array \$filters): int
    {
        return \$this->model->countExportRows(\$filters);
    }

    /** @return list<string> */
    public function exportFields(): array
    {
        return \$this->model->exportFields();
    }

{$apiMethodsCode}    public function relationOptions(): array
    {
        return \$this->model->relationOptions();
    }

    /** @return list<array{id:string,text:string}> */
    public function searchRelationOptions(string \$field, string \$query, int \$limit = 20): array
    {
        return \$this->model->searchRelationOptions(\$field, \$query, \$limit);
    }

    public function loadHasMany(int|string \$parentId): array
    {
        return \$this->model->loadHasMany(\$parentId);
    }

    public function create(array \$data): int|string
    {
        \$data = \$this->prepareData(\$data, false);
{$createBody}
        if (\$id === false) {
            throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Inserimento non riuscito.');
        }
        \$this->model->clearListCountCache();
{$returnCreatedId}
    }

    public function update(int|string \$id, array \$data): void
    {
        \$data = \$this->prepareData(\$data, true);
        // update() applica allowedFields e funziona sia con returnType object
        // sia con Entity, senza usare il record arricchito dai JOIN.
        if (!\$this->model->update(\$id, \$data)) {
            throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Aggiornamento non riuscito.');
        }
    }

    private function prepareData(array \$data, bool \$isUpdate): array
    {
        if (!\$isUpdate) {
            foreach (self::AUTOMATIC_DATE_FIELDS as \$field => \$format) {
                if (!isset(\$data[\$field]) || trim((string) \$data[\$field]) === '') {
                    \$data[\$field] = date(\$format);
                }
            }
        }

        foreach (self::PASSWORD_FIELDS as \$field) {
            if (!array_key_exists(\$field, \$data)) {
                continue;
            }

            \$value = trim((string) \$data[\$field]);
            if (\$value === '') {
                if (\$isUpdate) {
                    unset(\$data[\$field]);
                }
                continue;
            }

            \$data[\$field] = password_hash(\$value, PASSWORD_DEFAULT);
        }

        return \$data;
    }

    public function delete(int|string \$id): void
    {
        if (!\$this->model->delete(\$id)) {
            throw new RuntimeException('Eliminazione non riuscita.');
        }
        \$this->model->clearListCountCache();
    }

{$softMethods}}

PHP;

        return $this->writeGenerated("Generated/Services/{$class}.php", $content, $force);
    }
}
