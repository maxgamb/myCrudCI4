<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/**
 * Proiezione MCP indipendente dalla REST Resource.
 *
 * The MCP data surface is independent from apiVisible.
 */
final class McpResourceGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $mcp = (array) ($config['mcp'] ?? []);
        if (empty($mcp['enabled']) || (string) ($config['architecture'] ?? '') !== 'full') {
            return [];
        }

        $table = (string) ($config['table'] ?? '');
        $studly = $this->studly($table);
        $class = $studly . 'McpResource';

        $readable = [];

        foreach ((array) ($config['fields'] ?? []) as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name === '') {
                continue;
            }

            $ui = (array) ($field['ui'] ?? []);
            if (empty($ui['mcpVisible'])) {
                continue;
            }

            $readable[] = $name;

        }

        foreach ((array) ($config['relations']['belongsTo'] ?? []) as $fieldName => $relation) {
            $fieldUi = (array) ($config['fields'][$fieldName]['ui'] ?? []);
            if (empty($fieldUi['mcpVisible'])) {
                continue;
            }

            $alias = (string) ($relation['alias'] ?? '');
            if ($alias !== '') {
                $readable[] = $alias;
            }
        }

        $pk = (string) ($config['primaryKey'] ?? '');
        if ($pk !== '' && !in_array($pk, $readable, true)) {
            array_unshift($readable, $pk);
        }


        $readableCode = var_export(array_values(array_unique($readable)), true);

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\\Mcp\\Resources;

final class {$class}
{
    private const READABLE = {$readableCode};

    public static function make(object|array \$record): array
    {
        if (is_array(\$record)) {
            \$source = \$record;
        } elseif (method_exists(\$record, 'toRawArray')) {
            \$source = \$record->toRawArray();
        } elseif (method_exists(\$record, 'toArray')) {
            \$source = \$record->toArray();
        } else {
            \$source = get_object_vars(\$record);
        }

        return array_intersect_key(\$source, array_flip(self::READABLE));
    }

    public static function collection(array \$records): array
    {
        return array_map(
            static fn (object|array \$record): array => self::make(\$record),
            \$records
        );
    }

}

PHP;

        return $this->writeGenerated(
            'Generated/Mcp/Resources/' . $class . '.php',
            $content,
            $force
        );
    }

    private function studly(string $value): string
    {
        $parts = preg_split('/[^a-zA-Z0-9]+/', $value) ?: [$value];

        $result = implode('', array_map(
            static fn (string $part): string => ucfirst(strtolower($part)),
            $parts
        ));

        return $result !== '' ? $result : 'Crud';
    }
}
