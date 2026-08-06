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
        $useEntity = !empty($config['features']['entity']);
        $entityUse = $useEntity ? "use App\\Entities\\{$entity};\n" : '';
        $createBody = $useEntity
            ? "        \$id = \$this->model->insert(new {$entity}(\$data), true);"
            : "        \$id = \$this->model->insert(\$data, true);";
        $updateBody = $useEntity
            ? "        \$record = \$this->find(\$id);\n        \$record->fill(\$data);\n        \$result = \$this->model->save(\$record);"
            : "        \$result = \$this->model->update(\$id, \$data);";

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Services;

{$entityUse}use App\Models\{$modelClass};
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

    public function relationOptions(): array
    {
        return \$this->model->relationOptions();
    }

    public function loadHasMany(int|string \$parentId): array
    {
        return \$this->model->loadHasMany(\$parentId);
    }

    public function create(array \$data): int
    {
{$createBody}
        if (\$id === false) {
            throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Inserimento non riuscito.');
        }
        return (int) \$id;
    }

    public function update(int|string \$id, array \$data): void
    {
{$updateBody}
        if (\$result === false) {
            throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Aggiornamento non riuscito.');
        }
    }

    public function delete(int|string \$id): void
    {
        if (!\$this->model->delete(\$id)) {
            throw new RuntimeException('Eliminazione non riuscita.');
        }
    }

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
}

PHP;

        return $this->writeGenerated("Services/{$class}.php", $content, $force);
    }
}
