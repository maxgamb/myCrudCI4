<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AgendaService;
use App\Validation\AgendaRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/** Controller CRUD full per agenda; tutte le query restano nel Model. */
final class AgendaController extends BaseController
{
    private const EXPORT_FIELDS = array (
  0 => 'preno_id',
  1 => 'hotel_id',
  2 => 'preno_in_data',
  3 => 'preno_importo',
  4 => 'preno_impoto_mod',
  5 => 'preno_dal',
  6 => 'preno_al',
  7 => 'preno_n_notti',
  8 => 'preno_arr_ore',
  9 => 'preno_trattamento',
  10 => 't1',
  11 => 'q1',
  12 => 'p1',
  13 => 't2',
  14 => 'q2',
  15 => 'p2',
  16 => 't3',
  17 => 'q3',
  18 => 'p3',
  19 => 't4',
  20 => 'q4',
  21 => 'p4',
  22 => 't5',
  23 => 'q5',
  24 => 'p5',
  25 => 't6',
  26 => 'q6',
  27 => 'p6',
  28 => 'preno_nome',
  29 => 'preno_cogno',
  30 => 'preno_agenzia',
  31 => 'voucher_id',
  32 => 'ota_voucher',
  33 => 'allotment_id',
  34 => 'preno_cc_tip',
  35 => 'preno_cc_n',
  36 => 'preno_cc_scad',
  37 => 'preno_tel',
  38 => 'preno_fax',
  39 => 'preno_email',
  40 => 'preno_mercato',
  41 => 'nazione_iso2',
  42 => 'preno_note',
  43 => 'preno_doc_fax',
  44 => 'preno_doc_email',
  45 => 'preno_doc_form',
  46 => 'preno_doc_mail',
  47 => 'preno_doc_vaglia',
  48 => 'preno_doc_woucher',
  49 => 'preno_pag_modalita',
  50 => 'preno_caparra',
  51 => 'preno_stato',
  52 => 'data_opzione',
  53 => 'cancella_user',
  54 => 'cancella_pass',
  55 => 'agenda_utente_id',
);
    private const CSV_CHUNK_SIZE = 2000;
    private const CSV_MAXIMUM_ROWS = 150000;
    private const WORD_CHUNK_SIZE = 1000;
    private const WORD_MAXIMUM_ROWS = 50000;

