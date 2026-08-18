<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudListRequest;
use App\Libraries\Crud\CrudNavigationTrail;
use App\Libraries\Crud\CrudInputProcessor;
use App\Libraries\Crud\SubmissionGuard;
use App\Libraries\Crud\CrudUploadManager;
use App\Models\FilmModel;
use App\Services\FilmService;
use App\Validation\FilmRules;
use CodeIgniter\Exceptions\PageNotFoundException;
use RuntimeException;
use Throwable;

/**
 * CRUD full controller for resource `film`.
 *
 * Handles the HTTP flow and delegates queries/persistence to Model/Service.
 * Contains no SQL queries.
 */
final class FilmController extends BaseController
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
  0 => 'language_id',
  1 => 'original_language_id',
);

    /** Foreign keys authorized for atomic parent creation within the same form. */
    private const RELATED_CREATE_FIELDS = array (
  'language_id' =>
  array (
    0 => 'name',
  ),
  'original_language_id' =>
  array (
    0 => 'name',
  ),
);

    /** Fields allowed for inline many-to-many target creation. */
    private const MANY_TO_MANY_RELATED_CREATE_FIELDS = array (
  'many__film_actor__film_id' =>
  array (
    0 => 'first_name',
    1 => 'last_name',
  ),
  'many__film_category__film_id' =>
  array (
    0 => 'name',
  ),
);

    /** Upload fields and runtime policies. */
    private const UPLOAD_FIELDS = array (
  'uploads' =>
  array (
    'type' => 'file',
    'required' => false,
  ),
);

    /**
     * Allowed parent contexts for Create started from a hasMany relation.
     * The return table is derived exclusively from the generated schema, never from POST.
     */
    private const PARENT_CONTEXT_FIELDS = array (
  'language_id' =>
  array (
    'table' => 'language',
    'label' => 'Language',
  ),
  'original_language_id' =>
  array (
    'table' => 'language',
    'label' => 'Language',
  ),
);

    /** Read/query dependency: the generated Model. */
    private FilmModel $model;
    private FilmService $service;
    private CrudExporter $exporter;
    private CrudInputProcessor $inputProcessor;
    private SubmissionGuard $submissionGuard;
    private CrudUploadManager $uploadManager;

    public function __construct()
    {
        helper(['form', 'url']);
        $this->model = new FilmModel();
        $this->service = new FilmService();
        // Shared site runtime: a single implementation for export, input, and tokens.
        $this->exporter = new CrudExporter();
        $this->inputProcessor = new CrudInputProcessor();
        $this->submissionGuard = new SubmissionGuard();
        $this->uploadManager = new CrudUploadManager();
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
            'film_id',
            array (
  0 => 25,
  1 => 50,
  2 => 100,
),
            array (
  0 => 'film_id',
  1 => 'title',
  2 => 'language_id',
  3 => 'original_language_id',
)
        );

        $navigationContext = $this->navigationContextFromQuery();
        $cascadeTrail = $this->cascadeTrailFromQuery();
        $data = $this->model->getListPage($listRequest->filters, $listRequest->page, $listRequest->perPage, $listRequest->sort, $listRequest->direction);
        $data += [
            'title' => 'film',
            'primaryKey' => 'film_id',
            'filters' => $listRequest->filters,
            'query' => $listRequest->query,
            'navigationContext' => $navigationContext,
            'cascadeTrail' => $cascadeTrail,
        ];

        if ($this->request->isAJAX()) {
            return view('film/_table', $data);
        }

        $data['options'] = $this->model->relationOptions();

        return view('film/index', $data);
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
     * Serves an upload stored under writable/ after verifying
     * both the authorized field and the record existence.
     */
    public function upload(int|string $id, string $field)
    {
        if (!array_key_exists($field, self::UPLOAD_FIELDS)) {
            throw PageNotFoundException::forPageNotFound('Invalid upload field.');
        }

        $row = $this->findRecordOrFail($id);
        $filename = basename(trim((string) ($row->{$field} ?? '')));
        if ($filename === '') {
            throw PageNotFoundException::forPageNotFound('File not present.');
        }

        $settings = (array) (config('MyCrud')->upload ?? []);
        $directory = rtrim((string) ($settings['directory'] ?? (WRITEPATH . 'uploads')), DIRECTORY_SEPARATOR);
        $path = $directory . DIRECTORY_SEPARATOR . $filename;

        if (!is_file($path)) {
            throw PageNotFoundException::forPageNotFound('File not found.');
        }

        return $this->response->download($path, null)->inline();
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

        return view('film/view', [
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
  0 => 'language_id',
  1 => 'original_language_id',
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
        return view('film/create', [
            'title' => 'New record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => $this->model->relationOptions(),
            'relatedCreateOptions' => $this->model->relatedCreateRelationOptions(),
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
        $parentContext = $this->parentContextFromPost($navigationContext, $cascadeTrail);
        if (!$this->submissionGuard->consume('store', $this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'The form has already been submitted or has expired.');
        }

        $uploadErrors = $this->uploadManagerErrors(false);
        if ($uploadErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $uploadErrors);
        }
        $related = $this->relatedCreateDataFromPost();
        $manyToManyNew = $this->manyToManyRelatedCreateDataFromPost();
        $manyToManyNewErrors = $this->validateManyToManyRelatedCreates($manyToManyNew);
        if ($manyToManyNewErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $manyToManyNewErrors);
        }
        $createRules = FilmRules::createRules();
        foreach (array_keys($related) as $relatedField) {
            // The foreign key is produced by creating the parent within the same
            // transaction, so it cannot be required before the INSERT.
            unset($createRules[$relatedField]);
        }        if (!$this->validate($createRules, FilmRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $relatedErrors = $this->validateRelatedCreates($related);
        if ($relatedErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $relatedErrors);
        }
        $data = $this->formData(false);
        unset($data['film_id']);
        try {
            $id = $this->service->create($data, $related, $this->manyToManyDataFromPost(), $manyToManyNew);
            $uploadData = $this->uploadManager->store('film', $id, self::UPLOAD_FIELDS, $this->request->getFiles());
            if ($uploadData !== []) { $this->service->update($id, $uploadData); }
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
        $redirectUrl = $parentContext['url'] ?? $this->contextUrl('film', $navigationContext, $cascadeTrail);
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

        return view('film/edit', [
            'title' => 'Edit record',
            'row' => $this->findRecordOrFail($id),
            'errors' => session('errors') ?? [],
            'options' => $this->model->relationOptions(),
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
        $uploadErrors = $this->uploadManagerErrors(true);
        if ($uploadErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $uploadErrors);
        }
        if (!$this->validate(FilmRules::updateRules($id), FilmRules::messages())) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $manyToManyNew = $this->manyToManyRelatedCreateDataFromPost();
        $manyToManyNewErrors = $this->validateManyToManyRelatedCreates($manyToManyNew);
        if ($manyToManyNewErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $manyToManyNewErrors);
        }
        $data = $this->formData(true);
        unset($data['film_id']);
        try {
            $oldUploadValues = $this->currentUploadValues($id);
            $uploadData = $this->uploadManager->store('film', $id, self::UPLOAD_FIELDS, $this->request->getFiles());
            $this->service->update($id, array_merge($data, $uploadData), $this->manyToManyDataFromPost(), $manyToManyNew);
            $this->deleteReplacedUploads($oldUploadValues, $uploadData);
        } catch (Throwable $e) {
            return redirect()->back()->withInput()->with('error', $e->getMessage());
        }
        return redirect()->to($this->contextUrl('film', $navigationContext, $cascadeTrail))->with('message', 'Record updated successfully.');
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
            return redirect()->to($this->contextUrl('film', $navigationContext))->with('error', $e->getMessage());
        }
        return redirect()->to($this->contextUrl('film', $navigationContext))->with('message', 'Record deleted successfully.');
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

        $listRequest = CrudListRequest::fromRequest($this->request, 'film_id', array (
  0 => 25,
  1 => 50,
  2 => 100,
), array (
  0 => 'film_id',
  1 => 'title',
  2 => 'language_id',
  3 => 'original_language_id',
));

        try {
            return $this->exporter->download(
                format: $format,
                response: $this->response,
                filename: 'film',
                languageGroup: 'Film',
                fields: $this->model->exportFields(),
                filters: $listRequest->filters,
                countProvider: fn (array $filters): int => $this->model->countExportRows($filters),
                rowProvider: fn (array $filters, int $limit, int|string|null $after): array => $this->model->getExportRows($filters, $limit, $after),
                primaryKey: 'film_id',
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
  1 => 'uploads',
),
            array (
),
            [],
            false,
            array (
  0 => 'original_language_id',
)
        );
    }
    /**
     * Validates uploaded files according to the generated field policies.
     *
     * @param bool $isUpdate True when validating an Edit request.
     * @return array<string,string> Field-scoped validation errors.
     */
    private function uploadManagerErrors(bool $isUpdate): array
    {
        return $this->uploadManager->validate(self::UPLOAD_FIELDS, $this->request->getFiles(), $isUpdate);
    }

    /**
     * Reads currently persisted upload filenames before an Edit replacement.
     *
     * @param int|string $id Record identifier.
     * @return array<string,string> Existing filenames keyed by upload field.
     */
    private function currentUploadValues(int|string $id): array
    {
        $row = $this->findRecordOrFail($id);
        $values = [];
        foreach (array_keys(self::UPLOAD_FIELDS) as $field) {
            $values[$field] = isset($row->{$field}) ? (string) $row->{$field} : '';
        }
        return $values;
    }

    /**
     * Deletes files that were replaced successfully by a new upload.
     *
     * @param array<string,string> $old Previous filenames.
     * @param array<string,string> $new Newly stored filenames.
     */
    private function deleteReplacedUploads(array $old, array $new): void
    {
        foreach ($new as $field => $filename) {
            if (($old[$field] ?? '') !== '' && ($old[$field] ?? '') !== $filename) {
                $this->uploadManager->delete($old[$field]);
            }
        }
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

        $definitions = FilmRules::manyToManyRelatedCreateRules();
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

        $definitions = FilmRules::relatedCreateRules();
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
        $url = site_url('film') . ($query === [] ? '' : '?' . http_build_query($query));

        return redirect()->to($url)->with('error', $message);
    }
}
