<?php

namespace App\Commands;

use App\Libraries\MyCrud\Diagnostics\CrudBenchmarkRunner;
use App\Libraries\MyCrud\Diagnostics\DiagnosticResult;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/** Benchmark non distruttivo per dataset grandi. */
final class MyCrudBenchmark extends BaseCommand
{
    protected $group = 'myCrudGpt';
    protected $name = 'mycrud:benchmark';
    protected $description = 'Misura COUNT, prima pagina, pagina profonda e filtro indicizzato.';
    protected $usage = 'mycrud:benchmark <table> [--iterations 5] [--per-page 50]';
    protected $arguments = ['table' => 'Tabella da misurare.'];
    protected $options = [
        '--iterations' => 'Numero di iterazioni per la media.',
        '--per-page' => 'Righe lette per pagina.',
    ];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Uso: php spark mycrud:benchmark nome_tabella');
            return EXIT_ERROR;
        }
        $config = config('MyCrud');
        $iterations = (int) (CLI::getOption('iterations') ?: ($config->benchmarkIterations ?? 5));
        $perPage = (int) (CLI::getOption('per-page') ?: ($config->benchmarkPerPage ?? 50));
        $results = (new CrudBenchmarkRunner())->run($table, $iterations, $perPage);

        CLI::write('myCrudGpt benchmark: ' . $table, 'yellow');
        CLI::newLine();
        $failed = false;
        foreach ($results as $result) {
            $failed = $failed || $result->status === DiagnosticResult::FAIL;
            [$symbol, $color] = match ($result->status) {
                DiagnosticResult::PASS => ['✓', 'green'],
                DiagnosticResult::WARN => ['!', 'yellow'],
                DiagnosticResult::FAIL => ['✗', 'red'],
                default => ['-', 'light_gray'],
            };
            CLI::write($symbol . ' ' . $result->name . ': ' . $result->message, $color);
        }
        return $failed ? EXIT_ERROR : EXIT_SUCCESS;
    }
}
