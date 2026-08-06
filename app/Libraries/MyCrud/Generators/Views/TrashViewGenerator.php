<?php
namespace App\Libraries\MyCrud\Generators\Views;

final class TrashViewGenerator extends AbstractViewGenerator
{
    public function generate(array $config): string
    {
        return $this->templates->render('views/trash.tpl', [
            'table'         => (string) $config['table'],
            'primary_key'   => (string) $config['primaryKey'],
            'deleted_field' => (string) ($config['softDelete']['field'] ?? 'deleted_at'),
        ]);
    }
}
