<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/** Generates the REST v1 controller and serialization Resource. */
final class ApiGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $api = (string) $config['classes']['api'];
        $service = (string) $config['classes']['service'];
        $model = (string) $config['classes']['model'];
        $rules = (string) $config['classes']['apiRules'];
        $pk = (string) $config['primaryKey'];
        $resource = (string) ($config['classes']['resource'] ?? (preg_replace('/ApiController$/', 'Resource', $api) ?: $api . 'Resource'));
        $softDeleteField = (string) ($config['softDelete']['field'] ?? 'deleted_at');
        $apiCaps = (array) ($config['apiCapabilities'] ?? []);
        $apiList = !empty($apiCaps['list']);
        $apiRead = !empty($apiCaps['read']);
        $apiCreate = !empty($apiCaps['create']);
        $apiUpdate = !empty($apiCaps['update']);
        $apiDelete = !empty($apiCaps['delete']);
        $apiTrash = !empty($apiCaps['trash']);
        $apiRestore = !empty($apiCaps['restore']);
        $apiForceDelete = !empty($apiCaps['forceDelete']);
        $apiWritable = $apiCreate || $apiUpdate;
        $isView = !empty($config['isView']);
        $recordDetail = $apiRead;
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        $readable = [];
        $writable = [];
        $filterable = [];
        $sortable = [];
        $uploadFields = [];

        foreach ($config['fields'] as $field) {
            $name = (string) $field['name'];
            $ui = (array) ($field['ui'] ?? []);
            $attributes = (array) ($field['attributes']['boolean'] ?? []);
            $primaryAuto = !empty($field['primary']) && !empty($field['autoIncrement']);
            $managedField = !empty($field['databaseManaged'])
                || (!empty($config['features']['softDeletes']) && $name === $softDeleteField)
                || ($timestampsEnabled && in_array($name, ['created_at', 'updated_at'], true));
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary'])
                || !empty($index['unique'])
                || !empty($index['leading']);

            // API visibility is an explicit Builder choice and is not
            // derived from the field name.
            if (!array_key_exists('apiVisible', $ui) || !empty($ui['apiVisible'])) {
                $readable[] = $name;
            }

            $inputType = strtolower((string) ($field['inputType'] ?? $ui['inputType'] ?? 'text'));
            $isUpload = in_array($inputType, ['file', 'image'], true);

            if ($isUpload && ($apiCreate || $apiUpdate)) {
                $uploadFields[$name] = [
                    'type' => $inputType,
                    'required' => empty($field['nullable']) && ($field['default'] ?? null) === null,
                ];
            }

            // Binary fields never accept arbitrary persisted filenames from JSON/form payloads.
            // They use the generated multipart upload path and CrudUploadManager only.
            if (
                $apiWritable
                && !$isUpload
                && !$primaryAuto
                && !$managedField
                && !empty($ui['visibleForm'])
                && !in_array('disabled', $attributes, true)
                && !in_array('readonly', $attributes, true)
            ) {
                $writable[] = $name;
            }

            if (!empty($ui['searchable']) && ($indexEligible || $isView)) {
                $filterable[] = $name;
            }
            if (!empty($ui['sortable']) && ($indexEligible || $isView)) {
                $sortable[] = $name;
            }
        }

        foreach ($config['relations']['belongsTo'] ?? [] as $fieldName => $relation) {
            $fieldUi = (array) ($config['fields'][$fieldName]['ui'] ?? []);
            $alias = (string) ($relation['alias'] ?? '');
            if ($alias !== '' && (!array_key_exists('apiVisible', $fieldUi) || !empty($fieldUi['apiVisible']))) {
                $readable[] = $alias;
            }
        }

        if (!in_array($pk, $readable, true)) {
            array_unshift($readable, $pk);
        }
        if (!in_array($pk, $sortable, true)) {
            $sortable[] = $pk;
        }

        $readableCode = var_export(array_values(array_unique($readable)), true);
        $writableCode = var_export(array_values(array_unique($writable)), true);
        $filterableCode = var_export(array_values(array_unique($filterable)), true);
        $sortableCode = var_export(array_values(array_unique($sortable)), true);
        $uploadFieldsCode = var_export($uploadFields, true);
        $hasApiUploads = $uploadFields !== [] && ($apiCreate || $apiUpdate);
        $baseControllerContent = <<<'BASEAPI'
