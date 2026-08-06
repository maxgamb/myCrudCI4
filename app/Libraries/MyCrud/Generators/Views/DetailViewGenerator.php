<?php
namespace App\Libraries\MyCrud\Generators\Views;

final class DetailViewGenerator extends AbstractViewGenerator
{
    public function generate(array $config): string
    {
        $rows = '';

        foreach ($this->orderedFields($config) as $name) {
            $label = $this->labelExpression($config['fields'][$name], $name);

            $rows .= <<<PHP
                        <tr>
                            <th style="width: 30%"><?= esc({$label}) ?></th>
                            <td><?= esc(\$row->{$name} ?? '') ?></td>
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

            $headers = '';
            $cells = '';

            foreach ($relation['columns'] ?? [] as $column) {
                $headers .= "                                <th><?= esc(lang('Fields.{$column}')) ?></th>\n";
                $cells .= "                                <td><?= esc(\$child->{$column} ?? '') ?></td>\n";
            }

            $countBadge = !empty($relation['showCount'])
                ? "<span class=\"badge bg-secondary\"><?= (int) (\$children['{$key}']['count'] ?? 0) ?></span>"
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
