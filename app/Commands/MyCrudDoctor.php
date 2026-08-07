<?php

namespace App\Commands;

use App\Libraries\MyCrud\Diagnostics\CrudBenchmarkRunner;
use App\Libraries\MyCrud\Diagnostics\DiagnosticReport;
use App\Libraries\MyCrud\Diagnostics\DiagnosticResult;
use App\Libraries\MyCrud\Diagnostics\ExplainAnalyzer;
use App\Libraries\MyCrud\Diagnostics\IndexAnalyzer;
use App\Libraries\MyCrud\Diagnostics\ProjectDiagnostics;
use App\Libraries\MyCrud\Diagnostics\PersistentConfigAnalyzer;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use JsonException;
use Throwable;

/**
 * Diagnostica generale o di una singola tabella.
 * Senza argomenti controlla myCrudGpt; con una tabella analizza schema, indici,
 * relazioni e, su richiesta, piano EXPLAIN e benchmark non distruttivo.
 */
final class MyCrudDoctor extends BaseCommand
{
    protected $group       = 'myCrudGpt';
    protected $name        = 'mycrud:doctor';
    protected $description = 'Controlla progetto oppure schema/indici/performance di una tabella.';
    protected $usage       = 'mycrud:doctor [table] [--explain] [--benchmark] [--json] [--report path]';

    protected $arguments = [
        'table' => 'Tabella opzionale da analizzare.',
    ];

    protected $options = [
        '--explain'   => 'Esegue EXPLAIN su query rappresentative della lista.',
        '--benchmark' => 'Esegue benchmark sintetico e non distruttivo.',
        '--json'      => 'Stampa il report in formato JSON.',
        '--report'    => 'Salva anche il report JSON nel percorso indicato.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));

        try {
            $report = $table === ''
                ? (new ProjectDiagnostics())->run()
                : $this->tableReport($table);
        } catch (Throwable $exception) {
            CLI::error($exception->getMessage());
            return EXIT_ERROR;
        }

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
            $this->printReport($report, $table);
        }

        return $report->hasFailures() ? EXIT_ERROR : EXIT_SUCCESS;
    }

    private function tableReport(string $table): DiagnosticReport
    {
        $report = new DiagnosticReport();
        $report->addMany((new PersistentConfigAnalyzer())->analyze($table));
        $report->addMany((new IndexAnalyzer())->analyze($table));

        if ((bool) CLI::getOption('explain')) {
            $report->addMany((new ExplainAnalyzer())->analyze(
                $table,
                (int) (config('MyCrud')->benchmarkPerPage ?? 50)
            ));
        }

        if ((bool) CLI::getOption('benchmark')) {
            $report->addMany((new CrudBenchmarkRunner())->run(
                $table,
                (int) (config('MyCrud')->benchmarkIterations ?? 5),
                (int) (config('MyCrud')->benchmarkPerPage ?? 50)
            ));
        }

        return $report;
    }

    private function printReport(DiagnosticReport $report, string $table = ''): void
    {
        CLI::write($table === '' ? 'myCrudGpt Doctor' : 'myCrudGpt Doctor: ' . $table, 'yellow');
        CLI::newLine();

        foreach ($report->results() as $result) {
            [$symbol, $color] = match ($result->status) {
                DiagnosticResult::PASS => ['✓', 'green'],
                DiagnosticResult::WARN => ['!', 'yellow'],
                DiagnosticResult::FAIL => ['✗', 'red'],
                default                => ['-', 'light_gray'],
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
