<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators\Views;

use App\Libraries\MyCrud\Core\FieldPolicy;

/**
 * Genera l'elenco del sito: tabella, ordinamento e filtro dinamico.
 *
 * Lato generatore vengono prodotte solo whitelist/configurazioni; la query
 * effettiva resta nel Model generato.
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
        $visibleCount = 0;

        foreach ($this->orderedFields($config) as $name) {
            $field = $config['fields'][$name];
            $ui = (array) ($field['ui'] ?? []);
            $type = strtolower((string) ($field['type'] ?? ''));
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
            $sensitive = !empty($ui['sensitive']) || FieldPolicy::isSensitive($name, $inputType);
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary'])
                || !empty($index['unique'])
                || !empty($index['leading']);

            if (
                !$sensitive
                && !empty($ui['visibleIndex'])
                && !in_array($type, ['text', 'mediumtext', 'longtext', 'blob', 'mediumblob', 'longblob'], true)
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
                if (is_array($relation)) {
                    $alias = (string) ($relation['alias'] ?? ((string) $relation['parentTable'] . '_' . (string) $relation['displayField']));
                    $cells .= "                                <td><?= esc(\$row->{$alias} ?? \$row->{$name} ?? '') ?></td>\n";
                } else {
                    $cells .= "                                <td><?= esc(\$row->{$name} ?? '') ?></td>\n";
                }
                $visibleCount++;
            }

            if (!$sensitive && !empty($ui['searchable']) && $indexEligible) {
                $filterDefinitions[$name] = $this->filterDefinition($config, $field, $name);
            }
        }

        $trashButton = !empty($config['features']['softDeletes'])
            ? "            <a href=\"<?= site_url('{$table}/trash') ?>\" class=\"btn btn-outline-danger\"><i class=\"bi bi-trash3\"></i> Cestino</a>\n"
            : '';
        $languageFile = (string) ($config['languageFile'] ?? 'Fields');
        $filtersSummary = "<?= esc(lang('{$languageFile}.filtersSummary')) ?>";

        return [
            'index' => $this->templates->render('views/index.tpl', [
                'table' => $table,
                'primary_key' => $primaryKey,
                'trash_button' => $trashButton,
                'filters_summary' => $filtersSummary,
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
                'colspan' => (string) ($visibleCount + 1),
            ]),
            'pager' => $this->templates->render('views/pager.tpl'),
        ];
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

    /** Genera PHP, non JSON, così le label possono continuare a usare lang(). */
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
