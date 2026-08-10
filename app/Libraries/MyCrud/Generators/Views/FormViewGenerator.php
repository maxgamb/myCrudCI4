<?php
namespace App\Libraries\MyCrud\Generators\Views;

use App\Libraries\MyCrud\Core\FieldPolicy;
use App\Libraries\MyCrud\Core\Naming;

final class FormViewGenerator extends AbstractViewGenerator
{
    /** @return array{form:string,create:string,edit:string,relatedPartials:array<string,string>} */
    public function generate(array $config): array
    {
        $table = (string) $config['table'];

        return [
            'form' => $this->templates->render('views/form.tpl', [
                'table'  => $table,
                'fields' => $this->buildFields($config),
            ]),
            'create' => $this->templates->render('views/create.tpl', [
                'table'     => $table,
                'view_path' => $table,
                'route'     => $table,
            ]),
            'edit' => $this->templates->render('views/edit.tpl', [
                'table'       => $table,
                'view_path'   => $table,
                'route'       => $table,
                'primary_key' => (string) $config['primaryKey'],
            ]),
            'relatedPartials' => $this->buildRelatedCreatePartials($config),
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
            if (!empty($field['databaseManaged'])) {
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
            $rowValue = $this->objectProperty('row', $name);
            $value = match ($type) {
                'password', 'file', 'image' => "old('{$name}', '')",
                'datetime-local' => "old('{$name}', isset({$rowValue}) ? str_replace(' ', 'T', substr((string) {$rowValue}, 0, 16)) : (\$context['{$name}'] ?? ''))",
                default => "old('{$name}', {$rowValue} ?? (\$context['{$name}'] ?? ''))",
            };
            $errorId = $name . '-error';
            $relationMode = strtolower((string) ($field['relationMode'] ?? ''));
            if (!empty($field['foreignKey']) && $relationMode === 'ajax') {
                $control = $this->buildAjaxRelationControl($config, $field, $name, $value, $errorId);
            } else {
                $control = $this->buildControl($type, $name, $value, $attributes, $errorId);
            }

            $relatedCreatePanel = '';
            if (!empty($field['foreignKey'])) {
                $relationActions = $this->buildRelationNavigation($field, $name, $value);
                if ($relationActions !== '') {
                    if ($relationMode === 'ajax') {
                        // La select AJAX mantiene la propria struttura (hidden + search + risultati):
                        // le azioni restano subito sotto per non rompere il widget di ricerca.
                        $control .= '<div class="d-flex gap-1 mt-2 relation-navigation-actions">' . $relationActions . '</div>';
                    } else {
                        // FK standard: select/input e azioni correlate formano un unico input-group.
                        $control = '<div class="input-group crud-relation-input-group">' . "\n" . $control . "\n" . $relationActions . "\n" . '</div>';
                    }
                }
                if (!empty($field['relationCreate']['enabled'])) {
                    $field['_ownerTable'] = (string) ($config['table'] ?? '');
                    $relatedCreatePanel = $this->buildRelatedCreatePanel($field, $name);
                }
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
{$relatedCreatePanel}

PHP;
        }

        return $output;
    }

    /**
     * Shell del Relational Create. Il contenuto del padre vive in un partial
     * dedicato del CRUD corrente (`_related_create_<fk>.php`). L'interfaccia
     * usa un Bootstrap Offcanvas sovrapposto: la vista/form principale resta
     * visivamente invariata e non viene mai caricata la create completa del
     * padre (niente breadcrumb, toolbar, submit o form annidati).
     */
    private function buildRelatedCreatePanel(array $field, string $name): string
    {
        $definition = (array) ($field['foreignKey']['relatedCreate'] ?? []);
        if (empty($definition['available']) || (array) ($definition['fields'] ?? []) === []) {
            return '';
        }

        $parentTable = (string) ($definition['table'] ?? $field['foreignKey']['parentTable'] ?? 'record collegato');
        $panelId = 'related_create_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $name);
        $partial = '_related_create_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $name);
        $title = htmlspecialchars(Naming::human($parentTable), ENT_QUOTES);
        $currentTable = htmlspecialchars((string) ($field['_ownerTable'] ?? ''), ENT_QUOTES);

        return <<<PHP
                <?php if (\$row === null): ?>
                    <?php
                    \$relatedNewState = (array) old('_related_new', []);
                    \$relatedPayloadState = (array) old('_related', []);
                    \$relatedCreateActive = !empty(\$relatedNewState['{$name}']);
                    ?>
                    <div class="col-12">
                        <input
                            type="hidden"
                            name="_related_new[{$name}]"
                            id="{$panelId}_state"
                            value="<?= \$relatedCreateActive ? '1' : '0' ?>"
                        >
                        <div
                            id="{$panelId}"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            tabindex="-1"
                            aria-labelledby="{$panelId}_label"
                            data-related-field="{$name}"
                            data-state-target="{$panelId}_state"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="{$panelId}_label">Nuovo {$title}</h2>
                                    <small class="text-muted">Relazione {$name}</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="{$name}"
                                    data-state-target="{$panelId}_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Annulla nuovo {$title}"
                                ></button>
                            </div>
                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Compila i dati del nuovo {$title}. Il record collegato e questo record verranno salvati insieme al submit del form principale, nella stessa transazione.
                                </div>
                                <?= view('{$currentTable}/{$partial}', [
                                    'relatedField'        => '{$name}',
                                    'relatedCreateActive' => \$relatedCreateActive,
                                    'relatedPayloadState' => \$relatedPayloadState,
                                    'errors'              => \$errors,
                                ]) ?>
                            </div>
                            <div class="offcanvas-footer border-top p-3 d-flex justify-content-end">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary crud-related-create-cancel"
                                    data-related-field="{$name}"
                                    data-state-target="{$panelId}_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Annulla nuovo {$title}
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
PHP;
    }

    /** @return array<string,string> */
    private function buildRelatedCreatePartials(array $config): array
    {
        $partials = [];
        foreach ($this->orderedFields($config) as $name) {
            $field = (array) ($config['fields'][$name] ?? []);
            if (empty($field['foreignKey']) || empty($field['relationCreate']['enabled'])) {
                continue;
            }
            $definition = (array) ($field['foreignKey']['relatedCreate'] ?? []);
            if (empty($definition['available']) || (array) ($definition['fields'] ?? []) === []) {
                continue;
            }
            $safe = preg_replace('/[^a-zA-Z0-9_]/', '_', (string) $name);
            $partials['_related_create_' . $safe . '.php'] = $this->buildRelatedCreatePartial((string) $name, $definition);
        }
        return $partials;
    }

    private function buildRelatedCreatePartial(string $name, array $definition): string
    {
        $panelId = 'related_create_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $name);
        $rows = '';
        foreach ((array) ($definition['fields'] ?? []) as $relatedName => $relatedField) {
            $relatedName = (string) $relatedName;
            $relatedField = (array) $relatedField;
            $type = strtolower((string) ($relatedField['inputType'] ?? 'text'));
            $label = var_export(Naming::human($relatedName), true);
            $inputId = $panelId . '_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $relatedName);
            $errorKey = $name . '__related__' . $relatedName;
            $required = in_array('required', (array) ($relatedField['attributes']['boolean'] ?? []), true);
            $maxLength = trim((string) ($relatedField['attributes']['values']['maxlength'] ?? ''));
            $requiredAttr = $required ? ' required' : '';
            $maxLengthAttr = $maxLength !== '' ? ' maxlength="' . htmlspecialchars($maxLength, ENT_QUOTES) . '"' : '';
            $valueExpr = "(string) ((\$relatedPayloadState[" . var_export($name, true) . "][" . var_export($relatedName, true) . "] ?? ''))";
            $invalid = "<?= isset(\$errors[" . var_export($errorKey, true) . "]) ? 'is-invalid' : '' ?>";

            if ($type === 'textarea') {
                $control = <<<PHP
                <textarea
                    name="_related[{$name}][{$relatedName}]"
                    id="{$inputId}"
                    class="form-control {$invalid} crud-related-create-field"
                    data-related-field="{$name}"
                    <?= \$relatedCreateActive ? '' : 'disabled' ?>
                    {$requiredAttr}{$maxLengthAttr}
                ><?= esc({$valueExpr}) ?></textarea>
PHP;
            } elseif ($type === 'checkbox') {
                $control = <<<PHP
                <input
                    type="hidden"
                    name="_related[{$name}][{$relatedName}]"
                    value="0"
                    class="crud-related-create-field"
                    data-related-field="{$name}"
                    <?= \$relatedCreateActive ? '' : 'disabled' ?>
                >
                <div class="form-check">
                    <input
                        type="checkbox"
                        name="_related[{$name}][{$relatedName}]"
                        id="{$inputId}"
                        value="1"
                        class="form-check-input crud-related-create-field"
                        data-related-field="{$name}"
                        <?= \$relatedCreateActive ? '' : 'disabled' ?>
                        <?= !empty(\$relatedPayloadState['{$name}']['{$relatedName}']) ? 'checked' : '' ?>
                    >
                </div>
PHP;
            } else {
                $htmlType = in_array($type, ['text', 'number', 'email', 'password', 'date', 'datetime-local', 'time', 'url', 'tel'], true)
                    ? $type
                    : 'text';
                $control = <<<PHP
                <input
                    type="{$htmlType}"
                    name="_related[{$name}][{$relatedName}]"
                    id="{$inputId}"
                    value="<?= esc({$valueExpr}) ?>"
                    class="form-control {$invalid} crud-related-create-field"
                    data-related-field="{$name}"
                    <?= \$relatedCreateActive ? '' : 'disabled' ?>
                    {$requiredAttr}{$maxLengthAttr}
                >
PHP;
            }

            $rows .= <<<PHP
            <div class="col-md-6">
                <label for="{$inputId}" class="form-label"><?= esc({$label}) ?></label>
{$control}\n                <?php if (!empty(\$errors['{$errorKey}'])): ?>
                    <div class="invalid-feedback d-block"><?= esc(\$errors['{$errorKey}']) ?></div>
                <?php endif; ?>
            </div>
PHP;
        }

        return <<<PHP
<?php
\$relatedCreateActive = !empty(\$relatedCreateActive);
\$relatedPayloadState = (array) (\$relatedPayloadState ?? []);
\$errors = (array) (\$errors ?? []);
?>
<div class="row g-3">
{$rows}</div>
PHP;
    }

    private function buildAjaxRelationControl(array $config, array $field, string $name, string $value, string $errorId): string
    {
        $table = (string) ($config['table'] ?? '');
        $relation = (array) ($field['foreignKey'] ?? []);
        $alias = (string) ($relation['alias'] ?? '');
        $rowAlias = $alias !== '' ? $this->objectProperty('row', $alias) : '';
        $labelValue = $alias !== ''
            ? "old('{$name}__label', {$rowAlias} ?? (\$contextLabels['{$name}'] ?? ''))"
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
        $relatedCreateEnabled = !empty($field['relationCreate']['enabled'])
            && !empty($relation['relatedCreate']['available']);

        if ($parentTable === '') {
            return '';
        }

        $actions = '';
        if (!empty($navigation['parentLink'])) {
            $actions .= <<<PHP
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
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>
PHP;
        }

        if (!empty($navigation['createParentLink'])) {
            $actions .= <<<PHP
                        <a
                            href="<?= site_url('{$parentTable}/create') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="Nuovo record padre"
                            aria-label="Nuovo record padre"
                        >
                            <i class="bi bi-plus-lg" aria-hidden="true"></i>
                        </a>
PHP;
        }

        if ($relatedCreateEnabled) {
            $panelId = 'related_create_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $name);
            $title = htmlspecialchars(Naming::human($parentTable), ENT_QUOTES);
            $actions .= <<<PHP
                    <?php if (\$row === null): ?>
                        <button
                            type="button"
                            class="btn btn-outline-secondary crud-related-create-toggle"
                            id="{$panelId}_toggle"
                            data-bs-toggle="offcanvas"
                            data-bs-target="#{$panelId}"
                            aria-controls="{$panelId}"
                            data-related-field="{$name}"
                            data-panel-target="{$panelId}"
                            data-state-target="{$panelId}_state"
                            title="Crea nuovo {$title}"
                            aria-label="Crea nuovo {$title}"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            Nuovo
                        </button>
                    <?php endif; ?>
PHP;
        }

        return $actions;
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
