<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RuntimeException;
use Throwable;

/** Verifica la generazione API v1 per una table reale. */
final class MyCrudApiCheck extends BaseCommand
{
    protected $group = 'myCrudCI4';
    protected $name = 'mycrud:check-api';
    protected $description = 'Generates and checks API controller, Resource, Routes, and OpenAPI.';
    protected $usage = 'mycrud:check-api <table>';
    protected $arguments = ['table' => 'Table da verificare'];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specificare una table.');
            return EXIT_ERROR;
        }
        try {
            $config = (new ConfigBuilder())->buildFromTable($table);
            $config['architecture'] = 'full';
            $config['features']['entity'] = true;
            $config['features']['service'] = true;
            $config['features']['api'] = true;

            (new CrudGeneratorService())->generate($config, true);

            $root = config('MyCrud')->generatedStagingPath();
            $checks = [
                $root . 'Controllers/Api/V1/' . $config['classes']['api'] . '.php',
                $root . 'API/Resources/' . $config['classes']['resource'] . '.php',
                $root . 'OpenApi/' . $table . '.yaml',
                $root . 'Routes/' . $table . '.php',
            ];

            // API validation exists only when the generated API exposes writes.
            // SQL VIEWs are intentionally GET-only and therefore must not be
            // failed for the absence of a write-validation class.
            $apiCapabilities = (array) ($config['apiCapabilities'] ?? []);
            if (!empty($apiCapabilities['create']) || !empty($apiCapabilities['update'])) {
                $checks[] = $root . 'Validation/' . $config['classes']['apiRules'] . '.php';
            }

            foreach ($checks as $file) {
                if (!is_file($file)) {
                    throw new RuntimeException('File non generato: ' . $file);
                }
                CLI::write('OK ' . $file, 'green');
            }

            if (!empty($config['isView'])) {
                $apiFile = $root . 'Controllers/Api/V1/' . $config['classes']['api'] . '.php';
                $apiCode = (string) file_get_contents($apiFile);
                foreach (['function create(', 'function update(', 'function delete(', 'function restore(', 'function forceDelete('] as $writeMethod) {
                    if (str_contains($apiCode, $writeMethod)) {
                        throw new RuntimeException('SQL VIEW API non read-only: trovato ' . $writeMethod);
                    }
                }
            }

            CLI::write(
                !empty($config['isView'])
                    ? 'API v1 read-only della SQL VIEW generata e verificata.'
                    : 'API v1 generata e verificata.',
                'green'
            );
            return EXIT_SUCCESS;
        } catch (Throwable $e) {
            CLI::error('Verifica API fallita: ' . $e::class . ': ' . $e->getMessage());
            return EXIT_ERROR;
        }
    }
}
