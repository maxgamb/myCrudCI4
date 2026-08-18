<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use RuntimeException;

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
        $config = (new ConfigBuilder())->buildFromTable($table);
        $config['architecture'] = 'full';
        $config['features']['entity'] = true;
        $config['features']['service'] = true;
        $config['features']['api'] = true;
        $result = (new CrudGeneratorService())->generate($config, true);
        $root = config('MyCrud')->generatedStagingPath();
        $checks = [
            $root . 'Controllers/Api/V1/' . $config['classes']['api'] . '.php',
            $root . 'API/Resources/' . $config['classes']['resource'] . '.php',
            $root . 'Validation/' . $config['classes']['apiRules'] . '.php',
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
