<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

use App\Libraries\MyCrud\Core\FieldPolicy;

/**
 * Generates the shared web Controller for Basic, Standard, and Full architectures.
 *
 * Lato generatore: il Controller prodotto deve descrivere il flusso HTTP e
 * avoid duplicating infrastructure. Export, list parsing, one-time tokens, and sanitization
 * meccanica dell'input sono delegati alle librerie runtime App\Libraries\Crud.
 * Basic/Standard-Full differences are resolved here during generation,
 * so the site Controller does not need unnecessary private adapters or wrappers.
 */
final class ControllerGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) $config['table'];
        $primaryKey = (string) $config['primaryKey'];
        $primaryKeys = array_values((array) ($config['primaryKeys'] ?? [$primaryKey]));
        $exportCursorKeyCode = count($primaryKeys) > 1 ? var_export($primaryKeys, true) : var_export($primaryKey, true);
        $architecture = (string) ($config['architecture'] ?? 'basic');
        $languageFile = (string) ($config['languageFile'] ?? 'Fields');
        $controller = (string) $config['classes']['controller'];
        $model = (string) $config['classes']['model'];
        $service = (string) $config['classes']['service'];
        $rules = (string) $config['classes']['rules'];
        $useService = !empty($config['features']['service']);
        $softDeleteEnabled = !empty($config['features']['softDeletes']);
        $createAllowed = !empty($config['features']['createAllowed']);
        $writable = !empty($config['features']['writable']);
        $recordDetail = !empty($config['features']['recordDetail']);
        $isView = !empty($config['isView']);
        $hasForms = $createAllowed || $writable;
        $hasBelongsTo = !empty($config['relations']['belongsTo']);
        $hasHasMany = !empty($config['relationsConfig']['hasMany']);
        $hasManyToMany = !empty($config['relationsConfig']['manyToMany']);
        $enabledManyToMany = array_filter(
            (array) ($config['relationsConfig']['manyToMany'] ?? []),
            static fn (array $relation): bool => !empty($relation['enabled'])
        );
        $manyToManyCreateEnabled = (bool) array_filter(
            $enabledManyToMany,
            static fn (array $relation): bool => !empty($relation['createEnabled'])
        );
        $manyToManyEditEnabled = (bool) array_filter(
            $enabledManyToMany,
            static fn (array $relation): bool => !empty($relation['editEnabled'])
        );
        $manyToManyRelatedCreateEnabled = (bool) array_filter(
            $enabledManyToMany,
            static fn (array $relation): bool => !empty($relation['createRelatedEnabled'])
                && !empty($relation['createRelatedAvailable'])
        );
        $manyToManyRelatedCreateEnabled = (bool) array_filter(
            $enabledManyToMany,
            static fn (array $relation): bool =>
                !empty($relation['createRelatedEnabled'])
                && !empty($relation['createRelatedAvailable'])
        );
        $rulesUse = $hasForms ? "use App\\Validation\\{$rules};\n" : '';
        $manyToManyCreatePayload = ($hasManyToMany && $createAllowed) ? '$this->manyToManyDataFromPost()' : '[]';
        $manyToManyUpdatePayload = ($hasManyToMany && $writable) ? '$this->manyToManyDataFromPost()' : '[]';
        $manyToManyNewPayload = $manyToManyRelatedCreateEnabled ? '$manyToManyNew' : '[]';
        $deletedField = (string) ($config['softDelete']['field'] ?? 'deleted_at');
        $viewDoc = $isView ? "\n * SQL VIEW: generated as read-only; any writes are manual extensions." : '';

        $myCrudConfig = config('MyCrud');
        $csvChunkSize = max(100, min(5000, (int) ($myCrudConfig->csvChunkSize ?? 2000)));
        $csvMaximumRows = max(1000, (int) ($myCrudConfig->csvMaximumRows ?? 150000));
        $csvUnfilteredMaximumRows = max(0, (int) ($myCrudConfig->csvUnfilteredMaximumRows ?? 25000));
        $wordChunkSize = max(100, min(5000, (int) ($myCrudConfig->wordChunkSize ?? $csvChunkSize)));
        $wordMaximumRows = max(1000, (int) ($myCrudConfig->wordMaximumRows ?? 10000));
        $wordUnfilteredMaximumRows = max(0, (int) ($myCrudConfig->wordUnfilteredMaximumRows ?? 5000));
        $defaultPerPage = max(25, min(100, (int) ($myCrudConfig->defaultPerPage ?? 25)));
        $maximumPerPage = max($defaultPerPage, min(500, (int) ($myCrudConfig->maximumPerPage ?? 100)));
        $relationAjaxLimit = max(1, min(100, (int) ($myCrudConfig->relationAjaxLimit ?? 20)));
        $relationAjaxMinimumChars = max(0, min(10, (int) ($myCrudConfig->relationAjaxMinimumChars ?? 2)));

        $allowedPerPage = array_values(array_filter(
            [25, 50, 100],
            static fn (int $size): bool => $size <= $maximumPerPage
        ));
        if (!in_array($defaultPerPage, $allowedPerPage, true)) {
            $allowedPerPage[] = $defaultPerPage;
        }
        $allowedPerPage = array_values(array_unique($allowedPerPage));
        sort($allowedPerPage);
        $allowedPerPageCode = var_export($allowedPerPage, true);

        $primaryAutoIncrement = false;
        $disabled = [];
        $readonly = [];
        $passwords = [];
        $automaticDateFields = [];
        $managed = [];
        $nullableForeignKeys = [];
        $simpleFilterFields = [];
        $navigationContextFields = [];
        $relatedCreateFields = [];
        $relatedCreateTables = [];
        $uploadFields = [];
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        foreach ($config['fields'] as $field) {
            $name = (string) ($field['name'] ?? '');
            $type = strtolower((string) ($field['type'] ?? ''));
            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));

            if (in_array($inputType, ['file', 'image'], true)) {
                $uploadFields[$name] = [
                    'type' => $inputType,
                    'required' => empty($field['nullable']) && ($field['default'] ?? null) === null,
                ];
                // The file value does not come from getPost(): it is added after storage.
                $managed[] = $name;
            }

            if (
                !empty($field['foreignKey'])
                && preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $name) === 1
            ) {
                $navigationContextFields[] = $name;
                if (!empty($field['nullable'])) {
                    $nullableForeignKeys[] = $name;
                }
                if (
                    !empty($field['relationCreate']['enabled'])
                    && !empty($field['foreignKey']['relatedCreate']['available'])
                ) {
                    $relatedCreateFields[$name] = array_values(array_keys((array) ($field['foreignKey']['relatedCreate']['fields'] ?? [])));
                    $relatedCreateTables[$name] = (string) ($field['foreignKey']['relatedCreate']['table'] ?? $field['foreignKey']['parentTable'] ?? '');
                }
            }

            if ($name === $primaryKey) {
                $primaryAutoIncrement = !empty($field['autoIncrement']);
            }

            $boolean = (array) ($field['attributes']['boolean'] ?? []);
            if (in_array('disabled', $boolean, true)) {
                $disabled[] = $name;
            }
            if (in_array('readonly', $boolean, true)) {
                $readonly[] = $name;
            }
            if (FieldPolicy::isPassword($name, $inputType)) {
                $passwords[] = $name;
            }
            if (
                empty($field['databaseManaged'])
                && preg_match('/(?:^|_)(?:data_record|recorded_at)(?:$|_)/i', $name) === 1
                && in_array($type, ['date', 'datetime', 'timestamp'], true)
            ) {
                $automaticDateFields[$name] = $type === 'date' ? 'Y-m-d' : 'Y-m-d H:i:s';
            }
            if (
                !empty($field['databaseManaged'])
                || ($timestampsEnabled && in_array($name, ['created_at', 'updated_at'], true))
                || ($softDeleteEnabled && $name === $deletedField)
            ) {
                $managed[] = $name;
            }

            $ui = (array) ($field['ui'] ?? []);
            $index = (array) ($field['index'] ?? []);
            $indexEligible = !empty($index['primary']) || !empty($index['unique']) || !empty($index['leading']);
            $sensitive = !empty($ui['sensitive']) || FieldPolicy::isSensitive($name, $inputType);
            if (
                !$sensitive
                && !empty($ui['searchable'])
                && ($indexEligible || $isView)
                && preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $name) === 1
            ) {
                $simpleFilterFields[] = $name;
            }
        }

        $manyToManyRelatedCreateFields = [];
        $manyToManyRelatedCreateTables = [];

        foreach ($enabledManyToMany as $relationKey => $relation) {
            if (empty($relation['createRelatedEnabled']) || empty($relation['createRelatedAvailable'])) {
                continue;
            }

            $definition = (array) ($relation['relatedCreate'] ?? []);

            $manyToManyRelatedCreateFields[(string) $relationKey] = array_values(array_keys(
                (array) ($definition['fields'] ?? [])
            ));

            $manyToManyRelatedCreateTables[(string) $relationKey]
                = trim((string) ($relation['relatedTable'] ?? ''));
        }

        $disabledCode = var_export(array_values(array_unique($disabled)), true);
        $readonlyCode = var_export(array_values(array_unique($readonly)), true);
        $passwordsCode = var_export(array_values(array_unique($passwords)), true);
        $automaticDateFieldsCode = var_export($automaticDateFields, true);
        $managedCode = var_export(array_values(array_unique($managed)), true);
        $nullableForeignKeysCode = var_export(array_values(array_unique($nullableForeignKeys)), true);
        $simpleFilterFieldsCode = var_export(array_values(array_unique($simpleFilterFields)), true);
        $navigationContextFieldsCode = var_export(array_values(array_unique($navigationContextFields)), true);
        $relatedCreatePostLines = [];
        foreach ($relatedCreateFields as $relationField => $allowedFields) {
            $parentTable = trim((string) ($relatedCreateTables[$relationField] ?? ''));
            if ($parentTable === '') {
                continue;
            }
            $allowedCode = var_export(array_values($allowedFields), true);
            $relatedCreatePostLines[] = <<<PHP
        if (!empty(\$flags['{$relationField}'])) {
            \$payload = \$this->request->getPost('{$relationField}');
            if (is_array(\$payload)) {
                \$allowed = array_fill_keys({$allowedCode}, true);
                \$related['{$relationField}'] = array_intersect_key(\$payload, \$allowed);
            }
        }
PHP;
        }
        $relatedCreatePostCode = implode("\n", $relatedCreatePostLines);
        $relatedCreateFieldsCode = var_export($relatedCreateFields, true);
        $manyToManyRelatedCreateFieldsCode = var_export($manyToManyRelatedCreateFields, true);
        $manyToManyRelatedCreateTablesCode = var_export($manyToManyRelatedCreateTables, true);
        $hasRelatedCreate = $relatedCreateFields !== [];
        $hasManyToManyRelatedCreate = $manyToManyRelatedCreateFields !== [];
        $hasOperationalManyToManyUpdate = $manyToManyEditEnabled || $hasManyToManyRelatedCreate;
        $serviceCreateArgs = ['$data'];
        if ($hasRelatedCreate) {
            $serviceCreateArgs[] = '$related';
        }
        if ($manyToManyCreateEnabled || $hasManyToManyRelatedCreate) {
            $serviceCreateArgs[] = $manyToManyCreatePayload;
        }
        if ($hasManyToManyRelatedCreate) {
            $serviceCreateArgs[] = $manyToManyNewPayload;
        }
        $serviceCreateCall = '$this->service->create(' . implode(', ', $serviceCreateArgs) . ')';

        $serviceUpdateArgs = ['$id', '$data'];
        if ($manyToManyEditEnabled || $hasManyToManyRelatedCreate) {
            $serviceUpdateArgs[] = $manyToManyUpdatePayload;
        }
        if ($hasManyToManyRelatedCreate) {
            $serviceUpdateArgs[] = $manyToManyNewPayload;
        }
        $serviceUpdateCall = '$this->service->update(' . implode(', ', $serviceUpdateArgs) . ')';

        // Basic has no Service layer, so its Model call is also emitted feature-aware.
        $modelCreateArgs = ['$data'];
        if ($hasRelatedCreate) {
            $modelCreateArgs[] = '$related';
        }
        if ($manyToManyCreateEnabled || $hasManyToManyRelatedCreate) {
            $modelCreateArgs[] = $manyToManyCreatePayload;
        }
        if ($hasManyToManyRelatedCreate) {
            $modelCreateArgs[] = $manyToManyNewPayload;
        }
        $modelCreateCall = '$this->model->createRecord(' . implode(', ', $modelCreateArgs) . ')';

        $modelUpdateArgs = ['$id', '$data'];
        if ($manyToManyEditEnabled || $hasManyToManyRelatedCreate) {
            $modelUpdateArgs[] = $manyToManyUpdatePayload;
        }
        if ($hasManyToManyRelatedCreate) {
            $modelUpdateArgs[] = $manyToManyNewPayload;
        }
        $modelUpdateManyCall = '$this->model->updateRecordWithManyToMany(' . implode(', ', $modelUpdateArgs) . ')';

        $uploadFieldsCode = var_export($uploadFields, true);
        $hasUploads = $uploadFields !== [];

        // Read operations always use the generated Model directly.
        // Standard/Full add a Service only for write use-cases.
        $modelUse = "use App\\Models\\{$model};";
        $modelType = $model;
        $modelInit = "        \$this->model = new {$model}();";
        $serviceUse = $useService ? "use App\\Services\\{$service};\n" : '';
        $serviceProperty = $useService ? "    private {$service} \$service;\n" : '';
        $serviceInit = $useService ? "        \$this->service = new {$service}();\n" : '';

        // Lato generatore: Standard/Full demandano date e password al Service;
        // Basic uses CrudInputProcessor because it does not have the Service layer.
        $processorAutomaticDates = $useService ? '[]' : $automaticDateFieldsCode;
        $processorPasswordFields = $useService ? '[]' : $passwordsCode;
        $processorHashPasswords = $useService ? 'false' : 'true';

        if ($useService) {
            $listCall = "\$this->model->getListPage(\$listRequest->filters, \$listRequest->page, \$listRequest->perPage, \$listRequest->sort, \$listRequest->direction)";
            $findCall = "\$this->model->getDetail(\$id)";
            $createCode = "            {$serviceCreateCall};";
            $updateCode = "            {$serviceUpdateCall};";
            $deleteCode = "            \$this->service->delete(\$id);";
            $exportFieldsCall = "\$this->model->exportFields()";
            $exportCountCall = "\$this->model->countExportRows(\$filters)";
            $exportRowsCall = "\$this->model->getExportRows(\$filters, \$limit, \$after)";
            $deletedListCall = "\$this->model->getDeletedList()";
            $restoreCode = "            \$this->service->restore(\$id);";
            $forceDeleteCode = "            \$this->service->forceDelete(\$id);";
        } else {
            $listCall = "\$this->model->getListPage(\$listRequest->filters, \$listRequest->page, \$listRequest->perPage, \$listRequest->sort, \$listRequest->direction)";
            $findCall = "\$this->model->getDetail(\$id)";
            $createCode = "            {$modelCreateCall};";
            if ($hasOperationalManyToManyUpdate) {
                $updateCode = <<<PHP
            if (!{$modelUpdateManyCall}) {
                throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Update failed.');
            }
PHP;
            } else {
                $updateCode = <<<PHP
            if (!\$this->model->updateRecord(\$id, \$data)) {
                throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Update failed.');
            }
PHP;
            }
            $deleteCode = <<<PHP
            if (!\$this->model->delete(\$id)) {
                throw new RuntimeException('Delete failed.');
            }
            \$this->model->clearListCountCache();
PHP;
            $exportFieldsCall = "\$this->model->exportFields()";
            $exportCountCall = "\$this->model->countExportRows(\$filters)";
            $exportRowsCall = "\$this->model->getExportRows(\$filters, \$limit, \$after)";
            $deletedListCall = "\$this->model->getDeletedList()";
            $restoreCode = <<<PHP
            if (!\$this->model->restoreRecord(\$id)) {
                throw new RuntimeException('Ripristino non riuscito.');
            }
            \$this->model->clearListCountCache();
PHP;
            $forceDeleteCode = <<<PHP
            if (!\$this->model->delete(\$id, true)) {
                throw new RuntimeException('Permanent delete failed.');
            }
            \$this->model->clearListCountCache();
PHP;
        }


        if ($hasUploads) {
            if ($useService) {
                $createCode = "            \$id = {$serviceCreateCall};\n"
                    . "            \$uploadData = \$this->uploadManager->store('{$table}', \$id, self::UPLOAD_FIELDS, \$this->mainFormFilesFromRequest());\n"
                    . "            if (\$uploadData !== []) { \$this->service->update(\$id, \$uploadData); }";
                $updateCode = "            \$oldUploadValues = \$this->currentUploadValues(\$id);\n"
                    . "            \$uploadData = \$this->uploadManager->store('{$table}', \$id, self::UPLOAD_FIELDS, \$this->mainFormFilesFromRequest());\n"
                    . "            " . str_replace('$data', 'array_merge($data, $uploadData)', $serviceUpdateCall) . ";\n"
                    . "            \$this->deleteReplacedUploads(\$oldUploadValues, \$uploadData);";
            } else {
                $createCode = "            \$id = {$modelCreateCall};\n"
                    . "            \$uploadData = \$this->uploadManager->store('{$table}', \$id, self::UPLOAD_FIELDS, \$this->mainFormFilesFromRequest());\n";
                if ($hasOperationalManyToManyUpdate) {
                    $createCode .= "            if (\$uploadData !== [] && !\$this->model->updateRecordWithManyToMany(\$id, \$uploadData, [])) { throw new RuntimeException('Salvataggio upload non riuscito.'); }";
                    $uploadUpdateManyCall = str_replace('$data', 'array_merge($data, $uploadData)', $modelUpdateManyCall);
                    $updateCode = "            \$oldUploadValues = \$this->currentUploadValues(\$id);\n"
                        . "            \$uploadData = \$this->uploadManager->store('{$table}', \$id, self::UPLOAD_FIELDS, \$this->mainFormFilesFromRequest());\n"
                        . "            if (!{$uploadUpdateManyCall}) { throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Update failed.'); }\n"
                        . "            \$this->deleteReplacedUploads(\$oldUploadValues, \$uploadData);";
                } else {
                    $createCode .= "            if (\$uploadData !== [] && !\$this->model->updateRecord(\$id, \$uploadData)) { throw new RuntimeException('Salvataggio upload non riuscito.'); }";
                    $updateCode = "            \$oldUploadValues = \$this->currentUploadValues(\$id);\n"
                        . "            \$uploadData = \$this->uploadManager->store('{$table}', \$id, self::UPLOAD_FIELDS, \$this->mainFormFilesFromRequest());\n"
                        . "            if (!\$this->model->updateRecord(\$id, array_merge(\$data, \$uploadData))) { throw new RuntimeException(implode(' ', \$this->model->errors()) ?: 'Update failed.'); }\n"
                        . "            \$this->deleteReplacedUploads(\$oldUploadValues, \$uploadData);";
                }
            }
        }

        if ($isView) {
            $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudListRequest;
{$modelUse}
use RuntimeException;

/**
 * Read-only controller for SQL VIEW `{$table}`.
 *
 * Responsibilities:
 * - AJAX/paginated list with authorized filters and sorting;
 * - export CSV e Word;
 * - no Create/Edit/Delete operations and no form helpers.
 *
 * Contains no SQL queries.
 */
final class {$controller} extends BaseController
{
    private const EXPORT_OPTIONS = [
        'csv' => [
            'chunkSize' => {$csvChunkSize},
            'maximumRows' => {$csvMaximumRows},
            'unfilteredMaximumRows' => {$csvUnfilteredMaximumRows},
        ],
        'word' => [
            'chunkSize' => {$wordChunkSize},
            'maximumRows' => {$wordMaximumRows},
            'unfilteredMaximumRows' => {$wordUnfilteredMaximumRows},
        ],
    ];

    private {$modelType} \$model;
    private CrudExporter \$exporter;

    public function __construct()
    {
        helper(['url']);
{$modelInit}
        \$this->exporter = new CrudExporter();
    }

    /** Displays the complete read-only list or the AJAX fragment. */
    public function index()
    {
        \$listRequest = CrudListRequest::fromRequest(
            \$this->request,
            '{$primaryKey}',
            {$allowedPerPageCode},
            {$simpleFilterFieldsCode}
        );

        \$data = {$listCall};
        \$data += [
            'title' => '{$table}',
            'primaryKey' => '{$primaryKey}',
            'filters' => \$listRequest->filters,
            'query' => \$listRequest->query,
            'navigationContext' => [],
            'cascadeTrail' => [],
            'options' => [],
        ];

        if (\$this->request->isAJAX()) {
            return view('{$table}/_table', \$data);
        }

        return view('{$table}/index', \$data);
    }

    /** Streams the current filtered result set as CSV. */
    public function exportCsv()
    {
        return \$this->export('csv');
    }

    /** Streams the current filtered result set as a Word-compatible document. */
    public function exportWord()
    {
        return \$this->export('word');
    }

    /** Unifies CSV and Word through the shared runtime library. */
    private function export(string \$format)
    {
        \$options = self::EXPORT_OPTIONS[\$format] ?? null;
        if (!is_array(\$options)) {
            throw new RuntimeException('Unsupported export format.');
        }

        \$listRequest = CrudListRequest::fromRequest(
            \$this->request,
            '{$primaryKey}',
            {$allowedPerPageCode},
            {$simpleFilterFieldsCode}
        );

        try {
            return \$this->exporter->download(
                format: \$format,
                response: \$this->response,
                filename: '{$table}',
                languageGroup: '{$languageFile}',
                fields: {$exportFieldsCall},
                filters: \$listRequest->filters,
                countProvider: fn (array \$filters): int => {$exportCountCall},
                rowProvider: fn (array \$filters, int \$limit, int|string|null \$after): array => {$exportRowsCall},
                primaryKey: {$exportCursorKeyCode},
                chunkSize: (int) \$options['chunkSize'],
                maximumRows: (int) \$options['maximumRows'],
                unfilteredMaximumRows: (int) \$options['unfilteredMaximumRows']
            );
        } catch (RuntimeException \$e) {
            if (str_starts_with(\$e->getMessage(), 'EXPORT_UNFILTERED_LIMIT:')) {
                return \$this->exportLimitRedirect(strtoupper(\$format), true);
            }
            if (str_starts_with(\$e->getMessage(), 'EXPORT_LIMIT:')) {
                return \$this->exportLimitRedirect(strtoupper(\$format), false);
            }
            throw \$e;
        }
    }

    private function exportLimitRedirect(string \$format, bool \$unfiltered)
    {
        \$message = \$unfiltered
            ? 'The view contains too many records for an unfiltered export. Apply at least one filter before exporting to ' . \$format . '.'
            : 'The number of records exceeds the configured limit for ' . \$format . '. Apply more restrictive filters.';

        \$query = (array) \$this->request->getGet();
        \$url = site_url('{$table}') . (\$query === [] ? '' : '?' . http_build_query(\$query));

        return redirect()->to(\$url)->with('error', \$message);
    }
}

PHP;

            return $this->writeGenerated("Generated/Controllers/{$controller}.php", $content, $force);
        }

        $autoIncrementFields = [];
        foreach ((array) ($config['fields'] ?? []) as $fieldName => $fieldConfig) {
            if (!empty($fieldConfig['autoIncrement'])) {
                $autoIncrementFields[] = (string) $fieldName;
            }
        }
        $unsetCreatePrimaryKey = '';
        foreach (array_values(array_unique($autoIncrementFields)) as $autoIncrementField) {
            $unsetCreatePrimaryKey .= "        unset(\$data['" . addslashes($autoIncrementField) . "']);\n";
        }

        $softMethods = $softDeleteEnabled ? <<<PHP
    /** Displays soft-deleted records. */
    public function trash()
    {
        return view('{$table}/trash', [
            'title' => 'Cestino',
            'rows' => {$deletedListCall},
            'primaryKey' => '{$primaryKey}',
            'deletedField' => '{$deletedField}',
        ]);
    }

    public function restore(int|string \$id)
    {
        try {
{$restoreCode}
        } catch (Throwable \$e) {
            return redirect()->to(site_url('{$table}/trash'))->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}/trash'))->with('message', 'Record restored.');
    }

    public function forceDelete(int|string \$id)
    {
        try {
{$forceDeleteCode}
        } catch (Throwable \$e) {
            return redirect()->to(site_url('{$table}/trash'))->with('error', \$e->getMessage());
        }

        return redirect()->to(site_url('{$table}/trash'))->with('message', 'Record permanently deleted.');
    }

