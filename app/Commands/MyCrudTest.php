<?php

namespace App\Commands;

use App\Libraries\MyCrud\Diagnostics\DiagnosticReport;
use App\Libraries\MyCrud\Diagnostics\DiagnosticResult;
use App\Libraries\MyCrud\Diagnostics\GenerationTestRunner;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use JsonException;

final class MyCrudTest extends BaseCommand
{
    protected $group       = 'myCrudGpt';
    protected $name        = 'mycrud:test';
    protected $description = 'Genera e verifica un CRUD 2.7.3 su una tabella reale.';
    protected $usage       = 'mycrud:test <table> [--no-force] [--json] [--report path]';

    protected $arguments = [
        'table' => 'Tabella da usare per il test di generazione.',
    ];

    protected $options = [
        '--no-force' => 'Non sovrascrive i file già presenti nel percorso di generazione.',
        '--json'     => 'Stampa il report JSON.',
        '--report'   => 'Salva il report JSON nel percorso indicato.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));

        if ($table === '') {
            CLI::error('Specificare la tabella: php spark mycrud:test nome_tabella');
            return EXIT_ERROR;
        }

        $report = (new GenerationTestRunner())->run(
            $table,
            !(bool) CLI::getOption('no-force')
        );

        $reportPath = CLI::getOption('report');
        if (is_string($reportPath) && $reportPath !== '') {
            try {
                $directory = dirname($reportPath);
                if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
                    CLI::error('Impossibile creare la directory del report: ' . $directory);
                } else {
                    file_put_contents($reportPath, $report->toJson() . PHP_EOL, LOCK_EX);
                }
            } catch (JsonException $exception) {
                CLI::error('Errore report JSON: ' . $exception->getMessage());
            }
        }

        if ((bool) CLI::getOption('json')) {
            try {
                CLI::write($report->toJson());
            } catch (JsonException $exception) {
                CLI::error($exception->getMessage());
                return EXIT_ERROR;
            }
        } else {
            $this->printReport($report, $table);
        }

        return $report->hasFailures() ? EXIT_ERROR : EXIT_SUCCESS;
    }

    private function printReport(DiagnosticReport $report, string $table): void
    {
        CLI::write('myCrudGpt generation test: ' . $table, 'yellow');
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
}
