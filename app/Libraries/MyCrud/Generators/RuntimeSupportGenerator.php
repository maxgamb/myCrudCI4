<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/**
 * Genera le librerie runtime condivise dai CRUD del sito.
 *
 * Questi file NON dipendono da myCrudGpt a runtime: vengono scritti sotto
 * App\Libraries\Crud e continuano a funzionare anche dopo la rimozione del
 * generatore dall'applicazione.
 */
final class RuntimeSupportGenerator
{
    use GeneratorTrait;

    /** @return array<string, mixed> */
    public function generate(bool $force = false): array
    {
        return [
            'list_request' => $this->writeGenerated(
                'Generated/Libraries/Crud/CrudListRequest.php',
                $this->listRequestContent(),
                $force
            ),
            'submission_guard' => $this->writeGenerated(
                'Generated/Libraries/Crud/SubmissionGuard.php',
                $this->submissionGuardContent(),
                $force
            ),
            'input_processor' => $this->writeGenerated(
                'Generated/Libraries/Crud/CrudInputProcessor.php',
                $this->inputProcessorContent(),
                $force
            ),
            'exporter' => $this->writeGenerated(
                'Generated/Libraries/Crud/CrudExporter.php',
                $this->exporterContent(),
                $force
            ),
            'csv_writer' => $this->writeGenerated(
                'Generated/Libraries/Crud/Export/CsvWriter.php',
                $this->csvWriterContent(),
                $force
            ),
            'word_writer' => $this->writeGenerated(
                'Generated/Libraries/Crud/Export/WordHtmlWriter.php',
                $this->wordWriterContent(),
                $force
            ),
        ];
    }

    private function listRequestContent(): string
    {
        return <<<'PHP'
<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

use CodeIgniter\HTTP\IncomingRequest;

/**
 * Normalizza i parametri comuni dell'elenco CRUD.
 *
 * Lato sito: Controller diversi condividono la stessa lettura di filtri,
 * pagina, righe per pagina e ordinamento. La whitelist effettiva di campi e
 * operatori resta nel Model, che è l'unico livello autorizzato a comporre query.
 */
final class CrudListRequest
{
    /** @param list<array{field:string,operator:string,value:mixed,value_to:mixed,logic:string}> $filters */
    private function __construct(
        public readonly array $filters,
        public readonly int $page,
        public readonly int $perPage,
        public readonly string $sort,
        public readonly string $direction,
        public readonly array $query,
    ) {
    }

    /** @param list<int> $allowedPerPage */
    public static function fromRequest(
        IncomingRequest $request,
        string $defaultSort,
        array $allowedPerPage = [25, 50, 100],
        array $simpleFilterFields = []
    ): self {
        $allowedPerPage = array_values(array_unique(array_map('intval', $allowedPerPage)));
        $allowedPerPage = array_values(array_filter(
            $allowedPerPage,
            static fn (int $value): bool => $value > 0 && $value <= 500
        ));
        if ($allowedPerPage === []) {
            $allowedPerPage = [25, 50, 100];
        }

        $requestedPerPage = (int) ($request->getGet('perPage') ?? $allowedPerPage[0]);
        $perPage = in_array($requestedPerPage, $allowedPerPage, true)
            ? $requestedPerPage
            : $allowedPerPage[0];

        $direction = strtolower((string) ($request->getGet('direction') ?? 'desc')) === 'asc'
            ? 'asc'
            : 'desc';

        $query = (array) $request->getGet();
        $filters = self::normalizeFilters((array) ($query['filters'] ?? []));
        $filters = array_merge($filters, self::normalizeSimpleFilters($query, $simpleFilterFields));

        return new self(
            filters: $filters,
            page: max(1, (int) ($query['page'] ?? 1)),
            perPage: $perPage,
            sort: trim((string) ($query['sort'] ?? $defaultSort)) ?: $defaultSort,
            direction: $direction,
            query: $query,
        );
    }

    /**
     * Converte la forma corta `?campo=valore` nello stesso filtro `eq` usato
     * dal motore dinamico. La whitelist viene generata dal CRUD e comprende
     * solo campi realmente filtrabili; i parametri vuoti vengono ignorati.
     *
     * @param array<string,mixed> $query
     * @param list<string> $allowedFields
     * @return list<array{field:string,operator:string,value:mixed,value_to:mixed,logic:string}>
     */
    private static function normalizeSimpleFilters(array $query, array $allowedFields): array
    {
        $allowed = array_fill_keys(array_values(array_unique(array_map('strval', $allowedFields))), true);
        if ($allowed === []) {
            return [];
        }

        $normalized = [];
        foreach ($query as $field => $value) {
            $field = (string) $field;
            if (!isset($allowed[$field]) || is_array($value) || $value === null) {
                continue;
            }

            $value = (string) $value;
            if ($value === '') {
                continue;
            }

            $normalized[] = [
                'field' => $field,
                'operator' => 'eq',
                'value' => $value,
                'value_to' => null,
                'logic' => 'and',
            ];
        }

        return $normalized;
    }

    /**
     * Mantiene solo la forma strutturale dei filtri. Non considera attendibili
     * campo e operatore: la validazione semantica viene eseguita dal Model.
     *
     * @return list<array{field:string,operator:string,value:mixed,value_to:mixed,logic:string}>
     */
    private static function normalizeFilters(array $filters): array
    {
        $normalized = [];

        foreach ($filters as $filter) {
            if (!is_array($filter)) {
                continue;
            }

            $field = trim((string) ($filter['field'] ?? ''));
            $operator = trim((string) ($filter['operator'] ?? ''));
            if ($field === '' || $operator === '') {
                continue;
            }

            $normalized[] = [
                'field' => $field,
                'operator' => $operator,
                'value' => $filter['value'] ?? null,
                'value_to' => $filter['value_to'] ?? null,
                'logic' => strtolower((string) ($filter['logic'] ?? 'and')) === 'or' ? 'or' : 'and',
            ];
        }

        return $normalized;
    }
}
PHP;
    }

