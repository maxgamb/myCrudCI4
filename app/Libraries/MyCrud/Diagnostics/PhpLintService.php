<?php

namespace App\Libraries\MyCrud\Diagnostics;

final class PhpLintService
{
    public function lint(string $path): DiagnosticResult
    {
        if (!is_file($path)) {
            return new DiagnosticResult(
                'PHP lint: ' . $path,
                DiagnosticResult::FAIL,
                'File non trovato.'
            );
        }

        if (!function_exists('proc_open')) {
            return new DiagnosticResult(
                'PHP lint: ' . $path,
                DiagnosticResult::SKIP,
                'proc_open() non disponibile; lint esterno non eseguito.'
            );
        }

        $command = escapeshellarg(PHP_BINARY)
            . ' -l '
            . escapeshellarg($path);

        $descriptorSpec = [
            1 => ['pipe', 'w'],
            2 => ['pipe', 'w'],
        ];

        $process = @proc_open($command, $descriptorSpec, $pipes);

        if (!is_resource($process)) {
            return new DiagnosticResult(
                'PHP lint: ' . $path,
                DiagnosticResult::SKIP,
                'Impossibile avviare il processo di lint.'
            );
        }

        $stdout = stream_get_contents($pipes[1]);
        $stderr = stream_get_contents($pipes[2]);
        fclose($pipes[1]);
        fclose($pipes[2]);
        $exitCode = proc_close($process);

        $output = trim((string) $stdout . PHP_EOL . (string) $stderr);

        return new DiagnosticResult(
            'PHP lint: ' . $path,
            $exitCode === 0 ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $exitCode === 0 ? 'Sintassi PHP valida.' : 'Errore di sintassi PHP.',
            ['output' => $output]
        );
    }
}
