<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\ClientusService;
use App\Validation\ClientusRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/** Controller CRUD standard per clienti; tutte le query restano nel Model. */
final class ClientusController extends BaseController
{
    private const EXPORT_FIELDS = array (
  0 => 'clienti_id',
  1 => 'preno_id',
  2 => 'hotel_id',
  3 => 'camera_id',
  4 => 'camera_numero',
  5 => 'camara_tipologia',
  6 => 'clienti_nome',
  7 => 'clienti_cogno',
  8 => 'cliente_nato_a',
  9 => 'cliente_nato_il',
  10 => 'cliente_nazione',
  11 => 'cliente_provincia',
  12 => 'cliente_residenza',
  13 => 'cliente_cocumento_tipo',
  14 => 'cliente_cocumento_numero',
  15 => 'cliente_cocumento_rilasciato_il',
  16 => 'cliente_sesso',
  17 => 'clienti_nome1',
  18 => 'clienti_nome2',
  19 => 'clienti_nome3',
  20 => 'clienti_nome4',
  21 => 'clienti_cogno1',
  22 => 'clienti_cogno2',
  23 => 'clienti_cogno3',
  24 => 'clienti_cogno4',
  25 => 'cliente_nato_a1',
  26 => 'cliente_nato_a2',
  27 => 'cliente_nato_a3',
  28 => 'cliente_nato_a4',
  29 => 'cliente_nato_il1',
  30 => 'cliente_nato_il2',
  31 => 'cliente_nato_il3',
  32 => 'cliente_nato_il4',
  33 => 'cliente_sesso1',
  34 => 'cliente_sesso2',
  35 => 'cliente_sesso3',
  36 => 'cliente_sesso4',
  37 => 'cliente_nazione1',
  38 => 'cliente_nazione2',
  39 => 'cliente_nazione3',
  40 => 'cliente_nazione4',
  41 => 'cliente_provincia1',
  42 => 'cliente_provincia2',
  43 => 'cliente_provincia3',
  44 => 'cliente_provincia4',
  45 => 'clienti_cc_tip',
  46 => 'clienti_cc_n',
  47 => 'clienti_cc_scad',
  48 => 'clienti_tel',
  49 => 'clienti_fax',
  50 => 'clienti_email',
  51 => 'clienti_note',
  52 => 'privacy',
  53 => 'marketing',
  54 => 'lingua',
  55 => 'clienti_utente_id',
);
    private const CSV_CHUNK_SIZE = 2000;
    private const CSV_MAXIMUM_ROWS = 150000;
    private const WORD_CHUNK_SIZE = 1000;
    private const WORD_MAXIMUM_ROWS = 50000;

