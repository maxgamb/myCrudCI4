<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\DatabaseValidationResolver;
use App\Libraries\MyCrud\Core\FieldPolicy;

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
        $relatedCreate = [];
        $manageTimestamps = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        foreach ($config['fields'] as $field) {
            if (!empty($field['primary']) && !empty($field['autoIncrement'])) {
                continue;
            }
            if (!empty($field['databaseManaged'])) {
                continue;
            }

            $name = (string) $field['name'];
            $ui = (array) ($field['ui'] ?? []);
            $inputType = (string) ($field['inputType'] ?? 'text');
            if (array_key_exists('visibleForm', $ui) && empty($ui['visibleForm'])) {
                continue;
            }
            if (FieldPolicy::isSensitive($name, $inputType) && !FieldPolicy::isPassword($name, $inputType)) {
                continue;
            }
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
            if (FieldPolicy::isPassword($name, $inputType)) {
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

        foreach ((array) ($config['relations']['belongsTo'] ?? []) as $fieldName => $relation) {
            $fieldConfig = (array) ($config['fields'][$fieldName] ?? []);
            if (empty($fieldConfig['relationCreate']['enabled'])) {
                continue;
            }

            $definition = (array) ($relation['relatedCreate'] ?? []);
            if (empty($definition['available'])) {
                continue;
            }

            $parentTable = (string) ($definition['table'] ?? $relation['parentTable'] ?? '');
            $parentKey = (string) ($definition['key'] ?? $relation['parentKey'] ?? 'id');
            $rulesForRelation = [];
            foreach ((array) ($definition['fields'] ?? []) as $parentFieldName => $parentField) {
                $parentRules = $resolver->rulesFor((array) $parentField, $parentTable, $parentKey, false);
                if ($parentRules !== []) {
                    $rulesForRelation[(string) $parentFieldName] = implode('|', array_unique($parentRules));
                }
            }
            if ($rulesForRelation !== []) {
                $relatedCreate[(string) $fieldName] = $rulesForRelation;
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
            . "    /** Regole dei record padre creati nello stesso submit. */\n"
            . "    public static function relatedCreateRules(): array\n    {\n        return "
            . var_export($relatedCreate, true) . ";\n    }\n\n"
            . "    public static function messages(): array\n    {\n        return [];\n    }\n}\n";

        return $this->writeGenerated("Generated/Validation/{$class}.php", $content, $force);
    }
}
