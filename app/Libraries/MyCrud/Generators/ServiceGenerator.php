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
            ? "\$record = new {$entity}(\$data);\n        \$id = \$this->model->insert(\$record, true);"
            : "\$id = \$this->model->insert(\$data, true);";

        $updateBody = $useEntity
            ? "\$record = \$this->find(\$id);\n        \$record->fill(\$data);\n        \$result = \$this->model->save(\$record);"
            : "\$result = \$this->model->update(\$id, \$data);";

        $content = <<<PHP
<?php

namespace App\Services;

{$entityUse}use App\Models\\{$modelClass};
use RuntimeException;

class {$class}
{
    private {$modelClass} \$model;

    public function __construct(?{$modelClass} \$model = null)
    {
        \$this->model = \$model ?? new {$modelClass}();
    }

    /**
     * @return list<object>
     */
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

    public function model(): {$modelClass}
    {
        return \$this->model;
    }
}

PHP;

        return $this->writeGenerated("Services/{$class}.php", $content, $force);
    }
}