PHP : '';

        $relationContextFields = [];
        $parentContextFields = [];
        foreach ((array) ($config['fields'] ?? []) as $fieldName => $fieldConfig) {
            if (empty($fieldConfig['foreignKey'])) {
                continue;
            }
            if (!empty($fieldConfig['relationNavigation']['acceptContext'])) {
                $relationContextFields[] = (string) $fieldName;
            }

            $parentTable = trim((string) ($fieldConfig['foreignKey']['parentTable'] ?? ''));
            if (
                $parentTable !== ''
                && preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', (string) $fieldName) === 1
                && preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $parentTable) === 1
            ) {
                $parentContextFields[(string) $fieldName] = [
                    'table' => $parentTable,
                    'label' => ucfirst(str_replace('_', ' ', $parentTable)),
                ];
            }
        }
        $relationContextFieldsCode = var_export(array_values(array_unique($relationContextFields)), true);
        $parentContextFieldsCode = var_export($parentContextFields, true);
        $hasRelatedCreate = $relatedCreateFields !== [];
        $hasParentContext = $createAllowed && $parentContextFields !== [];
        $relationOptionsExpression = $hasBelongsTo ? '$this->model->relationOptions()' : '[]';
        $hasManyExpression = ($recordDetail && $hasHasMany) ? '$this->model->loadHasMany($id)' : '[]';
        $relatedCreateOptionsExpression = $hasRelatedCreate ? '$this->model->relatedCreateRelationOptions()' : '[]';
        $manyToManyOptionsExpression = (($createAllowed && $manyToManyCreateEnabled) || ($writable && $manyToManyEditEnabled))
            ? '$this->model->manyToManyFormOptions()'
            : '[]';
        $manyToManySelectedExpression = ($manyToManyEditEnabled && $writable)
            ? '$this->model->manyToManySelected($id)'
            : '[]';
        $manyToManyRelatedCreateOptionsExpression = $manyToManyRelatedCreateEnabled
            ? '$this->model->manyToManyRelatedCreateRelationOptions()'
            : '[]';
        $parentContextQueryExpression = $hasParentContext ? '$this->parentContextFromQuery($navigationContext, $cascadeTrail)' : '[]';
        $parentContextPostExpression = $hasParentContext ? '$this->parentContextFromPost($navigationContext, $cascadeTrail)' : '[]';
        $relatedPayloadExpression = $hasRelatedCreate ? '$this->relatedCreateDataFromPost()' : '[]';
        $relatedPayloadLine = $hasRelatedCreate ? "        \$related = {$relatedPayloadExpression};\n" : '';
        $uploadCreateValidationCode = $hasUploads ? <<<'PHP'
        $uploadErrors = $this->uploadManagerErrors(false);
        if ($uploadErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $uploadErrors);
        }

