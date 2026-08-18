<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators\Views;

use App\Libraries\MyCrud\Core\FieldPolicy;

/**
 * Generates the site list: table, sorting, and dynamic filtering.
 *
 * On the generator side, only whitelists/configuration are produced; the query
 * effettiva resta nel Model generated.
 */
final class IndexViewGenerator extends AbstractViewGenerator
{
    /** @return array{index: string, filters: string, table: string, pager: string} */
    public function generateAll(array $config): array
    {
        $table = (string) $config['table'];
        $primaryKey = (string) $config['primaryKey'];
        $headers = '';
        $cells = '';
        $filterDefinitions = [];
        $navigationContextFields = [];
        $simpleFilterFields = [];
        $visibleCount = 0;
        $createAllowed = !empty($config['features']['createAllowed']);
        $writable = !empty($config['features']['writable']);
        $recordActions = !empty($config['features']['recordActions']);

        foreach ($this->orderedFields($config) as $name) {
            $field = $config['fields'][$name];
            $ui = (array) ($field['ui'] ?? []);
            $type = strtolower((string) ($field['type'] ?? ''));
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
            $sensitive = !empty($ui['sensitive']) || FieldPolicy::isSensitive($name, $inputType);
            if (!empty($field['foreignKey']) && preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $name) === 1) {
                $navigationContextFields[] = $name;
            }
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary'])
                || !empty($index['unique'])
                || !empty($index['leading']);

            $binary = str_contains($type, 'blob') || str_contains($type, 'binary');

            if (
                !$sensitive
                && !empty($ui['visibleIndex'])
                && !$binary
            ) {
                $label = $this->labelExpression($field, $name);
                $sortable = !empty($ui['sortable']) && $indexEligible;

                if ($sortable) {
                    $headers .= <<<PHP
                        <?php
                        \$nextDirection = (\$sort ?? '') === '{$name}' && (\$direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        \$sortQuery = array_replace((array) (\$query ?? []), [
                            'sort' => '{$name}',
                            'direction' => \$nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query(\$sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="{$name}"
                                data-direction="<?= esc(\$nextDirection) ?>"
                            >
                                <?= esc({$label}) ?>
                                <?php if ((\$sort ?? '') === '{$name}'): ?>
                                    <i class="bi bi-sort-<?= (\$direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>
PHP;
                } else {
                    $headers .= "                        <th><?= esc({$label}) ?></th>\n";
                }

                $relation = $config['relations']['belongsTo'][$name] ?? null;
                $cells .= $this->indexCell($field, $name, is_array($relation) ? $relation : null, $indexEligible, $table, $primaryKey);
                $visibleCount++;
            }

            if (!$sensitive && !empty($ui['searchable']) && $indexEligible) {
                $filterDefinitions[$name] = $this->filterDefinition($config, $field, $name);
                if (preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $name) === 1) {
                    $simpleFilterFields[] = $name;
                }
            }
        }

        $createButton = $createAllowed ? <<<PHP
            <a id="createRecordButton" data-base-url="<?= site_url('{$table}/create') ?>" href="<?= site_url('{$table}/create') . (\$navigationQuery ?? '') ?>" class="btn btn-primary" title="New record">
                <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> New
            </a>
PHP : '';
        $trashButton = !empty($config['features']['softDeletes'])
            ? "            <a href=\"<?= site_url('{$table}/trash') ?>\" class=\"btn btn-outline-danger\"><i class=\"bi bi-trash3\"></i> Cestino</a>\n"
            : '';
        $languageFile = (string) ($config['languageFile'] ?? 'Fields');
        $filtersSummary = "<?= esc(lang('{$languageFile}.filtersSummary')) ?>";

        return [
            'index' => $this->templates->render('views/index.tpl', [
                'table' => $table,
                'primary_key' => $primaryKey,
                'create_button' => $createButton,
                'trash_button' => $trashButton,
                'filters_summary' => $filtersSummary,
                'navigation_context_fields_json' => json_encode(array_values(array_unique($navigationContextFields)), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '[]',
                'simple_filter_fields_json' => json_encode(array_values(array_unique($simpleFilterFields)), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '[]',
            ]),
            'filters' => $this->templates->render('views/filters.tpl', [
                'table' => $table,
                'primary_key' => $primaryKey,
                'filter_definitions' => $this->filterDefinitionsCode($filterDefinitions),
            ]),
            'table' => $this->templates->render('views/table.tpl', [
                'table' => $table,
                'primary_key' => $primaryKey,
                'headers' => $headers,
                'cells' => $cells,
                'action_header' => $recordActions ? '                        <th class="text-end">Azioni</th>' . "\n" : '',
                'action_cell' => $recordActions ? $this->recordActionCell($table, $primaryKey, $writable) : '',
                'colspan' => (string) ($visibleCount + ($recordActions ? 1 : 0)),
            ]),
            'pager' => $this->templates->render('views/pager.tpl'),
        ];
    }

    private function indexCell(array $field, string $name, ?array $relation, bool $indexEligible, string $table = '', string $primaryKey = 'id'): string
    {
        $rowValue = $this->objectProperty('row', $name);

        if ($relation !== null) {
            $alias = (string) ($relation['alias'] ?? ($name . '__label'));
            $rowLabel = $this->objectProperty('row', $alias);
            $parentTable = (string) ($relation['parentTable'] ?? '');
            $navigation = (array) ($field['relationNavigation'] ?? []);
            $parentLink = !empty($navigation['parentLink']) && $parentTable !== '';
            $quickFilter = !empty($navigation['quickFilter']) && $indexEligible && !empty($field['ui']['searchable']);

            $labelMarkup = $parentLink
                ? "<?php if ((string) ({$rowValue} ?? '') !== ''): ?><?php \$parentTrailEncoded = \App\Libraries\Crud\CrudNavigationTrail::encode((array) (\$cascadeTrail ?? [])); \$parentHref = site_url('{$parentTable}/view/' . rawurlencode((string) {$rowValue})); if (\$parentTrailEncoded !== '') \$parentHref .= '?_trail=' . rawurlencode(\$parentTrailEncoded); ?><a href=\"<?= esc(\$parentHref) ?>\" class=\"text-decoration-none\"><?= esc({$rowLabel} ?? {$rowValue} ?? '') ?></a><?php else: ?><?= esc({$rowLabel} ?? '') ?><?php endif; ?>"
                : "<?= esc({$rowLabel} ?? {$rowValue} ?? '') ?>";

            $filterMarkup = '';
            if ($quickFilter) {
                $filterMarkup = <<<PHP
                                    <?php
                                    \$quickQuery = (array) (\$query ?? []);
                                    \$quickQuery['{$name}'] = (string) ({$rowValue} ?? '');
                                    unset(\$quickQuery['page']);
                                    ?>
                                    <?php if ((string) ({$rowValue} ?? '') !== ''): ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query(\$quickQuery) ?>"
                                            class="js-list-link ms-1 text-decoration-none"
                                            data-quick-filter="1"
                                            title="Filter by this value"
                                            aria-label="Filter by this value"
                                        ><i class="bi bi-funnel"></i></a>
                                    <?php endif; ?>
PHP;
            }

            return <<<PHP
                                <td>
                                    {$labelMarkup}
{$filterMarkup}                                </td>
PHP;
        }

        $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
        if (in_array($inputType, ['file', 'image'], true)) {
            $rowId = $this->objectProperty('row', $primaryKey);
            $displayMarkup = $this->uploadValueMarkup($table, $rowId, $name, $rowValue, $inputType, false);
            return <<<PHP
                                <td>{$displayMarkup}</td>
PHP;
        }

        $type = strtolower((string) ($field['type'] ?? ''));
        $displayMarkup = $this->tabularValueMarkup($rowValue, $type, 'index:' . $name);

        if ($indexEligible && !empty($field['ui']['searchable'])) {
            return <<<PHP
                                <td>
                                    <?php if ((string) ({$rowValue} ?? '') !== ''): ?>
                                        <?php
                                        \$quickQuery = (array) (\$query ?? []);
                                        \$quickQuery['{$name}'] = (string) {$rowValue};
                                        unset(\$quickQuery['page']);
                                        ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query(\$quickQuery) ?>"
                                            class="js-list-link text-decoration-none"
                                            data-quick-filter="1"
                                            title="Filter by this value"
                                        >{$displayMarkup}</a>
                                    <?php endif; ?>
                                </td>
PHP;
        }

        return "                                <td>{$displayMarkup}</td>\n";
    }

    private function recordActionCell(string $table, string $primaryKey, bool $writable): string
    {
        $editDelete = $writable ? <<<PHP
                                        <a href="<?= site_url('{$table}/edit/' . rawurlencode((string) \$id)) . (\$navigationQuery ?? '') ?>" class="btn btn-outline-warning" title="Edit">
                                            <i class="bi bi-pencil-square" aria-hidden="true"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('{$table}/delete/' . rawurlencode((string) \$id)) . (\$navigationQuery ?? '') ?>" class="d-inline" onsubmit="return confirm('Delete this record?')">
                                            <?= csrf_field() ?>
                                            <?php foreach ((array) (\$navigationContext ?? []) as \$contextField => \$contextValue): ?>
                                                <input type="hidden" name="_context[<?= esc((string) \$contextField) ?>]" value="<?= esc((string) \$contextValue) ?>">
                                            <?php endforeach; ?>
                                            <button type="submit" class="btn btn-outline-danger" title="Cancella">
                                                <i class="bi bi-trash" aria-hidden="true"></i>
                                            </button>
                                        </form>
PHP : '';

        return <<<PHP
                                <td class="text-end text-nowrap">
                                    <?php \$id = {$this->objectProperty('row', $primaryKey)} ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Record actions">
                                        <a href="<?= site_url('{$table}/view/' . rawurlencode((string) \$id)) . (\$navigationQuery ?? '') ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye" aria-hidden="true"></i>
                                        </a>
{$editDelete}                                    </div>
                                </td>
PHP;
    }

    /** @return array{label:string,input:string,operators:list<string>,relation:?string} */
    private function filterDefinition(array $config, array $field, string $name): array
    {
        $type = strtolower((string) ($field['type'] ?? ''));
        $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
        $columnType = strtolower((string) ($field['columnType'] ?? ''));
        $relation = $config['relations']['belongsTo'][$name] ?? null;
        $isBoolean = $inputType === 'checkbox' || $type === 'bool' || $type === 'boolean'
            || preg_match('/^tinyint\(1\)/', $columnType) === 1;
        $isNumeric = preg_match('/int|decimal|float|double|numeric|real/', $type) === 1;
        $isDate = in_array($type, ['date', 'datetime', 'timestamp', 'time'], true);

        if (is_array($relation)) {
            $relationMode = strtolower((string) ($field['relationMode'] ?? $relation['optionMode'] ?? 'select'));
            $input = $relationMode === 'ajax' ? 'relation_ajax' : 'select';
            $operators = ['eq', 'neq'];
        } elseif ($isBoolean) {
            $input = 'boolean';
            $operators = ['eq', 'neq'];
        } elseif ($isNumeric) {
            $input = 'number';
            $operators = ['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'between', 'is_null', 'not_null'];
        } elseif ($isDate) {
            $input = $type === 'date' ? 'date' : ($type === 'time' ? 'time' : 'datetime-local');
            $operators = ['eq', 'neq', 'gt', 'gte', 'lt', 'lte', 'between', 'is_null', 'not_null'];
        } else {
            $input = 'text';
            $operators = ['eq', 'neq', 'starts_with', 'contains', 'ends_with', 'is_null', 'not_null'];
        }

        return [
            'label' => $this->labelExpression($field, $name),
            'input' => $input,
            'operators' => $operators,
            'relation' => is_array($relation) ? $name : null,
        ];
    }

    /** Generates PHP rather than JSON so labels can continue to use lang(). */
    private function filterDefinitionsCode(array $definitions): string
    {
        $lines = [];
        foreach ($definitions as $field => $definition) {
            $operators = var_export($definition['operators'], true);
            $relation = var_export($definition['relation'], true);
            $input = var_export($definition['input'], true);
            $lines[] = "    '" . addslashes((string) $field) . "' => [\n"
                . "        'label' => " . $definition['label'] . ",\n"
                . "        'input' => {$input},\n"
                . "        'operators' => {$operators},\n"
                . "        'relation' => {$relation},\n"
                . "    ],";
        }

        return implode("\n", $lines);
    }
}
