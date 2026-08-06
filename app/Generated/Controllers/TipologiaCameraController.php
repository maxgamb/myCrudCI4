<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\TipologiaCameraService;
use App\Validation\TipologiaCameraRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class TipologiaCameraController extends BaseController
{
    private TipologiaCameraService $service;

    public function __construct()
    {
        helper([
            'form',
            'url',
        ]);

        $this->service = new TipologiaCameraService();
    }

    /**
     * Elenco principale.
     */
    public function index()
    {
        return view('tipologia_camera/index', [
            'title'      => 'tipologia_camera',
            'fields'     => array (
  0 => 'tipologia_id',
  1 => 'nome_tipologia',
  2 => 'nome_tipologia_en',
  3 => 'nome_tipologia_fr',
  4 => 'nome_tipologia_de',
  5 => 'nome_tipologia_sp',
  6 => 'nome_tipologia_jp',
  7 => 'tipologia_sigla',
  8 => 'numero_pax',
  9 => 'tipologia_camera_data_record',
  10 => 'tipologia_camera_utente_id',
  11 => 'perc_prezzo',
),
            'primaryKey' => 'tipologia_id',
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
  0 => 'tipologia_id',
  1 => 'nome_tipologia',
  2 => 'nome_tipologia_en',
  3 => 'nome_tipologia_fr',
  4 => 'nome_tipologia_de',
  5 => 'nome_tipologia_sp',
  6 => 'nome_tipologia_jp',
  7 => 'tipologia_sigla',
  8 => 'numero_pax',
  9 => 'tipologia_camera_data_record',
  10 => 'tipologia_camera_utente_id',
  11 => 'perc_prezzo',
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
                    'tipologia_camera.' . $field,
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
                    'tipologia_camera.' . $fields[$index],
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
            ?? 'tipologia_id';

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
                'tipologia_camera.' . $orderField,
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
  'camere__tipologia_id' => 
  array (
    'enabled' => true,
    'mode' => 'readonly',
    'title' => 'Camere',
    'icon' => 'bi-diagram-3',
    'childTable' => 'camere',
    'foreignKey' => 'tipologia_id',
    'parentKey' => 'tipologia_id',
    'primaryKey' => 'camera_id',
    'columns' => 
    array (
      0 => 'camera_id',
      1 => 'hotel_id',
      2 => 'numero_camera',
      3 => 'tipologia_camera',
      4 => 'camere_max_pax',
      5 => 'camere_metri_quadri',
    ),
    'displayField' => 'tipologia_camera',
    'limit' => 20,
    'showCount' => true,
    'showViewButton' => true,
  ),
  'foglio_giorno__tipologia_id' => 
  array (
    'enabled' => true,
    'mode' => 'readonly',
    'title' => 'Foglio Giorno',
    'icon' => 'bi-diagram-3',
    'childTable' => 'foglio_giorno',
    'foreignKey' => 'tipologia_id',
    'parentKey' => 'tipologia_id',
    'primaryKey' => 'foglio_id',
    'columns' => 
    array (
      0 => 'foglio_id',
      1 => 'hotel_id',
      2 => 'conto_id',
      3 => 'camera_id',
      4 => 'preno_id',
      5 => 'numero_camera',
    ),
    'displayField' => 'date_foglio',
    'limit' => 20,
    'showCount' => true,
    'showViewButton' => true,
  ),
  'obmp_cm_rooms__obmp_cm_rooms_tipologia_id' => 
  array (
    'enabled' => true,
    'mode' => 'readonly',
    'title' => 'Obmp Cm Rooms',
    'icon' => 'bi-diagram-3',
    'childTable' => 'obmp_cm_rooms',
    'foreignKey' => 'obmp_cm_rooms_tipologia_id',
    'parentKey' => 'tipologia_id',
    'primaryKey' => 'obmp_cm_rooms_id',
    'columns' => 
    array (
      0 => 'obmp_cm_rooms_id',
      1 => 'obmp_cm_id',
      2 => 'hotel_id',
      3 => 'obmp_cm_rooms_room_id',
      4 => 'obmp_cm_rooms_attiva',
      5 => 'obmp_cm_rooms_room_note',
    ),
    'displayField' => 'obmp_cm_rooms_room_note',
    'limit' => 20,
    'showCount' => true,
    'showViewButton' => true,
  ),
  'ref_costi_tipologia__tipologia_id' => 
  array (
    'enabled' => true,
    'mode' => 'readonly',
    'title' => 'Ref Costi Tipologia',
    'icon' => 'bi-diagram-3',
    'childTable' => 'ref_costi_tipologia',
    'foreignKey' => 'tipologia_id',
    'parentKey' => 'tipologia_id',
    'primaryKey' => 'ref_costi_tipologia_id',
    'columns' => 
    array (
      0 => 'ref_costi_tipologia_id',
      1 => 'costi_var_id',
      2 => 'hotel_id',
      3 => 'stay',
      4 => 'days',
      5 => 'check_out',
    ),
    'displayField' => 'ref_costi_tipologia_id',
    'limit' => 20,
    'showCount' => true,
    'showViewButton' => true,
  ),
);
        $children = [];

        if (!empty($hasManyConfig)) {
            $children = $this->service->loadHasMany($id, $hasManyConfig);
        }

        return view('tipologia_camera/view', [
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

        return view('tipologia_camera/create', [
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
                TipologiaCameraRules::createRules(),
                TipologiaCameraRules::messages()
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
            $data['tipologia_id']
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
            ->to(site_url('tipologia_camera'))
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

        return view('tipologia_camera/edit', [
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
                TipologiaCameraRules::updateRules($id),
                TipologiaCameraRules::messages()
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
            $data['tipologia_id']
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
            ->to(site_url('tipologia_camera'))
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
                ->to(site_url('tipologia_camera'))
                ->with(
                    'error',
                    $e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('tipologia_camera'))
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


        return $options;
    }
}
