<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\CrudConfigurationService;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use App\Libraries\MyCrud\Diagnostics\GenerationDiffService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;

/**
 * Rigenerazione controllata: mostra prima il diff rispetto ad app/ e scrive
 * comunque soltanto nell'area sicura app/Generated/.
 */
final class MyCrudRegenerate extends BaseCommand
{
    protected $group       = 'myCrudGpt';
    protected $name        = 'mycrud:regenerate';
    protected $description = 'Rigenera da config persistente dopo aver mostrato il diff rispetto al codice operativo.';
    protected $usage       = 'mycrud:regenerate <table> [--force]';

    protected $arguments = [
        'table' => 'Nome della tabella configurata.',
    ];

    protected $options = [
        '--force' => 'Aggiorna anche i file già presenti in app/Generated/.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specificare il nome della tabella.');
            return;
        }

        try {
            $diff = (new GenerationDiffService())->compare($table, 'app');
            $configuration = new CrudConfigurationService();
            $resolved = $configuration->resolve($table, true);

            if (!$resolved['saved']) {
                CLI::error('Configurazione persistente non trovata per ' . $table . '.');
                return;
            }

            CLI::write('Preflight diff: ' . $table, 'cyan');
            CLI::write(
                'NEW ' . $diff['summary']['new']
                . ' | CHANGED ' . $diff['summary']['changed']
                . ' | UNCHANGED ' . $diff['summary']['unchanged']
            );

            if (!empty($diff['schemaDrift'])) {
                CLI::write('! Schema drift rilevato: verrà usato lo schema DB corrente.', 'yellow');
            }

            $result = (new CrudGeneratorService())->generate(
                $resolved['config'],
                (bool) CLI::getOption('force')
            );

            CLI::write(
                '✓ Rigenerato in staging: ' . $result['table']
                . ' [' . $result['architecture'] . ']',
                'green'
            );
            CLI::write('Nessun file operativo in app/ è stato sovrascritto.', 'cyan');
        } catch (Throwable $e) {
            CLI::error($e->getMessage());
        }
    }
}
