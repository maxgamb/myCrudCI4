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

    /**
     * Build a PHP object-property expression preserving the exact DB column name.
     *
     * Always uses the quoted dynamic-property form, e.g. $row->{'zip code'},
     * so generated views remain valid even when a column is not a valid PHP
     * identifier.
     */
    protected function objectProperty(string $object, string $property): string
    {
        return '$' . ltrim($object, '$') . '->{' . var_export($property, true) . '}';
    }

    /**
     * Compact rendering for very large text fields in tables only.
     * The full value remains unchanged in the database, detail view, form, and export.
     */
    protected function tabularValueMarkup(string $expression, string $type, string $key = 'value'): string
    {
        $type = strtolower(trim($type));
        $config = config('MyCrud');
        $limit = match ($type) {
            'mediumtext' => max(50, (int) ($config->mediumTextPreviewLength ?? 250)),
            'longtext' => max(50, (int) ($config->longTextPreviewLength ?? 350)),
            default => 0,
        };

        if ($limit <= 0) {
            return "<?= esc({$expression} ?? '') ?>";
        }

        $suffix = substr(sha1($key), 0, 8);

        return <<<PHP
<?php
                                    \$__crudValue_{$suffix} = (string) ({$expression} ?? '');
                                    \$__crudLimit_{$suffix} = {$limit};
                                    if (function_exists('mb_strlen') && function_exists('mb_substr')) {
                                        \$__crudShown_{$suffix} = mb_strlen(\$__crudValue_{$suffix}, 'UTF-8') > \$__crudLimit_{$suffix}
                                            ? mb_substr(\$__crudValue_{$suffix}, 0, \$__crudLimit_{$suffix} - 1, 'UTF-8') . '…'
                                            : \$__crudValue_{$suffix};
                                    } else {
                                        \$__crudShown_{$suffix} = strlen(\$__crudValue_{$suffix}) > \$__crudLimit_{$suffix}
                                            ? substr(\$__crudValue_{$suffix}, 0, \$__crudLimit_{$suffix} - 3) . '...'
                                            : \$__crudValue_{$suffix};
                                    }
                                    ?><?= esc(\$__crudShown_{$suffix}) ?>
PHP;
    }


    /**
     * Render sicuro di file/immagini conservati fuori dalla public/.
     * The browser always goes through the generated Controller, which verifies the record and field.
     */
    protected function uploadValueMarkup(
        string $table,
        string $primaryKeyExpression,
        string $fieldName,
        string $valueExpression,
        string $inputType,
        bool $detail = false
    ): string {
        $tableExport = var_export($table, true);
        $fieldExport = var_export($fieldName, true);
        $image = strtolower($inputType) === 'image';

        if ($image) {
            $class = $detail
                ? 'img-fluid rounded border'
                : 'img-thumbnail';
            $style = $detail
                ? 'max-height:420px;max-width:100%;'
                : 'width:64px;height:48px;object-fit:cover;';

            return <<<PHP
<?php if (trim((string) ({$valueExpression} ?? '')) !== ''): ?>
    <?php \$__uploadUrl = site_url({$tableExport} . '/upload/' . rawurlencode((string) ({$primaryKeyExpression} ?? '')) . '/' . rawurlencode({$fieldExport})); ?>
    <a href="<?= esc(\$__uploadUrl) ?>" target="_blank" rel="noopener">
        <img src="<?= esc(\$__uploadUrl) ?>" alt="<?= esc(basename((string) {$valueExpression})) ?>" class="{$class}" style="{$style}">
    </a>
<?php else: ?>
    <span class="text-muted">—</span>
<?php endif; ?>
PHP;
        }

        return <<<PHP
<?php if (trim((string) ({$valueExpression} ?? '')) !== ''): ?>
    <?php \$__uploadUrl = site_url({$tableExport} . '/upload/' . rawurlencode((string) ({$primaryKeyExpression} ?? '')) . '/' . rawurlencode({$fieldExport})); ?>
    <a href="<?= esc(\$__uploadUrl) ?>" target="_blank" rel="noopener" class="text-decoration-none">
        <i class="bi bi-file-earmark-arrow-down me-1" aria-hidden="true"></i><?= esc(basename((string) {$valueExpression})) ?>
    </a>
<?php else: ?>
    <span class="text-muted">—</span>
<?php endif; ?>
PHP;
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
