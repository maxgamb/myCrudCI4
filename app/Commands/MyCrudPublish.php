<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\CrudPublishService;
use App\Libraries\MyCrud\MyCrudVersion;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;

/**
 * Copia nello spazio operativo app/ il CRUD presente in app/Generated/.
 *
 * Staging remains available after publish for diff, verification, and Git rollback.
 */
final class MyCrudPublish extends BaseCommand
{
    protected $group       = 'myCrudCI4';
    protected $name        = 'mycrud:publish';
    protected $description = 'Publishes one configured CRUD from app/Generated/ to app/.';
    protected $usage       = 'mycrud:publish <table> [--dry-run] [--force]';

    protected $arguments = [
        'table' => 'Nome della table da pubblicare.',
    ];

    protected $options = [
        '--dry-run' => 'Shows what would be copied without modifying app/.',
        '--force'   => 'Sovrascrive i file operativi esistenti quando differiscono dallo staging.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Specify the table name.');
            CLI::write('Example: php spark mycrud:publish film --dry-run', 'yellow');
            return EXIT_ERROR;
        }

        $dryRun = (bool) CLI::getOption('dry-run');
        $force = (bool) CLI::getOption('force');

        try {
            CLI::write('myCrudCI4 ' . MyCrudVersion::VERSION, 'cyan');
            CLI::write(($dryRun ? 'Publish DRY-RUN: ' : 'Publish: ') . $table);
            CLI::write('Da: app/Generated/');
            CLI::write('A:  app/');
            CLI::newLine();

            if ($force) {
                CLI::write('FORCE attivo: i file operativi differenti possono essere sovrascritti.', 'yellow');
            } else {
                CLI::write('SAFE: existing application files are skipped; generated tests and MCP artifacts are always synchronized.', 'green');
            }

            if ($dryRun) {
                CLI::write('DRY-RUN: no files will be modified.', 'cyan');
            }

            CLI::newLine();

            $report = (new CrudPublishService())->publish($table, $force, $dryRun);

            foreach ($report['files'] as $relative => $row) {
                $status = (string) ($row['status'] ?? '');
                $reason = (string) ($row['reason'] ?? '');

                $label = match ($status) {
                    'created' => 'CREATED',
                    'overwritten' => 'OVERWRITTEN',
                    'unchanged' => 'UNCHANGED',
                    'skipped' => 'SKIPPED',
                    'missing' => 'MISSING',
                    'would_create' => 'WOULD CREATE',
                    'would_overwrite' => 'WOULD OVERWRITE',
                    'removed' => 'REMOVED',
                    'would_remove' => 'WOULD REMOVE',
                    default => strtoupper($status),
                };

                $color = match ($status) {
                    'created' => 'green',
                    'overwritten' => 'yellow',
                    'unchanged' => 'light_gray',
                    'skipped' => 'yellow',
                    'missing' => 'red',
                    'would_create' => 'green',
                    'would_overwrite' => 'yellow',
                    'removed' => 'yellow',
                    'would_remove' => 'yellow',
                    default => 'white',
                };

                CLI::write(
                    str_pad($label, 16) . ' ' . $relative
                    . ($reason !== '' ? ' [' . $reason . ']' : ''),
                    $color
                );
            }

            $summary = $report['summary'];
            CLI::newLine();

            if ($dryRun) {
                CLI::write(
                    'WOULD CREATE ' . $summary['would_create']
                    . ' | WOULD OVERWRITE ' . $summary['would_overwrite']
                    . ' | UNCHANGED ' . $summary['unchanged']
                    . ' | SKIPPED ' . $summary['skipped']
                    . ' | WOULD REMOVE ' . $summary['would_remove']
                    . ' | MISSING ' . $summary['missing'],
                    'cyan'
                );
                CLI::write('No file è stato modificato.', 'cyan');
            } else {
                CLI::write(
                    'CREATED ' . $summary['created']
                    . ' | OVERWRITTEN ' . $summary['overwritten']
                    . ' | UNCHANGED ' . $summary['unchanged']
                    . ' | SKIPPED ' . $summary['skipped']
                    . ' | REMOVED ' . $summary['removed']
                    . ' | MISSING ' . $summary['missing'],
                    'cyan'
                );
                CLI::write('✓ Publish completato. app/Generated/ è rimasto intatto.', 'green');
            }

            if (!$force && $summary['skipped'] > 0) {
                CLI::write(
                    'Per sostituire i file operativi differenti, riesegui con --force.',
                    'yellow'
                );
            }

            if ($summary['missing'] > 0) {
                CLI::write(
                    'Alcuni file attesi non esistono nello staging: esegui prima mycrud:generate ' . $table . ' --force.',
                    'yellow'
                );
            }

            return EXIT_SUCCESS;
        } catch (Throwable $e) {
            CLI::error($e->getMessage());
            return EXIT_ERROR;
        }
    }
}
