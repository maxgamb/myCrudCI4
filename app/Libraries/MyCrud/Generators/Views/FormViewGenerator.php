<?php
namespace App\Libraries\MyCrud\Generators\Views;

final class FormViewGenerator extends AbstractViewGenerator
{
    /** @return array{form:string,create:string,edit:string} */
    public function generate(array $config): array
    {
        $table = (string) $config['table'];

        return [
            'form' => $this->templates->render('views/form.tpl', [
                'table'  => $table,
                'fields' => $this->buildFields($config),
            ]),
            'create' => $this->templates->render('views/create.tpl', [
                'view_path' => $table,
                'route'     => $table,
            ]),
            'edit' => $this->templates->render('views/edit.tpl', [
                'view_path'   => $table,
                'route'       => $table,
                'primary_key' => (string) $config['primaryKey'],
            ]),
        ];
    }

    private function buildFields(array $config): string
    {
        $output = '';

        foreach ($this->orderedFields($config) as $name) {
            $field = $config['fields'][$name];

            if (!empty($field['primary']) && !empty($field['autoIncrement'])) {
                continue;
            }

            if (
                !empty($config['features']['softDeletes'])
                && $name === ($config['softDelete']['field'] ?? 'deleted_at')
            ) {
                continue;
            }

            $type = (string) ($field['inputType'] ?? 'text');
            $width = max(1, min(12, (int) ($field['width'] ?? 6)));
            $attributes = $this->attributesString($field);
            $label = $this->labelExpression($field, $name);
            $value = "old('{$name}', \$row->{$name} ?? '')";
            $control = $this->buildControl($type, $name, $value, $attributes);
            $wrapper = $type === 'hidden' ? 'd-none' : "col-md-{$width}";

            $labelHtml = $type === 'hidden'
                ? ''
                : <<<PHP
                    <label for="{$name}" class="form-label">
                        <?= esc({$label}) ?>
                    </label>

PHP;

            $output .= <<<PHP
                <div class="{$wrapper}">
{$labelHtml}{$control}
                    <?php if (!empty(\$errors['{$name}'])): ?>
                        <div class="invalid-feedback d-block">
                            <?= esc(\$errors['{$name}']) ?>
                        </div>
                    <?php endif; ?>
                </div>

PHP;
        }

        return $output;
    }

    private function buildControl(string $type, string $name, string $value, string $attributes): string
    {
        $invalid = "<?= isset(\$errors['{$name}']) ? 'is-invalid' : '' ?>";
        $attributeLine = $attributes === '' ? '' : "\n                        {$attributes}";

        return match ($type) {
            'textarea' => <<<PHP
                    <textarea
                        name="{$name}"
                        id="{$name}"
                        class="form-control {$invalid}"{$attributeLine}
                    ><?= esc({$value}) ?></textarea>
PHP,
            'select' => <<<PHP
                    <select
                        name="{$name}"
                        id="{$name}"
                        class="form-select {$invalid}"{$attributeLine}
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach ((\$options['{$name}'] ?? []) as \$optionValue => \$optionLabel): ?>
                            <option
                                value="<?= esc(\$optionValue) ?>"
                                <?= (string) {$value} === (string) \$optionValue ? 'selected' : '' ?>
                            >
                                <?= esc(\$optionLabel) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
PHP,
            'checkbox' => <<<PHP
                    <input type="hidden" name="{$name}" value="0">

                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="{$name}"
                            id="{$name}"
                            value="1"
                            class="form-check-input {$invalid}"
                            <?= {$value} ? 'checked' : '' ?>{$attributeLine}
                        >
                    </div>
PHP,
            'file' => <<<PHP
                    <input type="file" name="{$name}" id="{$name}" class="form-control {$invalid}"{$attributeLine}>
PHP,
            'image' => <<<PHP
                    <input type="file" name="{$name}" id="{$name}" accept="image/*" class="form-control {$invalid}"{$attributeLine}>
PHP,
            'hidden' => <<<PHP
                    <input type="hidden" name="{$name}" id="{$name}" value="<?= esc({$value}) ?>">
PHP,
            default => <<<PHP
                    <input
                        type="{$type}"
                        name="{$name}"
                        id="{$name}"
                        value="<?= esc({$value}) ?>"
                        class="form-control {$invalid}"{$attributeLine}
                    >
PHP,
        };
    }
}
