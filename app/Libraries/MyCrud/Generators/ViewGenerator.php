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
        $listViews = $this->index->generateAll($config);

        $files = [
            'index.php'    => $this->writeGenerated("Generated/Views/{$table}/index.php", $listViews['index'], $force),
            '_filters.php' => $this->writeGenerated("Generated/Views/{$table}/_filters.php", $listViews['filters'], $force),
            '_table.php'   => $this->writeGenerated("Generated/Views/{$table}/_table.php", $listViews['table'], $force),
            '_pager.php'   => $this->writeGenerated("Generated/Views/{$table}/_pager.php", $listViews['pager'], $force),
        ];

        if (!empty($config['features']['recordDetail'])) {
            $files['view.php'] = $this->writeGenerated(
                "Generated/Views/{$table}/view.php",
                $this->detail->generate($config),
                $force
            );
            foreach ($this->detail->generateHasManyPartials($config) as $partialName => $partialContent) {
                $files[$partialName] = $this->writeGenerated(
                    "Generated/Views/{$table}/{$partialName}",
                    $partialContent,
                    $force
                );
            }
            foreach ($this->detail->generateManyToManyPartials($config) as $partialName => $partialContent) {
                $files[$partialName] = $this->writeGenerated(
                    "Generated/Views/{$table}/{$partialName}",
                    $partialContent,
                    $force
                );
            }
        }

        $createAllowed = !empty($config['features']['createAllowed']);
        $writable = !empty($config['features']['writable']);
        if ($createAllowed || $writable) {
            $formViews = $this->forms->generate($config);
            $files['_fields.php'] = $this->writeGenerated("Generated/Views/{$table}/_fields.php", $formViews['fields'], $force);
            $files['_form.php'] = $this->writeGenerated("Generated/Views/{$table}/_form.php", $formViews['form'], $force);
            foreach ((array) ($formViews['relatedPartials'] ?? []) as $partialName => $partialContent) {
                $files[$partialName] = $this->writeGenerated("Generated/Views/{$table}/{$partialName}", $partialContent, $force);
            }
            if ($createAllowed) {
                $files['create.php'] = $this->writeGenerated("Generated/Views/{$table}/create.php", $formViews['create'], $force);
            }
            if ($writable) {
                $files['edit.php'] = $this->writeGenerated("Generated/Views/{$table}/edit.php", $formViews['edit'], $force);
            }
        }

        if (!empty($config['features']['softDeletes'])) {
            $files['trash.php'] = $this->writeGenerated(
                "Generated/Views/{$table}/trash.php",
                $this->trash->generate($config),
                $force
            );
        }

        return $files;
    }
}
