<?php
namespace App\Libraries\MyCrud\Generators\Views;

use App\Libraries\MyCrud\Core\FieldPolicy;
use App\Libraries\MyCrud\Core\Naming;

final class DetailViewGenerator extends AbstractViewGenerator
{
    public function generate(array $config): string
    {
        $rows = '';

        foreach ($this->orderedFields($config) as $name) {
            $field = $config['fields'][$name];
            $ui = (array) ($field['ui'] ?? []);
            $inputType = (string) ($field['inputType'] ?? 'text');
            if (!empty($ui['sensitive']) || FieldPolicy::isSensitive($name, $inputType)) {
                continue;
            }
            if (array_key_exists('visibleView', (array) ($field['ui'] ?? [])) && empty($field['ui']['visibleView'])) {
                continue;
            }
            $label = $this->labelExpression($field, $name);
            $relation = $config['relations']['belongsTo'][$name] ?? null;
            $valueMarkup = "<?= esc(\$row->{$name} ?? '') ?>";

            if (is_array($relation)) {
                $alias = (string) ($relation['alias'] ?? ((string) ($relation['parentTable'] ?? 'parent') . '__' . $name . '__label'));
                $parentTable = (string) ($relation['parentTable'] ?? '');
                $displayMarkup = "<?= esc(\$row->{$alias} ?? \$row->{$name} ?? '') ?>";
                if (!empty($field['relationNavigation']['parentLink']) && $parentTable !== '') {
                    $valueMarkup = "<a href=\"<?= site_url('{$parentTable}/view/' . rawurlencode((string) (\$row->{$name} ?? ''))) ?>\" class=\"text-decoration-none\">{$displayMarkup}</a>";
                } else {
                    $valueMarkup = $displayMarkup;
                }
            }

            $rows .= <<<PHP
                        <tr>
                            <th class="w-25"><?= esc({$label}) ?></th>
                            <td>{$valueMarkup}</td>
                        </tr>
PHP;
        }

        return $this->templates->render('views/detail.tpl', [
            'table'  => (string) $config['table'],
            'rows'   => $rows,
            'panels' => $this->buildHasManyPanels($config),
        ]);
    }

    private function buildHasManyPanels(array $config): string
    {
        $output = '';

        foreach ($config['relationsConfig']['hasMany'] ?? [] as $key => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }

            // Le relazioni devono provenire dallo schema corrente. Una config
            // legacy/stale incompleta viene ignorata invece di interrompere la
            // generazione della pagina di dettaglio.
            if (
                empty($relation['childTable'])
                || empty($relation['foreignKey'])
                || empty($relation['primaryKey'])
            ) {
                continue;
            }

            $headers = '';
            $cells = '';

            foreach ($relation['columns'] ?? [] as $column) {
                $childLabel = var_export(Naming::human((string) $column), true);
                $headers .= "                                <th><?= esc({$childLabel}) ?></th>\n";
                $cells .= "                                <td><?= esc(\$child->{$column} ?? '') ?></td>\n";
            }

            $countBadge = !empty($relation['showCount'])
                ? "<span class=\"badge bg-secondary\"><?= (int) (\$children['{$key}']['count'] ?? 0) ?><?= !empty(\$children['{$key}']['hasMore']) ? '+' : '' ?></span>"
                : '';

            $actionHeader = !empty($relation['showViewButton']) ? '<th>Azioni</th>' : '';
            $actionCell = !empty($relation['showViewButton'])
                ? "<td><a href=\"<?= site_url('{$relation['childTable']}/view/' . (\$child->{$relation['primaryKey']} ?? '')) ?>\" class=\"btn btn-sm btn-outline-info\"><i class=\"bi bi-eye\"></i></a></td>"
                : '';

            $output .= $this->templates->render('views/has_many_panel.tpl', [
                'relation_key'  => (string) $key,
                'title'         => htmlspecialchars((string) $relation['title'], ENT_QUOTES),
                'icon'          => htmlspecialchars((string) ($relation['icon'] ?? 'bi-diagram-3'), ENT_QUOTES),
                'count_badge'   => $countBadge,
                'headers'       => $headers,
                'cells'         => $cells,
                'action_header' => $actionHeader,
                'action_cell'   => $actionCell,
                'limit'         => (string) max(1, (int) ($relation['limit'] ?? 20)),
            ]);
        }

        return $output;
    }
}
