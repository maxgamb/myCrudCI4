<?php
namespace App\Libraries\MyCrud\Generators\Views;

use App\Libraries\MyCrud\Core\FieldPolicy;

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
        $manageTimestamps = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        foreach ($this->orderedFields($config) as $name) {
            $field = $config['fields'][$name];
            $ui = (array) ($field['ui'] ?? []);
            $inputType = (string) ($field['inputType'] ?? 'text');
            if (FieldPolicy::isSensitive($name, $inputType) && !FieldPolicy::isPassword($name, $inputType)) {
                continue;
            }

            if (!empty($field['primary']) && !empty($field['autoIncrement'])) {
                continue;
            }

            if (array_key_exists('visibleForm', (array) ($field['ui'] ?? [])) && empty($field['ui']['visibleForm'])) {
                continue;
            }

            if ($manageTimestamps && in_array($name, ['created_at', 'updated_at'], true)) {
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
            $fieldForAttributes = $field;
            $passwordRequired = $type === 'password'
                && in_array('required', (array) ($field['attributes']['boolean'] ?? []), true);
            if ($passwordRequired) {
                $fieldForAttributes['attributes']['boolean'] = array_values(array_diff(
                    (array) ($fieldForAttributes['attributes']['boolean'] ?? []),
                    ['required']
                ));
            }
            $attributes = $this->attributesString($fieldForAttributes);
            if ($passwordRequired) {
                $attributes = trim($attributes . " <?= \$row === null ? 'required' : '' ?>");
            }
            $label = $this->labelExpression($field, $name);
            $value = match ($type) {
                'password', 'file', 'image' => "old('{$name}', '')",
                'datetime-local' => "old('{$name}', isset(\$row->{$name}) ? str_replace(' ', 'T', substr((string) \$row->{$name}, 0, 16)) : (\$context['{$name}'] ?? ''))",
                default => "old('{$name}', \$row->{$name} ?? (\$context['{$name}'] ?? ''))",
            };
            $errorId = $name . '-error';
            $relationMode = strtolower((string) ($field['relationMode'] ?? ''));
            if (!empty($field['foreignKey']) && $relationMode === 'ajax') {
                $control = $this->buildAjaxRelationControl($config, $field, $name, $value, $errorId);
            } else {
                $control = $this->buildControl($type, $name, $value, $attributes, $errorId);
            }

            if (!empty($field['foreignKey'])) {
                $control .= $this->buildRelationNavigation($field, $name, $value);
            }
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
                        <div id="{$errorId}" class="invalid-feedback d-block">
                            <?= esc(\$errors['{$name}']) ?>
                        </div>
                    <?php endif; ?>
                </div>

PHP;
        }

        return $output;
    }

    private function buildAjaxRelationControl(array $config, array $field, string $name, string $value, string $errorId): string
    {
        $table = (string) ($config['table'] ?? '');
        $relation = (array) ($field['foreignKey'] ?? []);
        $alias = (string) ($relation['alias'] ?? '');
        $labelValue = $alias !== ''
            ? "old('{$name}__label', \$row->{$alias} ?? (\$contextLabels['{$name}'] ?? ''))"
            : "old('{$name}__label', \$contextLabels['{$name}'] ?? '')";
        $invalid = "<?= isset(\$errors['{$name}']) ? 'is-invalid' : '' ?>";
        $minChars = max(0, min(10, (int) (config('MyCrud')->relationAjaxMinimumChars ?? 2)));

        return <<<PHP
                    <input
                        type="hidden"
                        name="{$name}"
                        id="{$name}"
                        value="<?= esc({$value}) ?>"
                        class="crud-relation-value"
                    >
                    <input
                        type="search"
                        name="{$name}__label"
                        id="{$name}_search"
                        value="<?= esc({$labelValue}) ?>"
                        class="form-control {$invalid} crud-relation-search"
                        data-url="<?= site_url('{$table}/relation-options/{$name}') ?>"
                        data-value-target="{$name}"
                        data-results-target="{$name}_results"
                        data-min-chars="{$minChars}"
                        autocomplete="off"
                        aria-describedby="{$errorId}"
                    >
                    <select
                        id="{$name}_results"
                        class="form-select mt-2 d-none crud-relation-results"
                        size="5"
                        aria-label="Risultati ricerca"
                    ></select>
PHP;
    }

    private function buildRelationNavigation(array $field, string $name, string $value): string
    {
        $relation = (array) ($field['foreignKey'] ?? []);
        $navigation = (array) ($field['relationNavigation'] ?? []);
        $parentTable = (string) ($relation['parentTable'] ?? '');

        if ($parentTable === '' || (empty($navigation['parentLink']) && empty($navigation['createParentLink']))) {
            return '';
        }

        $parentLink = '';
        if (!empty($navigation['parentLink'])) {
            $parentLink = <<<PHP
                        <a
                            href="#"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary js-relation-parent-link disabled"
                            data-value-source="{$name}"
                            data-base-url="<?= site_url('{$parentTable}/view') ?>"
                            title="Apri record padre"
                            aria-label="Apri record padre"
                        >
                            <i class="bi bi-box-arrow-up-right"></i>
                        </a>
PHP;
        }

        $createLink = '';
        if (!empty($navigation['createParentLink'])) {
            $createLink = <<<PHP
                        <a
                            href="<?= site_url('{$parentTable}/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg"></i>
                        </a>
PHP;
        }

        return <<<PHP
                    <div class="d-flex gap-1 mt-2 relation-navigation-actions">
{$parentLink}{$createLink}                    </div>
PHP;
    }

    private function buildControl(string $type, string $name, string $value, string $attributes, string $errorId): string
    {
        $invalid = "<?= isset(\$errors['{$name}']) ? 'is-invalid' : '' ?>";
        $attributeLine = "\n                        aria-describedby=\"{$errorId}\"\n                        aria-invalid=\"<?= isset(\$errors['{$name}']) ? 'true' : 'false' ?>\"";
        if ($attributes !== '') {
            $attributeLine .= "\n                        {$attributes}";
        }

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
