<?php

namespace App\Commands;

use App\Libraries\MyCrud\Diagnostics\ArchitectureRegressionRunner;
use App\Libraries\MyCrud\Diagnostics\ConfigurationRegressionRunner;
use App\Libraries\MyCrud\Diagnostics\DiagnosticResult;
use App\Libraries\MyCrud\Diagnostics\DashboardRegressionRunner;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/** Test automatico Basic/Standard/Full in staging temporanei. */
final class MyCrudTestAll extends BaseCommand
{
    protected $group = 'myCrudCI4';
    protected $name = 'mycrud:test-all';
    protected $description = 'Runs Basic/Standard/Full regression tests and the persistent-configuration lifecycle.';
    protected $usage = 'mycrud:test-all <table>';
    protected $arguments = ['table' => 'Table reale usata come schema di test.'];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Uso: php spark mycrud:test-all nome_table');
            return EXIT_ERROR;
        }

        $report = (new ArchitectureRegressionRunner())->run($table);
        $report->addMany((new ConfigurationRegressionRunner())->run($table)->results());
        if (is_file(APPPATH . 'Generated/Services/DashboardService.php')) {
            $report->addMany((new DashboardRegressionRunner())->run()->results());
        }
        CLI::write('myCrudCI4 regression suite: ' . $table, 'yellow');
        CLI::newLine();
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
