<?php

namespace App\Commands;

use App\Libraries\MyCrud\Diagnostics\ArchitectureRegressionRunner;
use App\Libraries\MyCrud\Diagnostics\ConfigurationRegressionRunner;
use App\Libraries\MyCrud\Diagnostics\DiagnosticResult;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/** Test automatico Basic/Standard/Full in staging temporanei. */
final class MyCrudTestAll extends BaseCommand
{
    protected $group = 'myCrudGpt';
    protected $name = 'mycrud:test-all';
    protected $description = 'Esegue i test di regressione Basic/Standard/Full e del ciclo configurazioni persistenti 2.8.';
    protected $usage = 'mycrud:test-all <table>';
    protected $arguments = ['table' => 'Tabella reale usata come schema di test.'];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Uso: php spark mycrud:test-all nome_tabella');
            return EXIT_ERROR;
        }

        $report = (new ArchitectureRegressionRunner())->run($table);
        $report->addMany((new ConfigurationRegressionRunner())->run($table)->results());
        CLI::write('myCrudGpt regression suite: ' . $table, 'yellow');
        CLI::newLine();
        foreach ($report->results() as $result) {
            [$symbol, $color] = match ($result->status) {
                DiagnosticResult::PASS => ['✓', 'green'],
                DiagnosticResult::WARN => ['!', 'yellow'],
                DiagnosticResult::FAIL => ['✗', 'red'],
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
