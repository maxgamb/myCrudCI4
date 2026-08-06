<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AppIpService;
use App\Validation\AppIpRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

class AppIpController extends BaseController
{
    private AppIpService $service;

    public function __construct()
    {
        helper([
            'form',
            'url',
        ]);

        $this->service = new AppIpService();
    }

    /**
     * Elenco principale.
     */
    public function index()
    {
        return view('app_ip/index', [
            'title'      => 'app_ip',
            'fields'     => array (
  0 => 'app_ip_id',
  1 => 'ip_aderss',
  2 => 'Livello',
  3 => 'data',
),
            'primaryKey' => 'app_ip_id',
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
  0 => 'app_ip_id',
  1 => 'ip_aderss',
  2 => 'Livello',
  3 => 'data',
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
                    'app_ip.' . $field,
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
                    'app_ip.' . $fields[$index],
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
            ?? 'app_ip_id';

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
                'app_ip.' . $orderField,
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
);
        $children = [];

        if (!empty($hasManyConfig)) {
            $children = $this->service->loadHasMany($id, $hasManyConfig);
        }

        return view('app_ip/view', [
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

        return view('app_ip/create', [
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
                AppIpRules::createRules(),
                AppIpRules::messages()
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
            $data['app_ip_id']
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
            ->to(site_url('app_ip'))
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

        return view('app_ip/edit', [
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
                AppIpRules::updateRules($id),
                AppIpRules::messages()
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
            $data['app_ip_id']
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
            ->to(site_url('app_ip'))
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
                ->to(site_url('app_ip'))
                ->with(
                    'error',
                    $e->getMessage()
                );
        }

        return redirect()
            ->to(site_url('app_ip'))
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
