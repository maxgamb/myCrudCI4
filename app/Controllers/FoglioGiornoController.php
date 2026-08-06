<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\FoglioGiornoModel;
use App\Validation\FoglioGiornoRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/** Controller CRUD basic per foglio_giorno; tutte le query restano nel Model. */
final class FoglioGiornoController extends BaseController
{
    private const EXPORT_FIELDS = array (
  0 => 'foglio_id',
  1 => 'hotel_id',
  2 => 'conto_id',
  3 => 'camera_id',
  4 => 'preno_id',
  5 => 'tipologia_id',
  6 => 'numero_camera',
  7 => 'foglio_prezzo_camera',
  8 => 'date_foglio',
  9 => 'nome_cliente',
  10 => 'cognome_cliente',
  11 => 'in_conto',
  12 => 'out_preno',
  13 => 'stato_camera',
  14 => 'preno_agenzia',
  15 => 'foglio_utente_id',
);
    private const CSV_CHUNK_SIZE = 2000;
    private const CSV_MAXIMUM_ROWS = 150000;
    private const WORD_CHUNK_SIZE = 1000;
    private const WORD_MAXIMUM_ROWS = 50000;

    private FoglioGiornoModel $gateway;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->gateway = new FoglioGiornoModel();
    }

    /** Pagina completa o frammento AJAX della tabella Bootstrap. */
    public function index()
    {
        $filters = $this->getListFilters();
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = $this->getPerPage();
        $sort = trim((string) ($this->request->getGet('sort') ?? 'foglio_id'));
        $direction = strtolower((string) ($this->request->getGet('direction') ?? 'desc')) === 'asc'
            ? 'asc'
            : 'desc';

        $data = $this->listPage($filters, $page, $perPage, $sort, $direction);
        $data['title'] = 'foglio_giorno';
        $data['primaryKey'] = 'foglio_id';
        $data['filters'] = $filters;
        $data['query'] = (array) $this->request->getGet();

        if ($this->request->isAJAX()) {
            return view('foglio_giorno/_table', $data);
        }

        $data['options'] = $this->relationOptions();

        return view('foglio_giorno/index', $data);
    }

    /** Esporta in CSV gli stessi record risultanti dai filtri correnti. */
    public function exportCsv()
    {
        $filters = $this->getListFilters();
        $total = $this->countExportRows($filters);

        if ($total > self::CSV_MAXIMUM_ROWS) {
            return $this->exportLimitRedirect('CSV');
        }

        $temporaryFile = $this->createTemporaryFile('mycrud_csv_');
        $handle = fopen($temporaryFile, 'wb');
        if ($handle === false) {
            @unlink($temporaryFile);
            throw new RuntimeException('Impossibile aprire il file CSV temporaneo.');
        }

        try {
            fwrite($handle, "﻿");
            fputcsv($handle, array_values($this->exportHeaders()), ';', '"', '');

            $cursor = null;
            do {
                $rows = $this->exportRows($filters, self::CSV_CHUNK_SIZE, $cursor);
                foreach ($rows as $row) {
                    $line = [];
                    foreach (self::EXPORT_FIELDS as $field) {
                        $line[] = $this->safeCsvValue($row[$field] ?? '');
                    }
                    fputcsv($handle, $line, ';', '"', '');
                }
                $cursor = $this->nextCursor($rows);
            } while (count($rows) === self::CSV_CHUNK_SIZE && $cursor !== null);
        } finally {
            fclose($handle);
        }

        $this->registerTemporaryFileCleanup($temporaryFile);

        return $this->response
            ->download($temporaryFile, null)
            ->setFileName('foglio_giorno_' . date('Y-m-d_H-i-s') . '.csv');
    }

    /** Esporta un documento HTML compatibile con Microsoft Word. */
    public function exportWord()
    {
        $filters = $this->getListFilters();
        $total = $this->countExportRows($filters);

        if ($total > self::WORD_MAXIMUM_ROWS) {
            return $this->exportLimitRedirect('Word');
        }

        $temporaryFile = $this->createTemporaryFile('mycrud_word_');
        $handle = fopen($temporaryFile, 'wb');
        if ($handle === false) {
            @unlink($temporaryFile);
            throw new RuntimeException('Impossibile aprire il file Word temporaneo.');
        }

        try {
            fwrite($handle, "﻿");
            fwrite($handle, '<!DOCTYPE html><html><head><meta charset="UTF-8">');
            fwrite($handle, '</head><body>');
            fwrite($handle, '<h1>' . $this->wordEscape('foglio_giorno') . '</h1>');
            fwrite($handle, '<p>Esportazione: ' . $this->wordEscape(date('d/m/Y H:i:s')) . '</p>');
            fwrite($handle, '<p>Record: ' . number_format($total, 0, ',', '.') . '</p>');
            fwrite($handle, $this->wordFiltersHtml($filters));
            fwrite($handle, '<table border="1" cellpadding="4" cellspacing="0"><thead><tr>');
            foreach ($this->exportHeaders() as $header) {
                fwrite($handle, '<th>' . $this->wordEscape($header) . '</th>');
            }
            fwrite($handle, '</tr></thead><tbody>');

            $cursor = null;
            do {
                $rows = $this->exportRows($filters, self::WORD_CHUNK_SIZE, $cursor);
                foreach ($rows as $row) {
                    fwrite($handle, '<tr>');
                    foreach (self::EXPORT_FIELDS as $field) {
                        fwrite($handle, '<td>' . $this->wordEscape($row[$field] ?? '') . '</td>');
                    }
                    fwrite($handle, '</tr>');
                }
                $cursor = $this->nextCursor($rows);
            } while (count($rows) === self::WORD_CHUNK_SIZE && $cursor !== null);

            fwrite($handle, '</tbody></table></body></html>');
        } finally {
            fclose($handle);
        }

        $this->registerTemporaryFileCleanup($temporaryFile);

        return $this->response
            ->download($temporaryFile, null)
            ->setFileName('foglio_giorno_' . date('Y-m-d_H-i-s') . '.doc')
            ->setHeader('Content-Type', 'application/msword; charset=UTF-8');
    }

    public function view(int|string $id)
    {
        try {
            $row = $this->findRecord($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('foglio_giorno/view', [
            'title' => 'Dettaglio',
            'row' => $row,
            'children' => $this->loadHasMany($id),
        ]);
    }

    public function create()
    {
        return view('foglio_giorno/create', [
            'title' => 'Nuovo record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => $this->relationOptions(),
            'submissionToken' => $this->createSubmissionToken('store'),
        ]);
    }

    public function store()
    {
        if (!$this->consumeSubmissionToken('store')) {
            return redirect()->back()->withInput()->with('error', 'Il form è già stato inviato oppure è scaduto.');
        }
        if (!$this->validate(FoglioGiornoRules::createRules(), FoglioGiornoRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->sanitizeInput($this->request->getPost(), false);
        unset($data['foglio_id']);

        try {
            $this->createRecord($data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('foglio_giorno'))->with('message', 'Record creato correttamente.');
    }

    public function edit(int|string $id)
    {
        try {
            $row = $this->findRecord($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('foglio_giorno/edit', [
            'title' => 'Modifica record',
            'row' => $row,
            'errors' => session('errors') ?? [],
            'options' => $this->relationOptions(),
            'submissionToken' => $this->createSubmissionToken('update_' . (string) $id),
        ]);
    }

    public function update(int|string $id)
    {
        if (!$this->consumeSubmissionToken('update_' . (string) $id)) {
            return redirect()->back()->withInput()->with('error', 'Il form è già stato inviato oppure è scaduto.');
        }
        if (!$this->validate(FoglioGiornoRules::updateRules($id), FoglioGiornoRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->sanitizeInput($this->request->getPost(), true);
        unset($data['foglio_id']);

        try {
            $this->updateRecord($id, $data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('foglio_giorno'))->with('message', 'Record aggiornato correttamente.');
    }

    public function delete(int|string $id)
    {
        try {
            $this->deleteRecord($id);
        } catch (Throwable $e) {
            return redirect()->to(site_url('foglio_giorno'))->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('foglio_giorno'))->with('message', 'Record eliminato correttamente.');
    }

    private function listPage(array $filters, int $page, int $perPage, string $sort, string $direction): array
    {
        return $this->gateway->getListPage($filters, $page, $perPage, $sort, $direction);
    }

    private function exportRows(array $filters, int $limit, int|string|null $after): array
    {
        return $this->gateway->getCsvRows($filters, $limit, $after);
    }

    private function countExportRows(array $filters): int
    {
        return $this->gateway->countCsvRows($filters);
    }

    private function findRecord(int|string $id): object
    {
        $record = $this->gateway->getDetail($id);
        if (!is_object($record)) {
            throw new RuntimeException('Record non trovato.');
        }
        return $record;
    }

    private function relationOptions(): array
    {
        return $this->gateway->relationOptions();
    }

    private function loadHasMany(int|string $id): array
    {
        return $this->gateway->loadHasMany($id);
    }

    private function createRecord(array $data): int|string
    {
        $id = $this->gateway->insert($data, true);
        if ($id === false) {
            throw new RuntimeException(implode(' ', $this->gateway->errors()) ?: 'Inserimento non riuscito.');
        }
        $this->gateway->clearListCountCache();
        return is_int($id) ? $id : (string) $id;
    }

    private function updateRecord(int|string $id, array $data): void
    {
        if (!$this->gateway->update($id, $data)) {
            throw new RuntimeException(implode(' ', $this->gateway->errors()) ?: 'Aggiornamento non riuscito.');
        }
    }

    private function deleteRecord(int|string $id): void
    {
        if (!$this->gateway->delete($id)) {
            throw new RuntimeException('Eliminazione non riuscita.');
        }
        $this->gateway->clearListCountCache();
    }
    private function getListFilters(): array
    {
        return (array) ($this->request->getGet('filter') ?? []);
    }

    private function getPerPage(): int
    {
        $requested = (int) ($this->request->getGet('perPage') ?? 25);
        $allowed = array_values(array_unique(array_filter([25, 50, 100, 100], static fn (int $value): bool => $value >= 25 && $value <= 100)));

        return in_array($requested, $allowed, true) ? $requested : 25;
    }

    /** @return array<string, string> */
    private function exportHeaders(): array
    {
        return [
            'foglio_id' => lang('FoglioGiorno.foglio_id'),
            'hotel_id' => lang('FoglioGiorno.hotel_id'),
            'conto_id' => lang('FoglioGiorno.conto_id'),
            'camera_id' => lang('FoglioGiorno.camera_id'),
            'preno_id' => lang('FoglioGiorno.preno_id'),
            'tipologia_id' => lang('FoglioGiorno.tipologia_id'),
            'numero_camera' => lang('FoglioGiorno.numero_camera'),
            'foglio_prezzo_camera' => lang('FoglioGiorno.foglio_prezzo_camera'),
            'date_foglio' => lang('FoglioGiorno.date_foglio'),
            'nome_cliente' => lang('FoglioGiorno.nome_cliente'),
            'cognome_cliente' => lang('FoglioGiorno.cognome_cliente'),
            'in_conto' => lang('FoglioGiorno.in_conto'),
            'out_preno' => lang('FoglioGiorno.out_preno'),
            'stato_camera' => lang('FoglioGiorno.stato_camera'),
            'preno_agenzia' => lang('FoglioGiorno.preno_agenzia'),
            'foglio_utente_id' => lang('FoglioGiorno.foglio_utente_id'),
        ];
    }

    private function nextCursor(array $rows): int|string|null
    {
        if ($rows === []) {
            return null;
        }

        $last = end($rows);

        return is_array($last) && isset($last['foglio_id'])
            ? $last['foglio_id']
            : null;
    }

    private function createTemporaryFile(string $prefix): string
    {
        $directory = WRITEPATH . 'cache';
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new RuntimeException('Impossibile creare la directory temporanea.');
        }

        $temporaryFile = tempnam($directory, $prefix);
        if ($temporaryFile === false) {
            throw new RuntimeException('Impossibile creare il file temporaneo.');
        }

        return $temporaryFile;
    }

    private function registerTemporaryFileCleanup(string $temporaryFile): void
    {
        register_shutdown_function(static function () use ($temporaryFile): void {
            if (is_file($temporaryFile)) {
                @unlink($temporaryFile);
            }
        });
    }

    private function exportLimitRedirect(string $format)
    {
        return redirect()->to(site_url('foglio_giorno') . '?' . http_build_query((array) $this->request->getGet()))
            ->with('error', 'Applicare filtri più restrittivi prima di esportare in ' . $format . '.');
    }

    private function safeCsvValue(mixed $value): string
    {
        $value = is_scalar($value) || $value === null
            ? (string) $value
            : (json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '');

        if ($value !== '' && preg_match('/^[=+\-@]/u', $value) === 1) {
            return "'" . $value;
        }

        return $value;
    }

    private function wordEscape(mixed $value): string
    {
        if (!is_scalar($value) && $value !== null) {
            $value = json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?: '';
        }

        return htmlspecialchars((string) $value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }

    private function wordFiltersHtml(array $filters): string
    {
        $items = [];
        foreach ($filters as $field => $value) {
            if (is_array($value)) {
                $value = implode(' - ', array_filter(array_map('strval', $value), static fn (string $item): bool => $item !== ''));
            }
            if (!is_scalar($value) || trim((string) $value) === '') {
                continue;
            }
            $items[] = '<li><strong>' . $this->wordEscape($field) . ':</strong> ' . $this->wordEscape($value) . '</li>';
        }

        return $items === [] ? '' : '<h2>Filtri applicati</h2><ul>' . implode('', $items) . '</ul>';
    }

    private function sanitizeInput(array $data, bool $isUpdate): array
    {
        unset($data['_submission_token']);
        $csrfName = csrf_token();
        if ($csrfName !== '') {
            unset($data[$csrfName]);
        }

        if (!$isUpdate) {
            foreach (array (
  'foglio_data_record' => 'Y-m-d H:i:s',
) as $field => $format) {
                if (!isset($data[$field]) || trim((string) $data[$field]) === '') {
                    $data[$field] = date($format);
                }
            }
        }

        foreach (array_merge(array (
), array (
)) as $field) {
            unset($data[$field]);
        }
        if ($isUpdate) {
            foreach (array (
) as $field) {
                unset($data[$field]);
            }
            foreach (array (
) as $field) {
                if ((string) ($data[$field] ?? '') === '') {
                    unset($data[$field]);
                }
            }
        }

        foreach (array (
) as $field) {
            if (isset($data[$field]) && trim((string) $data[$field]) !== '') {
                $data[$field] = password_hash((string) $data[$field], PASSWORD_DEFAULT);
            }
        }
        return $data;
    }

    private function createSubmissionToken(string $action): string
    {
        $token = bin2hex(random_bytes(16));
        session()->set('mycrud_submission_' . $action . '_' . $token, true);

        return $token;
    }

    private function consumeSubmissionToken(string $action): bool
    {
        $token = trim((string) $this->request->getPost('_submission_token'));
        if ($token === '') {
            return false;
        }

        $key = 'mycrud_submission_' . $action . '_' . $token;
        if (!session()->has($key)) {
            return false;
        }

        session()->remove($key);

        return true;
    }
}
