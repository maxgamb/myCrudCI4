<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\DatabaseValidationResolver;

final class ValidationGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $class = (string) $config['classes']['rules'];
        $table = (string) $config['table'];
        $primaryKey = (string) $config['primaryKey'];
        $resolver = new DatabaseValidationResolver();
        $create = [];
        $update = [];
        $manageTimestamps = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        foreach ($config['fields'] as $field) {
            if (!empty($field['primary']) && !empty($field['autoIncrement'])) {
                continue;
            }

            $name = (string) $field['name'];
            if (!empty($config['features']['softDeletes'])
                && $name === (string) ($config['softDelete']['field'] ?? 'deleted_at')) {
                continue;
            }
            if ($manageTimestamps && in_array($name, ['created_at', 'updated_at'], true)) {
                continue;
            }

            $boolean = (array) ($field['attributes']['boolean'] ?? []);
            if (in_array('disabled', $boolean, true)) {
                continue;
            }

            $createRules = $resolver->rulesFor($field, $table, $primaryKey, false);
            $updateRules = $resolver->rulesFor($field, $table, $primaryKey, true);

            // In modifica una password vuota significa "mantieni quella attuale".
            if ((string) ($field['inputType'] ?? '') === 'password') {
                $updateRules = array_values(array_diff($updateRules, ['required', 'permit_empty']));
                array_unshift($updateRules, 'permit_empty');
            }

            if ($createRules !== []) {
                $create[$name] = implode('|', array_unique($createRules));
            }
            if ($updateRules !== []) {
                $update[$name] = implode('|', array_unique($updateRules));
            }
        }

        $content = "<?php\n\ndeclare(strict_types=1);\n\nnamespace App\\Validation;\n\nfinal class {$class}\n{\n"
            . "    public static function createRules(): array\n    {\n        return "
            . var_export($create, true) . ";\n    }\n\n"
            . "    public static function updateRules(int|string \$id): array\n    {\n"
            . "        \$rules = " . var_export($update, true) . ";\n"
            . "        foreach (\$rules as \$field => \$rule) {\n"
            . "            \$rules[\$field] = str_replace('{id}', (string) \$id, \$rule);\n"
            . "        }\n        return \$rules;\n    }\n\n"
            . "    public static function messages(): array\n    {\n        return [];\n    }\n}\n";

        return $this->writeGenerated("Generated/Validation/{$class}.php", $content, $force);
    }
}
