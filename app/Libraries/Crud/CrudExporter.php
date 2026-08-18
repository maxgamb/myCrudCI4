<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

use App\Libraries\Crud\Export\CsvWriter;
use App\Libraries\Crud\Export\WordHtmlWriter;
use CodeIgniter\HTTP\ResponseInterface;
use RuntimeException;

/**
 * Coordina gli export comuni a tutti i CRUD del sito.
 *
 * On the site side, the Controller provides format, fields, and data callbacks; this
 * libreria costruisce intestazioni, file temporanei e download. Il database
 * resta fuori dal runtime di export e continua a essere interrogato dal Model.
 */
final class CrudExporter
{
    public function __construct(
        private readonly CsvWriter $csvWriter = new CsvWriter(),
        private readonly WordHtmlWriter $wordWriter = new WordHtmlWriter(),
    ) {
    }

    /**
     * Punto di ingresso unico per CSV e Word HTML.
     *
     * @param list<string> $fields
     */
    public function download(
        string $format,
        ResponseInterface $response,
        string $filename,
        string $languageGroup,
        array $fields,
        array $filters,
        callable $countProvider,
        callable $rowProvider,
        string|array $primaryKey,
        int $chunkSize = 2000,
        int $maximumRows = 150000,
        int $unfilteredMaximumRows = 0
    ) {
        $format = strtolower(trim($format));
        $headers = $this->headers($languageGroup, $fields);

        return match ($format) {
            'csv' => $this->csv(
                $response,
                $filename,
                $fields,
                $headers,
                $filters,
                $countProvider,
                $rowProvider,
                $primaryKey,
                $chunkSize,
                $maximumRows,
                $unfilteredMaximumRows
            ),
            'word' => $this->word(
                $response,
                $filename,
                $fields,
                $headers,
                $filters,
                $countProvider,
                $rowProvider,
                $primaryKey,
                $chunkSize,
                $maximumRows,
                $unfilteredMaximumRows
            ),
            default => throw new RuntimeException('Unsupported export format.'),
        };
    }

    private function csv(
        ResponseInterface $response,
        string $filename,
        array $fields,
        array $headers,
        array $filters,
        callable $countProvider,
        callable $rowProvider,
        string|array $primaryKey,
        int $chunkSize,
        int $maximumRows,
        int $unfilteredMaximumRows
    ) {
        $total = (int) $countProvider($filters);
        if ($unfilteredMaximumRows > 0 && $filters === [] && $total > $unfilteredMaximumRows) {
            throw new RuntimeException('EXPORT_UNFILTERED_LIMIT:CSV');
        }
        if ($total > $maximumRows) {
            throw new RuntimeException('EXPORT_LIMIT:CSV');
        }

        $temporaryFile = $this->temporaryFile('crud_csv_');
        $handle = fopen($temporaryFile, 'wb');
        if ($handle === false) {
            @unlink($temporaryFile);
            throw new RuntimeException('Impossibile aprire il file CSV temporaneo.');
        }

        try {
            $this->csvWriter->begin($handle, $headers);
            $this->iterateRows($filters, $rowProvider, $primaryKey, $chunkSize, function (array $row) use ($handle, $fields): void {
                $this->csvWriter->row($handle, $fields, $row);
            });
        } finally {
            fclose($handle);
        }

        $this->cleanupAfterResponse($temporaryFile);

        return $response
            ->download($temporaryFile, null)
            ->setFileName($filename . '_' . date('Y-m-d_H-i-s') . '.csv');
    }

    private function word(
        ResponseInterface $response,
        string $filename,
        array $fields,
        array $headers,
        array $filters,
        callable $countProvider,
        callable $rowProvider,
        string|array $primaryKey,
        int $chunkSize,
        int $maximumRows,
        int $unfilteredMaximumRows
    ) {
        $total = (int) $countProvider($filters);
        if ($unfilteredMaximumRows > 0 && $filters === [] && $total > $unfilteredMaximumRows) {
            throw new RuntimeException('EXPORT_UNFILTERED_LIMIT:WORD');
        }
        if ($total > $maximumRows) {
            throw new RuntimeException('EXPORT_LIMIT:WORD');
        }

        $temporaryFile = $this->temporaryFile('crud_word_');
        $handle = fopen($temporaryFile, 'wb');
        if ($handle === false) {
            @unlink($temporaryFile);
            throw new RuntimeException('Impossibile aprire il file Word temporaneo.');
        }

        try {
            $this->wordWriter->begin($handle, $filename, $headers, $filters, $total);
            $this->iterateRows($filters, $rowProvider, $primaryKey, $chunkSize, function (array $row) use ($handle, $fields): void {
                $this->wordWriter->row($handle, $fields, $row);
            });
            $this->wordWriter->end($handle);
        } finally {
            fclose($handle);
        }

        $this->cleanupAfterResponse($temporaryFile);

        return $response
            ->download($temporaryFile, null)
            ->setFileName($filename . '_' . date('Y-m-d_H-i-s') . '.doc')
            ->setHeader('Content-Type', 'application/msword; charset=UTF-8');
    }

    /** @param list<string> $fields @return array<string, string> */
    private function headers(string $languageGroup, array $fields): array
    {
        $headers = [];

        foreach ($fields as $field) {
            $field = (string) $field;
            $translated = lang($languageGroup . '.' . $field);
            $headers[$field] = is_string($translated) && $translated !== ''
                ? $translated
                : $field;
        }

        return $headers;
    }

    private function iterateRows(
        array $filters,
        callable $rowProvider,
        string|array $primaryKey,
        int $chunkSize,
        callable $consumer
    ): void {
        $chunkSize = max(100, min(5000, $chunkSize));
        $cursor = null;

        do {
            $rows = (array) $rowProvider($filters, $chunkSize, $cursor);
            foreach ($rows as $row) {
                if (is_array($row)) {
                    $consumer($row);
                }
            }
            $cursor = $this->nextCursor($rows, $primaryKey);
        } while (count($rows) === $chunkSize && $cursor !== null);
    }

    private function nextCursor(array $rows, string|array $primaryKey): int|string|null
    {
        if ($rows === []) {
            return null;
        }

        $last = end($rows);
        if (!is_array($last)) {
            return null;
        }

        if (is_string($primaryKey)) {
            return isset($last[$primaryKey]) ? $last[$primaryKey] : null;
        }

        $cursor = [];
        foreach ($primaryKey as $key) {
            $key = (string) $key;
            if ($key === '' || !array_key_exists($key, $last)) {
                return null;
            }
            $cursor[$key] = $last[$key];
        }

        return $cursor === [] ? null : json_encode($cursor, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }

    private function temporaryFile(string $prefix): string
    {
        $directory = WRITEPATH . 'cache';
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new RuntimeException('Impossibile creare la directory temporanea.');
        }

        $file = tempnam($directory, $prefix);
        if ($file === false) {
            throw new RuntimeException('Impossibile creare il file temporaneo.');
        }

        return $file;
    }

    private function cleanupAfterResponse(string $file): void
    {
        register_shutdown_function(static function () use ($file): void {
            if (is_file($file)) {
                @unlink($file);
            }
        });
    }
}
