<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudListRequest;
use App\Libraries\Crud\CrudNavigationTrail;
use App\Libraries\Crud\CrudInputProcessor;
use App\Libraries\Crud\SubmissionGuard;
use App\Models\RentalModel;
use App\Services\RentalService;
use App\Validation\RentalRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/**
 * CRUD full controller for resource `rental`.
 *
 * Handles the HTTP flow and delegates queries/persistence to Model/Service.
 * Contains no SQL queries.
 */
final class RentalController extends BaseController
{
    /** Export limits configured at generation time. */
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

    /** Only real table foreign keys may travel as URL context. */
    private const NAVIGATION_CONTEXT_FIELDS = array (
  0 => 'inventory_id',
  1 => 'customer_id',
  2 => 'staff_id',
);

    /** Foreign keys authorized for atomic parent creation within the same form. */
    private const RELATED_CREATE_FIELDS = array (
  'inventory_id' =>
  array (
    0 => 'film_id',
    1 => 'store_id',
  ),
  'customer_id' =>
  array (
    0 => 'store_id',
    1 => 'first_name',
    2 => 'last_name',
    3 => 'email',
    4 => 'address_id',
    5 => 'active',
    6 => 'create_date',
  ),
  'staff_id' =>
  array (
    0 => 'first_name',
    1 => 'last_name',
    2 => 'address_id',
    3 => 'email',
    4 => 'store_id',
    5 => 'active',
    6 => 'username',
    7 => 'password',
  ),
);

    /**
     * Allowed parent contexts for Create started from a hasMany relation.
     * The return table is derived exclusively from the generated schema, never from POST.
     */
    private const PARENT_CONTEXT_FIELDS = array (
  'inventory_id' =>
  array (
    'table' => 'inventory',
    'label' => 'Inventory',
  ),
  'customer_id' =>
  array (
    'table' => 'customer',
    'label' => 'Customer',
  ),
  'staff_id' =>
  array (
    'table' => 'staff',
    'label' => 'Staff',
  ),
);

