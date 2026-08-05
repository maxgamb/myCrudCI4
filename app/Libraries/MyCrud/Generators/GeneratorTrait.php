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
        $path = $this->generatedRoot() . ltrim($relativePath, DIRECTORY_SEPARATOR);
        $dir  = dirname($path);

        if (!is_dir($dir) && !mkdir($dir, 0755, true) && !is_dir($dir)) {
            throw new RuntimeException('Impossibile creare la directory: ' . $dir);
        }

        if (is_file($path) && !$force) {
            return [
                'status' => 'skipped',
                'path'   => $path,
            ];
        }

        if (file_put_contents($path, $content, LOCK_EX) === false) {
            throw new RuntimeException('Impossibile scrivere il file: ' . $path);
        }

        return [
            'status' => 'generated',
            'path'   => $path,
        ];
    }

    private function exportArray(array $value, int $indent = 4): string
    {
        return var_export($value, true);
    }
}
