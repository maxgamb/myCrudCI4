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
 * Controlled regeneration: first shows the diff against app/ and writes
 * comunque soltanto nell'area sicura app/Generated/.
 */
final class MyCrudRegenerate extends BaseCommand
{
    protected $group       = 'myCrudCI4';
    protected $name        = 'mycrud:regenerate';
    protected $description = 'Rigenera da config persistente dopo aver mostrato il diff rispetto al codice operativo.';
    protected $usage       = 'mycrud:regenerate <table> [--force]';

    protected $arguments = [
        'table' => 'Nome della table configurata.',
    ];

    protected $options = [
        '--force' => 'Also updates files already present in app/Generated/.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specify the table name.');
            return;
        }

        try {
            $diff = (new GenerationDiffService())->compare($table, 'app');
            $configuration = new CrudConfigurationService();
            $resolved = $configuration->resolve($table, true);

            if (!$resolved['saved']) {
                CLI::error('Persistent configuration not found per ' . $table . '.');
                return;
            }

            CLI::write('Preflight diff: ' . $table, 'cyan');
            CLI::write(
                'NEW ' . $diff['summary']['new']
                . ' | CHANGED ' . $diff['summary']['changed']
                . ' | UNCHANGED ' . $diff['summary']['unchanged']
            );

            if (!empty($diff['schemaDrift'])) {
                CLI::write('! Schema drift rilevato: verrà usato lo DB schema corrente.', 'yellow');
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
            CLI::write('No file operativo in app/ è stato sovrascritto.', 'cyan');
        } catch (Throwable $e) {
            CLI::error($e->getMessage());
        }
    }
}
