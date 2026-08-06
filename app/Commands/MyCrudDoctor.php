<?php

namespace App\Commands;

use App\Libraries\MyCrud\Diagnostics\DiagnosticReport;
use App\Libraries\MyCrud\Diagnostics\DiagnosticResult;
use App\Libraries\MyCrud\Diagnostics\ProjectDiagnostics;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use JsonException;

final class MyCrudDoctor extends BaseCommand
{
    protected $group       = 'myCrudGpt';
    protected $name        = 'mycrud:doctor';
    protected $description = 'Controlla installazione, template e file generati di myCrudGpt.';
    protected $usage       = 'mycrud:doctor [--json] [--report path]';

    protected $options = [
        '--json'   => 'Stampa il report in formato JSON.',
        '--report' => 'Salva anche il report JSON nel percorso indicato.',
    ];

    public function run(array $params)
    {
        $report = (new ProjectDiagnostics())->run();

        $reportPath = CLI::getOption('report');
        if (is_string($reportPath) && $reportPath !== '') {
            $this->writeReport($report, $reportPath);
        }

        if ((bool) CLI::getOption('json')) {
            try {
                CLI::write($report->toJson());
            } catch (JsonException $exception) {
                CLI::error('Impossibile serializzare il report: ' . $exception->getMessage());
                return EXIT_ERROR;
            }
        } else {
            $this->printReport($report);
        }

        return $report->hasFailures() ? EXIT_ERROR : EXIT_SUCCESS;
    }

    private function printReport(DiagnosticReport $report): void
    {
        CLI::write('myCrudGpt Doctor', 'yellow');
        CLI::newLine();

        foreach ($report->results() as $result) {
            [$symbol, $color] = match ($result->status) {
                DiagnosticResult::PASS => ['✓', 'green'],
                DiagnosticResult::WARN => ['!', 'yellow'],
                DiagnosticResult::FAIL => ['✗', 'red'],
                default                => ['-', 'light_gray'],
            };

            CLI::write($symbol . ' ' . $result->name . ': ' . $result->message, $color);

            if ($result->status === DiagnosticResult::FAIL && $result->context !== []) {
                CLI::write('  ' . json_encode($result->context, JSON_UNESCAPED_SLASHES));
            }
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
    }

    private function writeReport(DiagnosticReport $report, string $path): void
    {
        try {
            $directory = dirname($path);
            if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
                CLI::error('Impossibile creare la directory del report: ' . $directory);
                return;
            }

            file_put_contents($path, $report->toJson() . PHP_EOL, LOCK_EX);
            CLI::write('Report salvato in: ' . $path, 'green');
        } catch (JsonException $exception) {
            CLI::error('Impossibile salvare il report: ' . $exception->getMessage());
        }
    }
}
