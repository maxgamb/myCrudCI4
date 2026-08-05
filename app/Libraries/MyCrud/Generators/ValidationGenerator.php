<?php
namespace App\Libraries\MyCrud\Generators;

class ValidationGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $class = $config['classes']['rules'];
        $table = $config['table'];
        $primaryKey = $config['primaryKey'];
        $create = [];
        $update = [];

        foreach ($config['fields'] as $field) {
            if ($field['primary'] && $field['autoIncrement']) continue;
            if (!empty($config['features']['softDeletes'])
                && $field['name'] === $config['softDelete']['field']) continue;

            $boolean = $field['attributes']['boolean'] ?? [];
            if (in_array('disabled', $boolean, true)) continue;

            $base = $this->baseRules($field);
            $createRules = $base;
            $updateRules = $base;

            if (!empty($field['unique'])) {
                $createRules[] = "is_unique[{$table}.{$field['name']}]";
                $updateRules[] = "is_unique[{$table}.{$field['name']},{$primaryKey},{id}]";
            }

            $create[$field['name']] = implode('|', array_unique($createRules));
            $update[$field['name']] = implode('|', array_unique($updateRules));
        }

        $content = "<?php\n\nnamespace App\\Validation;\n\nfinal class {$class}\n{\n"
            . "    public static function createRules(): array\n    {\n        return "
            . var_export($create, true) . ";\n    }\n\n"
            . "    public static function updateRules(int|string \$id): array\n    {\n"
            . "        \$rules = " . var_export($update, true) . ";\n"
            . "        foreach (\$rules as \$field => \$rule) {\n"
            . "            \$rules[\$field] = str_replace('{id}', (string) \$id, \$rule);\n"
            . "        }\n        return \$rules;\n    }\n\n"
            . "    public static function messages(): array\n    {\n        return [];\n    }\n}\n";

        return $this->writeGenerated("Validation/{$class}.php", $content, $force);
    }

    private function baseRules(array $field): array
    {
        $boolean = $field['attributes']['boolean'] ?? [];
        $values = $field['attributes']['values'] ?? [];
        $rules = [in_array('required', $boolean, true) ? 'required' : 'permit_empty'];

        if (!empty($field['maxLength'])) $rules[] = 'max_length[' . (int) $field['maxLength'] . ']';

        $type = $field['type'];
        if (preg_match('/tinyint|smallint|mediumint|int|bigint/', $type)) $rules[] = 'integer';
        elseif (preg_match('/decimal|float|double|numeric/', $type)) $rules[] = 'decimal';
        elseif ($type === 'date') $rules[] = 'valid_date[Y-m-d]';
        elseif (in_array($type, ['datetime', 'timestamp'], true)) $rules[] = 'valid_date';

        if ($field['inputType'] === 'email') $rules[] = 'valid_email';
        if ($field['inputType'] === 'url') $rules[] = 'valid_url_strict';
        if (!empty($values['pattern'])) $rules[] = 'regex_match[' . $values['pattern'] . ']';

        return $rules;
    }
}
