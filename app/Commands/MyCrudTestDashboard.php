<?php

declare(strict_types=1);

namespace App\Commands;

use App\Libraries\MyCrud\Diagnostics\DashboardRegressionRunner;
use App\Libraries\MyCrud\Diagnostics\DiagnosticResult;
use App\Libraries\MyCrud\MyCrudVersion;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/** Runs structural and runtime regression checks for the generated Dashboard. */
final class MyCrudTestDashboard extends BaseCommand
{
    protected $group = 'myCrudCI4';
    protected $name = 'mycrud:test-dashboard';
    protected $description = 'Tests the generated Dashboard DTO/object boundaries and published runtime.';
    protected $usage = 'mycrud:test-dashboard';

    public function run(array $params)
    {
        if ($params !== []) {
            CLI::write('Dashboard tests are project-wide; table arguments are ignored.', 'yellow');
            CLI::newLine();
        }

        CLI::write('myCrudCI4 ' . MyCrudVersion::VERSION, 'cyan');
        CLI::write('Dashboard regression suite', 'yellow');
        CLI::newLine();

        $report = (new DashboardRegressionRunner())->run();

        foreach ($report->results() as $result) {
            [$symbol, $color] = match ($result->status) {
                DiagnosticResult::PASS => ['✓', 'green'],
                DiagnosticResult::WARN => ['!', 'yellow'],
                DiagnosticResult::FAIL => ['✗', 'red'],
                DiagnosticResult::SKIP => ['↷ SKIP', 'light_gray'],
                default => ['-', 'light_gray'],
            };
            CLI::write($symbol . ' ' . $result->name . ': ' . $result->message, $color);
        }

        $summary = $report->summary();
        CLI::newLine();
        CLI::write(sprintf(
            'PASS %d | WARN %d | FAIL %d | SKIP %d',
            $summary[DiagnosticResult::PASS],
            $summary[DiagnosticResult::WARN],
            $summary[DiagnosticResult::FAIL],
            $summary[DiagnosticResult::SKIP]
        ), $report->hasFailures() ? 'red' : 'green');

        return $report->hasFailures() ? EXIT_ERROR : EXIT_SUCCESS;
    }
}
