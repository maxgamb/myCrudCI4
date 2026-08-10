<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudInputProcessor;
use App\Libraries\Crud\CrudListRequest;
use App\Libraries\Crud\SubmissionGuard;
use App\Services\FilmCategoryService;
use App\Validation\FilmCategoryRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/**
 * Controller CRUD full per film_category.
 *
 * Lato sito: coordina request, validazione, view e redirect. Le query restano
 * nel Model; Standard/Full demandano inoltre la logica applicativa al Service.
 */
final class FilmCategoryController extends BaseController
{
    /** Limiti export configurati al momento della generazione. */
    private const EXPORT_OPTIONS = [
        'csv' => [
            'chunkSize' => 2000,
            'maximumRows' => 150000,
            'unfilteredMaximumRows' => 25000,
        ],
        'word' => [
            'chunkSize' => 1000,
            'maximumRows' => 10000,
            'unfilteredMaximumRows' => 5000,
        ],
    ];

    /** Solo le FK reali della tabella possono viaggiare come contesto URL. */
    private const NAVIGATION_CONTEXT_FIELDS = array (
  0 => 'film_id',
  1 => 'category_id',
);

    /** FK autorizzate alla creazione atomica del record padre nello stesso form. */
    private const RELATED_CREATE_FIELDS = array (
  'category_id' => 
  array (
    0 => 'name',
  ),
);

