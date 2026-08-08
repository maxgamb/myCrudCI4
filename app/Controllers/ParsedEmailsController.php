<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudInputProcessor;
use App\Libraries\Crud\CrudListRequest;
use App\Libraries\Crud\SubmissionGuard;
use App\Services\ParsedEmailsService;
use App\Validation\ParsedEmailsRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/**
 * Controller CRUD full per parsed_emails.
 *
 * Lato sito: coordina request, validazione, view e redirect. Le query restano
 * nel Model; Standard/Full demandano inoltre la logica applicativa al Service.
 */
final class ParsedEmailsController extends BaseController
{
    /** Limiti export configurati al momento della generazione. */
    private const EXPORT_OPTIONS = [
        'csv' => ['chunkSize' => 2000, 'maximumRows' => 150000],
        'word' => ['chunkSize' => 1000, 'maximumRows' => 50000],
    ];

    private ParsedEmailsService $gateway;
    private CrudExporter $exporter;
    private CrudInputProcessor $inputProcessor;
    private SubmissionGuard $submissionGuard;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->gateway = new ParsedEmailsService();
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
            'id',
            array (
  0 => 25,
  1 => 50,
  2 => 100,
)
        );

        $data = $this->gateway->listPage($listRequest->filters, $listRequest->page, $listRequest->perPage, $listRequest->sort, $listRequest->direction);
        $data += [
            'title' => 'parsed_emails',
            'primaryKey' => 'id',
            'filters' => $listRequest->filters,
            'query' => $listRequest->query,
        ];

        if ($this->request->isAJAX()) {
            return view('parsed_emails/_table', $data);
        }

        $data['options'] = $this->gateway->relationOptions();

        return view('parsed_emails/index', $data);
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

        return view('parsed_emails/view', [
            'title' => 'Dettaglio',
            'row' => $row,
            'children' => $this->gateway->loadHasMany($id),
        ]);
    }

    public function create()
    {
        // Le sole FK esplicitamente abilitate dal Builder possono essere
        // ricevute dalla query string. Prima di usarle verifichiamo che il
        // record padre esista realmente: hidden/select/input non fanno
        // differenza dal punto di vista della sicurezza.
        $context = [];
        $contextLabels = [];
        foreach (array (
) as $field) {
            $requested = $this->request->getGet($field);
            if (!is_scalar($requested) || trim((string) $requested) === '') {
                continue;
            }

            $option = $this->gateway->relationOptionById($field, (string) $requested);
            if ($option === null) {
                throw PageNotFoundException::forPageNotFound('Valore FK non valido per ' . $field . '.');
            }

            $context[$field] = (string) $option['id'];
            $contextLabels[$field] = (string) $option['text'];
        }

        return view('parsed_emails/create', [
            'title' => 'Nuovo record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => $this->gateway->relationOptions(),
            'context' => $context,
            'contextLabels' => $contextLabels,
            'submissionToken' => $this->submissionGuard->create('store'),
        ]);
    }

    public function store()
    {
        if (!$this->submissionGuard->consume('store', $this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'Il form è già stato inviato oppure è scaduto.');
        }
        if (!$this->validate(ParsedEmailsRules::createRules(), ParsedEmailsRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->formData(false);

        try {
            $this->gateway->create($data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('parsed_emails'))->with('message', 'Record creato correttamente.');
    }

    public function edit(int|string $id)
    {
        return view('parsed_emails/edit', [
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
        if (!$this->validate(ParsedEmailsRules::updateRules($id), ParsedEmailsRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->formData(true);
        unset($data['id']);

        try {
            $this->gateway->update($id, $data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('parsed_emails'))->with('message', 'Record aggiornato correttamente.');
    }

    public function delete(int|string $id)
    {
        try {
            $this->gateway->delete($id);
        } catch (Throwable $e) {
            return redirect()->to(site_url('parsed_emails'))->with('error', $e->getMessage());
        }

        return redirect()->to(site_url('parsed_emails'))->with('message', 'Record eliminato correttamente.');
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

        $listRequest = CrudListRequest::fromRequest($this->request, 'id', array (
  0 => 25,
  1 => 50,
  2 => 100,
));

        try {
            return $this->exporter->download(
                format: $format,
                response: $this->response,
                filename: 'parsed_emails',
                languageGroup: 'ParsedEmails',
                fields: $this->gateway->exportFields(),
                filters: $listRequest->filters,
                countProvider: fn (array $filters): int => $this->gateway->countExportRows($filters),
                rowProvider: fn (array $filters, int $limit, int|string|null $after): array => $this->gateway->exportRows($filters, $limit, $after),
                primaryKey: 'id',
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
        return redirect()->to(site_url('parsed_emails') . '?' . http_build_query((array) $this->request->getGet()))
            ->with('error', 'Applicare filtri più restrittivi prima di esportare in ' . $format . '.');
    }
}
