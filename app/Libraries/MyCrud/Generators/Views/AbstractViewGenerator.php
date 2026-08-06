<?php
namespace App\Libraries\MyCrud\Generators\Views;

use App\Libraries\MyCrud\Template\TemplateEngine;

abstract class AbstractViewGenerator
{
    public function __construct(protected readonly TemplateEngine $templates)
    {
    }

    /** @return list<string> */
    protected function orderedFields(array $config): array
    {
        $ordered = [];

        foreach ($config['order'] ?? [] as $name) {
            if (isset($config['fields'][$name])) {
                $ordered[] = (string) $name;
            }
        }

        return $ordered ?: array_keys($config['fields']);
    }

    protected function labelExpression(array $field, string $fieldName): string
    {
        $label = trim((string) ($field['label'] ?? ''));

        if ($label !== '') {
            return var_export($label, true);
        }

        $languageKey = (string) ($field['languageKey'] ?? 'Fields.' . $fieldName);

        return 'lang(' . var_export($languageKey, true) . ')';
    }

    protected function attributesString(array $field): string
    {
        $parts = [];

        foreach ($field['attributes']['boolean'] ?? [] as $attribute) {
            if (in_array($attribute, ['required', 'readonly', 'disabled'], true)) {
                $parts[] = $attribute;
            }
        }

        foreach ($field['attributes']['values'] ?? [] as $name => $value) {
            if ($value === '' || $value === null) {
                continue;
            }

            if ((string) $name === 'maxlength' && (int) $value > 65535) {
                continue;
            }

            $parts[] = sprintf(
                '%s="%s"',
                htmlspecialchars((string) $name, ENT_QUOTES),
                htmlspecialchars((string) $value, ENT_QUOTES)
            );
        }

        return implode(' ', $parts);
    }
}
