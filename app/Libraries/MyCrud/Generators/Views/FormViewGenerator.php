<?php
namespace App\Libraries\MyCrud\Generators\Views;

use App\Libraries\MyCrud\Core\FieldPolicy;
use App\Libraries\MyCrud\Core\Naming;

final class FormViewGenerator extends AbstractViewGenerator
{
    /** @return array{form:string,fields:string,create:string,edit:string,manyToManyPartials:array<string,string>} */
    public function generate(array $config): array
    {
        $table = (string) $config['table'];
        $fields = $this->buildFields($config);

        return [
            'fields' => $fields,
            'form' => $this->templates->render('views/form.tpl', [
                'table'  => $table,
                'fields' => "<?= view('{$table}/_fields', get_defined_vars()) ?>",
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
            'manyToManyPartials' => $this->buildManyToManyFormPartials($config),
        ];
    }

    private function buildFields(array $config): string
    {
        $table = (string) ($config['table'] ?? '');
        $output = "<?php\n"
            . "// Standalone + embedded field-view contract.\n"
            . "// Normal CRUD: namespace defaults to the owner table (e.g. staff[first_name]).\n"
            . "// Embedded related create: caller supplies relation/resource namespaces.\n"
            . "\$embeddedRelatedCreate = !empty(\$embeddedRelatedCreate);\n"
            . "\$formNamespace = (string) (\$formNamespace ?? " . var_export($table, true) . ");\n"
            . "\$idNamespace = (string) (\$idNamespace ?? \$formNamespace);\n"
            . "?>\n";
        $fieldGroups = [];
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
            $width = max(1, min(12, (int) ($field['width'] ?? config('MyCrud')->defaultBootstrapFieldWidth ?? 6)));
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
            $initialCreateValue = $this->initialCreateValueExpression($field, $type);
            $safeFieldName = preg_replace('/[^a-zA-Z0-9_-]/', '_', $name) ?: $name;
            $oldKey = "\$formNamespace . " . var_export('.' . $name, true);
            $htmlName = "<?= esc(\$formNamespace) ?>[{$name}]";
            $idName = "<?= esc(\$embeddedRelatedCreate ? \$idNamespace . '_{$safeFieldName}' : '{$safeFieldName}') ?>";
            $value = match ($type) {
                'password', 'file', 'image' => "old({$oldKey}, '')",
                'datetime-local' => "old({$oldKey}, isset({$rowValue}) ? str_replace(' ', 'T', substr((string) {$rowValue}, 0, 16)) : (\$context['{$name}'] ?? {$initialCreateValue}))",
                default => "old({$oldKey}, {$rowValue} ?? (\$context['{$name}'] ?? {$initialCreateValue}))",
            };
            $errorId = "<?= esc(\$embeddedRelatedCreate ? \$idNamespace . '_{$safeFieldName}_error' : '{$safeFieldName}-error') ?>";
            $relationMode = strtolower((string) ($field['relationMode'] ?? ''));
            if (!empty($field['foreignKey']) && $relationMode === 'ajax') {
                $control = $this->buildAjaxRelationControl($config, $field, $name, $htmlName, $idName, $value, $errorId);
            } else {
                $control = $this->buildControl($type, $htmlName, $idName, $name, $value, $attributes, $errorId);
            }

            $relatedCreatePanel = '';
            if (!empty($field['foreignKey'])) {
                $relationActions = $this->buildRelationNavigation($field, $name, $idName, $value);
                if ($relationActions !== '') {
                    if ($relationMode === 'ajax') {
                        // La select AJAX mantiene la propria struttura (hidden + search + risultati):
                        // actions remain immediately below to avoid breaking the search widget.
                        $control .= '<div class="d-flex gap-1 mt-2 relation-navigation-actions">' . $relationActions . '</div>';
                    } else {
                        // FK standard: select/input e azioni correlate formano un unico input-group.
                        $control = '<div class="input-group crud-relation-input-group">' . "\n" . $control . "\n" . $relationActions . "\n" . '</div>';
                    }
                }
                if (!empty($field['relationCreate']['enabled'])) {
                    $field['_ownerTable'] = (string) ($config['table'] ?? '');
                    $panelMarkup = $this->buildRelatedCreatePanel($field, $name);
                    if ($panelMarkup !== '') {
                        $relatedCreatePanel = "<?php if (empty(\$embeddedRelatedCreate)): ?>\n" . $panelMarkup . "\n<?php endif; ?>";
                    }
                }
            }
            $wrapper = $type === 'hidden' ? 'd-none' : "col-md-{$width}";

            $labelHtml = $type === 'hidden'
                ? ''
                : <<<PHP
                    <label for="{$idName}" class="form-label">
                        <?= esc({$label}) ?>
                    </label>

PHP;

            $fieldMarkup = <<<PHP
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
            $sectionId = trim((string) ($field['section'] ?? ''));
            $fieldGroups[$sectionId][] = $fieldMarkup;
        }

        $sections = array_values((array) ($config['formSections'] ?? []));
        if ($sections === []) {
            // Full backward compatibility with previous configurations: without
            // sections all normalized fields belong to General, but
            // the container is not shown and the legacy markup is preserved.
            //
            // IMPORTANT: append to $output instead of replacing it, because
            // $output already contains the standalone/embedded namespace contract.
            $output .= implode('', $fieldGroups[''] ?? []);
        } else {
            $output .= $this->buildFormSection(
                '',
                'General',
                '',
                false,
                $fieldGroups[''] ?? [],
                12
            );

            foreach ($sections as $section) {
                $section = (array) $section;
                $sectionId = (string) ($section['id'] ?? '');
                if ($sectionId === '') {
                    continue;
                }

                $output .= $this->buildFormSection(
                    $sectionId,
                    (string) ($section['title'] ?? 'Section'),
                    (string) ($section['description'] ?? ''),
                    !empty($section['collapsed']),
                    $fieldGroups[$sectionId] ?? [],
                    max(1, min(12, (int) ($section['width'] ?? 12)))
                );
            }
        }

        $relationMarkup = $this->buildManyToManyPartialIncludes($config);
        if ($relationMarkup !== '') {
            $output .= "<?php if (empty(\$embeddedRelatedCreate)): ?>\n"
                . "                <!-- mycrud:start relation-panels -->\n"
                . $relationMarkup
                . "                <!-- mycrud:end relation-panels -->\n"
                . "<?php endif; ?>\n";
        }

        return $output;
    }

    /**
     * A section is only a layout container. It does not change field names,
     * validazione, Model, Service o payload.
     *
     * @param list<string> $fields
     */
    private function buildFormSection(
        string $id,
        string $title,
        string $description,
        bool $collapsed,
        array $fields,
        int $width = 12
    ): string {
        if ($fields === []) {
            return '';
        }

        $safeId = preg_replace('/[^a-zA-Z0-9_-]/', '_', $id !== '' ? $id : 'general') ?: 'general';
        $width = max(1, min(12, $width));
        $title = htmlspecialchars($title, ENT_QUOTES);
        $description = htmlspecialchars($description, ENT_QUOTES);
        $open = $collapsed ? '' : ' open';
        $descriptionMarkup = $description !== ''
            ? '<div class="small text-muted mt-1 mb-2">' . $description . '</div>'
            : '';

        $fieldsMarkup = $this->joinFieldMarkup($fields);

        return <<<PHP
                <div class="col-{$width} crud-form-section-col">
                    <details class="w-100 h-100 border rounded p-3 crud-form-section" id="form_section_{$safeId}"{$open}>
                        <summary class="fw-semibold">{$title}</summary>
                        {$descriptionMarkup}
                        <div class="row g-3 mt-1">
{$fieldsMarkup}                        </div>
                    </details>
                </div>

PHP;
    }

    /** @param list<string> $fields */
    private function joinFieldMarkup(array $fields): string
    {
        return implode('', $fields);
    }

    private function configuredRelationWidth(string $key, int $fallback): int
    {
        $widths = (array) (config('MyCrud')->relationPanelWidths ?? []);
        return max(1, min(12, (int) ($widths[$key] ?? $fallback)));
    }
    private function relationOffcanvasWidth(): int
    {
        return max(320, (int) (config('MyCrud')->relationOffcanvasWidth ?? 640));
    }

    /** @return array<string,string> */
    private function buildManyToManyFormPartials(array $config): array
    {
        $partials = [];
        $offcanvasWidth = $this->relationOffcanvasWidth();
        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $key => $relation) {
            if (empty($relation['enabled']) || (empty($relation['createEnabled']) && empty($relation['editEnabled']))) {
                continue;
            }
            $safeKey = preg_replace('/[^a-zA-Z0-9_]/', '_', (string) $key);
            $relationWidth = max(1, min(12, (int) ($relation['formWidth'] ?? $this->configuredRelationWidth('manyToMany', 12))));
            $panelClass = 'col-12 col-md-' . $relationWidth;
            $title = htmlspecialchars((string) ($relation['title'] ?? Naming::human((string) ($relation['relatedTable'] ?? 'Relation'))), ENT_QUOTES);
            $createEnabled = !empty($relation['createEnabled']) ? 'true' : 'false';
            $editEnabled = !empty($relation['editEnabled']) ? 'true' : 'false';
            $createRelatedEnabled = !empty($relation['createRelatedEnabled'])
                && !empty($relation['createRelatedAvailable']);
            $createRelatedMarkup = $createRelatedEnabled
                ? $this->buildManyToManyRelatedCreateFields(
                    (string) $key,
                    (string) ($relation['relatedTable'] ?? ''),
                    (array) ($relation['relatedCreate'] ?? []),
                    $title
                )
                : '';
            $createRelatedInlineButton = '';
            if ($createRelatedEnabled) {
                $panelId = 'many_related_create_' . ($safeKey ?: 'relation');
                $createRelatedInlineButton = <<<PHP
                                <button
                                    type="button"
                                    class="btn btn-outline-primary btn-sm crud-many-related-create-toggle"
                                    id="{$panelId}_toggle"
                                    data-bs-toggle="offcanvas"
                                    data-bs-target="#{$panelId}"
                                    aria-controls="{$panelId}"
                                    title="Create new {$title}"
                                    aria-label="Create new {$title}"
                                >
                                    <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>New {$title}
                                </button>
PHP;
            }
            $partialName = '_many_form_' . ($safeKey ?: 'relation') . '.php';
            $partials[$partialName] = <<<PHP
                <?php
                \$m2mCreateEnabled = {$createEnabled};
                \$m2mEditEnabled = {$editEnabled};
                \$m2mVisible = (\$row === null && \$m2mCreateEnabled) || (\$row !== null && \$m2mEditEnabled);
                ?>
                <?php if (\$m2mVisible): ?>
                <div class="{$panelClass}">
                    <!-- mycrud:start many-to-many relation -->
                    <div class="card border-primary-subtle h-100">
                        <div class="card-header"><i class="bi bi-diagram-2 me-1"></i><strong>{$title}</strong> <small class="text-muted">N:N</small></div>
                        <div class="card-body">
                            <?php
                            \$manyOld = old('_many', \$manyToManySelected ?? []);
                            \$selected = array_map('strval', (array) (\$manyOld['{$key}'] ?? []));
                            \$manyOptions = (array) ((\$manyToManyOptions ?? [])['{$key}'] ?? []);
                            ?>
                            <input type="hidden" name="_many_present[{$key}]" value="1">
                            <div id="many_component_{$safeKey}" class="crud-many-selector">
                                <div class="d-flex align-items-center justify-content-between gap-2 mb-2">
                                    <label class="form-label mb-0">Select {$title}</label>
                                    <span class="badge text-bg-secondary" data-many-count>0 selected</span>
                                </div>

                                <div class="d-flex flex-wrap gap-1 mb-2" data-many-selected></div>

                                <div class="input-group input-group-sm mb-2 crud-many-primary-actions">
                                    <button
                                        class="btn btn-outline-secondary text-start flex-grow-1"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#many_picker_{$safeKey}"
                                        aria-expanded="false"
                                        aria-controls="many_picker_{$safeKey}"
                                    >
                                        <i class="bi bi-search me-1"></i>Search and select {$title}
                                    </button>
{$createRelatedInlineButton}                                </div>

                                <div class="collapse mt-2" id="many_picker_{$safeKey}">
                                    <div class="border rounded p-2 bg-body-tertiary">
                                        <div class="input-group input-group-sm mb-2">
                                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                                            <input
                                                type="search"
                                                class="form-control"
                                                placeholder="Search {$title}..."
                                                autocomplete="off"
                                                data-many-search
                                            >
                                        </div>
                                        <div class="list-group overflow-auto" style="max-height: 260px;" data-many-options>
                                            <?php foreach (\$manyOptions as \$option): ?>
                                                <?php
                                                \$optionId = (string) (\$option['id'] ?? '');
                                                \$optionText = (string) (\$option['text'] ?? \$optionId);
                                                ?>
                                                <label class="list-group-item list-group-item-action py-2" data-many-option data-search="<?= esc(strtolower(\$optionText)) ?>">
                                                    <input
                                                        class="form-check-input me-2"
                                                        type="checkbox"
                                                        name="_many[{$key}][]"
                                                        value="<?= esc(\$optionId) ?>"
                                                        data-many-checkbox
                                                        data-many-label="<?= esc(\$optionText) ?>"
                                                        <?= in_array(\$optionId, \$selected, true) ? 'checked' : '' ?>
                                                    >
                                                    <span><?= esc(\$optionText) ?></span>
                                                </label>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>

{$createRelatedMarkup}
                                <div class="form-text"><i class="bi bi-shield-check me-1"></i>Selected associations are revalidated server-side before pivot synchronization.</div>
                            </div>
                            <script>
                            (() => {
                                const root = document.getElementById('many_component_{$safeKey}');
                                if (!root || root.dataset.initialized === '1') return;
                                root.dataset.initialized = '1';

                                const search = root.querySelector('[data-many-search]');
                                const selectedBox = root.querySelector('[data-many-selected]');
                                const count = root.querySelector('[data-many-count]');
                                const checkboxes = Array.from(root.querySelectorAll('[data-many-checkbox]'));
                                const optionRows = Array.from(root.querySelectorAll('[data-many-option]'));

                                const renderSelected = () => {
                                    const selected = checkboxes.filter((checkbox) => checkbox.checked);
                                    count.textContent = selected.length + ' selected';
                                    selectedBox.innerHTML = '';

                                    if (selected.length === 0) {
                                        const empty = document.createElement('span');
                                        empty.className = 'small text-muted';
                                        empty.textContent = 'No selection';
                                        selectedBox.appendChild(empty);
                                        return;
                                    }

                                    selected.forEach((checkbox) => {
                                        const badge = document.createElement('button');
                                        badge.type = 'button';
                                        badge.className = 'btn btn-primary btn-sm rounded-pill py-0 px-2';
                                        badge.setAttribute('aria-label', 'Remove ' + (checkbox.dataset.manyLabel || checkbox.value));
                                        badge.innerHTML = '<span class="me-1"></span><i class="bi bi-x-lg"></i>';
                                        badge.querySelector('span').textContent = checkbox.dataset.manyLabel || checkbox.value;
                                        badge.addEventListener('click', () => {
                                            checkbox.checked = false;
                                            checkbox.dispatchEvent(new Event('change', { bubbles: true }));
                                        });
                                        selectedBox.appendChild(badge);
                                    });
                                };

                                checkboxes.forEach((checkbox) => checkbox.addEventListener('change', renderSelected));

                                if (search) {
                                    search.addEventListener('input', () => {
                                        const needle = search.value.trim().toLocaleLowerCase();
                                        optionRows.forEach((row) => {
                                            row.hidden = needle !== '' && !String(row.dataset.search || '').includes(needle);
                                        });
                                    });
                                }

                                renderSelected();
                            })();
                            </script>
                        </div>
                    </div>
                    <!-- mycrud:end many-to-many relation -->
                </div>
                <?php endif; ?>

PHP;
        }
        return $partials;
    }

