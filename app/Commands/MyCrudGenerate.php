<?php

namespace App\Commands;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

class MyCrudGenerate extends BaseCommand
{
    protected $group       = 'myCrudGpt';
    protected $name        = 'mycrud:generate';
    protected $description = 'Genera un CRUD CI4 dalla struttura di una tabella.';
    protected $usage       = 'mycrud:generate <table> [--architecture basic|standard|full] [--force]';

    protected $arguments = [
        'table' => 'Nome della tabella.',
    ];

    protected $options = [
        '--architecture' => 'Architettura: basic, standard oppure full.',
        '--force'        => 'Sovrascrive i file già presenti nel percorso di generazione.',
    ];

    public function run(array $params)
    {
        $table = $params[0] ?? null;

        if (!$table) {
            CLI::error('Specificare il nome della tabella.');
            return;
        }

        $config = (new ConfigBuilder())->buildFromTable($table);

        $architecture = strtolower((string) (CLI::getOption('architecture') ?: config('MyCrud')->defaultArchitecture));
        if (!in_array($architecture, ['basic', 'standard', 'full'], true)) {
            CLI::error('Architettura non valida. Usa basic, standard oppure full.');
            return;
        }

        $config['architecture'] = $architecture;
        $config['features']['entity'] = in_array($architecture, ['standard', 'full'], true);
        $config['features']['service'] = in_array($architecture, ['standard', 'full'], true);
        $config['features']['api'] = $architecture === 'full';

        $result = (new CrudGeneratorService())->generate(
            $config,
            (bool) CLI::getOption('force')
        );

        CLI::write(
            'CRUD generato: ' . $result['table'] . ' [' . $result['architecture'] . ']',
            'green'
        );
        CLI::write(print_r($result['files'], true));
    }
}