    /** Read/query dependency: the generated Model. */
    private RentalModel $model;
    private RentalService $service;
    private CrudExporter $exporter;
    private CrudInputProcessor $inputProcessor;
    private SubmissionGuard $submissionGuard;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->model = new RentalModel();
        $this->service = new RentalService();
        // Shared site runtime: a single implementation for export, input, and tokens.
        $this->exporter = new CrudExporter();
        $this->inputProcessor = new CrudInputProcessor();
        $this->submissionGuard = new SubmissionGuard();
    }

    /**
     * Displays the full list or the AJAX table fragment.
     *
     * Filters, pagination, and sorting are validated by the CRUD runtime before
     * reaching Model/Service.
     */
    public function index()
    {
        $listRequest = CrudListRequest::fromRequest(
            $this->request,
            'rental_id',
            array (
  0 => 25,
  1 => 50,
  2 => 100,
),
            array (
  0 => 'rental_id',
  1 => 'rental_date',
  2 => 'inventory_id',
  3 => 'customer_id',
  4 => 'staff_id',
)
        );

        $navigationContext = $this->navigationContextFromQuery();
        $cascadeTrail = $this->cascadeTrailFromQuery();
        $data = $this->model->getListPage($listRequest->filters, $listRequest->page, $listRequest->perPage, $listRequest->sort, $listRequest->direction);
        $data += [
            'title' => 'rental',
            'primaryKey' => 'rental_id',
            'filters' => $listRequest->filters,
            'query' => $listRequest->query,
            'navigationContext' => $navigationContext,
            'cascadeTrail' => $cascadeTrail,
        ];

        if ($this->request->isAJAX()) {
            return view('rental/_table', $data);
        }

        $data['options'] = $this->model->relationOptions();

        return view('rental/index', $data);
    }

    /**
     * JSON endpoint for searching belongsTo options in AJAX mode.
     * The requested field is checked against the generated whitelist.
     */
    public function relationOptions(string $field)
    {
        $query = trim((string) $this->request->getGet('q'));
        if (strlen($query) < 2) {
            return $this->response->setJSON(['results' => []]);
        }

        return $this->response->setJSON([
            'results' => $this->model->searchRelationOptions($field, $query, 20),
        ]);
    }
    /** Streams the current filtered result set as CSV. */
    public function exportCsv()
    {
        return $this->export('csv');
    }

    /** Streams the current filtered result set as a Word-compatible document. */
    public function exportWord()
    {
        return $this->export('word');
    }

    /**
     * Displays one record and its explicitly configured child relations.
     *
     * @param int|string $id Record identifier.
     */
    public function view(int|string $id)
    {
        $row = $this->findRecordOrFail($id);
        $navigationContext = $this->navigationContextFromQuery();
        $cascadeTrail = $this->cascadeTrailFromQuery();

        return view('rental/view', [
            'title' => 'Details',
            'row' => $row,
            'children' => $this->model->loadHasMany($id),
            'navigationContext' => $navigationContext,
            'cascadeTrail' => $cascadeTrail,
        ]);
    }
    /** Displays the Create form with generated relation/context options. */
    public function create()
    {
        $navigationContext = $this->navigationContextFromQuery();
        $cascadeTrail = $this->cascadeTrailFromQuery();
        $parentContext = $this->parentContextFromQuery($navigationContext, $cascadeTrail);
        $context = [];
        $contextLabels = [];
        foreach (array (
  0 => 'inventory_id',
  1 => 'customer_id',
  2 => 'staff_id',
) as $field) {
            $requested = $navigationContext[$field] ?? null;
            if (!is_scalar($requested) || trim((string) $requested) === '') {
                continue;
            }
            $option = $this->model->relationOptionById($field, (string) $requested);
            if ($option === null) {
                throw PageNotFoundException::forPageNotFound('Invalid foreign-key value for ' . $field . '.');
            }
            $context[$field] = (string) $option['id'];
            $contextLabels[$field] = (string) $option['text'];
        }
        return view('rental/create', [
            'title' => 'New record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => $this->model->relationOptions(),
            'relatedCreateOptions' => $this->model->relatedCreateRelationOptions(),
            'manyToManyOptions' => [],
            'manyToManyRelatedCreateOptions' => [],
            'manyToManySelected' => [],
            'context' => $context,
            'contextLabels' => $contextLabels,
            'navigationContext' => $navigationContext,
            'parentContext' => $parentContext,
            'cascadeTrail' => $cascadeTrail,
            'submissionToken' => $this->submissionGuard->create('store'),
        ]);
    }

    /** Validates the HTTP payload and delegates the Create use-case to the Service. */
    public function store()
    {
        $navigationContext = $this->navigationContextFromPost();
        $cascadeTrail = $this->cascadeTrailFromPost();
        $parentContext = $this->parentContextFromPost($navigationContext, $cascadeTrail);
        if (!$this->submissionGuard->consume('store', $this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'The form has already been submitted or has expired.');
        }

        $related = $this->relatedCreateDataFromPost();
        $createRules = RentalRules::createRules();
        foreach (array_keys($related) as $relatedField) {
            // The foreign key is produced by creating the parent within the same
            // transaction, so it cannot be required before the INSERT.
            unset($createRules[$relatedField]);
        }        if (!$this->validate($createRules, RentalRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $relatedErrors = $this->validateRelatedCreates($related);
        if ($relatedErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $relatedErrors);
        }
        $data = $this->formData(false);
        unset($data['rental_id']);
        try {
            $this->service->create($data, $related);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
        $redirectUrl = $parentContext['url'] ?? $this->contextUrl('rental', $navigationContext, $cascadeTrail);
        return redirect()->to($redirectUrl)->with('message', 'Record created successfully.');
    }
    /**
     * Displays the Edit form for one record.
     *
     * @param int|string $id Record identifier.
     */
    public function edit(int|string $id)
    {
        $navigationContext = $this->navigationContextFromQuery();
        $cascadeTrail = $this->cascadeTrailFromQuery();

        return view('rental/edit', [
            'title' => 'Edit record',
            'row' => $this->findRecordOrFail($id),
            'errors' => session('errors') ?? [],
            'options' => $this->model->relationOptions(),
            'manyToManyOptions' => [],
            'manyToManyRelatedCreateOptions' => [],
            'manyToManySelected' => [],
            'navigationContext' => $navigationContext,
            'cascadeTrail' => $cascadeTrail,
            'submissionToken' => $this->submissionGuard->create('update_' . (string) $id),
        ]);
    }

    /**
     * Validates the HTTP payload and delegates the Update use-case to the Service.
     *
     * @param int|string $id Record identifier.
     */
    public function update(int|string $id)
    {
        $navigationContext = $this->navigationContextFromPost();
        $cascadeTrail = $this->cascadeTrailFromPost();
        if (!$this->submissionGuard->consume('update_' . (string) $id, $this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'The form has already been submitted or has expired.');
        }
        if (!$this->validate(RentalRules::updateRules($id), RentalRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $data = $this->formData(true);
        unset($data['rental_id']);
        try {
            $this->service->update($id, $data);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
        return redirect()->to($this->contextUrl('rental', $navigationContext, $cascadeTrail))->with('message', 'Record updated successfully.');
    }

    /**
     * Delegates record deletion to the generated Service.
     *
     * @param int|string $id Record identifier.
     */
    public function delete(int|string $id)
    {
        $navigationContext = $this->navigationContextFromPost();
        if ($navigationContext === []) {
            $navigationContext = $this->navigationContextFromQuery();
        }

        try {
            $this->service->delete($id);
        } catch (Throwable $e) {
            return redirect()->to($this->contextUrl('rental', $navigationContext))->with('error', $e->getMessage());
        }
        return redirect()->to($this->contextUrl('rental', $navigationContext))->with('message', 'Record deleted successfully.');
    }
    /**
     * Unifies CSV and Word: only the writer selected by the runtime library changes.
     */
    private function export(string $format)
    {
        $options = self::EXPORT_OPTIONS[$format] ?? null;
        if (!is_array($options)) {
            throw new RuntimeException('Unsupported export format.');
        }

        $listRequest = CrudListRequest::fromRequest($this->request, 'rental_id', array (
  0 => 25,
  1 => 50,
  2 => 100,
), array (
  0 => 'rental_id',
  1 => 'rental_date',
  2 => 'inventory_id',
  3 => 'customer_id',
  4 => 'staff_id',
));

        try {
            return $this->exporter->download(
                format: $format,
                response: $this->response,
                filename: 'rental',
                languageGroup: 'Rental',
                fields: $this->model->exportFields(),
                filters: $listRequest->filters,
                countProvider: fn (array $filters): int => $this->model->countExportRows($filters),
                rowProvider: fn (array $filters, int $limit, int|string|null $after): array => $this->model->getExportRows($filters, $limit, $after),
                primaryKey: 'rental_id',
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

    /** Retrieves the record and converts any missing result into a standard HTTP 404. */
    private function findRecordOrFail(int|string $id): object
    {
        try {
            $record = $this->model->getDetail($id);
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record not found.');
        }

        if (!is_object($record)) {
            throw PageNotFoundException::forPageNotFound('Record not found.');
        }

        return $record;
    }
    /**
     * Extracts and sanitizes write payload from the current HTTP request.
     *
     * Standard/Full leave password/date normalization to the Service; Basic may
     * apply the corresponding runtime transformations here.
     *
     * @param bool $isUpdate True while handling an Edit submission.
     * @return array<string,mixed> Sanitized application payload.
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
            false,
            array (
)
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

        $definitions = RentalRules::relatedCreateRules();
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

    /** @return list<array{table:string,id:string,label:string}> */
    private function cascadeTrailFromQuery(): array
    {
        return CrudNavigationTrail::decode($this->request->getGet('_trail'));
    }
    /** @return array<string,string> */
    private function navigationContextFromPost(): array
    {
        $context = $this->request->getPost('_context');
        return $this->sanitizeNavigationContext(is_array($context) ? $context : []);
    }

    /** @return list<array{table:string,id:string,label:string}> */
    private function cascadeTrailFromPost(): array
    {
        return CrudNavigationTrail::decode($this->request->getPost('_trail'));
    }
    /** @return array{field:string,table:string,id:string,label:string,url:string}|array{} */
    private function parentContextFromQuery(array $navigationContext, array $cascadeTrail = []): array
    {
        return $this->parentContext((string) ($this->request->getGet('_parent_field') ?? ''), $navigationContext, $cascadeTrail);
    }

    /** @return array{field:string,table:string,id:string,label:string,url:string}|array{} */
    private function parentContextFromPost(array $navigationContext, array $cascadeTrail = []): array
    {
        return $this->parentContext((string) ($this->request->getPost('_parent_field') ?? ''), $navigationContext, $cascadeTrail);
    }

    /**
     * Resolves a safe contextual return to the hasMany parent.
     * The client selects only the foreign key; table and route come from the schema-driven whitelist.
     *
     * @return array{field:string,table:string,id:string,label:string,url:string}|array{}
     */
    private function parentContext(string $field, array $navigationContext, array $cascadeTrail = []): array
    {
        if ($field === '' || !isset(self::PARENT_CONTEXT_FIELDS[$field])) {
            return [];
        }
        $id = $navigationContext[$field] ?? null;
        if (!is_scalar($id) || trim((string) $id) === '') {
            return [];
        }
        $definition = self::PARENT_CONTEXT_FIELDS[$field];
        $table = (string) ($definition['table'] ?? '');
        if ($table === '') {
            return [];
        }
        $id = (string) $id;
        $ancestorTrail = CrudNavigationTrail::ancestorsForParent($cascadeTrail, $table, $id);
        $parentUrl = site_url($table . '/view/' . rawurlencode($id));
        $encodedTrail = CrudNavigationTrail::encode($ancestorTrail);
        if ($encodedTrail !== '') {
            $parentUrl .= '?_trail=' . rawurlencode($encodedTrail);
        }

        return [
            'field' => $field,
            'table' => $table,
            'id' => $id,
            'label' => (string) ($definition['label'] ?? $table),
            'url' => $parentUrl,
        ];
    }
    private function contextUrl(string $path, array $context, array $cascadeTrail = []): string
    {
        $url = site_url($path);
        $query = $context;
        $encodedTrail = CrudNavigationTrail::encode($cascadeTrail);
        if ($encodedTrail !== '') {
            $query['_trail'] = $encodedTrail;
        }

        return $query === [] ? $url : $url . '?' . http_build_query($query);
    }
    private function exportLimitRedirect(string $format, bool $unfiltered)
    {
        $message = $unfiltered
            ? 'The table contains too many records for an unfiltered export. Apply at least one filter before exporting to ' . $format . '.'
            : 'The number of records exceeds the configured limit for ' . $format . '. Apply more restrictive filters.';

        $query = (array) $this->request->getGet();
        $url = site_url('rental') . ($query === [] ? '' : '?' . http_build_query($query));

        return redirect()->to($url)->with('error', $message);
    }
}