    /**
     * The owner _fields.php remains small: each M:N form relation lives in its
     * own partial, while target field markup is still owned by target/_fields.php.
     */
    private function buildManyToManyPartialIncludes(array $config): string
    {
        $table = (string) ($config['table'] ?? '');
        $output = '';

        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $key => $relation) {
            if (empty($relation['enabled']) || (empty($relation['createEnabled']) && empty($relation['editEnabled']))) {
                continue;
            }

            $safeKey = preg_replace('/[^a-zA-Z0-9_]/', '_', (string) $key) ?: 'relation';
            $viewPath = $table . '/_many_form_' . $safeKey;
            $output .= "<!-- mycrud:many-to-many form {$safeKey} -->\n"
                . "<?= view(" . var_export($viewPath, true) . ", get_defined_vars()) ?>\n";
        }

        return $output;
    }


    private function buildManyToManyRelatedCreateFields(
        string $key,
        string $relatedTable,
        array $definition,
        string $title
    ): string
    {
        $offcanvasWidth = $this->relationOffcanvasWidth();
        $fields = (array) ($definition['fields'] ?? []);
        $relatedTable = trim($relatedTable);
        if ($fields === [] || $relatedTable === '') {
            return '';
        }

        $safeKey = preg_replace('/[^a-zA-Z0-9_]/', '_', $key) ?: 'relation';
        $panelId = 'many_related_create_' . $safeKey;
        $errorPrefix = $key . '__many_related__';

        return <<<PHP
                                <?php
                                \$manyCreateRelatedState = (array) old('_many_new', []);
                                \$manyCreateRelatedActive = !empty(\$manyCreateRelatedState['{$key}']);

                                \$manyRelatedErrors = [];
                                foreach ((array) (\$errors ?? []) as \$errorField => \$message) {
                                    \$errorField = (string) \$errorField;
                                    if (!str_starts_with(\$errorField, '{$errorPrefix}')) {
                                        continue;
                                    }
                                    \$manyRelatedErrors[substr(\$errorField, strlen('{$errorPrefix}'))] = (string) \$message;
                                }

                                \$manyRelatedOptions = [];
                                foreach ((array) ((\$manyToManyRelatedCreateOptions ?? [])['{$key}'] ?? []) as \$optionField => \$optionRows) {
                                    foreach ((array) \$optionRows as \$optionRow) {
                                        if (!is_array(\$optionRow)) {
                                            continue;
                                        }
                                        \$optionId = (string) (\$optionRow['id'] ?? '');
                                        if (\$optionId === '') {
                                            continue;
                                        }
                                        \$manyRelatedOptions[(string) \$optionField][\$optionId]
                                            = (string) (\$optionRow['text'] ?? \$optionId);
                                    }
                                }
                                ?>
                                <div class="mt-2 d-flex flex-wrap align-items-center gap-2">
                                    <input
                                        type="hidden"
                                        name="_many_new[{$key}]"
                                        id="{$panelId}_state"
                                        value="<?= \$manyCreateRelatedActive ? '1' : '0' ?>"
                                    >
                                    <span
                                        class="badge text-bg-success<?= \$manyCreateRelatedActive ? '' : ' d-none' ?>"
                                        id="{$panelId}_ready"
                                    >
                                        <i class="bi bi-check-circle me-1" aria-hidden="true"></i>
                                        New {$title} ready
                                    </span>
                                    <button
                                        type="button"
                                        class="btn btn-link btn-sm text-danger p-0<?= \$manyCreateRelatedActive ? '' : ' d-none' ?> crud-many-related-create-remove"
                                        id="{$panelId}_remove"
                                    >
                                        Remove
                                    </button>
                                </div>

                                <div
                                    id="{$panelId}"
                                    class="offcanvas offcanvas-end crud-many-related-create-panel"
                                    style="--bs-offcanvas-width: min({$offcanvasWidth}px, 100vw);"
                                    tabindex="-1"
                                    aria-labelledby="{$panelId}_label"
                                    data-state-target="{$panelId}_state"
                                    data-toggle-target="{$panelId}_toggle"
                                    data-ready-target="{$panelId}_ready"
                                    data-remove-target="{$panelId}_remove"
                                    data-bs-backdrop="static"
                                >
                                    <div class="offcanvas-header border-bottom">
                                        <div>
                                            <h2 class="offcanvas-title h5 mb-0" id="{$panelId}_label">New {$title}</h2>
                                            <small class="text-muted">Create and add to this many-to-many relation</small>
                                        </div>
                                        <button
                                            type="button"
                                            class="btn-close crud-many-related-create-cancel"
                                            data-bs-dismiss="offcanvas"
                                            aria-label="Cancel new {$title}"
                                        ></button>
                                    </div>

                                    <div class="offcanvas-body">
                                        <div class="alert alert-light border small" role="note">
                                            Enter the new {$title} data. It will be created with the main record and automatically added to this selection when the main form is submitted.
                                        </div>

                                        <fieldset
                                            class="border-0 p-0 m-0"
                                            data-many-related-field
                                            <?= \$manyCreateRelatedActive ? '' : 'disabled' ?>
                                        >
                                            <!-- Reuse target CRUD fields; relation UI remains in this M:N partial. -->
                                            <div class="row g-3" data-many-related-fields>
                                                <?= view('{$relatedTable}/_fields', [
                                                    'row' => null,
                                                    'formNamespace' => '{$relatedTable}',
                                                    'idNamespace' => '{$relatedTable}',
                                                    'errors' => \$manyRelatedErrors,
                                                    'options' => \$manyRelatedOptions,
                                                    'context' => [],
                                                    'contextLabels' => [],
                                                    'navigationContext' => [],
                                                    'parentContext' => [],
                                                    'cascadeTrail' => [],
                                                    'relatedCreateOptions' => [],
                                                    'manyToManyOptions' => [],
                                                    'manyToManyRelatedCreateOptions' => [],
                                                    'manyToManySelected' => [],
                                                    'embeddedRelatedCreate' => true,
                                                ]) ?>
                                            </div>
                                        </fieldset>

                                        <script>
                                        (() => {
                                            const panel = document.getElementById('{$panelId}');
                                            if (!panel) return;
                                            panel.querySelectorAll(
                                                '[data-many-related-fields] input, ' +
                                                '[data-many-related-fields] select, ' +
                                                '[data-many-related-fields] textarea'
                                            ).forEach((input) => input.setAttribute('data-many-related-field', ''));
                                        })();
                                        </script>
                                    </div>

                                    <div class="offcanvas-footer border-top p-3 d-flex justify-content-between gap-2">
                                        <button
                                            type="button"
                                            class="btn btn-outline-secondary crud-many-related-create-cancel"
                                            data-bs-dismiss="offcanvas"
                                        >
                                            <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                            Cancel
                                        </button>
                                        <button
                                            type="button"
                                            class="btn btn-primary crud-many-related-create-apply"
                                            data-bs-dismiss="offcanvas"
                                        >
                                            <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                            Apply new {$title}
                                        </button>
                                    </div>
                                </div>

PHP;
    }

    /**
     * Relational Create shell.
     *
     * The parent CRUD owns its field markup, labels and input configuration.
     * This owner form only prepares relation-specific runtime data and renders
     * parent/_fields.php directly inside the offcanvas; no intermediate
     * _related_create_<fk>.php wrapper is generated.
     */
    private function buildRelatedCreatePanel(array $field, string $name): string
    {
        $definition = (array) ($field['foreignKey']['relatedCreate'] ?? []);
        if (empty($definition['available']) || (array) ($definition['fields'] ?? []) === []) {
            return '';
        }

        $parentTable = trim((string) ($definition['table'] ?? $field['foreignKey']['parentTable'] ?? ''));
        if ($parentTable === '') {
            return '';
        }

        $panelId = 'related_create_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $name);
        $title = htmlspecialchars(Naming::human($parentTable), ENT_QUOTES);
        $offcanvasWidth = $this->relationOffcanvasWidth();
        $errorPrefix = $name . '__related__';

        return <<<PHP
                <!-- mycrud:start related-create {$name} -> {$parentTable} -->
                <?php if (\$row === null): ?>
                    <?php
                    // Relation state belongs to the owner form.
                    \$relatedNewState = (array) old('_related_new', []);
                    \$relatedCreateActive = !empty(\$relatedNewState['{$name}']);

                    // Adapt validation errors back to the field names expected by
                    // {$parentTable}/_fields.php (for example "name" instead of
                    // "{$errorPrefix}name").
                    \$relatedFieldErrors = [];
                    foreach ((array) (\$errors ?? []) as \$errorField => \$message) {
                        \$errorField = (string) \$errorField;
                        if (!str_starts_with(\$errorField, '{$errorPrefix}')) {
                            continue;
                        }
                        \$relatedFieldErrors[substr(\$errorField, strlen('{$errorPrefix}'))] = (string) \$message;
                    }

                    // Convert relation option rows to the id => label maps consumed
                    // by the reusable target _fields.php select controls.
                    \$relatedFieldOptions = [];
                    foreach ((array) ((\$relatedCreateOptions ?? [])['{$name}'] ?? []) as \$optionField => \$optionRows) {
                        foreach ((array) \$optionRows as \$optionRow) {
                            if (!is_array(\$optionRow)) {
                                continue;
                            }
                            \$optionId = (string) (\$optionRow['id'] ?? '');
                            if (\$optionId === '') {
                                continue;
                            }
                            \$relatedFieldOptions[(string) \$optionField][\$optionId]
                                = (string) (\$optionRow['text'] ?? \$optionId);
                        }
                    }
                    ?>
                    <div class="col-12">
                        <!-- Hidden state: tells the Controller to create this parent inline. -->
                        <input
                            type="hidden"
                            name="_related_new[{$name}]"
                            id="{$panelId}_state"
                            value="<?= \$relatedCreateActive ? '1' : '0' ?>"
                        >

                        <!-- Bootstrap offcanvas containing the target CRUD fields. -->
                        <div
                            id="{$panelId}"
                            class="offcanvas offcanvas-end crud-related-create-panel"
                            style="--bs-offcanvas-width: min({$offcanvasWidth}px, 100vw);"
                            tabindex="-1"
                            aria-labelledby="{$panelId}_label"
                            data-related-field="{$name}"
                            data-state-target="{$panelId}_state"
                            data-toggle-target="{$panelId}_toggle"
                            data-bs-backdrop="static"
                        >
                            <div class="offcanvas-header border-bottom">
                                <div>
                                    <h2 class="offcanvas-title h5 mb-0" id="{$panelId}_label">New {$title}</h2>
                                    <small class="text-muted">Relation {$name}</small>
                                </div>
                                <button
                                    type="button"
                                    class="btn-close crud-related-create-cancel"
                                    data-related-field="{$name}"
                                    data-state-target="{$panelId}_state"
                                    data-bs-dismiss="offcanvas"
                                    aria-label="Cancel new {$title}"
                                ></button>
                            </div>

                            <div class="offcanvas-body">
                                <div class="alert alert-light border small" role="note">
                                    Enter the new {$title} data. The related record and this record will be saved together when the main form is submitted, within the same transaction.
                                </div>

                                <!-- Reuse the target CRUD field view: no field markup is duplicated here. -->
                                <fieldset
                                    class="crud-related-create-fieldset border-0 p-0 m-0"
                                    data-related-field="{$name}"
                                    <?= \$relatedCreateActive ? '' : 'disabled' ?>
                                >
                                    <?= view('{$parentTable}/_fields', [
                                        'row' => null,
                                        'formNamespace' => '{$name}',
                                        'idNamespace' => '{$name}',
                                        'errors' => \$relatedFieldErrors,
                                        'options' => \$relatedFieldOptions,
                                        'context' => [],
                                        'contextLabels' => [],
                                        'navigationContext' => [],
                                        'parentContext' => [],
                                        'cascadeTrail' => [],
                                        'relatedCreateOptions' => [],
                                        'manyToManyOptions' => [],
                                        'manyToManyRelatedCreateOptions' => [],
                                        'manyToManySelected' => [],
                                        'embeddedRelatedCreate' => true,
                                    ]) ?>
                                </fieldset>
                            </div>

                            <div class="offcanvas-footer border-top p-3 d-flex justify-content-between gap-2">
                                <button
                                    type="button"
                                    class="btn btn-outline-secondary crud-related-create-cancel"
                                    data-related-field="{$name}"
                                    data-state-target="{$panelId}_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-x-circle me-1" aria-hidden="true"></i>
                                    Cancel
                                </button>
                                <button
                                    type="button"
                                    class="btn btn-primary crud-related-create-apply"
                                    data-related-field="{$name}"
                                    data-state-target="{$panelId}_state"
                                    data-bs-dismiss="offcanvas"
                                >
                                    <i class="bi bi-check2-circle me-1" aria-hidden="true"></i>
                                    Apply new {$title}
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endif; ?>
                <!-- mycrud:end related-create {$name} -->
PHP;
    }

    private function buildAjaxRelationControl(array $config, array $field, string $name, string $htmlName, string $idName, string $value, string $errorId): string
    {
        $table = (string) ($config['table'] ?? '');
        $relation = (array) ($field['foreignKey'] ?? []);
        $alias = (string) ($relation['alias'] ?? '');
        $rowAlias = $alias !== '' ? $this->objectProperty('row', $alias) : '';
        $oldLabelKey = $table . '.' . $name . '__label';
        $labelValue = $alias !== ''
            ? "old('{$oldLabelKey}', {$rowAlias} ?? (\$contextLabels['{$name}'] ?? ''))"
            : "old('{$oldLabelKey}', \$contextLabels['{$name}'] ?? '')";
        $invalid = "<?= isset(\$errors['{$name}']) ? 'is-invalid' : '' ?>";
        $minChars = max(0, min(10, (int) (config('MyCrud')->relationAjaxMinimumChars ?? 2)));

        return <<<PHP
                    <input
                        type="hidden"
                        name="{$htmlName}"
                        id="{$idName}"
                        value="<?= esc({$value}) ?>"
                        class="crud-relation-value"
                    >
                    <input
                        type="search"
                        name="{$table}[{$name}__label]"
                        id="{$idName}_search"
                        value="<?= esc({$labelValue}) ?>"
                        class="form-control {$invalid} crud-relation-search"
                        data-url="<?= site_url('{$table}/relation-options/{$name}') ?>"
                        data-value-target="{$idName}"
                        data-results-target="{$idName}_results"
                        data-min-chars="{$minChars}"
                        autocomplete="off"
                        aria-describedby="{$errorId}"
                    >
                    <select
                        id="{$idName}_results"
                        class="form-select mt-2 d-none crud-relation-results"
                        size="5"
                        aria-label="Search results"
                    ></select>
PHP;
    }

    private function buildRelationNavigation(array $field, string $name, string $idName, string $value): string
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
                            data-value-source="{$idName}"
                            data-base-url="<?= site_url('{$parentTable}/view') ?>"
                            data-trail="<?= esc(\App\Libraries\Crud\CrudNavigationTrail::encode((array) (\$cascadeTrail ?? []))) ?>"
                            title="Open parent record"
                            aria-label="Open parent record"
                        >
                            <i class="bi bi-box-arrow-up-right" aria-hidden="true"></i>
                        </a>
