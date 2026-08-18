<?php

namespace App\Libraries\MyCrud\Diagnostics;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final class GeneratedFileDiagnostics
{
    public function __construct(private readonly ?PhpLintService $lint = null)
    {
    }

    /** @return list<DiagnosticResult> */
    public function inspect(string $root): array
    {
        $results = [];

        if (!is_dir($root)) {
            return [new DiagnosticResult(
                'Generated directory',
                DiagnosticResult::WARN,
                'Il percorso di generazione non esiste ancora.',
                ['path' => $root]
            )];
        }

        $lint = $this->lint ?? new PhpLintService();
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        $phpFiles = 0;

        foreach ($iterator as $fileInfo) {
            if (!$fileInfo->isFile() || strtolower($fileInfo->getExtension()) !== 'php') {
                continue;
            }

            $phpFiles++;
            $path = $fileInfo->getPathname();
            $content = file_get_contents($path);

            if ($content === false) {
                $results[] = new DiagnosticResult(
                    'Generated file: ' . $path,
                    DiagnosticResult::FAIL,
                    'Impossibile leggere il file generated.'
                );
                continue;
            }

            $unresolved = preg_match_all('/\{\{[A-Z0-9_]+\}\}/', $content, $matches) > 0;
            $results[] = new DiagnosticResult(
                'Placeholder risolti: ' . basename($path),
                $unresolved ? DiagnosticResult::FAIL : DiagnosticResult::PASS,
                $unresolved
                    ? 'Sono presenti placeholder non risolti.'
                    : 'No residual placeholder.',
                $unresolved ? ['placeholders' => array_values(array_unique($matches[0]))] : []
            );

            $results[] = $lint->lint($path);
        }

        $results[] = new DiagnosticResult(
            'File PHP generati',
            $phpFiles > 0 ? DiagnosticResult::PASS : DiagnosticResult::WARN,
            $phpFiles > 0
                ? 'Analizzati ' . $phpFiles . ' file PHP.'
                : 'No file PHP presente nel percorso di generazione.'
        );

        return $results;
    }
}