<?php

declare(strict_types=1);

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use Throwable;

/**
 * Base comune delle API generate.
 * Standardizes payloads, errors, and pagination limits.
 */
abstract class BaseApiController extends BaseController
{
    protected int $maxPerPage = 100;

    protected function success(
        mixed $data,
        array $meta = [],
        array $links = [],
        int $status = 200
    ): ResponseInterface {
        return $this->response->setStatusCode($status)->setJSON([
            'data'  => $data,
            'meta'  => (object) $meta,
            'links' => (object) $links,
        ]);
    }

    protected function error(
        string $code,
        string $message,
        int $status,
        array $fields = []
    ): ResponseInterface {
        $error = [
            'code'    => $code,
            'message' => $message,
        ];

        if ($fields !== []) {
            $error['fields'] = $fields;
        }

        return $this->response
            ->setStatusCode($status)
            ->setJSON(['error' => $error]);
    }

    protected function payload(): array
    {
        $json = $this->request->getJSON(true);

        if (is_array($json)) {
            return $json;
        }

        $raw = $this->request->getRawInput();

        return is_array($raw) && $raw !== []
            ? $raw
            : (array) $this->request->getPost();
    }

    protected function safePerPage(int $default = 25): int
    {
        $requested = (int) ($this->request->getGet('perPage') ?? $default);

        return max(1, min($this->maxPerPage, $requested));
    }

    protected function internalError(Throwable $exception): ResponseInterface
    {
        log_message('error', '[API] {message} in {file}:{line}', [
            'message' => $exception->getMessage(),
            'file'    => $exception->getFile(),
            'line'    => $exception->getLine(),
        ]);

        return $this->error(
            'INTERNAL_ERROR',
            'Internal server error.',
            500
        );
    }
}

BASEAPI;

        $resourceContent = <<<PHP
<?php

declare(strict_types=1);

namespace App\API\Resources;

/**
 * Output-only serializer for `{$table}`.
 *
 * It performs no queries, request parsing, validation, or persistence.
 */
final class {$resource}
{
    private const READABLE = {$readableCode};

    public static function make(object|array \$record): array
    {
        if (is_array(\$record)) {
            \$source = \$record;
        } elseif (method_exists(\$record, 'toRawArray')) {
            \$source = \$record->toRawArray();
        } elseif (method_exists(\$record, 'toArray')) {
            \$source = \$record->toArray();
        } else {
            \$source = get_object_vars(\$record);
        }

        return array_intersect_key(\$source, array_flip(self::READABLE));
    }

    public static function collection(array \$records): array
    {
        return array_map(static fn (object|array \$record): array => self::make(\$record), \$records);
    }
}

