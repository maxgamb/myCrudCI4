<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Services\AgendaService;
use App\Validation\{AgendaRules};
use CodeIgniter\Exceptions\PageNotFoundException;
use Throwable;

/** Controller CRUD per agenda; non contiene query SQL. */
final class AgendaController extends BaseController
{
    private AgendaService $service;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->service = new AgendaService();
    }

    public function index()
    {
        return view('agenda/index', [
            'title' => 'agenda',
            'primaryKey' => 'preno_id',
        ]);
    }
    /** Endpoint DataTables server-side; la query è gestita dal Model. */
    public function datatable()
    {
        return $this->response->setJSON($this->service->datatable($this->request->getPost()));
    }
    public function view(int|string $id)
    {
        $row = $this->service->find($id);
        if (!is_object($row)) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('agenda/view', [
            'title' => 'Dettaglio',
            'row' => $row,
            'children' => $this->service->loadHasMany($id),
        ]);
    }

    public function create()
    {
        return view('agenda/create', [
            'title' => 'Nuovo record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => $this->service->relationOptions(),
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
            $this->service->create($data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('agenda'))->with('message', 'Record creato correttamente.');
    }

    public function edit(int|string $id)
    {
        $row = $this->service->find($id);
        if (!is_object($row)) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return view('agenda/edit', [
            'title' => 'Modifica record',
            'row' => $row,
            'errors' => session('errors') ?? [],
            'options' => $this->service->relationOptions(),
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
            $this->service->update($id, $data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('agenda'))->with('message', 'Record aggiornato correttamente.');
    }

    public function delete(int|string $id)
    {
        try {
            $this->service->delete($id);
        } catch (Throwable $e) {
            return redirect()->to(site_url('agenda'))->with('error', $e->getMessage());
        }
        return redirect()->to(site_url('agenda'))->with('message', 'Record eliminato correttamente.');
    }

    private function sanitizeInput(array $data, bool $isUpdate): array
    {
        unset($data['_submission_token']);
        $csrfName = csrf_token();
        if ($csrfName !== '') {
            unset($data[$csrfName]);
        }

        foreach (array (
) as $field) {
            unset($data[$field]);
        }
        if ($isUpdate) {
            foreach (array (
) as $field) {
                unset($data[$field]);
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
