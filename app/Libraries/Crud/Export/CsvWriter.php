<?php

declare(strict_types=1);

namespace App\Libraries\Crud\Export;

/** Scrive il formato CSV comune, incluso BOM UTF-8 e protezione CSV injection. */
final class CsvWriter
{
    /** @param resource $handle */
    public function begin($handle, array $headers): void
    {
        fwrite($handle, "\xEF\xBB\xBF");
        fputcsv($handle, array_values($headers), ';', '"', '');
    }

    /** @param resource $handle */
    public function row($handle, array $fields, array $row): void
    {
        $values = [];
        foreach ($fields as $field) {
            $values[] = $this->safeValue($row[(string) $field] ?? '');
        }
        fputcsv($handle, $values, ';', '"', '');
    }

    private function safeValue(mixed $value): string
    {
        $value = is_scalar($value) || $value === null
            ? (string) $value
            : (json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '');

        return $value !== '' && preg_match('/^[=+\-@]/u', $value) === 1
            ? "'" . $value
            : $value;
    }
}