PHP : '';
        $uploadUpdateValidationCode = $hasUploads ? <<<'PHP'
        $uploadErrors = $this->uploadManagerErrors(true);
        if ($uploadErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $uploadErrors);
        }

PHP : '';
        $manyToManyRelatedCreatePostCode = $manyToManyRelatedCreateEnabled ? <<<'PHP'
        $manyToManyNew = $this->manyToManyRelatedCreateDataFromPost();
        $manyToManyNewErrors = $this->validateManyToManyRelatedCreates($manyToManyNew);
        if ($manyToManyNewErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $manyToManyNewErrors);
        }

PHP : '';
        $relatedCreateRuleRelaxCode = $hasRelatedCreate ? <<<'PHP'
        foreach (array_keys($related) as $relatedField) {
            // The foreign key is produced by creating the parent within the same
            // transaction, so it cannot be required before the INSERT.
            unset($createRules[$relatedField]);
        }
PHP : '';
        $relatedCreateValidationCode = $hasRelatedCreate ? <<<'PHP'
        $relatedErrors = $this->validateRelatedCreates($related);
        if ($relatedErrors !== []) {
            return redirect()->back()->withInput()->with('errors', $relatedErrors);
        }

PHP : '';
        $createContextResolutionCode = $hasBelongsTo ? <<<PHP
        \$context = [];
        \$contextLabels = [];
        foreach ({$relationContextFieldsCode} as \$field) {
            \$requested = \$navigationContext[\$field] ?? null;
            if (!is_scalar(\$requested) || trim((string) \$requested) === '') {
                continue;
            }
            \$option = \$this->model->relationOptionById(\$field, (string) \$requested);
            if (\$option === null) {
                throw PageNotFoundException::forPageNotFound('Invalid foreign-key value for ' . \$field . '.');
            }
            \$context[\$field] = (string) \$option['id'];
            \$contextLabels[\$field] = (string) \$option['text'];
        }
