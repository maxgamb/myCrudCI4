<?php

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use App\Libraries\MyCrud\Core\Naming;
use Config\MyCrud;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Throwable;

/**
 * Test automatico di regressione del generatore.
 * Genera Basic, Standard e Full in cartelle temporanee isolate e controlla
 * componenti attesi, componenti vietati, placeholder e sintassi PHP.
 */
final class ArchitectureRegressionRunner
{
    public function run(string $table): DiagnosticReport
    {
        $report = new DiagnosticReport();
        /** @var MyCrud $myCrud */
        $myCrud = config('MyCrud');
        $originalPath = $myCrud->generatedPath;
        $base = rtrim(WRITEPATH, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR . 'mycrud-regression-' . bin2hex(random_bytes(4));

        try {
            foreach (['basic', 'standard', 'full'] as $architecture) {
                $root = $base . DIRECTORY_SEPARATOR . $architecture;
                $myCrud->generatedPath = $root;

                $config = (new ConfigBuilder())->buildFromTable($table);
                $config['architecture'] = $architecture;
                (new CrudGeneratorService())->generate($config, true);

                $generated = $root . DIRECTORY_SEPARATOR . 'Generated' . DIRECTORY_SEPARATOR;
                $report->addMany($this->architectureChecks($generated, $config, $architecture));
                $report->addMany((new GeneratedFileDiagnostics())->inspect($generated));
            }
        } catch (Throwable $exception) {
            $report->add(new DiagnosticResult(
                'Regression suite',
                DiagnosticResult::FAIL,
                $exception->getMessage(),
                ['exception' => $exception::class, 'file' => $exception->getFile(), 'line' => $exception->getLine()]
            ));
        } finally {
            $myCrud->generatedPath = $originalPath;
            $this->removeDirectory($base);
        }

        return $report;
    }

    /** @return list<DiagnosticResult> */
    private function architectureChecks(string $root, array $config, string $architecture): array
    {
        $class = (array) ($config['classes'] ?? []);
        $table = (string) ($config['table'] ?? '');
        $expected = [
            'Models/' . ($class['model'] ?? '') . '.php',
            'Controllers/' . ($class['controller'] ?? '') . '.php',
            'Validation/' . ($class['rules'] ?? '') . '.php',
            'Views/' . $table . '/index.php',
            'Routes/' . $table . '.php',
            'Libraries/Crud/CrudExporter.php',
            'Libraries/Crud/CrudListRequest.php',
        ];

        if (in_array($architecture, ['standard', 'full'], true)) {
            $expected[] = 'Entities/' . ($class['entity'] ?? '') . '.php';
            $expected[] = 'Services/' . ($class['service'] ?? '') . '.php';
        }
        if ($architecture === 'full') {
            $expected[] = 'Controllers/Api/BaseApiController.php';
            $expected[] = 'Controllers/Api/V1/' . ($class['api'] ?? '') . '.php';
            $expected[] = 'API/Resources/' . ($class['resource'] ?? '') . '.php';
        }

        $results = [];

        // Il nome delle classi deve derivare dalla tabella esattamente come
        // definita nel DB, senza singularizzazioni linguistiche automatiche.
        $expectedPrefix = Naming::tableClass($table);
        $actualController = (string) ($class['controller'] ?? '');
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' naming tabella',
            $actualController === $expectedPrefix . 'Controller'
                ? DiagnosticResult::PASS
                : DiagnosticResult::FAIL,
            $actualController === $expectedPrefix . 'Controller'
                ? 'Nome classe fedele alla tabella.'
                : 'Atteso ' . $expectedPrefix . 'Controller, generato ' . $actualController . '.'
        );

        // I nomi fisici dei campi non devono essere camelizzati o rinominati.
        $fieldNames = array_keys((array) ($config['fields'] ?? []));
        $preserved = true;
        foreach ($fieldNames as $fieldName) {
            if (!isset($config['fields'][$fieldName]['name']) || $config['fields'][$fieldName]['name'] !== $fieldName) {
                $preserved = false;
                break;
            }
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' naming campi DB',
            $preserved ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $preserved ? 'Nomi campi DB preservati.' : 'Uno o più campi sono stati rinominati.'
        );
        foreach ($expected as $relative) {
            $exists = is_file($root . str_replace('/', DIRECTORY_SEPARATOR, $relative));
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' componente ' . $relative,
                $exists ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $exists ? 'Presente.' : 'Mancante.'
            );
        }

        $forbidden = match ($architecture) {
            'basic' => ['Entities/', 'Services/', 'Controllers/Api/V1/', 'API/Resources/'],
            'standard' => ['Controllers/Api/V1/', 'API/Resources/'],
            default => [],
        };
        foreach ($forbidden as $relative) {
            $exists = is_dir($root . str_replace('/', DIRECTORY_SEPARATOR, $relative));
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' assenza ' . $relative,
                !$exists ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                !$exists ? 'Componente correttamente assente.' : 'Componente non previsto presente.'
            );
        }

        return $results;
    }

    private function removeDirectory(string $path): void
    {
        if (!is_dir($path)) {
            return;
        }
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($iterator as $item) {
            $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
        }
        @rmdir($path);
    }
}
