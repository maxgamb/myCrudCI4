<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators\Views;

final class IndexViewGenerator extends AbstractViewGenerator
{
    public function generate(array $config): string
    {
        return ($config['architecture'] ?? 'standard') === 'basic'
            ? $this->generateBasic($config)
            : $this->generateDatatable($config);
    }

    private function generateBasic(array $config): string
    {
        $headers = '';
        $cells = '';
        $count = 0;

        foreach ($this->orderedFields($config) as $name) {
            $field = $config['fields'][$name];
            $type = strtolower((string) ($field['type'] ?? ''));
            if (in_array($type, ['text', 'mediumtext', 'longtext', 'blob', 'mediumblob', 'longblob'], true)) {
                continue;
            }

            $label = $this->labelExpression($field, $name);
            $headers .= "                            <th><?= esc({$label}) ?></th>\n";
            $cells .= "                                    <td><?= esc(\$row->{$name} ?? '') ?></td>\n";
            $count++;
            if ($count >= 12) {
                break;
            }
        }

        return $this->templates->render('views/basic_index.tpl', [
            'table' => (string) $config['table'],
            'primary_key' => (string) $config['primaryKey'],
            'headers' => $headers,
            'cells' => $cells,
            'colspan' => (string) ($count + 1),
        ]);
    }

    private function generateDatatable(array $config): string
    {
        $table = (string) $config['table'];
        $headers = '';
        $filters = '';
        $columns = '';

        foreach ($this->orderedFields($config) as $name) {
            $field = $config['fields'][$name];
            $label = $this->labelExpression($field, $name);
            $headers .= "                            <th><?= esc({$label}) ?></th>\n";
            $filters .= "                            <th><input type=\"text\" class=\"form-control form-control-sm\" placeholder=\"<?= esc('Filtra ' . {$label}) ?>\"></th>\n";
            $columns .= "            { data: '{$name}', name: '{$name}', defaultContent: '' },\n";
        }

        $trashButton = !empty($config['features']['softDeletes'])
            ? "            <a href=\"<?= site_url('{$table}/trash') ?>\" class=\"btn btn-outline-danger\"><i class=\"bi bi-trash3\"></i> Cestino</a>\n"
            : '';

        return $this->templates->render('views/index.tpl', [
            'table' => $table,
            'primary_key' => (string) $config['primaryKey'],
            'headers' => $headers,
            'filters' => $filters,
            'columns' => $columns,
            'trash_button' => $trashButton,
        ]);
    }
}
