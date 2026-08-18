<?php

declare(strict_types=1);

namespace App\Libraries\Crud\Export;

/** Scrive un documento HTML semplice compatibile con Microsoft Word. */
final class WordHtmlWriter
{
    /** @param resource $handle */
    public function begin($handle, string $title, array $headers, array $filters, int $total): void
    {
        fwrite($handle, "\xEF\xBB\xBF");
        fwrite($handle, '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body>');
        fwrite($handle, '<h1>' . $this->escape($title) . '</h1>');
        fwrite($handle, '<p>Esportazione: ' . $this->escape(date('d/m/Y H:i:s')) . '</p>');
        fwrite($handle, '<p>Record: ' . number_format($total, 0, ',', '.') . '</p>');
        fwrite($handle, $this->filtersHtml($filters));
        fwrite($handle, '<table border="1" cellpadding="4" cellspacing="0"><thead><tr>');
        foreach ($headers as $header) {
            fwrite($handle, '<th>' . $this->escape($header) . '</th>');
        }
        fwrite($handle, '</tr></thead><tbody>');
    }

    /** @param resource $handle */
    public function row($handle, array $fields, array $row): void
    {
        fwrite($handle, '<tr>');
        foreach ($fields as $field) {
            fwrite($handle, '<td>' . $this->escape($row[(string) $field] ?? '') . '</td>');
        }
        fwrite($handle, '</tr>');
    }

    /** @param resource $handle */
    public function end($handle): void
    {
        fwrite($handle, '</tbody></table></body></html>');
    }

    private function filtersHtml(array $filters): string
    {
        $items = [];
        foreach ($filters as $index => $filter) {
            if (!is_array($filter)) {
                continue;
            }
            $field = trim((string) ($filter['field'] ?? ''));
            $operator = trim((string) ($filter['operator'] ?? ''));
            $value = trim((string) ($filter['value'] ?? ''));
            $valueTo = trim((string) ($filter['value_to'] ?? ''));
            if ($field === '' || $operator === '') {
                continue;
            }
            $logic = $index > 0 ? strtoupper((string) ($filter['logic'] ?? 'and')) . ' ' : '';
            $shownValue = $valueTo !== '' ? $value . ' - ' . $valueTo : $value;
            $items[] = '<li>' . $this->escape($logic . $field . ' ' . $operator . ' ' . $shownValue) . '</li>';
        }

        return $items === [] ? '' : '<h2>Applied filters</h2><ul>' . implode('', $items) . '</ul>';
    }

    private function escape(mixed $value): string
    {
        if (!is_scalar($value) && $value !== null) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '';
        }

        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
