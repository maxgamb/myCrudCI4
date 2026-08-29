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
                preg_match('/float|double/', $type) === 1 => 'float',
                // DECIMAL/NUMERIC stay as DB strings: exact monetary values must not
                // be silently converted to binary floating point.
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

declare(strict_types=1);

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class {$class} extends Entity
{
    protected \$datamap = [];

    protected \$dates = {$datesCode};

    protected \$casts = {$castsCode};

    /**
     * Creates one domain record from already prepared application data.
     *
     * HTTP normalization, validation and cross-resource business logic belong
     * to the Service; the Entity owns record-local typing and behavior.
     *
     * @param array<string,mixed> \$data
     */
    public static function fromArray(array \$data): self
    {
        return new self(\$data);
    }
}

PHP;

        return $this->writeGenerated("Generated/Entities/{$class}.php", $content, $force);
    }
}
