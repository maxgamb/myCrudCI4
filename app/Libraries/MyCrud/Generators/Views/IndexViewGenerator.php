<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators\Views;

use App\Libraries\MyCrud\Core\FieldPolicy;

final class IndexViewGenerator extends AbstractViewGenerator
{
    /** @return array{index: string, filters: string, table: string, pager: string} */
    public function generateAll(array $config): array
    {
        $table = (string) $config['table'];
        $primaryKey = (string) $config['primaryKey'];
        $headers = '';
        $cells = '';
        $filterControls = '';
        $visibleCount = 0;

        foreach ($this->orderedFields($config) as $name) {
            $field = $config['fields'][$name];
            $ui = (array) ($field['ui'] ?? []);
            $type = strtolower((string) ($field['type'] ?? ''));
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
            $sensitive = !empty($ui['sensitive']) || FieldPolicy::isSensitive($name, $inputType);

            if (
                !$sensitive
                && !empty($ui['visibleIndex'])
                && !in_array($type, ['text', 'mediumtext', 'longtext', 'blob', 'mediumblob', 'longblob'], true)
            ) {
                $label = $this->labelExpression($field, $name);
                $sortable = !empty($ui['sortable']);

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

            if (!$sensitive && !empty($ui['searchable'])) {
                $filterControls .= $this->filterControl($config, $field, $name);
            }
        }

        if ($filterControls === '') {
            $filterControls = "        <div class=\"col-12\"><div class=\"alert alert-light border mb-0\">Nessun filtro indicizzato disponibile.</div></div>\n";
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
                'filter_controls' => $filterControls,
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

    private function filterControl(array $config, array $field, string $name): string
    {
        $label = $this->labelExpression($field, $name);
        $ui = (array) ($field['ui'] ?? []);
        $mode = (string) ($ui['filterMode'] ?? 'exact');
        $type = strtolower((string) ($field['type'] ?? ''));
        $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
        $relation = $config['relations']['belongsTo'][$name] ?? null;

        if (is_array($relation)) {
            return <<<PHP
        <div class="col-12 col-md-3">
            <label for="filter_{$name}" class="form-label"><?= esc({$label}) ?></label>
            <select id="filter_{$name}" name="filter[{$name}]" class="form-select">
                <option value="">Tutti</option>
                <?php foreach ((array) (\$options['{$name}'] ?? []) as \$value => \$optionLabel): ?>
                    <option value="<?= esc((string) \$value) ?>" <?= (string) (\$filters['{$name}'] ?? '') === (string) \$value ? 'selected' : '' ?>>
                        <?= esc((string) \$optionLabel) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

PHP;
        }

        if ($mode === 'range') {
            $htmlType = $type === 'date' ? 'date' : 'datetime-local';
            return <<<PHP
        <div class="col-12 col-md-4">
            <label class="form-label"><?= esc({$label}) ?></label>
            <div class="input-group">
                <input type="{$htmlType}" name="filter[{$name}][from]" value="<?= esc((string) (\$filters['{$name}']['from'] ?? '')) ?>" class="form-control" aria-label="Da">
                <input type="{$htmlType}" name="filter[{$name}][to]" value="<?= esc((string) (\$filters['{$name}']['to'] ?? '')) ?>" class="form-control" aria-label="A">
            </div>
        </div>

PHP;
        }

        $columnType = strtolower((string) ($field['columnType'] ?? ''));
        $isBoolean = $inputType === 'checkbox' || $type === 'bool' || $type === 'boolean' || preg_match('/^tinyint\(1\)/', $columnType) === 1;
        if ($isBoolean) {
            return <<<PHP
        <div class="col-6 col-md-2">
            <label for="filter_{$name}" class="form-label"><?= esc({$label}) ?></label>
            <select id="filter_{$name}" name="filter[{$name}]" class="form-select">
                <option value="">Tutti</option>
                <option value="1" <?= (string) (\$filters['{$name}'] ?? '') === '1' ? 'selected' : '' ?>>Sì</option>
                <option value="0" <?= (string) (\$filters['{$name}'] ?? '') === '0' ? 'selected' : '' ?>>No</option>
            </select>
        </div>

PHP;
        }

        $htmlType = preg_match('/int|decimal|float|double|numeric/', $type) === 1 ? 'number' : 'search';
        $step = $htmlType === 'number' && preg_match('/decimal|float|double|numeric/', $type) === 1 ? ' step="any"' : '';
        $hint = $mode === 'prefix' ? '<div class="form-text">Ricerca per inizio testo, minimo 2 caratteri.</div>' : '';

        return <<<PHP
        <div class="col-12 col-md-3">
            <label for="filter_{$name}" class="form-label"><?= esc({$label}) ?></label>
            <input type="{$htmlType}"{$step} id="filter_{$name}" name="filter[{$name}]" value="<?= esc((string) (\$filters['{$name}'] ?? '')) ?>" class="form-control">
            {$hint}
        </div>

PHP;
    }
}
