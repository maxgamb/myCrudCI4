<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgendaModel;
use App\Validation\AgendaRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class AgendaController extends BaseController
{
    private AgendaModel $model;

    public function __construct()
    {
        helper([
            'form',
            'url',
        ]);

        $this->model = new AgendaModel();
    }

    /**
     * Elenco principale.
     */
    public function index()
    {
        return view('agenda/index', [
            'title'      => 'agenda',
            'fields'     => array (
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
  53 => 'cancella_data_record',
  54 => 'cancella_user',
  55 => 'cancella_pass',
  56 => 'preno_data_record',
  57 => 'agenda_utente_id',
),
            'primaryKey' => 'preno_id',
        ]);
    }

    /**
     * Endpoint DataTables server-side.
     */
    public function datatable()
    {
        $post = $this->request->getPost();

        $draw = (int) (
            $post['draw']
            ?? 1
        );

        $start = max(
            0,
            (int) (
                $post['start']
                ?? 0
            )
        );

        $length = (int) (
            $post['length']
            ?? 25
        );

        $length = $length < 1
            ? 25
            : min($length, 500);

        $search = trim(
            (string) (
                $post['search']['value']
                ?? ''
            )
        );

        $fields = array (
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
  53 => 'cancella_data_record',
  54 => 'cancella_user',
  55 => 'cancella_pass',
  56 => 'preno_data_record',
  57 => 'agenda_utente_id',
);

        $model = $this->model;

        $builder = $model->datatableBuilder();

        /*
         * Ricerca globale.
         */
        if ($search !== '') {
            $builder->groupStart();

            foreach ($fields as $field) {
                $builder->orLike(
                    'agenda.' . $field,
                    $search
                );
            }

            $builder->groupEnd();
        }

        /*
         * Filtri per colonna.
         */
        foreach (
            (array) (
                $post['columns']
                ?? []
            )
            as $index => $column
        ) {
            $value = trim(
                (string) (
                    $column['search']['value']
                    ?? ''
                )
            );

            if (
                $value !== ''
                && isset($fields[$index])
            ) {
                $builder->like(
                    'agenda.' . $fields[$index],
                    $value
                );
            }
        }

        $recordsTotal = $model->countAll();

        $recordsFiltered = (
            clone $builder
        )->countAllResults(false);

        /*
         * Ordinamento.
         */
        $orderIndex = (int) (
            $post['order'][0]['column']
            ?? 0
        );

        $orderField = $fields[$orderIndex]
            ?? 'preno_id';

        $orderDir = strtolower(
            (string) (
                $post['order'][0]['dir']
                ?? 'asc'
            )
        ) === 'desc'
            ? 'DESC'
            : 'ASC';

        $rows = $builder
            ->orderBy(
                'agenda.' . $orderField,
                $orderDir
            )
            ->limit(
                $length,
                $start
            )
            ->get()
            ->getResult();

        return $this->response->setJSON([
            'draw'            => $draw,
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data'            => $rows,
        ]);
    }

    /**
     * Dettaglio record.
     */
    public function view(int|string $id)
    {
        $row = $this->model->getDetail($id);

        if (!is_object($row)) {
            throw PageNotFoundException::forPageNotFound(
                'Record non trovato.'
            );
        }

        return view('agenda/view', [
            'title' => 'Dettaglio',
            'row'   => $row,
        ]);
    }

    /**
     * Form inserimento.
     */
    public function create()
    {
        $submissionToken =
            $this->createSubmissionToken(
                'store'
            );

        return view('agenda/create', [
            'title'           => 'Nuovo record',
            'row'             => null,
            'errors'          => session('errors') ?? [],
            'options'         => $this->relationOptions(),
            'submissionToken' => $submissionToken,
        ]);
    }

    /**
     * Salvataggio nuovo record.
     */
    public function store()
    {
        if (
            !$this->consumeSubmissionToken(
                'store'
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Il form è già stato inviato oppure è scaduto.'
                );
        }

        if (
            !$this->validate(
                AgendaRules::createRules(),
                AgendaRules::messages()
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $data = $this->sanitizeInput(
            $this->request->getPost(),
            false
        );

        unset(
            $data['preno_id']
        );

        try {
            $this->model->insert($data, true);
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('agenda'))
            ->with(
                'message',
                'Record creato correttamente.'
            );
    }

    /**
     * Form modifica.
     */
    public function edit(int|string $id)
    {
        $row = $this->model->getDetail($id);

        if (!is_object($row)) {
            throw PageNotFoundException::forPageNotFound(
                'Record non trovato.'
            );
        }

        $submissionToken =
            $this->createSubmissionToken(
                'update_' . (string) $id
            );

        return view('agenda/edit', [
            'title'           => 'Modifica record',
            'row'             => $row,
            'errors'          => session('errors') ?? [],
            'options'         => $this->relationOptions(),
            'submissionToken' => $submissionToken,
        ]);
    }

    /**
     * Aggiornamento record.
     */
    public function update(int|string $id)
    {
        if (
            !$this->consumeSubmissionToken(
                'update_' . (string) $id
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    'Il form è già stato inviato oppure è scaduto.'
                );
        }

        if (
            !$this->validate(
                AgendaRules::updateRules($id),
                AgendaRules::messages()
            )
        ) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'errors',
                    $this->validator->getErrors()
                );
        }

        $data = $this->sanitizeInput(
            $this->request->getPost(),
            true
        );

        unset(
            $data['preno_id']
        );

        try {
            $this->model->update($id, $data);
        } catch (Throwable $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with(
                    'error',
                    $e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('agenda'))
            ->with(
                'message',
                'Record aggiornato correttamente.'
            );
    }

    /**
     * Eliminazione normale o soft delete.
     */
    public function delete(int|string $id)
    {
        try {
            $this->model->delete($id);
        } catch (Throwable $e) {
            return redirect()
                ->to(site_url('agenda'))
                ->with(
                    'error',
                    $e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('agenda'))
            ->with(
                'message',
                'Record eliminato correttamente.'
            );
    }

    /**
     * Rimuove campi tecnici, disabled e readonly.
     */
    private function sanitizeInput(
        array $data,
        bool $isUpdate
    ): array {
        unset(
            $data['_submission_token']
        );

        $csrfName = csrf_token();

        if ($csrfName !== '') {
            unset(
                $data[$csrfName]
            );
        }

        $disabledFields =
            array (
);

        $readonlyFields =
            array (
);

        foreach (
            $disabledFields
            as $field
        ) {
            unset(
                $data[$field]
            );
        }

        /*
         * I readonly sono esclusi dall'update
         * perché il valore inviato dal browser
         * può essere comunque alterato.
         */
        if ($isUpdate) {
            foreach (
                $readonlyFields
                as $field
            ) {
                unset(
                    $data[$field]
                );
            }
        }

        return $data;
    }

    /**
     * Crea un token monouso contro il doppio invio.
     */
    private function createSubmissionToken(
        string $action
    ): string {
        $token = bin2hex(
            random_bytes(16)
        );

        $sessionKey =
            'mycrud_submission_'
            . $action
            . '_'
            . $token;

        session()->set(
            $sessionKey,
            true
        );

        return $token;
    }

    /**
     * Consuma il token.
     *
     * Lo stesso form non può essere inviato due volte.
     */
    private function consumeSubmissionToken(
        string $action
    ): bool {
        $token = trim(
            (string) $this->request->getPost(
                '_submission_token'
            )
        );

        if ($token === '') {
            return false;
        }

        $sessionKey =
            'mycrud_submission_'
            . $action
            . '_'
            . $token;

        if (!session()->has($sessionKey)) {
            return false;
        }

        session()->remove(
            $sessionKey
        );

        return true;
    }

    /**
     * Opzioni per le relazioni belongsTo.
     */
    private function relationOptions(): array
    {
        $options = [];

        $rows = db_connect()
            ->table('agenzie')
            ->select([
                'agenzia_id',
                'hotel_id',
            ])
            ->orderBy('hotel_id', 'ASC')
            ->get()
            ->getResult();

        $options['preno_agenzia'] = [];

        foreach ($rows as $option) {
            $options['preno_agenzia'][
                (string) $option->agenzia_id
            ] = (string) $option->hotel_id;
        }

        return $options;
    }
}
