<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RuntimeException;

/**
 * Verifica end-to-end le strategie Query Layer della release 2.6.1.
 */
final class MyCrudQueryLayerCheck extends BaseCommand
{
    protected $group = 'myCrudGpt';
    protected $name = 'mycrud:check-query-layer';
    protected $description = 'Genera Basic, Standard e Full e controlla Query Layer, paginazione e lint.';
    protected $usage = 'mycrud:check-query-layer <table>';

    protected $arguments = [
        'table' => 'Tabella reale da usare per la verifica.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specificare il nome della tabella.');
            return EXIT_ERROR;
        }

        $failures = [];

        foreach (['basic', 'standard', 'full'] as $architecture) {
            CLI::write("Verifica {$architecture}...", 'yellow');

            try {
                $config = (new ConfigBuilder())->buildFromTable($table);
                $config['architecture'] = $architecture;
                $config['features'] = $this->featuresFor($architecture, $config);

                (new CrudGeneratorService())->generate($config, true);
                $this->inspectGeneratedFiles($config, $architecture);
                CLI::write("  OK {$architecture}", 'green');
            } catch (RuntimeException $e) {
                $failures[] = "{$architecture}: {$e->getMessage()}";
                CLI::error("  FAIL {$architecture}: {$e->getMessage()}");
            }
        }

        if ($failures !== []) {
            CLI::newLine();
            CLI::error('Verifica Query Layer non superata.');
            return EXIT_ERROR;
        }

        CLI::newLine();
        CLI::write('Query Layer 2.6.1 verificato con successo.', 'green');
        return EXIT_SUCCESS;
    }

    private function featuresFor(string $architecture, array $config): array
    {
        $features = (array) ($config['features'] ?? []);
        $features['entity'] = $architecture !== 'basic';
        $features['service'] = $architecture !== 'basic';
        $features['api'] = $architecture === 'full';
        $features['datatable'] = $architecture !== 'basic';

        if (empty($config['softDelete']['available'])) {
            $features['softDeletes'] = false;
        }

        return $features;
    }

    private function inspectGeneratedFiles(array $config, string $architecture): void
    {
        $root = config('MyCrud')->generatedStagingPath();
        $controller = $root . 'Controllers/' . $config['classes']['controller'] . '.php';
        $model = $root . 'Models/' . $config['classes']['model'] . '.php';
        $route = $root . 'Routes/' . $config['table'] . '.php';
        $service = $root . 'Services/' . $config['classes']['service'] . '.php';

        foreach ([$controller, $model, $route] as $file) {
            $this->assertFile($file);
            $this->assertLint($file);
            $this->assertNoPlaceholders($file);
        }

        $controllerCode = (string) file_get_contents($controller);
        $modelCode = (string) file_get_contents($model);
        $routeCode = (string) file_get_contents($route);

        $this->assertNoDatabaseCalls($controllerCode, 'Controller');
        $this->assertContains($modelCode, 'function baseBuilder(', 'baseBuilder() mancante nel Model.');
        $this->assertContains($modelCode, 'function getDetail(', 'getDetail() mancante nel Model.');

        if ($architecture === 'basic') {
            $this->assertContains($controllerCode, 'paginateWithParents(', 'Basic non usa paginateWithParents().');
            $this->assertNotContains($controllerCode, 'function datatable(', 'Basic contiene ancora datatable().');
            $this->assertNotContains($routeCode, "post('datatable'", 'Basic registra ancora la rotta DataTables.');
            return;
        }

        $this->assertFile($service);
        $this->assertLint($service);
        $serviceCode = (string) file_get_contents($service);
        $this->assertNoDatabaseCalls($serviceCode, 'Service');
        $this->assertContains($controllerCode, 'function datatable(', 'Standard/Full non contiene datatable().');
        $this->assertContains($routeCode, "post('datatable'", 'Standard/Full non registra DataTables.');
        $this->assertContains($modelCode, 'function datatable(', 'datatable() mancante nel Model.');
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
