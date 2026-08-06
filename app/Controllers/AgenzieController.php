<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AgenzieService;
use App\Validation\AgenzieRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/** Controller CRUD standard per agenzie; tutte le query restano nel Model. */
final class AgenzieController extends BaseController
{
    private const EXPORT_FIELDS = array (
  0 => 'agenzia_id',
  1 => 'hotel_id',
  2 => 'agenzia_tipologia',
  3 => 'agenzia_nome',
  4 => 'agenzia_via',
  5 => 'agenzia_citta',
  6 => 'agenzia_state',
  7 => 'agenzia_country',
  8 => 'agenzia_cap',
  9 => 'agenzia_tel',
  10 => 'agenzia_fax',
  11 => 'agenzia_email',
  12 => 'agenzia_web',
  13 => 'agenzia_par_iva',
  14 => 'agenzia_par_cf',
  15 => 'agenzia_pec',
  16 => 'agenzia_sid',
  17 => 'agenzia_referente',
  18 => 'agenzia_banca_nome',
  19 => 'agenzia_banca_iban',
  20 => 'agenzia_banca_swift',
  21 => 'agenzia_banca_iata',
  22 => 'agenzia_cc_tipo',
  23 => 'agenzia_cc_nome',
  24 => 'agenzia_cc_numero',
  25 => 'agenzia_cc_scadenza',
  26 => 'agenzia_cc_cod_sicurezza',
  27 => 'agenzia_login',
  28 => 'agenzia_ab_web',
  29 => 'agenzia_ab_affiliati',
  30 => 'agenzia_ad_vis',
  31 => 'agenzia_ab_sospeso',
  32 => 'agenzia_data_record',
  33 => 'agenzie_utente_id',
);
    private const CSV_CHUNK_SIZE = 2000;
    private const CSV_MAXIMUM_ROWS = 150000;
    private const WORD_CHUNK_SIZE = 1000;
    private const WORD_MAXIMUM_ROWS = 50000;