PHP;

        $softMethods = '';

        if ($apiTrash) {
            $softMethods .= <<<PHP

    public function trash()
    {
        try {
            return \$this->success({$resource}::collection(\$this->model->getDeletedList()));
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }
PHP;
        }

        if ($apiRestore) {
            $softMethods .= <<<PHP

    public function restore(int|string \$id)
    {
        try {
            \$this->service->restore(\$id);
            return \$this->success(['{$pk}' => \$id, 'restored' => true]);
        } catch (RuntimeException \$e) {
            return \$this->error('RESTORE_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }
PHP;
        }

        if ($apiForceDelete) {
            $softMethods .= <<<PHP

    public function forceDelete(int|string \$id)
    {
        try {
            \$this->service->forceDelete(\$id);
            return \$this->response->setStatusCode(204)->setBody('');
        } catch (RuntimeException \$e) {
            return \$this->error('DELETE_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }
PHP;
        }

        $resourceUse = "use App\\API\\Resources\\{$resource};";
        $serviceUse = "use App\\Services\\{$service};";
        $modelUse = "use App\\Models\\{$model};";
        $uploadUse = $hasApiUploads ? "use App\\Libraries\\Crud\\CrudUploadManager;\n" : '';
        $rulesUse = ($apiCreate || $apiUpdate) ? "use App\\Validation\\{$rules};\n" : '';
        $uploadProperty = $hasApiUploads ? "    private CrudUploadManager \$uploadManager;\n" : '';
        $uploadInit = $hasApiUploads ? "        \$this->uploadManager = new CrudUploadManager();\n" : '';

        $recordApiMethod = $recordDetail ? <<<PHP
    public function show(int|string \$id)
    {
        try {
            return \$this->success({$resource}::make(\$this->recordOrFail(\$id)));
        } catch (RuntimeException) {
            return \$this->error('NOT_FOUND', 'Record not found.', 404);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

PHP : '';

        $createUploadValidation = $hasApiUploads ? <<<'PHP'
        $uploadErrors = $this->apiUploadErrors(false);
        if ($uploadErrors !== []) {
            return $this->error('VALIDATION_ERROR', 'Upload non valido.', 422, $uploadErrors);
        }
PHP : '';
        $createEmptyCondition = $hasApiUploads
            ? '$data === [] && !$this->hasApiUpload()'
            : '$data === []';
        $createUploadPersistence = $hasApiUploads ? <<<'PHP'
            $uploadData = $this->storeApiUploads($id);
            if ($uploadData !== []) {
                $this->service->updateUploads($id, $uploadData);
            }
PHP : '';

        $writeApiMethods = '';

        if ($apiCreate) {
            $writeApiMethods .= <<<PHP
    public function create()
    {
        \$data = \$this->writableData(\$this->payload());
{$createUploadValidation}
        if ({$createEmptyCondition}) {
            return \$this->error('EMPTY_PAYLOAD', 'No writable field received.', 422);
        }
        if (!\$this->validateData(\$data, {$rules}::createRules(), {$rules}::messages())) {
            return \$this->error('VALIDATION_ERROR', 'Dati non validi.', 422, \$this->validator->getErrors());
        }
        try {
            \$id = \$this->service->create(\$data);
{$createUploadPersistence}
            return \$this->success(['{$pk}' => \$id], [], [], 201);
        } catch (RuntimeException \$e) {
            return \$this->error('CREATE_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

PHP;
        }

        if ($apiUpdate) {
            $writeApiMethods .= <<<PHP
    public function update(int|string \$id)
    {
        return \$this->writeUpdate(\$id, false);
    }

    public function patch(int|string \$id)
    {
        return \$this->writeUpdate(\$id, true);
    }

    private function writeUpdate(int|string \$id, bool \$partial)
    {
        \$data = \$this->writableData(\$this->payload());
        unset(\$data['{$pk}']);
        if (\$data === []) {
            return \$this->error('EMPTY_PAYLOAD', 'No writable field received.', 422);
        }
        \$rules = {$rules}::updateRules(\$id);
        if (\$partial) {
            \$rules = array_intersect_key(\$rules, \$data);
        }
        if (\$rules !== [] && !\$this->validateData(\$data, \$rules, {$rules}::messages())) {
            return \$this->error('VALIDATION_ERROR', 'Dati non validi.', 422, \$this->validator->getErrors());
        }
        try {
            \$this->recordOrFail(\$id);
            if (\$partial) {
                \$this->service->patch(\$id, \$data);
            } else {
                \$this->service->update(\$id, \$data);
            }
            return \$this->success({$resource}::make(\$this->recordOrFail(\$id)));
        } catch (RuntimeException \$e) {
            if (\$e->getMessage() === 'Record not found.') {
                return \$this->error('NOT_FOUND', 'Record not found.', 404);
            }
            return \$this->error('UPDATE_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

PHP;
        }

        if ($apiUpdate && $hasApiUploads) {
            $writeApiMethods .= <<<PHP
    /**
     * Replaces one or more upload fields through multipart/form-data POST.
     *
     * Separate endpoint from PUT/PATCH for PHP 8.3 compatibility, where
     * \$_FILES viene popolato automaticamente per multipart POST.
     */
    public function upload(int|string \$id)
    {
        \$uploadErrors = \$this->apiUploadErrors(true);
        if (\$uploadErrors !== []) {
            return \$this->error('VALIDATION_ERROR', 'Upload non valido.', 422, \$uploadErrors);
        }
        if (!\$this->hasApiUpload()) {
            return \$this->error('EMPTY_UPLOAD', 'No file ricevuto.', 422);
        }

        try {
            \$this->recordOrFail(\$id);
            \$oldUploadValues = \$this->currentApiUploadValues(\$id);
            \$uploadData = \$this->storeApiUploads(\$id);
            if (\$uploadData === []) {
                return \$this->error('EMPTY_UPLOAD', 'No file valido ricevuto.', 422);
            }

            \$this->service->updateUploads(\$id, \$uploadData);
            \$this->deleteReplacedApiUploads(\$oldUploadValues, \$uploadData);

            return \$this->success({$resource}::make(\$this->recordOrFail(\$id)));
        } catch (RuntimeException \$e) {
            if (\$e->getMessage() === 'Record not found.') {
                return \$this->error('NOT_FOUND', 'Record not found.', 404);
            }
            return \$this->error('UPLOAD_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

PHP;
        }

        if ($apiDelete) {
            $writeApiMethods .= <<<PHP
    public function delete(int|string \$id)
    {
        try {
            \$this->recordOrFail(\$id);
            \$this->service->delete(\$id);
            return \$this->response->setStatusCode(204)->setBody('');
        } catch (RuntimeException \$e) {
            if (\$e->getMessage() === 'Record not found.') {
                return \$this->error('NOT_FOUND', 'Record not found.', 404);
            }
            return \$this->error('DELETE_FAILED', \$e->getMessage(), 400);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

PHP;
        }

        $runtimeExceptionUse = (
            $apiRead || $apiCreate || $apiUpdate || $apiDelete || $apiRestore || $apiForceDelete
        ) ? "use RuntimeException;\n" : '';
        $controllerDoc = $isView
            ? "/**\n * Read-only API for SQL VIEW `{$table}`.\n * Exposes only GET operations compatible with generated capabilities.\n * READ operations are delegated to the generated Model; no SQL is composed here.\n */"
            : "/**\n * REST API v1 for resource `{$table}`.\n * Exposed operations follow capabilities generated by the Builder/schema.\n * READ operations use the generated Model; WRITE operations use the generated Service.\n * This controller never composes SQL or resolves relation classes dynamically.\n */";

        $listApiMethod = $apiList ? <<<PHP
    public function index()
    {
        try {
            \$query = (array) \$this->request->getGet();
            \$query['perPage'] = \$this->safePerPage();
            \$result = \$this->model->apiList(\$query, self::FILTERABLE_FIELDS, self::SORTABLE_FIELDS);
            return \$this->success({$resource}::collection(\$result['rows']), \$result['meta'], \$result['links']);
        } catch (Throwable \$e) {
            return \$this->internalError(\$e);
        }
    }

PHP : '';

        $writableDataHelper = $apiWritable ? <<<'PHP'

    /**
     * Filters an incoming REST payload against the generated API write whitelist.
     *
     * Input filtering belongs to the API boundary. The Resource remains an
     * output-only serializer and never performs persistence or request handling.
     *
     * @param array<string,mixed> $data
     * @return array<string,mixed>
     */
    private function writableData(array $data): array
    {
        return array_intersect_key($data, array_flip(self::WRITABLE_FIELDS));
    }

PHP : '';

        $recordLookupHelper = ($apiRead || $apiUpdate || $apiDelete || $hasApiUploads) ? <<<'PHP'

    /**
     * Reads one record through the Model and translates absence into the API
     * application exception used by the existing error mapping.
     */
    private function recordOrFail(int|string $id): object
    {
        $record = $this->model->getDetail($id);
        if (!is_object($record)) {
            throw new RuntimeException('Record not found.');
        }

        return $record;
    }

PHP : '';

        $apiUploadHelpers = $hasApiUploads ? <<<'PHP'
    /** @return array<string,string> */
    private function apiUploadErrors(bool $isUpdate): array
    {
        return $this->uploadManager->validate(
            self::UPLOAD_FIELDS,
            $this->request->getFiles(),
            $isUpdate
        );
    }

    private function hasApiUpload(): bool
    {
        foreach (array_keys(self::UPLOAD_FIELDS) as $field) {
            $file = $this->request->getFile($field);
            if ($file !== null && $file->getError() !== UPLOAD_ERR_NO_FILE) {
                return true;
            }
        }

        return false;
    }

    /** @return array<string,string> */
    private function storeApiUploads(int|string $id): array
    {
        return $this->uploadManager->store(
            self::API_TABLE,
            $id,
            self::UPLOAD_FIELDS,
            $this->request->getFiles()
        );
    }

    /** @return array<string,string> */
    private function currentApiUploadValues(int|string $id): array
    {
        if (self::UPLOAD_FIELDS === []) {
            return [];
        }

        $record = $this->recordOrFail($id);
        $values = [];
        foreach (array_keys(self::UPLOAD_FIELDS) as $field) {
            if (is_array($record)) {
                $values[$field] = (string) ($record[$field] ?? '');
            } else {
                $values[$field] = isset($record->{$field}) ? (string) $record->{$field} : '';
            }
        }

        return $values;
    }

    /** @param array<string,string> $old @param array<string,string> $new */
    private function deleteReplacedApiUploads(array $old, array $new): void
    {
        foreach ($new as $field => $filename) {
            $previous = (string) ($old[$field] ?? '');
            if ($previous !== '' && $previous !== $filename) {
                $this->uploadManager->delete($previous);
            }
        }
    }

PHP : '';

        $apiRuntimeConstants = $hasApiUploads
            ? "    private const API_TABLE = '{$table}';\n    private const UPLOAD_FIELDS = {$uploadFieldsCode};\n"
            : '';

        $controllerContent = <<<PHP
<?php

declare(strict_types=1);

namespace App\Controllers\Api\V1;

{$resourceUse}
use App\Controllers\Api\BaseApiController;
{$uploadUse}{$modelUse}
{$serviceUse}
{$rulesUse}{$runtimeExceptionUse}use Throwable;

{$controllerDoc}
final class {$api} extends BaseApiController
{
{$apiRuntimeConstants}    /** Fields accepted as REST list filters. API query policy belongs to the HTTP boundary. */
    private const FILTERABLE_FIELDS = {$filterableCode};

    /** Fields accepted for REST list sorting. API query policy belongs to the HTTP boundary. */
    private const SORTABLE_FIELDS = {$sortableCode};

    /** Fields accepted from REST JSON/form request bodies. Binary upload fields are intentionally excluded. */
    private const WRITABLE_FIELDS = {$writableCode};

{$uploadProperty}    public function __construct(
        private readonly {$model} \$model = new {$model}(),
        private readonly {$service} \$service = new {$service}()
    ) {
{$uploadInit}    }

{$listApiMethod}{$recordApiMethod}{$writeApiMethods}{$softMethods}{$writableDataHelper}{$recordLookupHelper}{$apiUploadHelpers}}

PHP;

        return [
            'base_controller' => $this->writeGenerated(
                'Generated/Controllers/Api/BaseApiController.php',
                $baseControllerContent,
                $force
            ),
            'controller' => $this->writeGenerated(
                "Generated/Controllers/Api/V1/{$api}.php",
                $controllerContent,
                $force
            ),
            'resource' => $this->writeGenerated(
                "Generated/API/Resources/{$resource}.php",
                $resourceContent,
                $force
            ),
        ];
    }
}
