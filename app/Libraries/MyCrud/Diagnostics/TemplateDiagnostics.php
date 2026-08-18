<?php

namespace App\Libraries\MyCrud\Diagnostics;

use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;

final class TemplateDiagnostics
{
    /** @return list<DiagnosticResult> */
    public function inspect(?string $root = null): array
    {
        $root ??= APPPATH . 'Libraries/MyCrud/Templates';
        $results = [];

        if (!is_dir($root)) {
            return [new DiagnosticResult(
                'Template directory',
                DiagnosticResult::FAIL,
                'Directory template non trovata: ' . $root
            )];
        }

        $required = [
            'views/create.tpl',
            'views/edit.tpl',
            'views/form.tpl',
            'views/index.tpl',
            'views/filters.tpl',
            'views/table.tpl',
            'views/detail.tpl',
            'views/has_many_panel.tpl',
            'views/trash.tpl',
        ];

        foreach ($required as $relativePath) {
            $path = $root . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativePath);
            $results[] = new DiagnosticResult(
                'Template richiesto: ' . $relativePath,
                is_file($path) ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                is_file($path) ? 'Template presente.' : 'Template mancante.',
                ['path' => $path]
            );
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $fileInfo) {
            if (!$fileInfo->isFile()) {
                continue;
            }

            $path = $fileInfo->getPathname();
            $content = file_get_contents($path);

            if ($content === false) {
                $results[] = new DiagnosticResult(
                    'Template leggibile: ' . $path,
                    DiagnosticResult::FAIL,
                    'Impossibile leggere il template.'
                );
                continue;
            }

            $dangerous = preg_match('/\b(include|include_once|require|require_once)\b/', $content) === 1;
            $results[] = new DiagnosticResult(
                'Template sicuro: ' . basename($path),
                $dangerous ? DiagnosticResult::FAIL : DiagnosticResult::PASS,
                $dangerous
                    ? 'Il template contiene include/require e potrebbe essere eseguito accidentalmente.'
                    : 'No include/require detected.',
                ['path' => $path]
            );

            if (preg_match_all('/\{\{([A-Z0-9_]+)\}\}/', $content, $matches) > 0) {
                $results[] = new DiagnosticResult(
                    'Placeholder template: ' . basename($path),
                    DiagnosticResult::PASS,
                    'Placeholder rilevati e formalmente validi.',
                    ['placeholders' => array_values(array_unique($matches[1]))]
                );
            }
        }

        return $results;
    }
}