PHP : "        \$context = [];\n        \$contextLabels = [];\n";

        $uploadDisplayMethod = $hasUploads ? <<<PHP
    /**
     * Serves an upload stored under writable/ after verifying
     * both the authorized field and the record existence.
     */
    public function upload(int|string \$id, string \$field)
    {
        if (!array_key_exists(\$field, self::UPLOAD_FIELDS)) {
            throw PageNotFoundException::forPageNotFound('Invalid upload field.');
        }

        \$row = \$this->findRecordOrFail(\$id);
        \$filename = basename(trim((string) (\$row->{\$field} ?? '')));
        if (\$filename === '') {
            throw PageNotFoundException::forPageNotFound('File not present.');
        }

        \$settings = (array) (config('MyCrud')->upload ?? []);
        \$directory = rtrim((string) (\$settings['directory'] ?? (WRITEPATH . 'uploads')), DIRECTORY_SEPARATOR);
        \$path = \$directory . DIRECTORY_SEPARATOR . \$filename;

        if (!is_file(\$path)) {
            throw PageNotFoundException::forPageNotFound('File not found.');
        }

        return \$this->response->download(\$path, null)->inline();
    }

PHP : '';

        $viewMethod = $recordDetail ? <<<PHP
    /**
     * Displays one record and its explicitly configured child relations.
     *
     * @param int|string \$id Record identifier.
     */
    public function view(int|string \$id)
    {
        \$row = \$this->findRecordOrFail(\$id);
        \$navigationContext = \$this->navigationContextFromQuery();
        \$cascadeTrail = \$this->cascadeTrailFromQuery();

        return view('{$table}/view', [
            'title' => 'Details',
            'row' => \$row,
            'children' => {$hasManyExpression},
            'navigationContext' => \$navigationContext,
            'cascadeTrail' => \$cascadeTrail,
        ]);
    }

