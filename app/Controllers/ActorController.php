<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudListRequest;
use App\Libraries\Crud\CrudNavigationTrail;
use App\Libraries\Crud\CrudInputProcessor;
use App\Libraries\Crud\SubmissionGuard;
use App\Models\ActorModel;
use App\Services\ActorService;
use App\Validation\ActorRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/**
 * CRUD full controller for resource `actor`.
 *
 * Handles the HTTP flow and delegates queries/persistence to Model/Service.
 * Contains no SQL queries.
 */
final class ActorController extends BaseController
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
);

    /** Fields allowed for inline many-to-many target creation. */
    private const MANY_TO_MANY_RELATED_CREATE_FIELDS = array (
  'many__film_actor__actor_id' =>
  array (
    0 => 'title',
    1 => 'description',
    2 => 'release_year',
    3 => 'language_id',
    4 => 'original_language_id',
    5 => 'rental_duration',
    6 => 'rental_rate',
    7 => 'length',
    8 => 'replacement_cost',
    9 => 'rating',
    10 => 'special_features',
    11 => 'uploads',
  ),
);

    /** Read/query dependency: the generated Model. */
    private ActorModel $model;
    private ActorService $service;
    private CrudExporter $exporter;
    private CrudInputProcessor $inputProcessor;
    private SubmissionGuard $submissionGuard;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->model = new ActorModel();
        $this->service = new ActorService();
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
            'actor_id',
            array (
  0 => 25,
  1 => 50,
  2 => 100,
),
            array (
  0 => 'actor_id',
  1 => 'last_name',
)
        );

        $navigationContext = $this->navigationContextFromQuery();
        $cascadeTrail = $this->cascadeTrailFromQuery();
        $data = $this->model->getListPage($listRequest->filters, $listRequest->page, $listRequest->perPage, $listRequest->sort, $listRequest->direction);
        $data += [
            'title' => 'actor',
            'primaryKey' => 'actor_id',
            'filters' => $listRequest->filters,
            'query' => $listRequest->query,
            'navigationContext' => $navigationContext,
            'cascadeTrail' => $cascadeTrail,
        ];

        if ($this->request->isAJAX()) {
            return view('actor/_table', $data);
        }

        $data['options'] = [];

        return view('actor/index', $data);
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

        return view('actor/view', [
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
        $parentContext = [];
        $context = [];
        $contextLabels = [];

        return view('actor/create', [
            'title' => 'New record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => [],
            'relatedCreateOptions' => [],
            'manyToManyOptions' => $this->model->manyToManyFormOptions(),
            'manyToManyRelatedCreateOptions' => $this->model->manyToManyRelatedCreateRelationOptions(),
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
        $parentContext = [];
        if (!$this->submissionGuard->consume('store', $this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'The form has already been submitted or has expired.');
        }

        $manyToManyNew = $this->manyToManyRelatedCreateDataFromPost();
        $manyToManyNewErrors = $this->validateManyToManyRelatedCreates($manyToManyNew);
        if ($manyToManyNewErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $manyToManyNewErrors);
        }
        $createRules = ActorRules::createRules();
        if (!$this->validate($createRules, ActorRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = $this->formData(false);
        unset($data['actor_id']);
        try {
            $this->service->create($data, $this->manyToManyDataFromPost(), $manyToManyNew);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
        $redirectUrl = $parentContext['url'] ?? $this->contextUrl('actor', $navigationContext, $cascadeTrail);
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

        return view('actor/edit', [
            'title' => 'Edit record',
            'row' => $this->findRecordOrFail($id),
            'errors' => session('errors') ?? [],
            'options' => [],
            'manyToManyOptions' => $this->model->manyToManyFormOptions(),
            'manyToManyRelatedCreateOptions' => $this->model->manyToManyRelatedCreateRelationOptions(),
            'manyToManySelected' => $this->model->manyToManySelected($id),
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
        if (!$this->validate(ActorRules::updateRules($id), ActorRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $manyToManyNew = $this->manyToManyRelatedCreateDataFromPost();
        $manyToManyNewErrors = $this->validateManyToManyRelatedCreates($manyToManyNew);
        if ($manyToManyNewErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $manyToManyNewErrors);
        }
        $data = $this->formData(true);
        unset($data['actor_id']);
        try {
            $this->service->update($id, $data, $this->manyToManyDataFromPost(), $manyToManyNew);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
        return redirect()->to($this->contextUrl('actor', $navigationContext, $cascadeTrail))->with('message', 'Record updated successfully.');
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
            return redirect()->to($this->contextUrl('actor', $navigationContext))->with('error', $e->getMessage());
        }
        return redirect()->to($this->contextUrl('actor', $navigationContext))->with('message', 'Record deleted successfully.');
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

        $listRequest = CrudListRequest::fromRequest($this->request, 'actor_id', array (
  0 => 25,
  1 => 50,
  2 => 100,
), array (
  0 => 'actor_id',
  1 => 'last_name',
));

        try {
            return $this->exporter->download(
                format: $format,
                response: $this->response,
                filename: 'actor',
                languageGroup: 'Actor',
                fields: $this->model->exportFields(),
                filters: $listRequest->filters,
                countProvider: fn (array $filters): int => $this->model->countExportRows($filters),
                rowProvider: fn (array $filters, int $limit, int|string|null $after): array => $this->model->getExportRows($filters, $limit, $after),
                primaryKey: 'actor_id',
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
    /** @return array<string,list<string>> */
    private function manyToManyDataFromPost(): array
    {
        $payload = $this->request->getPost('_many');
        $present = $this->request->getPost('_many_present');
        $payload = is_array($payload) ? $payload : [];
        $present = is_array($present) ? $present : [];
        $result = [];

        // _many_present distinguishes an intentionally cleared relation from a
        // many-to-many relation not managed by the current form.
        foreach ($present as $key => $flag) {
            if (!is_string($key) || empty($flag)) {
                continue;
            }
            $ids = $payload[$key] ?? [];
            $ids = is_array($ids) ? $ids : [];
            $result[$key] = array_values(array_unique(array_map('strval', array_filter(
                $ids,
                static fn ($id): bool => is_scalar($id) && trim((string) $id) !== ''
            ))));
        }
        return $result;
    }
    /** @return array<string,array<string,mixed>> */
    private function manyToManyRelatedCreateDataFromPost(): array
    {
        $flags = $this->request->getPost('_many_new');
        $payload = $this->request->getPost('_many_related');
        $flags = is_array($flags) ? $flags : [];
        $payload = is_array($payload) ? $payload : [];
        $result = [];

        foreach (self::MANY_TO_MANY_RELATED_CREATE_FIELDS as $relationKey => $allowedFields) {
            if (empty($flags[$relationKey]) || !isset($payload[$relationKey]) || !is_array($payload[$relationKey])) {
                continue;
            }
            $allowed = array_fill_keys((array) $allowedFields, true);
            $result[(string) $relationKey] = array_intersect_key($payload[$relationKey], $allowed);
        }

        return $result;
    }

    /** @return array<string,string> */
    private function validateManyToManyRelatedCreates(array $payloads): array
    {
        if ($payloads === []) {
            return [];
        }

        $definitions = ActorRules::manyToManyRelatedCreateRules();
        $errors = [];

        foreach ($payloads as $relationKey => $payload) {
            $relationRules = (array) ($definitions[$relationKey] ?? []);
            if ($relationRules === []) {
                continue;
            }

            $validation = service('validation');
            $validation->reset();
            $validation->setRules($relationRules);
            if ($validation->run($payload)) {
                continue;
            }

            foreach ($validation->getErrors() as $field => $message) {
                $errors[$relationKey . '__many_related__' . $field] = $message;
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
        $url = site_url('actor') . ($query === [] ? '' : '?' . http_build_query($query));

        return redirect()->to($url)->with('error', $message);
    }
}
