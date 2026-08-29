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
            'index.php' => $this->writeGenerated(
                "Generated/Views/{$table}/index.php",
                $listViews['index'],
                $force
            ),
            '_filters.php' => $this->writeGenerated(
                "Generated/Views/{$table}/_filters.php",
                $listViews['filters'],
                $force
            ),
            '_table.php' => $this->writeGenerated(
                "Generated/Views/{$table}/_table.php",
                $listViews['table'],
                $force
            ),
            '_pager.php' => $this->writeGenerated(
                "Generated/Views/{$table}/_pager.php",
                $listViews['pager'],
                $force
            ),
        ];

        /*
         * Detail view.
         *
         * HasMany and many-to-many partials are generated dynamically from
         * the current schema/configuration.
         */
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

        /*
         * Create/Edit form.
         */
        $createAllowed = !empty($config['features']['createAllowed']);
        $writable = !empty($config['features']['writable']);

        if ($createAllowed || $writable) {
            $formViews = $this->forms->generate($config);

            $files['_fields.php'] = $this->writeGenerated(
                "Generated/Views/{$table}/_fields.php",
                $formViews['fields'],
                $force
            );

            $files['_form.php'] = $this->writeGenerated(
                "Generated/Views/{$table}/_form.php",
                $formViews['form'],
                $force
            );

            foreach ((array) ($formViews['relatedPartials'] ?? []) as $partialName => $partialContent) {
                $files[$partialName] = $this->writeGenerated(
                    "Generated/Views/{$table}/{$partialName}",
                    $partialContent,
                    $force
                );
            }

            foreach ((array) ($formViews['manyToManyPartials'] ?? []) as $partialName => $partialContent) {
                $files[$partialName] = $this->writeGenerated(
                    "Generated/Views/{$table}/{$partialName}",
                    $partialContent,
                    $force
                );
            }

            if ($createAllowed) {
                $files['create.php'] = $this->writeGenerated(
                    "Generated/Views/{$table}/create.php",
                    $formViews['create'],
                    $force
                );
            }

            if ($writable) {
                $files['edit.php'] = $this->writeGenerated(
                    "Generated/Views/{$table}/edit.php",
                    $formViews['edit'],
                    $force
                );
            }
        }

        /*
         * Soft-delete trash view.
         */
        if (!empty($config['features']['softDeletes'])) {
            $files['trash.php'] = $this->writeGenerated(
                "Generated/Views/{$table}/trash.php",
                $this->trash->generate($config),
                $force
            );
        }

        /*
         * Remove stale dynamic partials from staging.
         *
         * Only known generator-owned partial families are managed here.
         * Unknown/custom files are deliberately left untouched.
         */
        $this->cleanupStaleGeneratedPartials($table, array_keys($files));

        return $files;
    }

    /**
     * Removes dynamic View partials that belonged to an older generation but
     * are no longer expected by the current schema/configuration.
     *
     * This intentionally does NOT clean the whole CRUD View directory.
     * Developer-created files and ordinary View files are never touched.
     *
     * @param list<string> $expectedFiles
     */
    private function cleanupStaleGeneratedPartials(string $table, array $expectedFiles): void
    {
        $directory = rtrim($this->generatedRoot(), DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . 'Generated'
            . DIRECTORY_SEPARATOR
            . 'Views'
            . DIRECTORY_SEPARATOR
            . $table;

        if (!is_dir($directory)) {
            return;
        }

        $expected = array_fill_keys($expectedFiles, true);

        /*
         * These filename families are owned completely by the generator.
         *
         * _children_*       = hasMany detail partials
         * _many_many__*     = M:N detail partials
         * _many_form_*      = M:N form partials
         * _related_create_* = belongsTo inline-create partials
         */
        $patterns = [
            '_children_*.php',
            '_many_many__*.php',
            '_many_form_*.php',
            '_related_create_*.php',
        ];

        foreach ($patterns as $pattern) {
            $matches = glob($directory . DIRECTORY_SEPARATOR . $pattern);

            if ($matches === false) {
                continue;
            }

            foreach ($matches as $path) {
                if (!is_file($path)) {
                    continue;
                }

                $filename = basename($path);

                if (isset($expected[$filename])) {
                    continue;
                }

                @unlink($path);
            }
        }
    }
}