PHP : '';

        $createMethods = $createAllowed ? <<<PHP
    /** Displays the Create form with generated relation/context options. */
    public function create()
    {
        \$navigationContext = \$this->navigationContextFromQuery();
        \$cascadeTrail = \$this->cascadeTrailFromQuery();
        \$parentContext = {$parentContextQueryExpression};
{$createContextResolutionCode}
        return view('{$table}/create', [
            'title' => 'New record',
            'row' => null,
            'errors' => session('errors') ?? [],
            'options' => {$relationOptionsExpression},
            'relatedCreateOptions' => {$relatedCreateOptionsExpression},
            'manyToManyOptions' => {$manyToManyOptionsExpression},
            'manyToManyRelatedCreateOptions' => {$manyToManyRelatedCreateOptionsExpression},
            'manyToManySelected' => [],
            'context' => \$context,
            'contextLabels' => \$contextLabels,
            'navigationContext' => \$navigationContext,
            'parentContext' => \$parentContext,
            'cascadeTrail' => \$cascadeTrail,
            'submissionToken' => \$this->submissionGuard->create('store'),
        ]);
    }

    /** Validates the HTTP payload and delegates the Create use-case to the Service. */
    public function store()
    {
        \$navigationContext = \$this->navigationContextFromPost();
        \$cascadeTrail = \$this->cascadeTrailFromPost();
        \$parentContext = {$parentContextPostExpression};
        if (!\$this->submissionGuard->consume('store', \$this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'The form has already been submitted or has expired.');
        }

{$uploadCreateValidationCode}{$relatedPayloadLine}{$manyToManyRelatedCreatePostCode}        \$createRules = {$rules}::createRules();
{$relatedCreateRuleRelaxCode}        \$mainPayload = \$this->mainFormDataFromPost();
        if (!\$this->validateData(\$mainPayload, \$createRules, {$rules}::messages())) {
            return redirect()->back()->withInput()->with('errors', \$this->validator->getErrors());
        }

{$relatedCreateValidationCode}        \$data = \$this->formData(false);
{$unsetCreatePrimaryKey}        try {
{$createCode}
        } catch (Throwable \$e) {
            return redirect()->back()->withInput()->with('error', \$e->getMessage());
        }
        \$redirectUrl = \$parentContext['url'] ?? \$this->contextUrl('{$table}', \$navigationContext, \$cascadeTrail);
        return redirect()->to(\$redirectUrl)->with('message', 'Record created successfully.');
    }

