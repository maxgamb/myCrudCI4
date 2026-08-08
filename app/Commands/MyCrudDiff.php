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
    protected $usage       = 'mycrud:diff <table> [--target app|generated] [--all] [--details]';

    protected $arguments = [
        'table' => 'Nome della tabella configurata.',
    ];

    protected $options = [
        '--target'  => 'Target del confronto: app (default) oppure generated.',
        '--all'     => 'Mostra anche i file invariati.',
        '--details' => 'Mostra il numero di righe aggiunte/rimosse per i file nuovi o modificati.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specificare il nome della tabella.');
            return EXIT_ERROR;
        }

        $target = (string) (CLI::getOption('target') ?: 'app');

        try {
            $report = (new GenerationDiffService())->compare($table, $target);
        } catch (Throwable $e) {
            CLI::error($e->getMessage());
            return EXIT_ERROR;
        }

        CLI::write('myCrudGpt diff: ' . $table, 'cyan');
        CLI::write('Generator: ' . $report['generatorVersion']
            . ' | Config salvata con: ' . ($report['savedVersion'] ?: 'n/d'));
        CLI::write('Target: ' . ($target === 'app' ? 'app/ operativo' : 'app/Generated/ staging'));

        if (!empty($report['schemaDrift'])) {
            CLI::write('! Schema drift rilevato rispetto al salvataggio della configurazione.', 'yellow');
        }

        $showAll = (bool) CLI::getOption('all');
        $showDetails = (bool) CLI::getOption('details');

        $this->printCategory('CRUD FILES', 'crud', $report['files'], $showAll, $showDetails);
        $this->printCategory('SHARED FILES', 'shared', $report['files'], $showAll, $showDetails);

        CLI::newLine();
        $this->printSummary('CRUD', $report['summaryByCategory']['crud']);
        $this->printSummary('SHARED', $report['summaryByCategory']['shared']);
        $this->printSummary('TOTAL', $report['summary']);

        CLI::write('Nessun file è stato modificato.', 'cyan');

        return EXIT_SUCCESS;
    }

    /**
     * @param array<string,array<string,mixed>> $files
     */
    private function printCategory(
        string $title,
        string $category,
        array $files,
        bool $showAll,
        bool $showDetails
    ): void {
        $visible = [];

        foreach ($files as $relative => $row) {
            if (($row['category'] ?? 'crud') !== $category) {
                continue;
            }

            if (($row['status'] ?? '') === 'unchanged' && !$showAll) {
                continue;
            }

            $visible[$relative] = $row;
        }

        if ($visible === []) {
            return;
        }

        CLI::newLine();
        CLI::write($title, 'yellow');
        CLI::write(str_repeat('-', strlen($title)), 'light_gray');

        foreach ($visible as $relative => $row) {
            $status = (string) $row['status'];
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

            if ($showDetails && $status !== 'unchanged') {
                $details = (array) ($row['details'] ?? []);
                CLI::write(
                    '    +' . (int) ($details['added'] ?? 0)
                    . ' / -' . (int) ($details['removed'] ?? 0)
                    . ' righe',
                    'light_gray'
                );
            }
        }
    }

    /** @param array{new:int,changed:int,unchanged:int} $summary */
    private function printSummary(string $label, array $summary): void
    {
        CLI::write(
            $label . ': NEW ' . $summary['new']
            . ' | CHANGED ' . $summary['changed']
            . ' | UNCHANGED ' . $summary['unchanged']
        );
    }
}
