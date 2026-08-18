<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Core\CrudConfigurationService;
use App\Libraries\MyCrud\Core\CrudPublishService;
use App\Libraries\MyCrud\MyCrudVersion;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use Throwable;

/** Publishes every configured CRUD from app/Generated/ into the operational project. */
final class MyCrudPublishAll extends BaseCommand
{
    protected $group       = 'myCrudCI4';
    protected $name        = 'mycrud:publish-all';
    protected $description = 'Publishes all configured CRUDs from app/Generated/ to app/ and tests/.';
    protected $usage       = 'mycrud:publish-all [--dry-run] [--force]';

    protected $options = [
        '--dry-run' => 'Shows what would be copied without modifying operational files.',
        '--force'   => 'Overwrites differing operational application files.',
    ];

    public function run(array $params)
    {
        $dryRun = (bool) CLI::getOption('dry-run');
        $force = (bool) CLI::getOption('force');
        $tables = (new CrudConfigurationService())->configuredTables();

        if ($tables === []) {
            CLI::write('No persistent configurations found in app/MyCrudConfig/.', 'yellow');
            return EXIT_SUCCESS;
        }

        CLI::write('myCrudCI4 ' . MyCrudVersion::VERSION, 'cyan');
        CLI::write($dryRun ? 'Publish-all DRY-RUN' : 'Publish-all');
        CLI::write('Configured CRUDs: ' . count($tables));
        CLI::newLine();

        $service = new CrudPublishService();
        $totals = [
            'created' => 0,
            'overwritten' => 0,
            'unchanged' => 0,
            'skipped' => 0,
            'missing' => 0,
            'would_create' => 0,
            'would_overwrite' => 0,
            'removed' => 0,
            'would_remove' => 0,
        ];
        $failed = 0;

        foreach ($tables as $table) {
            try {
                $report = $service->publish($table, $force, $dryRun);
                foreach ($totals as $key => $_) {
                    $totals[$key] += (int) ($report['summary'][$key] ?? 0);
                }

                $summary = $report['summary'];
                $status = (int) ($summary['missing'] ?? 0) > 0 ? 'yellow' : 'green';
                CLI::write(
                    '✓ ' . $table
                    . ' | created ' . (int) ($summary['created'] ?? 0)
                    . ' | overwritten ' . (int) ($summary['overwritten'] ?? 0)
                    . ' | unchanged ' . (int) ($summary['unchanged'] ?? 0)
                    . ' | skipped ' . (int) ($summary['skipped'] ?? 0)
                    . ' | removed ' . (int) ($summary['removed'] ?? 0)
                    . ' | missing ' . (int) ($summary['missing'] ?? 0),
                    $status
                );
            } catch (Throwable $e) {
                $failed++;
                CLI::write('✗ ' . $table . ': ' . $e->getMessage(), 'red');
            }
        }

        CLI::newLine();
        if ($dryRun) {
            CLI::write(
                'WOULD CREATE ' . $totals['would_create']
                . ' | WOULD OVERWRITE ' . $totals['would_overwrite']
                . ' | UNCHANGED ' . $totals['unchanged']
                . ' | SKIPPED ' . $totals['skipped']
                . ' | WOULD REMOVE ' . $totals['would_remove']
                . ' | MISSING ' . $totals['missing']
                . ' | FAILED TABLES ' . $failed,
                'cyan'
            );
        } else {
            CLI::write(
                'CREATED ' . $totals['created']
                . ' | OVERWRITTEN ' . $totals['overwritten']
                . ' | UNCHANGED ' . $totals['unchanged']
                . ' | SKIPPED ' . $totals['skipped']
                . ' | REMOVED ' . $totals['removed']
                . ' | MISSING ' . $totals['missing']
                . ' | FAILED TABLES ' . $failed,
                'cyan'
            );
        }

        if (!$force && $totals['skipped'] > 0) {
            CLI::write('SAFE publish kept differing application files. Use --force only after review.', 'yellow');
        }
        if ($totals['missing'] > 0) {
            CLI::write('Some staging files are missing. Run php spark mycrud:generate-all --force first.', 'yellow');
        }

        return $failed === 0 ? EXIT_SUCCESS : EXIT_ERROR;
    }
}
