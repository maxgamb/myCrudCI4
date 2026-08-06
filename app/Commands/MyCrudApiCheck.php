<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RuntimeException;

/** Verifica la generazione API v1 per una tabella reale. */
final class MyCrudApiCheck extends BaseCommand
{
    protected $group = 'myCrudGpt';
    protected $name = 'mycrud:check-api';
    protected $description = 'Genera e controlla controller API, Resource, Routes e OpenAPI.';
    protected $usage = 'mycrud:check-api <table>';
    protected $arguments = ['table' => 'Tabella da verificare'];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specificare una tabella.');
            return EXIT_ERROR;
        }
        $config = (new ConfigBuilder())->buildFromTable($table);
        $config['architecture'] = 'full';
        $config['features']['entity'] = true;
        $config['features']['service'] = true;
        $config['features']['api'] = true;
        $result = (new CrudGeneratorService())->generate($config, true);
        $root = rtrim((string) config('MyCrud')->generatedPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $checks = [
            $root . 'Controllers/Api/V1/' . $config['classes']['api'] . '.php',
            $root . 'API/Resources/' . preg_replace('/ApiController$/', 'Resource', $config['classes']['api']) . '.php',
            $root . 'OpenApi/' . $table . '.yaml',
            $root . 'Routes/' . $table . '.php',
        ];
        foreach ($checks as $file) {
            if (!is_file($file)) {
                throw new RuntimeException('File non generato: ' . $file);
            }
            CLI::write('OK ' . $file, 'green');
        }
        CLI::write('API v1 generata e verificata.', 'green');
        return EXIT_SUCCESS;
    }
}