    private FilmCategoryService $gateway;
    private CrudExporter $exporter;
    private CrudInputProcessor $inputProcessor;
    private SubmissionGuard $submissionGuard;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->gateway = new FilmCategoryService();
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
            'film_id',
            array (
  0 => 25,
  1 => 50,
  2 => 100,
),
            array (
  0 => 'film_id',
  1 => 'category_id',
)
        );

        $navigationContext = $this->navigationContextFromQuery();
        $data = $this->gateway->listPage($listRequest->filters, $listRequest->page, $listRequest->perPage, $listRequest->sort, $listRequest->direction);
        $data += [
            'title' => 'film_category',
            'primaryKey' => 'film_id',
            'filters' => $listRequest->filters,
            'query' => $listRequest->query,
            'navigationContext' => $navigationContext,
        ];

        if ($this->request->isAJAX()) {
            return view('film_category/_table', $data);
        }

        $data['options'] = $this->gateway->relationOptions();

        return view('film_category/index', $data);
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

    public function create()
    {
        $navigationContext = $this->navigationContextFromQuery();
        $context = [];
        $contextLabels = [];
        foreach (array (
  0 => 'film_id',
  1 => 'category_id',
) as $field) {
            $requested = $navigationContext[$field] ?? null;
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

        return view('film_category/create', [
            'title' => 'Nuovo record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => $this->gateway->relationOptions(),
            'context' => $context,
            'contextLabels' => $contextLabels,
            'navigationContext' => $navigationContext,
            'submissionToken' => $this->submissionGuard->create('store'),
        ]);
    }

    public function store()
    {
        $navigationContext = $this->navigationContextFromPost();
        if (!$this->submissionGuard->consume('store', $this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'Il form è già stato inviato oppure è scaduto.');
        }

        $related = $this->relatedCreateDataFromPost();
        $createRules = FilmCategoryRules::createRules();
        foreach (array_keys($related) as $relatedField) {
            // La FK viene prodotta dalla creazione del padre nella stessa
            // transazione, quindi non può essere obbligatoria prima dell'INSERT.
            unset($createRules[$relatedField]);
        }
        if (!$this->validate($createRules, FilmCategoryRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $relatedErrors = $this->validateRelatedCreates($related);
        if ($relatedErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $relatedErrors);
        }

        $data = $this->formData(false);
        try {
            $this->gateway->create($data, $related);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
        return redirect()->to($this->contextUrl('film_category', $navigationContext))->with('message', 'Record creato correttamente.');
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

        $listRequest = CrudListRequest::fromRequest($this->request, 'film_id', array (
  0 => 25,
  1 => 50,
  2 => 100,
), array (
  0 => 'film_id',
  1 => 'category_id',
));

        try {
            return $this->exporter->download(
                format: $format,
                response: $this->response,
                filename: 'film_category',
                languageGroup: 'FilmCategory',
                fields: $this->gateway->exportFields(),
                filters: $listRequest->filters,
                countProvider: fn (array $filters): int => $this->gateway->countExportRows($filters),
                rowProvider: fn (array $filters, int $limit, int|string|null $after): array => $this->gateway->exportRows($filters, $limit, $after),
                primaryKey: array (
  0 => 'film_id',
  1 => 'category_id',
),
                chunkSize: (int) $options['chunkSize'],
                maximumRows: (int) $options['maximumRows'],
                unfilteredMaximumRows: (int) $options['unfilteredMaximumRows']
            );
        } catch (RuntimeException $e) {
            if (str_starts_with($e->getMessage(), 'EXPORT_UNFILTERED_LIMIT:')) {
                return $this->exportLimitRedirect(strtoupper($format), true);
            }
            if (str_starts_with($e->getMessage(), 'EXPORT_LIMIT:')) {
                return $this->exportLimitRedirect(strtoupper($format), false);
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
  0 => 'last_update',
),
            array (
),
            [],
            false
        );
    }

    /** @return array<string,array<string,mixed>> */
    private function relatedCreateDataFromPost(): array
    {
        $flags = $this->request->getPost('_related_new');
        $payload = $this->request->getPost('_related');
        $flags = is_array($flags) ? $flags : [];
        $payload = is_array($payload) ? $payload : [];
        $related = [];

        foreach (self::RELATED_CREATE_FIELDS as $field => $allowedFields) {
            if (empty($flags[$field]) || !isset($payload[$field]) || !is_array($payload[$field])) {
                continue;
            }
            $allowed = array_fill_keys((array) $allowedFields, true);
            $related[$field] = array_intersect_key($payload[$field], $allowed);
        }

        return $related;
    }

    /** @return array<string,string> */
    private function validateRelatedCreates(array $related): array
    {
        if ($related === []) {
            return [];
        }

        $definitions = FilmCategoryRules::relatedCreateRules();
        $errors = [];
        foreach ($related as $field => $payload) {
            $relationRules = (array) ($definitions[$field] ?? []);
            if ($relationRules === []) {
                continue;
            }

            $validation = service('validation');
            $validation->reset();
            $validation->setRules($relationRules);
            if ($validation->run($payload)) {
                continue;
            }

            foreach ($validation->getErrors() as $relatedField => $message) {
                $errors[$field . '__related__' . $relatedField] = (string) $message;
            }
        }

        return $errors;
    }

    /** @return array<string,string> */
    private function navigationContextFromQuery(): array
    {
        return $this->sanitizeNavigationContext((array) $this->request->getGet());
    }

    /** @return array<string,string> */
    private function navigationContextFromPost(): array
    {
        $context = $this->request->getPost('_context');

        return $this->sanitizeNavigationContext(is_array($context) ? $context : []);
    }

    /** @return array<string,string> */
    private function sanitizeNavigationContext(array $source): array
    {
        $context = [];
        foreach (self::NAVIGATION_CONTEXT_FIELDS as $field) {
            $value = $source[$field] ?? null;
            if (!is_scalar($value) || trim((string) $value) === '') {
                continue;
            }
            $context[$field] = (string) $value;
        }

        return $context;
    }

    private function contextUrl(string $path, array $context): string
    {
        $url = site_url($path);

        return $context === [] ? $url : $url . '?' . http_build_query($context);
    }

    private function exportLimitRedirect(string $format, bool $unfiltered)
    {
        $message = $unfiltered
            ? 'La tabella contiene troppi record per un export senza filtri. Applicare almeno un filtro prima di esportare in ' . $format . '.'
            : 'Il numero di record supera il limite configurato per ' . $format . '. Applicare filtri più restrittivi.';

        $query = (array) $this->request->getGet();
        $url = site_url('film_category') . ($query === [] ? '' : '?' . http_build_query($query));

        return redirect()->to($url)->with('error', $message);
    }
}
