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
 * né app/Generated/. Il report distingue i file propri del CRUD dai file
 * infrastrutturali condivisi e può fornire il numero di righe aggiunte/rimosse.
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
            $summary = $this->emptySummary();
            $summaryByCategory = [
                'crud' => $this->emptySummary(),
                'shared' => $this->emptySummary(),
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

                $category = $this->classifyFile($relative);
                $summary[$status]++;
                $summaryByCategory[$category][$status]++;

                $details = ['added' => 0, 'removed' => 0];
                if ($status !== 'unchanged') {
                    $details = $this->lineChangeStats(
                        is_file($currentPath) ? $currentPath : null,
                        $proposedPath
                    );
                }

                $rows[$relative] = [
                    'status' => $status,
                    'category' => $category,
                    'currentPath' => $currentPath,
                    'proposedPath' => $proposedPath,
                    'currentHash' => is_file($currentPath) ? hash_file('sha256', $currentPath) : null,
                    'proposedHash' => hash_file('sha256', $proposedPath),
                    'details' => $details,
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
                'summaryByCategory' => $summaryByCategory,
                'files' => $rows,
            ];
        } finally {
            $settings->generatedPath = $originalGeneratedPath;
            $this->removeDirectory($temporaryBase);
        }
    }

    /** @return array{new:int,changed:int,unchanged:int} */
    private function emptySummary(): array
    {
        return [
            'new' => 0,
            'changed' => 0,
            'unchanged' => 0,
        ];
    }

    /**
     * I file condivisi appartengono all'infrastruttura runtime e possono essere
     * usati da più CRUD. Tutto il resto è considerato specifico del CRUD.
     */
    private function classifyFile(string $relative): string
    {
        $relative = str_replace('\\', '/', $relative);

        if ($relative === 'Controllers/Api/BaseApiController.php') {
            return 'shared';
        }

        foreach ([
            'Libraries/Crud/',
            'Views/Pagers/',
            'Views/layouts/',
            'Config/',
        ] as $prefix) {
            if (str_starts_with($relative, $prefix)) {
                return 'shared';
            }
        }

        return 'crud';
    }

    /**
     * Restituisce quante righe sarebbero aggiunte e rimosse.
     * Usa la lunghezza della longest common subsequence per restare
     * indipendente dal comando shell `diff` e funzionare anche fuori Linux.
     *
     * @return array{added:int,removed:int}
     */
    private function lineChangeStats(?string $currentPath, string $proposedPath): array
    {
        $proposed = file($proposedPath, FILE_IGNORE_NEW_LINES);
        $proposed = is_array($proposed) ? $proposed : [];

        if ($currentPath === null || !is_file($currentPath)) {
            return [
                'added' => count($proposed),
                'removed' => 0,
            ];
        }

        $current = file($currentPath, FILE_IGNORE_NEW_LINES);
        $current = is_array($current) ? $current : [];

        if ($current === $proposed) {
            return ['added' => 0, 'removed' => 0];
        }

        $lcs = $this->lcsLength($current, $proposed);

        return [
            'added' => max(0, count($proposed) - $lcs),
            'removed' => max(0, count($current) - $lcs),
        ];
    }

    /**
     * Calcola la LCS usando due sole righe della matrice dinamica.
     * La memoria resta quindi proporzionale al file più corto.
     *
     * @param list<string> $left
     * @param list<string> $right
     */
    private function lcsLength(array $left, array $right): int
    {
        if ($left === [] || $right === []) {
            return 0;
        }

        // Mantiene la seconda dimensione più corta per ridurre la memoria.
        if (count($right) > count($left)) {
            [$left, $right] = [$right, $left];
        }

        $columns = count($right);
        $previous = array_fill(0, $columns + 1, 0);

        foreach ($left as $leftLine) {
            $current = array_fill(0, $columns + 1, 0);

            for ($column = 1; $column <= $columns; $column++) {
                if ($leftLine === $right[$column - 1]) {
                    $current[$column] = $previous[$column - 1] + 1;
                } else {
                    $current[$column] = max($previous[$column], $current[$column - 1]);
                }
            }

            $previous = $current;
        }

        return $previous[$columns];
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
