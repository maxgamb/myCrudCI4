<?php

namespace App\Libraries\MyCrud\Generators;

class ServiceGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $class      = $config['classes']['service'];
        $modelClass = $config['classes']['model'];
        $entity     = $config['classes']['entity'];
        $useEntity  = !empty($config['features']['entity']);

        $entityUse = $useEntity ? "use App\\Entities\\{$entity};\n" : '';
        $createBody = $useEntity
            ? "        \$record = new {$entity}(\$data);\n        \$id = \$this->model->insert(\$record, true);"
            : "        \$id = \$this->model->insert(\$data, true);";
        $updateBody = $useEntity
            ? "        \$record = \$this->find(\$id);\n        \$record->fill(\$data);\n        \$result = \$this->model->save(\$record);"
            : "        \$result = \$this->model->update(\$id, \$data);";

        // Remove the extra escaping used only while composing strings.
        $createBody = str_replace('\\\$', '\$', $createBody);
        $updateBody = str_replace('\\\$', '\$', $updateBody);

        $content = <<<PHP
<?php

namespace App\Services;

{$entityUse}use App\Models\{$modelClass};
use RuntimeException;

class {$class}
{
    private {$modelClass} \$model;

    public function __construct(?{$modelClass} \$model = null)
    {
        \$this->model = \$model ?? new {$modelClass}();
    }

    public function list(array \$filters = []): array
    {
        return \$this->model->getList(\$filters);
    }

    public function find(int|string \$id): object
    {
        \$record = \$this->model->getDetail(\$id);

        if (!is_object(\$record)) {
            throw new RuntimeException('Record non trovato.');
        }

        return \$record;
    }

    public function create(array \$data): int
    {
{$createBody}

        if (\$id === false) {
            throw new RuntimeException(
                implode(' ', \$this->model->errors()) ?: 'Inserimento non riuscito.'
            );
        }

        return (int) \$id;
    }

    public function update(int|string \$id, array \$data): void
    {
{$updateBody}

        if (\$result === false) {
            throw new RuntimeException(
                implode(' ', \$this->model->errors()) ?: 'Aggiornamento non riuscito.'
            );
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

    public function loadHasMany(int|string \$parentId, array \$relations): array
    {
        \$result = [];

        foreach (\$relations as \$key => \$relation) {
            if (empty(\$relation['enabled'])) {
                continue;
            }

            \$rows = \$this->model->getRelatedChildren(
                (string) \$relation['childTable'],
                (string) \$relation['foreignKey'],
                \$parentId,
                (string) (\$relation['primaryKey'] ?? ''),
                (int) (\$relation['limit'] ?? 20)
            );

            \$count = !empty(\$relation['showCount'])
                ? \$this->model->countRelatedChildren(
                    (string) \$relation['childTable'],
                    (string) \$relation['foreignKey'],
                    \$parentId
                )
                : count(\$rows);

            \$result[\$key] = [
                'rows'  => \$rows,
                'count' => \$count,
            ];
        }

        return \$result;
    }

    public function model(): {$modelClass}
    {
        return \$this->model;
    }
}

PHP;

        return $this->writeGenerated("Services/{$class}.php", $content, $force);
    }
}