PHP : '';

        $writeMethods = $writable ? <<<PHP
    /**
     * Displays the Edit form for one record.
     *
     * @param int|string \$id Record identifier.
     */
    public function edit(int|string \$id)
    {
        \$navigationContext = \$this->navigationContextFromQuery();
        \$cascadeTrail = \$this->cascadeTrailFromQuery();

        return view('{$table}/edit', [
            'title' => 'Edit record',
            'row' => \$this->findRecordOrFail(\$id),
            'errors' => session('errors') ?? [],
            'options' => {$relationOptionsExpression},
            'manyToManyOptions' => {$manyToManyOptionsExpression},
            'manyToManyRelatedCreateOptions' => {$manyToManyRelatedCreateOptionsExpression},
            'manyToManySelected' => {$manyToManySelectedExpression},
            'navigationContext' => \$navigationContext,
            'cascadeTrail' => \$cascadeTrail,
            'submissionToken' => \$this->submissionGuard->create('update_' . (string) \$id),
        ]);
    }

    /**
     * Validates the HTTP payload and delegates the Update use-case to the Service.
     *
     * @param int|string \$id Record identifier.
     */
    public function update(int|string \$id)
    {
        \$navigationContext = \$this->navigationContextFromPost();
        \$cascadeTrail = \$this->cascadeTrailFromPost();
        if (!\$this->submissionGuard->consume('update_' . (string) \$id, \$this->request->getPost('_submission_token'))) {
            return redirect()->back()->withInput()->with('error', 'The form has already been submitted or has expired.');
        }
{$uploadUpdateValidationCode}        \$mainPayload = \$this->mainFormDataFromPost();
        if (!\$this->validateData(\$mainPayload, {$rules}::updateRules(\$id), {$rules}::messages())) {
            return redirect()->back()->withInput()->with('errors', \$this->validator->getErrors());
        }
{$manyToManyRelatedCreatePostCode}        \$data = \$this->formData(true);
        unset(\$data['{$primaryKey}']);
        try {
{$updateCode}
        } catch (Throwable \$e) {
            return redirect()->back()->withInput()->with('error', \$e->getMessage());
        }
        return redirect()->to(\$this->contextUrl('{$table}', \$navigationContext, \$cascadeTrail))->with('message', 'Record updated successfully.');
    }

    /**
     * Delegates record deletion to the generated Service.
     *
     * @param int|string \$id Record identifier.
     */
    public function delete(int|string \$id)
    {
        \$navigationContext = \$this->navigationContextFromPost();
        if (\$navigationContext === []) {
            \$navigationContext = \$this->navigationContextFromQuery();
        }

        try {
{$deleteCode}
        } catch (Throwable \$e) {
            return redirect()->to(\$this->contextUrl('{$table}', \$navigationContext))->with('error', \$e->getMessage());
        }
        return redirect()->to(\$this->contextUrl('{$table}', \$navigationContext))->with('message', 'Record deleted successfully.');
    }

PHP : '';

        $relationOptionsMethod = $hasBelongsTo ? <<<PHP
    /**
     * JSON endpoint for searching belongsTo options in AJAX mode.
     * The requested field is checked against the generated whitelist.
     */
    public function relationOptions(string \$field)
    {
        \$query = trim((string) \$this->request->getGet('q'));
        if (strlen(\$query) < {$relationAjaxMinimumChars}) {
            return \$this->response->setJSON(['results' => []]);
        }

        return \$this->response->setJSON([
            'results' => \$this->model->searchRelationOptions(\$field, \$query, {$relationAjaxLimit}),
        ]);
    }

PHP : '';

        if ($isView) {
            $controllerDoc = "/**\n * Read-only controller for SQL VIEW `{$table}`.\n *\n * Exposes list, filters, export, and supported record details.\n * Contains no SQL queries or write actions.\n */";
        } elseif (!$createAllowed && !$writable) {
            $controllerDoc = "/**\n * Read-only controller for resource `{$table}`.\n *\n * Exposes only the generated read capabilities.\n * Contains no SQL queries or write actions.\n */";
        } elseif ($createAllowed && !$writable) {
            $controllerDoc = "/**\n * Read/create controller for `{$table}`.\n *\n * The schema allows Create but not record-level Edit/Delete actions.\n * Contains no SQL queries.\n */";
        } else {
            $controllerDoc = "/**\n * CRUD {$architecture} controller for resource `{$table}`.\n *\n * Handles the HTTP flow and delegates queries/persistence to Model/Service.\n * Contains no SQL queries.\n */";
        }

        $findHelperCode = ($recordDetail || $writable) ? <<<PHP
    /** Retrieves the record and converts any missing result into a standard HTTP 404. */
    private function findRecordOrFail(int|string \$id): object
    {
        try {
            \$record = {$findCall};
        } catch (Throwable) {
            throw PageNotFoundException::forPageNotFound('Record not found.');
        }

        if (!is_object(\$record)) {
            throw PageNotFoundException::forPageNotFound('Record not found.');
        }

        return \$record;
    }

PHP : '';

        $formDataHelperCode = $hasForms ? <<<PHP
    /** @return array<string,mixed> */
    private function mainFormDataFromPost(): array
    {
        \$payload = \$this->request->getPost('{$table}');
        return is_array(\$payload) ? \$payload : [];
    }

    /**
     * Extracts and sanitizes write payload from the current HTTP request.
     *
     * Standard/Full leave password/date normalization to the Service; Basic may
     * apply the corresponding runtime transformations here.
     *
     * @param bool \$isUpdate True while handling an Edit submission.
     * @return array<string,mixed> Sanitized application payload.
     */
    private function formData(bool \$isUpdate): array
    {
        return \$this->inputProcessor->process(
            \$this->mainFormDataFromPost(),
            \$isUpdate,
            {$processorAutomaticDates},
            {$disabledCode},
            {$managedCode},
            {$readonlyCode},
            {$processorPasswordFields},
            {$processorHashPasswords},
            {$nullableForeignKeysCode}
        );
    }

