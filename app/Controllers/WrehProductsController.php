<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudInputProcessor;
use App\Libraries\Crud\CrudListRequest;
use App\Libraries\Crud\SubmissionGuard;
use App\Services\WrehProductsService;
use App\Validation\WrehProductsRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/**
 * Controller CRUD full per wreh_products.
 *
 * Lato sito: coordina request, validazione, view e redirect. Le query restano
 * nel Model; Standard/Full demandano inoltre la logica applicativa al Service.
 */
final class WrehProductsController extends BaseController
{
    /** Limiti export configurati al momento della generazione. */
    private const EXPORT_OPTIONS = [
        'csv' => ['chunkSize' => 2000, 'maximumRows' => 150000],
        'word' => ['chunkSize' => 1000, 'maximumRows' => 50000],
    ];

    private WrehProductsService $gateway;
    private CrudExporter $exporter;
    private CrudInputProcessor $inputProcessor;
    private SubmissionGuard $submissionGuard;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->gateway = new WrehProductsService();
        // Runtime comune del sito: una sola implementazione per export, input e token.
        $this->exporter = new CrudExporter();
        $this->inputProcessor = new CrudInputProcessor();
        $this->submissionGuard = new SubmissionGuard();
    }

    /** Pagina completa o frammento AJAX della tabella Bootstrap. */
    public function index()
    {
        $listRequest = CrudListRequest::fromRequest(
            $this->request,
            'product_id',
            array (
  0 => 25,
  1 => 50,
  2 => 100,
)
        );

        $data = $this->gateway->listPage($listRequest->filters, $listRequest->page, $listRequest->perPage, $listRequest->sort, $listRequest->direction);
        $data += [
            'title' => 'wreh_products',
            'primaryKey' => 'product_id',
            'filters' => $listRequest->filters,
            'query' => $listRequest->query,
        ];

        if ($this->request->isAJAX()) {
            return view('wreh_products/_table', $data);
        }

        $data['options'] = $this->gateway->relationOptions();

        return view('wreh_products/index', $data);
    }

    /** Endpoint JSON usato dalle select AJAX delle relazioni grandi. */
    public function relationOptions(string $field)
    {
        $query = trim((string) $this->request->getGet('q'));
        if (strlen($query) < 2) {
            return $this->response->setJSON(['results' => []]);
        }

        return $this->response->setJSON([
            'results' => $this->gateway->searchRelationOptions($field, $query, 20),
        ]);
    }

    public function exportCsv()
    {
        return $this->export('csv');
    }

    public function exportWord()
    {
        return $this->export('word');
    }

    public function view(int|string $id)
    {
        $row = $this->findRecordOrFail($id);

        return view('wreh_products/view', [
            'title' => 'Dettaglio',
            'row' => $row,
            'children' => $this->gateway->loadHasMany($id),
        ]);
    }

    public function create()
    {
        return view('wreh_products/create', [
            'title' => 'Nuovo record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => $this->gateway->relationOptions(),
            'submissionToken' => $this->submissionGuard->create('store'),
        ]);
    }

    public function store()
    {
        if (!$this->submissionGuard->consume('store', $this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'Il form è già stato inviato oppure è scaduto.');
        }
        if (!$this->validate(WrehProductsRules::createRules(), WrehProductsRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->formData(false);
        unset($data['product_id']);

        try {
            $this->gateway->create($data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('wreh_products'))->with('message', 'Record creato correttamente.');
    }

    public function edit(int|string $id)
    {
        return view('wreh_products/edit', [
            'title' => 'Modifica record',
            'row' => $this->findRecordOrFail($id),
            'errors' => session('errors') ?? [],
            'options' => $this->gateway->relationOptions(),
            'submissionToken' => $this->submissionGuard->create('update_' . (string) $id),
        ]);
    }

    public function update(int|string $id)
    {
        if (!$this->submissionGuard->consume('update_' . (string) $id, $this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'Il form è già stato inviato oppure è scaduto.');
        }
        if (!$this->validate(WrehProductsRules::updateRules($id), WrehProductsRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->formData(true);
        unset($data['product_id']);

        try {
            $this->gateway->update($id, $data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('wreh_products'))->with('message', 'Record aggiornato correttamente.');
    }

    public function delete(int|string $id)
    {
        try {
            $this->gateway->delete($id);
        } catch (Throwable $e) {
            return redirect()->to(site_url('wreh_products'))->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('wreh_products'))->with('message', 'Record eliminato correttamente.');
    }

    /**
     * Unifica CSV e Word: cambia solo il writer selezionato dalla libreria runtime.
     */
    private function export(string $format)
    {
        $options = self::EXPORT_OPTIONS[$format] ?? null;
        if (!is_array($options)) {
            throw new RuntimeException('Formato export non supportato.');
        }

        $listRequest = CrudListRequest::fromRequest($this->request, 'product_id', array (
  0 => 25,
  1 => 50,
  2 => 100,
));

        try {
            return $this->exporter->download(
                format: $format,
                response: $this->response,
                filename: 'wreh_products',
                languageGroup: 'WrehProducts',
                fields: $this->gateway->exportFields(),
                filters: $listRequest->filters,
                countProvider: fn (array $filters): int => $this->gateway->countExportRows($filters),
                rowProvider: fn (array $filters, int $limit, int|string|null $after): array => $this->gateway->exportRows($filters, $limit, $after),
                primaryKey: 'product_id',
                chunkSize: (int) $options['chunkSize'],
                maximumRows: (int) $options['maximumRows']
            );
        } catch (RuntimeException $e) {
            if (str_starts_with($e->getMessage(), 'EXPORT_LIMIT:')) {
                return $this->exportLimitRedirect(strtoupper($format));
            }
            throw $e;
        }
    }

    /** Recupera il record o converte l'assenza in un normale 404 del sito. */
    private function findRecordOrFail(int|string $id): object
    {
        try {
            $record = $this->gateway->find($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        if (!is_object($record)) {
            throw PageNotFoundException::forPageNotFound('Record non trovato.');
        }

        return $record;
    }

    /**
     * Pulizia meccanica comune ai form. In Standard/Full date e password sono
     * preparate dal Service; in Basic vengono gestite qui dal runtime CRUD.
     */
    private function formData(bool $isUpdate): array
    {
        return $this->inputProcessor->process(
            $this->request->getPost(),
            $isUpdate,
            [],
            array (
),
            array (
),
            array (
),
            [],
            false
        );
    }

    private function exportLimitRedirect(string $format)
    {
        return redirect()->to(site_url('wreh_products') . '?' . http_build_query((array) $this->request->getGet()))
            ->with('error', 'Applicare filtri più restrittivi prima di esportare in ' . $format . '.');
    }
}
