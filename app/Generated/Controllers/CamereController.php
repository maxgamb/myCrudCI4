<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\CamereService;
use App\Validation\CamereRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class CamereController extends BaseController
{
    private CamereService $service;

    public function __construct()
    {
        helper([
            'form',
            'url',
        ]);

        $this->service = new CamereService();
    }

    /**
     * Elenco principale.
     */
    public function index()
    {
        return view('camere/index', [
            'title'      => 'camere',
            'fields'     => array (
  0 => 'camera_id',
  1 => 'hotel_id',
  2 => 'numero_camera',
  3 => 'tipologia_camera',
  4 => 'tipologia_id',
  5 => 'camere_max_pax',
  6 => 'camere_metri_quadri',
  7 => 'camere_vista',
  8 => 'camere_piano',
  9 => 'camere_bagno',
  10 => 'camere_edificio',
  11 => 'review_tot',
  12 => 'camere_data_record',
  13 => 'camere_utente_id',
),
            'primaryKey' => 'camera_id',
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
  0 => 'camera_id',
  1 => 'hotel_id',
  2 => 'numero_camera',
  3 => 'tipologia_camera',
  4 => 'tipologia_id',
  5 => 'camere_max_pax',
  6 => 'camere_metri_quadri',
  7 => 'camere_vista',
  8 => 'camere_piano',
  9 => 'camere_bagno',
  10 => 'camere_edificio',
  11 => 'review_tot',
  12 => 'camere_data_record',
  13 => 'camere_utente_id',
);

        $model = $this->service->model();

        $builder = $model->datatableBuilder();

        /*
         * Ricerca globale.
         */
        if ($search !== '') {
            $builder->groupStart();

            foreach ($fields as $field) {
                $builder->orLike(
                    'camere.' . $field,
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
                    'camere.' . $fields[$index],
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
            ?? 'camera_id';

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
                'camere.' . $orderField,
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
        $row = $this->service->find($id);

        if (!is_object($row)) {
            throw PageNotFoundException::forPageNotFound(
                'Record non trovato.'
            );
        }

        $hasManyConfig = array (
  'conti__camera_id' => 
  array (
    'enabled' => true,
    'mode' => 'readonly',
    'title' => 'Conti',
    'icon' => 'bi-diagram-3',
    'childTable' => 'conti',
    'foreignKey' => 'camera_id',
    'parentKey' => 'camera_id',
    'primaryKey' => 'conto_id',
    'columns' => 
    array (
      0 => 'conto_id',
      1 => 'hotel_id',
      2 => 'foglio_id',
      3 => 'clienti_id',
      4 => 'in_conto',
      5 => 'in_conto_time',
    ),
    'displayField' => 'trattamento_sog',
    'limit' => 20,
    'showCount' => true,
    'showViewButton' => true,
  ),
  'foglio_giorno__camera_id' => 
  array (
    'enabled' => true,
    'mode' => 'readonly',
    'title' => 'Foglio Giorno',
    'icon' => 'bi-diagram-3',
    'childTable' => 'foglio_giorno',
    'foreignKey' => 'camera_id',
    'parentKey' => 'camera_id',
    'primaryKey' => 'foglio_id',
    'columns' => 
    array (
      0 => 'foglio_id',
      1 => 'hotel_id',
      2 => 'conto_id',
      3 => 'preno_id',
      4 => 'tipologia_id',
      5 => 'numero_camera',
    ),
    'displayField' => 'date_foglio',
    'limit' => 20,
    'showCount' => true,
    'showViewButton' => true,
  ),
  'guasti__camera_id' => 
  array (
    'enabled' => true,
    'mode' => 'readonly',
    'title' => 'Guasti',
    'icon' => 'bi-diagram-3',
    'childTable' => 'guasti',
    'foreignKey' => 'camera_id',
    'parentKey' => 'camera_id',
    'primaryKey' => 'guasto_id',
    'columns' => 
    array (
      0 => 'guasto_id',
      1 => 'hotel_id',
      2 => 'guasto_priorita',
      3 => 'guasto_area',
      4 => 'guasto_piano',
      5 => 'guasto_note',
    ),
    'displayField' => 'guasto_area',
    'limit' => 20,
    'showCount' => true,
    'showViewButton' => true,
  ),
);
        $children = [];

        if (!empty($hasManyConfig)) {
            $children = $this->service->loadHasMany($id, $hasManyConfig);
        }

        return view('camere/view', [
            'title' => 'Dettaglio',
            'row' => $row,
            'children' => $children,
            'hasManyConfig' => $hasManyConfig,
        ]);
    }

    public function create()
    {
        $submissionToken =
            $this->createSubmissionToken(
                'store'
            );

        return view('camere/create', [
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
                CamereRules::createRules(),
                CamereRules::messages()
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
            $data['camera_id']
        );

        try {
            $this->service->create($data);
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
            ->to(site_url('camere'))
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
        $row = $this->service->find($id);

        if (!is_object($row)) {
            throw PageNotFoundException::forPageNotFound(
                'Record non trovato.'
            );
        }

        $submissionToken =
            $this->createSubmissionToken(
                'update_' . (string) $id
            );

        return view('camere/edit', [
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
                CamereRules::updateRules($id),
                CamereRules::messages()
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
            $data['camera_id']
        );

        try {
            $this->service->update($id, $data);
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
            ->to(site_url('camere'))
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
            $this->service->delete($id);
        } catch (Throwable $e) {
            return redirect()
                ->to(site_url('camere'))
                ->with(
                    'error',
                    $e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('camere'))
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
            ->table('tipologia_camera')
            ->select([
                'tipologia_id',
                'nome_tipologia',
            ])
            ->orderBy('nome_tipologia', 'ASC')
            ->get()
            ->getResult();

        $options['tipologia_id'] = [];

        foreach ($rows as $option) {
            $options['tipologia_id'][
                (string) $option->tipologia_id
            ] = (string) $option->nome_tipologia;
        }

        return $options;
    }
}