    private function submissionGuardContent(): string
    {
        return <<<'PHP'
<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

/**
 * Protegge i form CRUD dal doppio invio accidentale.
 * Ogni token è monouso e viene eliminato dalla sessione al primo consumo.
 */
final class SubmissionGuard
{
    public function create(string $action): string
    {
        $token = bin2hex(random_bytes(16));
        session()->set($this->key($action, $token), true);

        return $token;
    }

    public function consume(string $action, mixed $token): bool
    {
        $token = trim((string) $token);
        if ($token === '') {
            return false;
        }

        $key = $this->key($action, $token);
        if (!session()->has($key)) {
            return false;
        }

        session()->remove($key);

        return true;
    }

    private function key(string $action, string $token): string
    {
        return 'crud_submission_' . sha1($action) . '_' . $token;
    }
}
PHP;
    }

    private function inputProcessorContent(): string
    {
        return <<<'PHP'
<?php

declare(strict_types=1);

namespace App\Libraries\Crud;

/**
 * Esegue la normalizzazione meccanica dei dati provenienti dai form CRUD.
 *
 * Non contiene regole di business: rimuove campi infrastrutturali, gestisce
 * date automatiche, campi readonly/managed e password configurate come tali.
 */
final class CrudInputProcessor
{
    public function process(
        array $data,
        bool $isUpdate,
        array $automaticDateFields = [],
        array $disabledFields = [],
        array $managedFields = [],
        array $readonlyFields = [],
        array $passwordFields = [],
        bool $hashPasswords = false
    ): array {
        unset($data['_submission_token'], $data['_context'], $data['_related'], $data['_related_new']);

        $csrfName = csrf_token();
        if ($csrfName !== '') {
            unset($data[$csrfName]);
        }

        // Le select AJAX inviano anche una label di supporto per ripopolare il
        // form dopo errori di validazione. Il database deve ricevere solo l'ID.
        foreach (array_keys($data) as $field) {
            if (str_ends_with((string) $field, '__label')) {
                unset($data[$field]);
            }
        }

        if (!$isUpdate) {
            foreach ($automaticDateFields as $field => $format) {
                if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                    $data[$field] = date((string) $format);
                }
            }
        }

        foreach (array_unique(array_merge($disabledFields, $managedFields)) as $field) {
            unset($data[(string) $field]);
        }

        if ($isUpdate) {
            foreach ($readonlyFields as $field) {
                unset($data[(string) $field]);
            }
            foreach ($passwordFields as $field) {
                if (trim((string) ($data[$field] ?? '')) === '') {
                    unset($data[$field]);
                }
            }
        }

        if ($hashPasswords) {
            foreach ($passwordFields as $field) {
                if (isset($data[$field]) && trim((string) $data[$field]) !== '') {
                    $data[$field] = password_hash((string) $data[$field], PASSWORD_DEFAULT);
                }
            }
        }

        return $data;
    }
}
PHP;
    }

    private function exporterContent(): string
    {
        return <<<'PHP'
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
 * Lato sito: il Controller indica formato, campi e callback dati; questa
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
            default => throw new RuntimeException('Formato export non supportato.'),
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
PHP;
    }

    private function csvWriterContent(): string
    {
        return <<<'PHP'
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
PHP;
    }

    private function wordWriterContent(): string
    {
        return <<<'PHP'
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

        return $items === [] ? '' : '<h2>Filtri applicati</h2><ul>' . implode('', $items) . '</ul>';
    }

    private function escape(mixed $value): string
    {
        if (!is_scalar($value) && $value !== null) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '';
        }

        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
PHP;
    }
}
