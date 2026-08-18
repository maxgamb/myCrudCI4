<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\DatabaseValidationResolver;
use App\Libraries\MyCrud\Core\FieldPolicy;

/** Generates server-side rules consistent with the CRUD's effective capabilities. */
final class ValidationGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $class = (string) $config['classes']['rules'];
        $table = (string) $config['table'];
        $primaryKey = (string) $config['primaryKey'];
        $createAllowed = !empty($config['features']['createAllowed']);
        $writable = !empty($config['features']['writable']);
        $resolver = new DatabaseValidationResolver();
        $create = [];
        $update = [];
        $relatedCreate = [];
        $manyToManyRelatedCreate = [];
        $manageTimestamps = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        foreach ((array) ($config['fields'] ?? []) as $field) {
            if (!empty($field['primary']) && !empty($field['autoIncrement'])) {
                continue;
            }
            if (!empty($field['databaseManaged'])) {
                continue;
            }

            $name = (string) ($field['name'] ?? '');
            $ui = (array) ($field['ui'] ?? []);
            $inputType = (string) ($field['inputType'] ?? 'text');
            // Gli upload sono validati da CrudUploadManager sui file HTTP, non sul POST.
            if (in_array(strtolower($inputType), ['file', 'image'], true)) {
                continue;
            }
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

            if ($createAllowed) {
                $createRules = $resolver->rulesFor($field, $table, $primaryKey, false);
                if ($createRules !== []) {
                    $create[$name] = implode('|', array_unique($createRules));
                }
            }

            if ($writable) {
                $updateRules = $resolver->rulesFor($field, $table, $primaryKey, true);
                if (FieldPolicy::isPassword($name, $inputType)) {
                    $updateRules = array_values(array_diff($updateRules, ['required', 'permit_empty']));
                    array_unshift($updateRules, 'permit_empty');
                }
                if ($updateRules !== []) {
                    $update[$name] = implode('|', array_unique($updateRules));
                }
            }
        }

        if ($createAllowed) {
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
        }

        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $relationKey => $relation) {
            if (empty($relation['enabled'])
                || empty($relation['createRelatedEnabled'])
                || empty($relation['createRelatedAvailable'])
            ) {
                continue;
            }

            $definition = (array) ($relation['relatedCreate'] ?? []);
            $relatedTable = (string) ($definition['table'] ?? $relation['relatedTable'] ?? '');
            $relatedKey = (string) ($definition['key'] ?? $relation['relatedKey'] ?? 'id');
            $rulesForRelation = [];

            foreach ((array) ($definition['fields'] ?? []) as $relatedFieldName => $relatedField) {
                $fieldRules = $resolver->rulesFor((array) $relatedField, $relatedTable, $relatedKey, false);
                if ($fieldRules !== []) {
                    $rulesForRelation[(string) $relatedFieldName] = implode('|', array_unique($fieldRules));
                }
            }

            if ($rulesForRelation !== []) {
                $manyToManyRelatedCreate[(string) $relationKey] = $rulesForRelation;
            }
        }

        $createCode = var_export($create, true);
        $updateCode = var_export($update, true);
        $relatedCode = var_export($relatedCreate, true);
        $manyToManyRelatedCode = var_export($manyToManyRelatedCreate, true);

        $createMethod = $createAllowed ? <<<PHP
    /** @return array<string,string> */
    public static function createRules(): array
    {
        return {$createCode};
    }

PHP : '';

        $updateMethod = $writable ? <<<PHP
    /** @return array<string,string> */
    public static function updateRules(int|string \$id): array
    {
        \$rules = {$updateCode};
        foreach (\$rules as \$field => \$rule) {
            \$rules[\$field] = str_replace('{id}', (string) \$id, \$rule);
        }
        return \$rules;
    }

PHP : '';

        $relatedMethod = $createAllowed ? <<<PHP
    /** @return array<string,array<string,string>> */
    public static function relatedCreateRules(): array
    {
        return {$relatedCode};
    }

    /** @return array<string,array<string,string>> */
    public static function manyToManyRelatedCreateRules(): array
    {
        return {$manyToManyRelatedCode};
    }

PHP : '';

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Validation;

/** Regole server-side generate secondo le capability effettive del CRUD. */
final class {$class}
{
{$createMethod}{$updateMethod}{$relatedMethod}    /** @return array<string,string> */
    public static function messages(): array
    {
        return [];
    }
}

PHP;

        return $this->writeGenerated("Generated/Validation/{$class}.php", $content, $force);
    }
}
