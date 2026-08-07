<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Diagnostics\GenerationDiffService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;

/** Mostra cosa cambierebbe rigenerando un CRUD, senza scrivere nel progetto. */
final class MyCrudDiff extends BaseCommand
{
    protected $group       = 'myCrudGpt';
    protected $name        = 'mycrud:diff';
    protected $description = 'Confronta la nuova generazione con app/ o app/Generated/ senza modificare file.';
    protected $usage       = 'mycrud:diff <table> [--target app|generated] [--all]';

    protected $arguments = [
        'table' => 'Nome della tabella configurata.',
    ];

    protected $options = [
        '--target' => 'Target del confronto: app (default) oppure generated.',
        '--all'    => 'Mostra anche i file invariati.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specificare il nome della tabella.');
            return;
        }

        $target = (string) (CLI::getOption('target') ?: 'app');

        try {
            $report = (new GenerationDiffService())->compare($table, $target);
        } catch (Throwable $e) {
            CLI::error($e->getMessage());
            return;
        }

        CLI::write('myCrudGpt diff: ' . $table, 'cyan');
        CLI::write('Generator: ' . $report['generatorVersion']
            . ' | Config salvata con: ' . ($report['savedVersion'] ?: 'n/d'));
        CLI::write('Target: ' . ($target === 'app' ? 'app/ operativo' : 'app/Generated/ staging'));

        if (!empty($report['schemaDrift'])) {
            CLI::write('! Schema drift rilevato rispetto al salvataggio della configurazione.', 'yellow');
        }

        CLI::newLine();
        $showAll = (bool) CLI::getOption('all');

        foreach ($report['files'] as $relative => $row) {
            $status = (string) $row['status'];
            if ($status === 'unchanged' && !$showAll) {
                continue;
            }

            $prefix = match ($status) {
                'new' => '+',
                'changed' => '~',
                default => '=',
            };
            $color = match ($status) {
                'new' => 'green',
                'changed' => 'yellow',
                default => 'light_gray',
            };

            CLI::write($prefix . ' ' . strtoupper($status) . '  ' . $relative, $color);
        }

        CLI::newLine();
        CLI::write(
            'NEW ' . $report['summary']['new']
            . ' | CHANGED ' . $report['summary']['changed']
            . ' | UNCHANGED ' . $report['summary']['unchanged']
        );
        CLI::write('Nessun file è stato modificato.', 'cyan');
    }
}
