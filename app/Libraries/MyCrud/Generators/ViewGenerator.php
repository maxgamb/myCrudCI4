<?php
namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Generators\Views\DetailViewGenerator;
use App\Libraries\MyCrud\Generators\Views\FormViewGenerator;
use App\Libraries\MyCrud\Generators\Views\IndexViewGenerator;
use App\Libraries\MyCrud\Generators\Views\TrashViewGenerator;
use App\Libraries\MyCrud\Template\TemplateEngine;

final class ViewGenerator
{
    use GeneratorTrait;

    private FormViewGenerator $forms;
    private IndexViewGenerator $index;
    private DetailViewGenerator $detail;
    private TrashViewGenerator $trash;

    public function __construct(?TemplateEngine $templates = null)
    {
        $templates ??= new TemplateEngine();
        $this->forms = new FormViewGenerator($templates);
        $this->index = new IndexViewGenerator($templates);
        $this->detail = new DetailViewGenerator($templates);
        $this->trash = new TrashViewGenerator($templates);
    }

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $formViews = $this->forms->generate($config);

        $files = [
            '_form.php' => $this->writeGenerated("Views/{$table}/_form.php", $formViews['form'], $force),
            'create.php' => $this->writeGenerated("Views/{$table}/create.php", $formViews['create'], $force),
            'edit.php'   => $this->writeGenerated("Views/{$table}/edit.php", $formViews['edit'], $force),
            'index.php'  => $this->writeGenerated("Views/{$table}/index.php", $this->index->generate($config), $force),
            'view.php'   => $this->writeGenerated("Views/{$table}/view.php", $this->detail->generate($config), $force),
        ];

        if (!empty($config['features']['softDeletes'])) {
            $files['trash.php'] = $this->writeGenerated(
                "Views/{$table}/trash.php",
                $this->trash->generate($config),
                $force
            );
        }

        return $files;
    }
}
