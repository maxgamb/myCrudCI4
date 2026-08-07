<?php

namespace App\Commands;

use App\Libraries\MyCrud\Diagnostics\DiagnosticResult;
use App\Libraries\MyCrud\Diagnostics\ExplainAnalyzer;
use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;

/** Shortcut CLI per il piano di esecuzione delle query lista. */
final class MyCrudExplain extends BaseCommand
{
    protected $group = 'myCrudGpt';
    protected $name = 'mycrud:explain';
    protected $description = 'Esegue EXPLAIN su query rappresentative della lista CRUD.';
    protected $usage = 'mycrud:explain <table> [--per-page 50]';
    protected $arguments = ['table' => 'Tabella da analizzare.'];
    protected $options = ['--per-page' => 'Numero righe della query rappresentativa.'];

    public function run(array $params)
    {
        $table = trim((string) ($params[0] ?? ''));
        if ($table === '') {
            CLI::error('Uso: php spark mycrud:explain nome_tabella');
            return EXIT_ERROR;
        }

        $perPage = (int) (CLI::getOption('per-page') ?: (config('MyCrud')->benchmarkPerPage ?? 50));
        $results = (new ExplainAnalyzer())->analyze($table, $perPage);
        $failed = false;

        CLI::write('myCrudGpt EXPLAIN: ' . $table, 'yellow');
        CLI::newLine();
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