PHP : '';

        $uploadHelpersCode = $hasUploads ? <<<PHP
    /** @return array<string,mixed> */
    private function mainFormFilesFromRequest(): array
    {
        \$files = \$this->request->getFiles();
        \$payload = \$files['{$table}'] ?? [];
        return is_array(\$payload) ? \$payload : [];
    }

    /**
     * Validates uploaded files according to the generated field policies.
     *
     * @param bool \$isUpdate True when validating an Edit request.
     * @return array<string,string> Field-scoped validation errors.
     */
    private function uploadManagerErrors(bool \$isUpdate): array
    {
        return \$this->uploadManager->validate(self::UPLOAD_FIELDS, \$this->mainFormFilesFromRequest(), \$isUpdate);
    }

    /**
     * Reads currently persisted upload filenames before an Edit replacement.
     *
     * @param int|string \$id Record identifier.
     * @return array<string,string> Existing filenames keyed by upload field.
     */
    private function currentUploadValues(int|string \$id): array
    {
        \$row = \$this->findRecordOrFail(\$id);
        \$values = [];
        foreach (array_keys(self::UPLOAD_FIELDS) as \$field) {
            \$values[\$field] = isset(\$row->{\$field}) ? (string) \$row->{\$field} : '';
        }
        return \$values;
    }

    /**
     * Deletes files that were replaced successfully by a new upload.
     *
     * @param array<string,string> \$old Previous filenames.
     * @param array<string,string> \$new Newly stored filenames.
     */
    private function deleteReplacedUploads(array \$old, array \$new): void
    {
        foreach (\$new as \$field => \$filename) {
            if ((\$old[\$field] ?? '') !== '' && (\$old[\$field] ?? '') !== \$filename) {
                \$this->uploadManager->delete(\$old[\$field]);
            }
        }
    }

PHP : '';

        $manyToManyHelperCode = (($createAllowed && $manyToManyCreateEnabled) || ($writable && $manyToManyEditEnabled)) ? <<<'PHP'
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

PHP : '';

        $manyToManyRelatedCreateHelperCode = $manyToManyRelatedCreateEnabled ? <<<PHP
    /** @return array<string,array<string,mixed>> */
    private function manyToManyRelatedCreateDataFromPost(): array
    {
        \$flags = \$this->request->getPost('_many_new');
        \$flags = is_array(\$flags) ? \$flags : [];
        \$result = [];

        foreach (self::MANY_TO_MANY_RELATED_CREATE_FIELDS as \$relationKey => \$allowedFields) {
            if (empty(\$flags[\$relationKey])) {
                continue;
            }

            \$relatedTable = (string) (self::MANY_TO_MANY_RELATED_CREATE_TABLES[\$relationKey] ?? '');
            if (\$relatedTable === '') {
                continue;
            }

            \$payload = \$this->request->getPost(\$relatedTable);
            if (!is_array(\$payload)) {
                continue;
            }

            \$allowed = array_fill_keys((array) \$allowedFields, true);
            \$result[(string) \$relationKey] = array_intersect_key(\$payload, \$allowed);
        }

        return \$result;
    }

    /** @return array<string,string> */
    private function validateManyToManyRelatedCreates(array \$payloads): array
    {
        if (\$payloads === []) {
            return [];
        }

        \$definitions = {$rules}::manyToManyRelatedCreateRules();
        \$errors = [];

        foreach (\$payloads as \$relationKey => \$payload) {
            \$relationRules = (array) (\$definitions[\$relationKey] ?? []);
            if (\$relationRules === []) {
                continue;
            }

            \$validation = service('validation');
            \$validation->reset();
            \$validation->setRules(\$relationRules);
            if (\$validation->run(\$payload)) {
                continue;
            }

            foreach (\$validation->getErrors() as \$field => \$message) {
                \$errors[\$relationKey . '__many_related__' . \$field] = \$message;
            }
        }

        return \$errors;
    }

PHP : '';

        $relatedCreateHelpersCode = $hasRelatedCreate ? <<<PHP
    /** @return array<string,array<string,mixed>> */
    private function relatedCreateDataFromPost(): array
    {
        \$flags = \$this->request->getPost('_related_new');
        \$flags = is_array(\$flags) ? \$flags : [];
        \$related = [];

{$relatedCreatePostCode}

        return \$related;
    }

    /** @return array<string,string> */
    private function validateRelatedCreates(array \$related): array
    {
        if (\$related === []) {
            return [];
        }

        \$definitions = {$rules}::relatedCreateRules();
        \$errors = [];
        foreach (\$related as \$field => \$payload) {
            \$relationRules = (array) (\$definitions[\$field] ?? []);
            if (\$relationRules === []) {
                continue;
            }

            \$validation = service('validation');
            \$validation->reset();
            \$validation->setRules(\$relationRules);
            if (\$validation->run(\$payload)) {
                continue;
            }

            foreach (\$validation->getErrors() as \$relatedField => \$message) {
                \$errors[\$field . '__related__' . \$relatedField] = (string) \$message;
            }
        }

        return \$errors;
    }

PHP : '';

        $navigationHelpersCode = <<<'PHP'
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

PHP;

        $formNavigationHelpersCode = $hasForms ? <<<'PHP'
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

PHP : '';

        $parentHelpersCode = $hasParentContext ? <<<'PHP'
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

PHP : '';

        $contextUrlHelperCode = $hasForms ? <<<'PHP'
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

PHP : '';

        $helperMethodsCode = $findHelperCode
            . $formDataHelperCode
            . $uploadHelpersCode
            . $manyToManyHelperCode
            . $manyToManyRelatedCreateHelperCode
            . $relatedCreateHelpersCode
            . $navigationHelpersCode
            . $formNavigationHelpersCode
            . $parentHelpersCode
            . $contextUrlHelperCode;

        $inputProcessorUse = $hasForms ? "use App\\Libraries\\Crud\\CrudInputProcessor;\n" : '';
        $submissionGuardUse = $hasForms ? "use App\\Libraries\\Crud\\SubmissionGuard;\n" : '';
        $uploadManagerUse = $hasUploads ? "use App\\Libraries\\Crud\\CrudUploadManager;\n" : '';
        $pageNotFoundUse = ($recordDetail || $createAllowed || $writable) ? "use CodeIgniter\\Exceptions\\PageNotFoundException;\n" : '';
        $throwableUse = ($recordDetail || $createAllowed || $writable) ? "use Throwable;\n" : '';
        $inputProcessorProperty = $hasForms ? "    private CrudInputProcessor \$inputProcessor;\n" : '';
        $submissionGuardProperty = $hasForms ? "    private SubmissionGuard \$submissionGuard;\n" : '';
        $uploadManagerProperty = $hasUploads ? "    private CrudUploadManager \$uploadManager;\n" : '';
        $formRuntimeInit = $hasForms ? <<<'PHP'
        $this->inputProcessor = new CrudInputProcessor();
        $this->submissionGuard = new SubmissionGuard();