PHP;
        }

        if (!empty($navigation['createParentLink'])) {
            $actions .= <<<PHP
                        <a
                            href="<?= site_url('{$parentTable}/create') . ((\$encodedTrail ?? '') !== '' ? '?_trail=' . rawurlencode((string) \$encodedTrail) : '') ?>"
                            target="_blank"
                            rel="noopener"
                            class="btn btn-outline-secondary"
                            title="New parent record"
                            aria-label="New parent record"
                        >
                            <i class="bi bi-plus-lg" aria-hidden="true"></i>
                        </a>
PHP;
        }

        if ($relatedCreateEnabled) {
            $panelId = 'related_create_' . preg_replace('/[^a-zA-Z0-9_]/', '_', $name);
            $title = htmlspecialchars(Naming::human($parentTable), ENT_QUOTES);
            $actions .= <<<PHP
                    <?php if (\$row === null && empty(\$embeddedRelatedCreate)): ?>
                        <!-- Nested Related Create is intentionally terminal:
                             embedded _fields.php keeps the FK control/navigation,
                             but does not open another Related Create offcanvas. -->
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
                            title="Create new {$title}"
                            aria-label="Create new {$title}"
                        >
                            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i>
                            New
                        </button>
                    <?php endif; ?>
PHP;
        }

        return $actions;
    }

    /** Initial value applied only to Create; old(), context, and Edit always take precedence. */
    private function initialCreateValueExpression(array $field, string $inputType): string
    {
        if (!empty($field['databaseManaged'])) {
            return "''";
        }

        $initial = (array) ($field['initialValue'] ?? []);
        $mode = (string) ($initial['mode'] ?? 'none');
        $custom = (string) ($initial['custom'] ?? '');
        $inputType = strtolower($inputType);

        return match ($mode) {
            'today' => "date('Y-m-d')",
            'now' => $inputType === 'datetime-local' ? "date('Y-m-d\\TH:i')" : "date('Y-m-d H:i:s')",
            'time' => "date('H:i')",
            'custom' => var_export($inputType === 'datetime-local' ? str_replace(' ', 'T', substr($custom, 0, 16)) : $custom, true),
            default => "''",
        };
    }

    private function buildControl(string $type, string $htmlName, string $idName, string $fieldName, string $value, string $attributes, string $errorId): string
    {
        $invalid = "<?= isset(\$errors['{$fieldName}']) ? 'is-invalid' : '' ?>";
        $attributeLine = "\n                        aria-describedby=\"{$errorId}\"\n                        aria-invalid=\"<?= isset(\$errors['{$fieldName}']) ? 'true' : 'false' ?>\"";
        if ($attributes !== '') {
            $attributeLine .= "\n                        {$attributes}";
        }

        return match ($type) {
            'textarea' => <<<PHP
                    <textarea
                        name="{$htmlName}"
                        id="{$idName}"
                        class="form-control {$invalid}"{$attributeLine}
                    ><?= esc({$value}) ?></textarea>
PHP,
            'select' => <<<PHP
                    <select
                        name="{$htmlName}"
                        id="{$idName}"
                        class="form-select {$invalid}"{$attributeLine}
                    >
                        <option value="">Seleziona...</option>
                        <?php foreach ((\$options['{$fieldName}'] ?? []) as \$optionValue => \$optionLabel): ?>
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
                    <input type="hidden" name="{$htmlName}" value="0">

                    <div class="form-check mt-2">
                        <input
                            type="checkbox"
                            name="{$htmlName}"
                            id="{$idName}"
                            value="1"
                            class="form-check-input {$invalid}"
                            <?= {$value} ? 'checked' : '' ?>{$attributeLine}
                        >
                    </div>
PHP,
            'file' => <<<PHP
                    <input type="file" name="{$htmlName}" id="{$idName}" class="form-control {$invalid}"{$attributeLine}>
PHP,
            'image' => <<<PHP
                    <input type="file" name="{$htmlName}" id="{$idName}" accept="image/*" class="form-control {$invalid}"{$attributeLine}>
PHP,
            'hidden' => <<<PHP
                    <input type="hidden" name="{$htmlName}" id="{$idName}" value="<?= esc({$value}) ?>">
PHP,
            default => <<<PHP
                    <input
                        type="{$type}"
                        name="{$htmlName}"
                        id="{$idName}"
                        value="<?= esc({$value}) ?>"
                        class="form-control {$invalid}"{$attributeLine}
                    >
PHP,
        };
    }
}
