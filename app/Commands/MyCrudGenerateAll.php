<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\ConfiguredGenerationService;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/** Rigenera in staging tutti i CRUD configurati nel progetto. */
final class MyCrudGenerateAll extends BaseCommand
{
    protected $group       = 'myCrudGpt';
    protected $name        = 'mycrud:generate-all';
    protected $description = 'Genera tutti i CRUD presenti in app/MyCrudConfig/ usando la loro architettura salvata.';
    protected $usage       = 'mycrud:generate-all [--force]';

    protected $options = [
        '--force' => 'Sovrascrive i file esistenti esclusivamente in app/Generated/.',
    ];

    public function run(array $params)
    {
        $service = new ConfiguredGenerationService();
        $report = $service->generateAll(null, (bool) CLI::getOption('force'));

        if ((int) $report['summary']['selected'] === 0) {
            CLI::write('Nessuna configurazione persistente trovata in app/MyCrudConfig/.', 'yellow');
            return;
        }

        CLI::write('myCrudGpt generate-all ' . $report['version']);
        CLI::newLine();

        foreach ($report['tables'] as $table => $row) {
            if (($row['status'] ?? '') === 'ok') {
                $suffix = !empty($row['schemaDrift']) ? '  [SCHEMA DRIFT]' : '';
                CLI::write(
                    '✓ ' . $table . ' [' . ($row['architecture'] ?? '') . ']' . $suffix,
                    !empty($row['schemaDrift']) ? 'yellow' : 'green'
                );
                continue;
            }

            CLI::write('✗ ' . $table . ': ' . ($row['message'] ?? 'errore'), 'red');
        }

        CLI::newLine();
        CLI::write(
            'OK ' . $report['summary']['ok']
            . ' | FAIL ' . $report['summary']['failed']
            . ' | SCHEMA DRIFT ' . $report['summary']['schemaDrift']
        );
    }
}
