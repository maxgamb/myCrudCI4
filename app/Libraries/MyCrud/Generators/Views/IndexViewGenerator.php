<?php
namespace App\Libraries\MyCrud\Generators\Views;

final class IndexViewGenerator extends AbstractViewGenerator
{
    public function generate(array $config): string
    {
        $table = (string) $config['table'];
        $headers = '';
        $filters = '';
        $columns = '';

        foreach ($this->orderedFields($config) as $name) {
            $label = $this->labelExpression($config['fields'][$name], $name);

            $headers .= "                            <th><?= esc({$label}) ?></th>\n";
            $filters .= <<<PHP
                            <th>
                                <input
                                    type="text"
                                    class="form-control form-control-sm"
                                    placeholder="<?= esc('Filtra ' . {$label}) ?>"
                                >
                            </th>
PHP;
            $columns .= <<<JS
            {
                data: '{$name}',
                name: '{$name}',
                defaultContent: ''
            },
JS;
        }

        $trashButton = !empty($config['features']['softDeletes'])
            ? <<<PHP
            <a href="<?= site_url('{$table}/trash') ?>" class="btn btn-outline-danger">
                <i class="bi bi-trash3"></i> Cestino
            </a>
PHP
            : '';

        return $this->templates->render('views/index.tpl', [
            'table'        => $table,
            'primary_key'  => (string) $config['primaryKey'],
            'headers'      => $headers,
            'filters'      => $filters,
            'columns'      => $columns,
            'trash_button' => $trashButton,
        ]);
    }
}
