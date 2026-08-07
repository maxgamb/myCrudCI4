<?php

namespace App\Libraries\MyCrud\Diagnostics;

use Config\MyCrud;

final class ProjectDiagnostics
{
    public function run(): DiagnosticReport
    {
        $report = new DiagnosticReport();

        $requiredFiles = [
            'BaseController'       => APPPATH . 'Controllers/BaseController.php',
            'MyCrud configuration' => APPPATH . 'Config/MyCrud.php',
            'ConfigBuilder'        => APPPATH . 'Libraries/MyCrud/Core/ConfigBuilder.php',
            'CrudGeneratorService' => APPPATH . 'Libraries/MyCrud/Core/CrudGeneratorService.php',
            'ViewGenerator'        => APPPATH . 'Libraries/MyCrud/Generators/ViewGenerator.php',
            'TemplateEngine'       => APPPATH . 'Libraries/MyCrud/Template/TemplateEngine.php',
            'Layout CRUD'          => APPPATH . 'Views/layouts/default_crud.php',
            'Layout applicazione'  => APPPATH . 'Views/layouts/default_app.php',
        ];

        foreach ($requiredFiles as $name => $path) {
            $report->add(new DiagnosticResult(
                $name,
                is_file($path) ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                is_file($path) ? 'File presente.' : 'File mancante.',
                ['path' => $path]
            ));
        }

        /** @var MyCrud $config */
        $config = config('MyCrud');
        $generatedPath = rtrim($config->generatedStagingPath(), DIRECTORY_SEPARATOR);
        $parent = dirname($generatedPath);

        $report->add(new DiagnosticResult(
            'Generated path configurato',
            is_dir($generatedPath) || (is_dir($parent) && is_writable($parent))
                ? DiagnosticResult::PASS
                : DiagnosticResult::FAIL,
            is_dir($generatedPath)
                ? 'Directory Generated disponibile.'
                : 'La directory può essere creata nel percorso configurato.',
            ['path' => $generatedPath]
        ));

        $crudConfigPath = rtrim($config->crudConfigPath, DIRECTORY_SEPARATOR);
        $crudConfigParent = dirname($crudConfigPath);
        $configWritable = is_dir($crudConfigPath)
            ? is_writable($crudConfigPath)
            : (is_dir($crudConfigParent) && is_writable($crudConfigParent));

        $report->add(new DiagnosticResult(
            'MyCrudConfig path',
            $configWritable ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $configWritable
                ? 'Directory configurazioni persistenti disponibile/scrivibile.'
                : 'Directory configurazioni persistenti non scrivibile.',
            ['path' => $crudConfigPath]
        ));

        $report->addMany((new TemplateDiagnostics())->inspect());
        $report->addMany((new GeneratedFileDiagnostics())->inspect($generatedPath));

        return $report;
    }
}
