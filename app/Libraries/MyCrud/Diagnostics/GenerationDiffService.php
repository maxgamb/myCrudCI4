<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Core\CrudConfigurationService;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use Config\MyCrud;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RuntimeException;

/**
 * Confronta il codice che la versione corrente genererebbe con il progetto.
 *
 * La generazione di confronto avviene in writable/ e non modifica né app/
 * né app/Generated/. Il target predefinito è app/, cioè il codice operativo
 * che lo sviluppatore può avere personalizzato dopo la generazione iniziale.
 */
final class GenerationDiffService
{
    public function __construct(
        private readonly ?CrudConfigurationService $configuration = null,
        private readonly ?CrudGeneratorService $generator = null,
        private readonly ?MyCrud $settings = null,
    ) {
    }

    /**
     * @return array<string,mixed>
     */
    public function compare(string $table, string $target = 'app'): array
    {
        $target = strtolower(trim($target));
        if (!in_array($target, ['app', 'generated'], true)) {
            throw new RuntimeException('Target diff non valido. Usa app oppure generated.');
        }

        $configuration = $this->configuration ?? new CrudConfigurationService();
        $resolved = $configuration->resolve($table, true);
        if (!$resolved['saved']) {
            throw new RuntimeException(
                'Configurazione persistente non trovata per ' . $table
                . '. Genera o salva prima il CRUD con la linea 2.8.'
            );
        }

        /** @var MyCrud $settings */
        $settings = $this->settings ?? config('MyCrud');
        $generator = $this->generator ?? new CrudGeneratorService();

        $originalGeneratedPath = $settings->generatedPath;
        $temporaryBase = rtrim(WRITEPATH, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR
            . 'mycrud-diff'
            . DIRECTORY_SEPARATOR
            . preg_replace('/[^a-zA-Z0-9_]/', '_', $table)
            . '-'
            . bin2hex(random_bytes(5))
            . DIRECTORY_SEPARATOR;

        if (!mkdir($temporaryBase, 0755, true) && !is_dir($temporaryBase)) {
            throw new RuntimeException('Impossibile creare il workspace diff: ' . $temporaryBase);
        }

        try {
            // GeneratorTrait legge Config\MyCrud ad ogni scrittura: cambiare
            // temporaneamente generatedPath consente un dry generation reale.
            $settings->generatedPath = $temporaryBase;
            $generator->generate($resolved['config'], true);

            $generatedRoot = $temporaryBase . 'Generated' . DIRECTORY_SEPARATOR;
            $files = $this->collectFiles($generatedRoot);
            $rows = [];
            $summary = [
                'new' => 0,
                'changed' => 0,
                'unchanged' => 0,
            ];

            foreach ($files as $relative => $proposedPath) {
                $currentPath = $target === 'generated'
                    ? APPPATH . 'Generated' . DIRECTORY_SEPARATOR . $relative
                    : APPPATH . $relative;

                if (!is_file($currentPath)) {
                    $status = 'new';
                } else {
                    $status = hash_file('sha256', $proposedPath) === hash_file('sha256', $currentPath)
                        ? 'unchanged'
                        : 'changed';
                }

                $summary[$status]++;
                $rows[$relative] = [
                    'status' => $status,
                    'currentPath' => $currentPath,
                    'proposedPath' => $proposedPath,
                    'currentHash' => is_file($currentPath) ? hash_file('sha256', $currentPath) : null,
                    'proposedHash' => hash_file('sha256', $proposedPath),
                ];
            }

            ksort($rows, SORT_STRING);

            return [
                'table' => $table,
                'target' => $target,
                'generatorVersion' => $settings->version,
                'savedVersion' => $resolved['savedVersion'],
                'schemaDrift' => !empty($resolved['schemaDrift']),
                'configPath' => $resolved['configPath'],
                'summary' => $summary,
                'files' => $rows,
            ];
        } finally {
            $settings->generatedPath = $originalGeneratedPath;
            $this->removeDirectory($temporaryBase);
        }
    }

    /** @return array<string,string> */
    private function collectFiles(string $root): array
    {
        if (!is_dir($root)) {
            return [];
        }

        $files = [];
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($root, RecursiveDirectoryIterator::SKIP_DOTS)
        );

        foreach ($iterator as $file) {
            if (!$file->isFile()) {
                continue;
            }

            $path = $file->getPathname();
            $relative = substr($path, strlen($root));
            $relative = str_replace(DIRECTORY_SEPARATOR, '/', $relative);
            $files[$relative] = $path;
        }

        ksort($files, SORT_STRING);

        return $files;
    }

    private function removeDirectory(string $directory): void
    {
        if (!is_dir($directory)) {
            return;
        }

        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($directory, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );

        foreach ($iterator as $item) {
            if ($item->isDir()) {
                @rmdir($item->getPathname());
            } else {
                @unlink($item->getPathname());
            }
        }

        @rmdir($directory);
    }
}
