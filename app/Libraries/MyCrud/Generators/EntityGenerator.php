<?php

namespace App\Libraries\MyCrud\Generators;

class EntityGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $class = $config['classes']['entity'];
        $casts = [];
        $dates = [];

        foreach ($config['fields'] as $field) {
            $type = strtolower((string) $field['type']);
            $columnType = strtolower((string) ($field['columnType'] ?? ''));

            if (in_array($type, ['date', 'datetime', 'timestamp'], true)) {
                $dates[] = $field['name'];
            }

            $cast = match (true) {
                $type === 'bool' || $type === 'boolean' || preg_match('/^tinyint\(1\)/', $columnType) === 1 => 'boolean',
                preg_match('/tinyint|smallint|mediumint|int|bigint/', $type) === 1 => 'integer',
                preg_match('/decimal|float|double|numeric/', $type) === 1 => 'float',
                default => null,
            };

            if ($cast !== null) {
                $casts[$field['name']] = $cast;
            }
        }

        $castsCode = var_export($casts, true);
        $datesCode = var_export($dates, true);

        $content = <<<PHP
<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class {$class} extends Entity
{
    protected \$datamap = [];

    protected \$dates = {$datesCode};

    protected \$casts = {$castsCode};
}

PHP;

        return $this->writeGenerated("Generated/Entities/{$class}.php", $content, $force);
    }
}
