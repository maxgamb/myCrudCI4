<?php

namespace App\Libraries\MyCrud\Generators;

use Config\MyCrud;
use RuntimeException;

trait GeneratorTrait
{
    private function generatedRoot(): string
    {
        /** @var MyCrud $config */
        $config = config('MyCrud');

        return rtrim($config->generatedPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
    }

    private function writeGenerated(
        string $relativePath,
        string $content,
        bool $force
    ): array {
        if (str_contains($relativePath, "\0")) {
            throw new RuntimeException('Percorso di generazione non valido.');
        }

        $relativePath = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, trim($relativePath));
        $relativePath = ltrim($relativePath, DIRECTORY_SEPARATOR);
        $segments = explode(DIRECTORY_SEPARATOR, $relativePath);

        if (
            count($segments) < 2
            || $segments[0] !== 'Generated'
            || in_array('', $segments, true)
            || in_array('.', $segments, true)
            || in_array('..', $segments, true)
        ) {
            throw new RuntimeException(
                'Write blocked: the path must be relative to app/Generated/.'
            );
        }

        $path = $this->generatedRoot() . implode(DIRECTORY_SEPARATOR, $segments);
        $dir  = dirname($path);

        if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
            throw new RuntimeException('Impossibile creare la directory: ' . $dir);
        }

        $exists = is_file($path);

        if ($exists && !$force) {
            return [
                'status' => 'skipped',
                'path'   => $path,
            ];
        }

        $content = $this->formatGeneratedContent($relativePath, $content);

        if (file_put_contents($path, $content, LOCK_EX) === false) {
            throw new RuntimeException('Impossibile scrivere il file: ' . $path);
        }

        return [
            'status' => $exists ? 'overwritten' : 'created',
            'path'   => $path,
        ];
    }

    private function formatGeneratedContent(string $relativePath, string $content): string
    {
        // Keep generated source compact without changing executable structure:
        // trim trailing whitespace and cap vertical spacing at one empty line.
        if (!str_ends_with(strtolower($relativePath), '.php')) {
            return $content;
        }

        $content = preg_replace('/[ \t]+$/m', '', $content) ?? $content;
        $content = preg_replace("/\n{3,}/", "\n\n", $content) ?? $content;

        return rtrim($content) . "\n";
    }

    private function exportArray(array $value, int $indent = 4): string
    {
        return var_export($value, true);
    }
}