    private AgenzieService $gateway;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->gateway = new AgenzieService();
    }

    /** Pagina completa o frammento AJAX della tabella Bootstrap. */
    public function index()
    {
        $filters = $this->getListFilters();
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = $this->getPerPage();
        $sort = trim((string) ($this->request->getGet('sort') ?? 'agenzia_id'));
        $direction = strtolower((string) ($this->request->getGet('direction') ?? 'desc')) === 'asc'
            ? 'asc'
            : 'desc';

        $data = $this->listPage($filters, $page, $perPage, $sort, $direction);
        $data['title'] = 'agenzie';
        $data['primaryKey'] = 'agenzia_id';
        $data['filters'] = $filters;
        $data['query'] = (array) $this->request->getGet();

        if ($this->request->isAJAX()) {
            return view('agenzie/_table', $data);
        }

        $data['options'] = $this->relationOptions();

        return view('agenzie/index', $data);
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
            ->setFileName('agenzie_' . date('Y-m-d_H-i-s') . '.csv');
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
            fwrite($handle, '<style>body{font-family:Arial,sans-serif;font-size:10pt}table{border-collapse:collapse;width:100%}th,td{border:1px solid #777;padding:4px}th{background:#eee}</style>');
            fwrite($handle, '</head><body>');
            fwrite($handle, '<h1>' . $this->wordEscape('agenzie') . '</h1>');
            fwrite($handle, '<p>Esportazione: ' . $this->wordEscape(date('d/m/Y H:i:s')) . '</p>');
            fwrite($handle, '<p>Record: ' . number_format($total, 0, ',', '.') . '</p>');
            fwrite($handle, $this->wordFiltersHtml($filters));
            fwrite($handle, '<table><thead><tr>');
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
            ->setFileName('agenzie_' . date('Y-m-d_H-i-s') . '.doc')
            ->setHeader('Content-Type', 'application/msword; charset=UTF-8');
    }

    public function view(int|string $id)
    {
        try {
            $row = $this->findRecord($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('agenzie/view', [
            'title' => 'Dettaglio',
            'row' => $row,
            'children' => $this->loadHasMany($id),
        ]);
    }

    public function create()
    {
        return view('agenzie/create', [
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
        if (!$this->validate(AgenzieRules::createRules(), AgenzieRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->sanitizeInput($this->request->getPost(), false);
        unset($data['agenzia_id']);

        try {
            $this->createRecord($data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('agenzie'))->with('message', 'Record creato correttamente.');
    }

    public function edit(int|string $id)
    {
        try {
            $row = $this->findRecord($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('agenzie/edit', [
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
        if (!$this->validate(AgenzieRules::updateRules($id), AgenzieRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->sanitizeInput($this->request->getPost(), true);
        unset($data['agenzia_id']);

        try {
            $this->updateRecord($id, $data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('agenzie'))->with('message', 'Record aggiornato correttamente.');
    }

    public function delete(int|string $id)
    {
        try {
            $this->deleteRecord($id);
        } catch (Throwable $e) {
            return redirect()->to(site_url('agenzie'))->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('agenzie'))->with('message', 'Record eliminato correttamente.');
    }

    private function listPage(array $filters, int $page, int $perPage, string $sort, string $direction): array
    {
        return $this->gateway->listPage($filters, $page, $perPage, $sort, $direction);
    }

    private function exportRows(array $filters, int $limit, int|string|null $after): array
    {
        return $this->gateway->csvRows($filters, $limit, $after);
    }

    private function countExportRows(array $filters): int
    {
        return $this->gateway->countCsvRows($filters);
    }

    private function findRecord(int|string $id): object
    {
        return $this->gateway->find($id);
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
        return $this->gateway->create($data);
    }

    private function updateRecord(int|string $id, array $data): void
    {
        $this->gateway->update($id, $data);
    }

    private function deleteRecord(int|string $id): void
    {
        $this->gateway->delete($id);
    }
    private function getListFilters(): array
    {
        return (array) ($this->request->getGet('filter') ?? []);
    }

    private function getPerPage(): int
    {
        $requested = (int) ($this->request->getGet('perPage') ?? 25);
        $allowed = array_values(array_unique(array_filter([10, 25, 50, 100, 100], static fn (int $value): bool => $value <= 100)));

        return in_array($requested, $allowed, true) ? $requested : 25;
    }

    /** @return array<string, string> */
    private function exportHeaders(): array
    {
        return [
            'agenzia_id' => lang('Fields.agenzia_id'),
            'hotel_id' => lang('Fields.hotel_id'),
            'agenzia_tipologia' => lang('Fields.agenzia_tipologia'),
            'agenzia_nome' => lang('Fields.agenzia_nome'),
            'agenzia_via' => lang('Fields.agenzia_via'),
            'agenzia_citta' => lang('Fields.agenzia_citta'),
            'agenzia_state' => lang('Fields.agenzia_state'),
            'agenzia_country' => lang('Fields.agenzia_country'),
            'agenzia_cap' => lang('Fields.agenzia_cap'),
            'agenzia_tel' => lang('Fields.agenzia_tel'),
            'agenzia_fax' => lang('Fields.agenzia_fax'),
            'agenzia_email' => lang('Fields.agenzia_email'),
            'agenzia_web' => lang('Fields.agenzia_web'),
            'agenzia_par_iva' => lang('Fields.agenzia_par_iva'),
            'agenzia_par_cf' => lang('Fields.agenzia_par_cf'),
            'agenzia_pec' => lang('Fields.agenzia_pec'),
            'agenzia_sid' => lang('Fields.agenzia_sid'),
            'agenzia_referente' => lang('Fields.agenzia_referente'),
            'agenzia_banca_nome' => lang('Fields.agenzia_banca_nome'),
            'agenzia_banca_iban' => lang('Fields.agenzia_banca_iban'),
            'agenzia_banca_swift' => lang('Fields.agenzia_banca_swift'),
            'agenzia_banca_iata' => lang('Fields.agenzia_banca_iata'),
            'agenzia_cc_tipo' => lang('Fields.agenzia_cc_tipo'),
            'agenzia_cc_nome' => lang('Fields.agenzia_cc_nome'),
            'agenzia_cc_numero' => lang('Fields.agenzia_cc_numero'),
            'agenzia_cc_scadenza' => lang('Fields.agenzia_cc_scadenza'),
            'agenzia_cc_cod_sicurezza' => lang('Fields.agenzia_cc_cod_sicurezza'),
            'agenzia_login' => lang('Fields.agenzia_login'),
            'agenzia_ab_web' => lang('Fields.agenzia_ab_web'),
            'agenzia_ab_affiliati' => lang('Fields.agenzia_ab_affiliati'),
            'agenzia_ad_vis' => lang('Fields.agenzia_ad_vis'),
            'agenzia_ab_sospeso' => lang('Fields.agenzia_ab_sospeso'),
            'agenzia_data_record' => lang('Fields.agenzia_data_record'),
            'agenzie_utente_id' => lang('Fields.agenzie_utente_id'),
        ];
    }

    private function nextCursor(array $rows): int|string|null
    {
        if ($rows === []) {
            return null;
        }

        $last = end($rows);

        return is_array($last) && isset($last['agenzia_id'])
            ? $last['agenzia_id']
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
        return redirect()->to(site_url('agenzie') . '?' . http_build_query((array) $this->request->getGet()))
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
  0 => 'agenzia_password',
) as $field) {
                if ((string) ($data[$field] ?? '') === '') {
                    unset($data[$field]);
                }
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
