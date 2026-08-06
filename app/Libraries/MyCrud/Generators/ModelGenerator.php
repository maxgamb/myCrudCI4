<?php

namespace App\Libraries\MyCrud\Generators;

class ModelGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = $config['table'];
        $primaryKey = $config['primaryKey'];
        $class = $config['classes']['model'];
        $entity = $config['classes']['entity'];
        $usesEntity = !empty($config['features']['entity']);

        $allowed = [];
        foreach ($config['fields'] as $field) {
            if ($field['primary'] && $field['autoIncrement']) {
                continue;
            }
            $allowed[] = $field['name'];
        }

        $allowedCode = var_export($allowed, true);
        $returnType = $usesEntity ? "\\App\\Entities\\{$entity}::class" : "'object'";
        $useEntity = $usesEntity ? "use App\\Entities\\{$entity};\n" : '';

        $softDeleteEnabled = !empty($config['features']['softDeletes']);
        $deletedField = $config['softDelete']['field'] ?? 'deleted_at';
        $softDeleteCode = $softDeleteEnabled
            ? "    protected \$useSoftDeletes = true;\n    protected \$deletedField = '{$deletedField}';"
            : "    protected \$useSoftDeletes = false;";

        $joins = '';
        $select = "'{$table}.*'";

        if (!empty($config['features']['relations'])) {
            foreach ($config['relations']['belongsTo'] ?? [] as $relation) {
                $parent = $relation['parentTable'];
                $field = $relation['field'];
                $key = $relation['parentKey'];
                $label = $relation['displayField'];
                $alias = $relation['alias'];

                $joins .= "        \$builder->join('{$parent}', '{$parent}.{$key} = {$table}.{$field}', 'left');\n";
                $select .= ",\n            '{$parent}.{$label} AS {$alias}'";
            }
        }

        $content = <<<PHP
<?php

namespace App\Models;

{$useEntity}use CodeIgniter\Model;
use InvalidArgumentException;

class {$class} extends Model
{
    protected \$table = '{$table}';
    protected \$primaryKey = '{$primaryKey}';
    protected \$returnType = {$returnType};
{$softDeleteCode}
    protected \$protectFields = true;
    protected \$allowedFields = {$allowedCode};
    protected \$useTimestamps = false;
    protected \$skipValidation = true;
    protected \$cleanValidationRules = true;

    public function getList(array \$filters = []): array
    {
        \$builder = \$this->builder();
        \$builder->select([
            {$select}
        ]);

{$joins}
        foreach (\$filters as \$field => \$value) {
            if (\$value === null || \$value === '') {
                continue;
            }

            if (in_array(\$field, \$this->allowedFields, true) || \$field === \$this->primaryKey) {
                \$builder->where("{$table}." . \$field, \$value);
            }
        }

        return \$builder
            ->orderBy("{$table}.{$primaryKey}", 'DESC')
            ->get()
            ->getResult();
    }

    public function getDetail(int|string \$id): ?object
    {
        return \$this->builder()
            ->where(\$this->primaryKey, \$id)
            ->get()
            ->getRow(\$this->returnType);
    }

    public function datatableBuilder(): \CodeIgniter\Database\BaseBuilder
    {
        \$builder = \$this->builder();
        \$builder->select([
            {$select}
        ]);

{$joins}
        return \$builder;
    }

    public function getRelatedChildren(
        string \$childTable,
        string \$foreignKey,
        int|string \$parentId,
        string \$orderField,
        int \$limit = 20
    ): array {
        \$this->assertIdentifier(\$childTable);
        \$this->assertIdentifier(\$foreignKey);
        \$this->assertIdentifier(\$orderField);

        return \$this->db
            ->table(\$childTable)
            ->where(\$foreignKey, \$parentId)
            ->orderBy(\$orderField, 'DESC')
            ->limit(max(1, min(200, \$limit)))
            ->get()
            ->getResult();
    }

    public function countRelatedChildren(
        string \$childTable,
        string \$foreignKey,
        int|string \$parentId
    ): int {
        \$this->assertIdentifier(\$childTable);
        \$this->assertIdentifier(\$foreignKey);

        return \$this->db
            ->table(\$childTable)
            ->where(\$foreignKey, \$parentId)
            ->countAllResults();
    }

    private function assertIdentifier(string \$identifier): void
    {
        if (preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', \$identifier) !== 1) {
            throw new InvalidArgumentException('Identificatore database non valido.');
        }
    }
}

PHP;

        return $this->writeGenerated("Models/{$class}.php", $content, $force);
    }
}
