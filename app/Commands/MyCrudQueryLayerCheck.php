<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RuntimeException;

/** Verifica il Query Layer comune delle architetture 2.7.4. */
final class MyCrudQueryLayerCheck extends BaseCommand
{
    protected $group = 'myCrudCI4';
    protected $name = 'mycrud:check-query-layer';
    protected $description = 'Generates the Full CRUD and checks Bootstrap AJAX, CSV, Word, Query Layer, and lint.';
    protected $usage = 'mycrud:check-query-layer <table>';

    protected $arguments = [
        'table' => 'Table reale da usare per la verifica.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specify the table name.');
            return EXIT_ERROR;
        }

        try {
            $config = (new ConfigBuilder())->buildFromTable($table);
            (new CrudGeneratorService())->generate($config, true);
            $this->inspectGeneratedFiles($config);
        } catch (RuntimeException $e) {
            CLI::error('Verifica fallita: ' . $e->getMessage());
            return EXIT_ERROR;
        }

        CLI::write('Query Layer comune 2.7.4 verificato con successo.', 'green');
        return EXIT_SUCCESS;
    }

    private function inspectGeneratedFiles(array $config): void
    {
        $root = config('MyCrud')->generatedStagingPath();
        $controller = $root . 'Controllers/' . $config['classes']['controller'] . '.php';
        $model = $root . 'Models/' . $config['classes']['model'] . '.php';
        $route = $root . 'Routes/' . $config['table'] . '.php';
        $service = $root . 'Services/' . $config['classes']['service'] . '.php';
        $index = $root . 'Views/' . $config['table'] . '/index.php';
        $tableView = $root . 'Views/' . $config['table'] . '/_table.php';
        $filtersView = $root . 'Views/' . $config['table'] . '/_filters.php';

        $required = [$controller, $model, $route, $index, $tableView, $filtersView];
        if (empty($config['isView'])) {
            $required[] = $service;
        }

        foreach ($required as $file) {
            $this->assertFile($file);
            $this->assertLint($file);
            $this->assertNoPlaceholders($file);
        }

        $controllerCode = (string) file_get_contents($controller);
        $modelCode = (string) file_get_contents($model);
        $routeCode = (string) file_get_contents($route);
        $serviceCode = is_file($service) ? (string) file_get_contents($service) : '';
        $indexCode = (string) file_get_contents($index);

        $this->assertNoDatabaseCalls($controllerCode, 'Controller');
        if (empty($config['isView'])) {
            $this->assertNoDatabaseCalls($serviceCode, 'Service');
        } elseif (is_file($service)) {
            throw new RuntimeException('SQL VIEW non deve generare un Service write-only: ' . $service);
        }
        $this->assertContains($modelCode, 'function getListPage(', 'getListPage() mancante nel Model.');
        $this->assertContains($modelCode, 'function getExportRows(', 'getExportRows() mancante nel Model.');
        $this->assertContains($controllerCode, 'function exportCsv(', 'exportCsv() mancante nel Controller.');
        $this->assertContains($controllerCode, 'function exportWord(', 'exportWord() mancante nel Controller.');
        $this->assertContains($routeCode, "get('export-csv'", 'Rotta CSV mancante.');
        $this->assertContains($routeCode, "get('export-word'", 'Rotta Word mancante.');
        $this->assertContains($indexCode, 'X-Requested-With', 'Caricamento AJAX mancante nella view.');
        $this->assertNotContains($routeCode, "post('datatable'", 'È ancora presente la rotta DataTables.');
        $this->assertNotContains($modelCode, 'function datatable(', 'È ancora presente datatable() nel Model.');

        if (!empty($config['isView'])) {
            foreach ([
                "get('create'",
                "post('create'",
                "get('edit/",
                "post('edit/",
                "post('delete/",
                "post('restore/",
                "post('force-delete/",
            ] as $writeRoute) {
                $this->assertNotContains(
                    $routeCode,
                    $writeRoute,
                    'SQL VIEW espone una rotta di scrittura non consentita: ' . $writeRoute
                );
            }
            foreach (['function create(', 'function edit(', 'function delete(', 'function restore(', 'function forceDelete('] as $writeMethod) {
                $this->assertNotContains(
                    $controllerCode,
                    $writeMethod,
                    'SQL VIEW espone un metodo web di scrittura non consentito: ' . $writeMethod
                );
            }
        }
    }

    private function assertNoDatabaseCalls(string $code, string $layer): void
    {
        foreach (['db_connect(', 'Database::connect(', '->table(', '->join(', '->select('] as $needle) {
            if (str_contains($code, $needle)) {
                throw new RuntimeException("{$layer} contiene una chiamata DB non consentita: {$needle}");
            }
        }
    }

    private function assertFile(string $file): void
    {
        if (!is_file($file)) {
            throw new RuntimeException('File generato mancante: ' . $file);
        }
    }

    private function assertLint(string $file): void
    {
        $command = escapeshellarg(PHP_BINARY) . ' -l ' . escapeshellarg($file) . ' 2>&1';
        exec($command, $output, $status);
        if ($status !== 0) {
            throw new RuntimeException('Lint fallito per ' . $file . ': ' . implode(' ', $output));
        }
    }

    private function assertNoPlaceholders(string $file): void
    {
        $code = (string) file_get_contents($file);
        if (preg_match('/\{\{[A-Z0-9_]+\}\}/', $code) === 1) {
            throw new RuntimeException('Placeholder irrisolto in ' . $file);
        }
    }

    private function assertContains(string $code, string $needle, string $message): void
    {
        if (!str_contains($code, $needle)) {
            throw new RuntimeException($message);
        }
    }

    private function assertNotContains(string $code, string $needle, string $message): void
    {
        if (str_contains($code, $needle)) {
            throw new RuntimeException($message);
        }
    }
}
