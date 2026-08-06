<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

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
        $entityUse = $useEntity ? "use App\\Entities\\{$entity};\n" : '';
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
    }

    public function forceDelete(int|string \$id): void
    {
        if (!\$this->model->delete(\$id, true)) {
            throw new RuntimeException('Eliminazione definitiva non riuscita.');
        }
    }

PHP : '';

        $modelUse = "use App\\Models\\{$modelClass};";

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Services;

{$entityUse}{$modelUse}
use RuntimeException;

/** Coordina la logica applicativa senza comporre query SQL. */
final class {$class}
{
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

    public function datatable(array \$request): array
    {
        return \$this->model->datatable(\$request);
    }

    /** Elenco REST paginato con filtri e ordinamento autorizzati. */
    public function apiList(array \$query, array \$filterable, array \$sortable): array
    {
        return \$this->model->apiList(\$query, \$filterable, \$sortable);
    }

    public function relationOptions(): array
    {
        return \$this->model->relationOptions();
    }

    public function loadHasMany(int|string \$parentId): array
    {
        return \$this->model->loadHasMany(\$parentId);
    }

    public function create(array \$data): int|string
    {
{$createBody}
        if (\$id === false) {
            throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Inserimento non riuscito.');
        }
{$returnCreatedId}
    }

    public function update(int|string \$id, array \$data): void
    {
        // update() applica allowedFields e funziona sia con returnType object
        // sia con Entity, senza usare il record arricchito dai JOIN.
        if (!\$this->model->update(\$id, \$data)) {
            throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Aggiornamento non riuscito.');
        }
    }

    public function delete(int|string \$id): void
    {
        if (!\$this->model->delete(\$id)) {
            throw new RuntimeException('Eliminazione non riuscita.');
        }
    }

{$softMethods}}

PHP;

        return $this->writeGenerated("Services/{$class}.php", $content, $force);
    }
}