    private ClientusService $gateway;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->gateway = new ClientusService();
    }

    /** Pagina completa o frammento AJAX della tabella Bootstrap. */
    public function index()
    {
        $filters = $this->getListFilters();
        $page = max(1, (int) ($this->request->getGet('page') ?? 1));
        $perPage = $this->getPerPage();
        $sort = trim((string) ($this->request->getGet('sort') ?? 'clienti_id'));
        $direction = strtolower((string) ($this->request->getGet('direction') ?? 'desc')) === 'asc'
            ? 'asc'
            : 'desc';

        $data = $this->listPage($filters, $page, $perPage, $sort, $direction);
        $data['title'] = 'clienti';
        $data['primaryKey'] = 'clienti_id';
        $data['filters'] = $filters;
        $data['query'] = (array) $this->request->getGet();

        if ($this->request->isAJAX()) {
            return view('clienti/_table', $data);
        }

        $data['options'] = $this->relationOptions();

        return view('clienti/index', $data);
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
            ->setFileName('clienti_' . date('Y-m-d_H-i-s') . '.csv');
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
            fwrite($handle, '<h1>' . $this->wordEscape('clienti') . '</h1>');
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
            ->setFileName('clienti_' . date('Y-m-d_H-i-s') . '.doc')
            ->setHeader('Content-Type', 'application/msword; charset=UTF-8');
    }

    public function view(int|string $id)
    {
        try {
            $row = $this->findRecord($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('clienti/view', [
            'title' => 'Dettaglio',
            'row' => $row,
            'children' => $this->loadHasMany($id),
        ]);
    }

    public function create()
    {
        return view('clienti/create', [
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
        if (!$this->validate(ClientusRules::createRules(), ClientusRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->sanitizeInput($this->request->getPost(), false);
        unset($data['clienti_id']);

        try {
            $this->createRecord($data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('clienti'))->with('message', 'Record creato correttamente.');
    }

    public function edit(int|string $id)
    {
        try {
            $row = $this->findRecord($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('clienti/edit', [
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
        if (!$this->validate(ClientusRules::updateRules($id), ClientusRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->sanitizeInput($this->request->getPost(), true);
        unset($data['clienti_id']);

        try {
            $this->updateRecord($id, $data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('clienti'))->with('message', 'Record aggiornato correttamente.');
    }

    public function delete(int|string $id)
    {
        try {
            $this->deleteRecord($id);
        } catch (Throwable $e) {
            return redirect()->to(site_url('clienti'))->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('clienti'))->with('message', 'Record eliminato correttamente.');
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
            'clienti_id' => lang('Clienti.clienti_id'),
            'preno_id' => lang('Clienti.preno_id'),
            'hotel_id' => lang('Clienti.hotel_id'),
            'camera_id' => lang('Clienti.camera_id'),
            'camera_numero' => lang('Clienti.camera_numero'),
            'camara_tipologia' => lang('Clienti.camara_tipologia'),
            'clienti_nome' => lang('Clienti.clienti_nome'),
            'clienti_cogno' => lang('Clienti.clienti_cogno'),
            'cliente_nato_a' => lang('Clienti.cliente_nato_a'),
            'cliente_nato_il' => lang('Clienti.cliente_nato_il'),
            'cliente_nazione' => lang('Clienti.cliente_nazione'),
            'cliente_provincia' => lang('Clienti.cliente_provincia'),
            'cliente_residenza' => lang('Clienti.cliente_residenza'),
            'cliente_cocumento_tipo' => lang('Clienti.cliente_cocumento_tipo'),
            'cliente_cocumento_numero' => lang('Clienti.cliente_cocumento_numero'),
            'cliente_cocumento_rilasciato_il' => lang('Clienti.cliente_cocumento_rilasciato_il'),
            'cliente_sesso' => lang('Clienti.cliente_sesso'),
            'clienti_nome1' => lang('Clienti.clienti_nome1'),
            'clienti_nome2' => lang('Clienti.clienti_nome2'),
            'clienti_nome3' => lang('Clienti.clienti_nome3'),
            'clienti_nome4' => lang('Clienti.clienti_nome4'),
            'clienti_cogno1' => lang('Clienti.clienti_cogno1'),
            'clienti_cogno2' => lang('Clienti.clienti_cogno2'),
            'clienti_cogno3' => lang('Clienti.clienti_cogno3'),
            'clienti_cogno4' => lang('Clienti.clienti_cogno4'),
            'cliente_nato_a1' => lang('Clienti.cliente_nato_a1'),
            'cliente_nato_a2' => lang('Clienti.cliente_nato_a2'),
            'cliente_nato_a3' => lang('Clienti.cliente_nato_a3'),
            'cliente_nato_a4' => lang('Clienti.cliente_nato_a4'),
            'cliente_nato_il1' => lang('Clienti.cliente_nato_il1'),
            'cliente_nato_il2' => lang('Clienti.cliente_nato_il2'),
            'cliente_nato_il3' => lang('Clienti.cliente_nato_il3'),
            'cliente_nato_il4' => lang('Clienti.cliente_nato_il4'),
            'cliente_sesso1' => lang('Clienti.cliente_sesso1'),
            'cliente_sesso2' => lang('Clienti.cliente_sesso2'),
            'cliente_sesso3' => lang('Clienti.cliente_sesso3'),
            'cliente_sesso4' => lang('Clienti.cliente_sesso4'),
            'cliente_nazione1' => lang('Clienti.cliente_nazione1'),
            'cliente_nazione2' => lang('Clienti.cliente_nazione2'),
            'cliente_nazione3' => lang('Clienti.cliente_nazione3'),
            'cliente_nazione4' => lang('Clienti.cliente_nazione4'),
            'cliente_provincia1' => lang('Clienti.cliente_provincia1'),
            'cliente_provincia2' => lang('Clienti.cliente_provincia2'),
            'cliente_provincia3' => lang('Clienti.cliente_provincia3'),
            'cliente_provincia4' => lang('Clienti.cliente_provincia4'),
            'clienti_cc_tip' => lang('Clienti.clienti_cc_tip'),
            'clienti_cc_n' => lang('Clienti.clienti_cc_n'),
            'clienti_cc_scad' => lang('Clienti.clienti_cc_scad'),
            'clienti_tel' => lang('Clienti.clienti_tel'),
            'clienti_fax' => lang('Clienti.clienti_fax'),
            'clienti_email' => lang('Clienti.clienti_email'),
            'clienti_note' => lang('Clienti.clienti_note'),
            'privacy' => lang('Clienti.privacy'),
            'marketing' => lang('Clienti.marketing'),
            'lingua' => lang('Clienti.lingua'),
            'clienti_utente_id' => lang('Clienti.clienti_utente_id'),
        ];
    }

    private function nextCursor(array $rows): int|string|null
    {
        if ($rows === []) {
            return null;
        }

        $last = end($rows);

        return is_array($last) && isset($last['clienti_id'])
            ? $last['clienti_id']
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
        return redirect()->to(site_url('clienti') . '?' . http_build_query((array) $this->request->getGet()))
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
  'clienti_data_record' => 'Y-m-d H:i:s',
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
  0 => 'password',
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