    private AgendaService $gateway;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->gateway = new AgendaService();
    }

    /** Pagina completa o frammento AJAX della tabella Bootstrap. */
    public function index()
    {
        $filters = $this->getListFilters();
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = $this->getPerPage();
        $sort = trim((string) ($this->request->getGet('sort') ?? 'preno_id'));
        $direction = strtolower((string) ($this->request->getGet('direction') ?? 'desc')) === 'asc'
            ? 'asc'
            : 'desc';

        $data = $this->listPage($filters, $page, $perPage, $sort, $direction);
        $data['title'] = 'agenda';
        $data['primaryKey'] = 'preno_id';
        $data['filters'] = $filters;
        $data['query'] = (array) $this->request->getGet();

        if ($this->request->isAJAX()) {
            return view('agenda/_table', $data);
        }

        $data['options'] = $this->relationOptions();

        return view('agenda/index', $data);
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
            ->setFileName('agenda_' . date('Y-m-d_H-i-s') . '.csv');
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
            fwrite($handle, '<h1>' . $this->wordEscape('agenda') . '</h1>');
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
            ->setFileName('agenda_' . date('Y-m-d_H-i-s') . '.doc')
            ->setHeader('Content-Type', 'application/msword; charset=UTF-8');
    }

    public function view(int|string $id)
    {
        try {
            $row = $this->findRecord($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('agenda/view', [
            'title' => 'Dettaglio',
            'row' => $row,
            'children' => $this->loadHasMany($id),
        ]);
    }

    public function create()
    {
        return view('agenda/create', [
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
        if (!$this->validate(AgendaRules::createRules(), AgendaRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->sanitizeInput($this->request->getPost(), false);
        unset($data['preno_id']);

        try {
            $this->createRecord($data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('agenda'))->with('message', 'Record creato correttamente.');
    }

    public function edit(int|string $id)
    {
        try {
            $row = $this->findRecord($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('agenda/edit', [
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
        if (!$this->validate(AgendaRules::updateRules($id), AgendaRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->sanitizeInput($this->request->getPost(), true);
        unset($data['preno_id']);

        try {
            $this->updateRecord($id, $data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('agenda'))->with('message', 'Record aggiornato correttamente.');
    }

    public function delete(int|string $id)
    {
        try {
            $this->deleteRecord($id);
        } catch (Throwable $e) {
            return redirect()->to(site_url('agenda'))->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('agenda'))->with('message', 'Record eliminato correttamente.');
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
        $allowed = array_values(array_unique(array_filter([25, 50, 100, 100], static fn (int $value): bool => $value >= 25 && $value <= 100)));

        return in_array($requested, $allowed, true) ? $requested : 25;
    }

    /** @return array<string, string> */
    private function exportHeaders(): array
    {
        return [
            'preno_id' => lang('Agenda.preno_id'),
            'hotel_id' => lang('Agenda.hotel_id'),
            'preno_in_data' => lang('Agenda.preno_in_data'),
            'preno_importo' => lang('Agenda.preno_importo'),
            'preno_impoto_mod' => lang('Agenda.preno_impoto_mod'),
            'preno_dal' => lang('Agenda.preno_dal'),
            'preno_al' => lang('Agenda.preno_al'),
            'preno_n_notti' => lang('Agenda.preno_n_notti'),
            'preno_arr_ore' => lang('Agenda.preno_arr_ore'),
            'preno_trattamento' => lang('Agenda.preno_trattamento'),
            't1' => lang('Agenda.t1'),
            'q1' => lang('Agenda.q1'),
            'p1' => lang('Agenda.p1'),
            't2' => lang('Agenda.t2'),
            'q2' => lang('Agenda.q2'),
            'p2' => lang('Agenda.p2'),
            't3' => lang('Agenda.t3'),
            'q3' => lang('Agenda.q3'),
            'p3' => lang('Agenda.p3'),
            't4' => lang('Agenda.t4'),
            'q4' => lang('Agenda.q4'),
            'p4' => lang('Agenda.p4'),
            't5' => lang('Agenda.t5'),
            'q5' => lang('Agenda.q5'),
            'p5' => lang('Agenda.p5'),
            't6' => lang('Agenda.t6'),
            'q6' => lang('Agenda.q6'),
            'p6' => lang('Agenda.p6'),
            'preno_nome' => lang('Agenda.preno_nome'),
            'preno_cogno' => lang('Agenda.preno_cogno'),
            'preno_agenzia' => lang('Agenda.preno_agenzia'),
            'voucher_id' => lang('Agenda.voucher_id'),
            'ota_voucher' => lang('Agenda.ota_voucher'),
            'allotment_id' => lang('Agenda.allotment_id'),
            'preno_cc_tip' => lang('Agenda.preno_cc_tip'),
            'preno_cc_n' => lang('Agenda.preno_cc_n'),
            'preno_cc_scad' => lang('Agenda.preno_cc_scad'),
            'preno_tel' => lang('Agenda.preno_tel'),
            'preno_fax' => lang('Agenda.preno_fax'),
            'preno_email' => lang('Agenda.preno_email'),
            'preno_mercato' => lang('Agenda.preno_mercato'),
            'nazione_iso2' => lang('Agenda.nazione_iso2'),
            'preno_note' => lang('Agenda.preno_note'),
            'preno_doc_fax' => lang('Agenda.preno_doc_fax'),
            'preno_doc_email' => lang('Agenda.preno_doc_email'),
            'preno_doc_form' => lang('Agenda.preno_doc_form'),
            'preno_doc_mail' => lang('Agenda.preno_doc_mail'),
            'preno_doc_vaglia' => lang('Agenda.preno_doc_vaglia'),
            'preno_doc_woucher' => lang('Agenda.preno_doc_woucher'),
            'preno_pag_modalita' => lang('Agenda.preno_pag_modalita'),
            'preno_caparra' => lang('Agenda.preno_caparra'),
            'preno_stato' => lang('Agenda.preno_stato'),
            'data_opzione' => lang('Agenda.data_opzione'),
            'cancella_user' => lang('Agenda.cancella_user'),
            'cancella_pass' => lang('Agenda.cancella_pass'),
            'agenda_utente_id' => lang('Agenda.agenda_utente_id'),
        ];
    }

    private function nextCursor(array $rows): int|string|null
    {
        if ($rows === []) {
            return null;
        }

        $last = end($rows);

        return is_array($last) && isset($last['preno_id'])
            ? $last['preno_id']
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
        return redirect()->to(site_url('agenda') . '?' . http_build_query((array) $this->request->getGet()))
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
  'cancella_data_record' => 'Y-m-d H:i:s',
  'preno_data_record' => 'Y-m-d H:i:s',
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