PHP : '';
        $uploadRuntimeInit = $hasUploads ? "        \$this->uploadManager = new CrudUploadManager();\n" : '';
        $relatedCreateConstCode = $hasRelatedCreate
            ? "    /** Foreign keys authorized for atomic parent creation within the same form. */\n    private const RELATED_CREATE_FIELDS = {$relatedCreateFieldsCode};\n\n"
            : '';
        $manyToManyRelatedConstCode = $manyToManyRelatedCreateEnabled
            ? "    /** Fields allowed for inline many-to-many target creation. */\n"
                . "    private const MANY_TO_MANY_RELATED_CREATE_FIELDS = {$manyToManyRelatedCreateFieldsCode};\n\n"
                . "    /** Related resource POST namespace for each many-to-many relation. */\n"
                . "    private const MANY_TO_MANY_RELATED_CREATE_TABLES = {$manyToManyRelatedCreateTablesCode};\n\n"
            : '';
        $uploadConstCode = $hasUploads
            ? "    /** Upload fields and runtime policies. */\n    private const UPLOAD_FIELDS = {$uploadFieldsCode};\n\n"
            : '';
        $parentContextConstCode = $hasParentContext
            ? "    /**\n     * Allowed parent contexts for Create started from a hasMany relation.\n     * The return table is derived exclusively from the generated schema, never from POST.\n     */\n    private const PARENT_CONTEXT_FIELDS = {$parentContextFieldsCode};\n\n"
            : '';

        $content = <<<PHP
<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Libraries\Crud\CrudExporter;
use App\Libraries\Crud\CrudListRequest;
use App\Libraries\Crud\CrudNavigationTrail;
{$inputProcessorUse}{$submissionGuardUse}{$uploadManagerUse}{$modelUse}
{$serviceUse}{$rulesUse}{$pageNotFoundUse}use RuntimeException;
{$throwableUse}
{$controllerDoc}
final class {$controller} extends BaseController
{
    /** Export limits configured at generation time. */
    private const EXPORT_OPTIONS = [
        'csv' => [
            'chunkSize' => {$csvChunkSize},
            'maximumRows' => {$csvMaximumRows},
            'unfilteredMaximumRows' => {$csvUnfilteredMaximumRows},
        ],
        'word' => [
            'chunkSize' => {$wordChunkSize},
            'maximumRows' => {$wordMaximumRows},
            'unfilteredMaximumRows' => {$wordUnfilteredMaximumRows},
        ],
    ];

    /** Only real table foreign keys may travel as URL context. */
    private const NAVIGATION_CONTEXT_FIELDS = {$navigationContextFieldsCode};

{$relatedCreateConstCode}{$manyToManyRelatedConstCode}{$uploadConstCode}{$parentContextConstCode}    /** Read/query dependency: the generated Model. */
    private {$modelType} \$model;
{$serviceProperty}    private CrudExporter \$exporter;
{$inputProcessorProperty}{$submissionGuardProperty}{$uploadManagerProperty}
    public function __construct()
    {
        helper(['form', 'url']);
{$modelInit}
{$serviceInit}        // Shared site runtime: a single implementation for export, input, and tokens.
        \$this->exporter = new CrudExporter();
{$formRuntimeInit}{$uploadRuntimeInit}    }

    /**
     * Displays the full list or the AJAX table fragment.
     *
     * Filters, pagination, and sorting are validated by the CRUD runtime before
     * reaching Model/Service.
     */
    public function index()
    {
        \$listRequest = CrudListRequest::fromRequest(
            \$this->request,
            '{$primaryKey}',
            {$allowedPerPageCode},
            {$simpleFilterFieldsCode}
        );

        \$navigationContext = \$this->navigationContextFromQuery();
        \$cascadeTrail = \$this->cascadeTrailFromQuery();
        \$data = {$listCall};
        \$data += [
            'title' => '{$table}',
            'primaryKey' => '{$primaryKey}',
            'filters' => \$listRequest->filters,
            'query' => \$listRequest->query,
            'navigationContext' => \$navigationContext,
            'cascadeTrail' => \$cascadeTrail,
        ];

        if (\$this->request->isAJAX()) {
            return view('{$table}/_table', \$data);
        }

        \$data['options'] = {$relationOptionsExpression};

        return view('{$table}/index', \$data);
    }

{$relationOptionsMethod}    /** Streams the current filtered result set as CSV. */
    public function exportCsv()
    {
        return \$this->export('csv');
    }

    /** Streams the current filtered result set as a Word-compatible document. */
    public function exportWord()
    {
        return \$this->export('word');
    }

{$uploadDisplayMethod}{$viewMethod}{$createMethods}{$writeMethods}{$softMethods}    /**
     * Unifies CSV and Word: only the writer selected by the runtime library changes.
     */
    private function export(string \$format)
    {
        \$options = self::EXPORT_OPTIONS[\$format] ?? null;
        if (!is_array(\$options)) {
            throw new RuntimeException('Unsupported export format.');
        }

        \$listRequest = CrudListRequest::fromRequest(\$this->request, '{$primaryKey}', {$allowedPerPageCode}, {$simpleFilterFieldsCode});

        try {
            return \$this->exporter->download(
                format: \$format,
                response: \$this->response,
                filename: '{$table}',
                languageGroup: '{$languageFile}',
                fields: {$exportFieldsCall},
                filters: \$listRequest->filters,
                countProvider: fn (array \$filters): int => {$exportCountCall},
                rowProvider: fn (array \$filters, int \$limit, int|string|null \$after): array => {$exportRowsCall},
                primaryKey: {$exportCursorKeyCode},
                chunkSize: (int) \$options['chunkSize'],
                maximumRows: (int) \$options['maximumRows'],
                unfilteredMaximumRows: (int) \$options['unfilteredMaximumRows']
            );
        } catch (RuntimeException \$e) {
            if (str_starts_with(\$e->getMessage(), 'EXPORT_UNFILTERED_LIMIT:')) {
                return \$this->exportLimitRedirect(strtoupper(\$format), true);
            }
            if (str_starts_with(\$e->getMessage(), 'EXPORT_LIMIT:')) {
                return \$this->exportLimitRedirect(strtoupper(\$format), false);
            }
            throw \$e;
        }
    }

{$helperMethodsCode}    private function exportLimitRedirect(string \$format, bool \$unfiltered)
    {
        \$message = \$unfiltered
            ? 'The table contains too many records for an unfiltered export. Apply at least one filter before exporting to ' . \$format . '.'
            : 'The number of records exceeds the configured limit for ' . \$format . '. Apply more restrictive filters.';

        \$query = (array) \$this->request->getGet();
        \$url = site_url('{$table}') . (\$query === [] ? '' : '?' . http_build_query(\$query));

        return redirect()->to(\$url)->with('error', \$message);
    }
}

PHP;

        // Architecture boundary guard: generated controllers must never expose the
        // legacy mixed read/write `$gateway`. Reads use `$model`; writes use `$service`.
        $content = str_replace('\$this->gateway', '\$this->model', $content);
        $content = str_replace('\$gateway', '\$model', $content);

        return $this->writeGenerated("Generated/Controllers/{$controller}.php", $content, $force);
    }
}
