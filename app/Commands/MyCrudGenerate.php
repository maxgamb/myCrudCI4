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
        '--architecture' => 'Architettura: basic, standard o full.',
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

        $architecture = CLI::getOption('architecture');
        if (is_string($architecture) && $architecture !== '') {
            $config['architecture'] = strtolower($architecture);

            $config['features'] = match ($config['architecture']) {
                'basic' => [
                    'entity'=>false, 'service'=>false, 'api'=>false,
                    'datatable'=>false, 'relations'=>true,
                    'softDeletes'=>false, 'timestamps'=>false,
                    'exportButtons'=>true,
                ],
                'full' => [
                    'entity'=>true, 'service'=>true, 'api'=>true,
                    'datatable'=>true, 'relations'=>true,
                    'softDeletes'=>false, 'timestamps'=>true,
                    'exportButtons'=>true,
                ],
                default => [
                    'entity'=>true, 'service'=>true, 'api'=>false,
                    'datatable'=>true, 'relations'=>true,
                    'softDeletes'=>false, 'timestamps'=>true,
                    'exportButtons'=>true,
                ],
            };
        }

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
