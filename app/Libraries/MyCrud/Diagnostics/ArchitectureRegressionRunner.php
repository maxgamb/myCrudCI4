<?php

namespace App\Libraries\MyCrud\Diagnostics;

use App\Libraries\MyCrud\Core\ConfigBuilder;
use App\Libraries\MyCrud\Core\CrudGeneratorService;
use App\Libraries\MyCrud\Core\DatabaseValidationResolver;
use App\Libraries\MyCrud\Core\FieldPolicy;
use App\Libraries\MyCrud\Core\Naming;
use Config\MyCrud;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use Throwable;

/**
 * Automatic generator regression suite.
 *
 * Generates Basic, Standard, and Full architectures in isolated temporary
 * directories and checks expected components, forbidden components,
 * placeholders, and generated PHP syntax.
 */
final class ArchitectureRegressionRunner
{
    public function run(string $table): DiagnosticReport
    {
        $report = new DiagnosticReport();
        /** @var MyCrud $myCrud */
        $myCrud = config('MyCrud');
        $originalPath = $myCrud->generatedPath;
        $originalExtensionPath = $myCrud->serviceExtensionPath;
        $base = rtrim(WRITEPATH, DIRECTORY_SEPARATOR)
            . DIRECTORY_SEPARATOR . 'mycrud-regression-' . bin2hex(random_bytes(4));

        try {
            foreach (['basic', 'standard', 'full'] as $architecture) {
                $root = $base . DIRECTORY_SEPARATOR . $architecture;
                $myCrud->generatedPath = $root;
                $myCrud->serviceExtensionPath = $root . DIRECTORY_SEPARATOR . 'CustomServiceExtensions';

                $config = (new ConfigBuilder())->buildFromTable($table);
                $config['architecture'] = $architecture;
                (new CrudGeneratorService())->generate($config, true);

                $generated = $root . DIRECTORY_SEPARATOR . 'Generated' . DIRECTORY_SEPARATOR;
                $report->addMany($this->architectureChecks($generated, $config, $architecture));
                $report->addMany((new GeneratedFileDiagnostics())->inspect($generated));
            }
        } catch (Throwable $exception) {
            $report->add(new DiagnosticResult(
                'Regression suite',
                DiagnosticResult::FAIL,
                $exception->getMessage(),
                ['exception' => $exception::class, 'file' => $exception->getFile(), 'line' => $exception->getLine()]
            ));
        } finally {
            $myCrud->generatedPath = $originalPath;
            $myCrud->serviceExtensionPath = $originalExtensionPath;
            $this->removeDirectory($base);
        }

        return $report;
    }

    /** @return list<DiagnosticResult> */
    private function architectureChecks(string $root, array $config, string $architecture): array
    {
        $class = (array) ($config['classes'] ?? []);
        $table = (string) ($config['table'] ?? '');
        $expected = [
            'Models/' . ($class['model'] ?? '') . '.php',
            'Controllers/' . ($class['controller'] ?? '') . '.php',
            'Views/' . $table . '/index.php',
            'Routes/' . $table . '.php',
            'Libraries/Crud/CrudExporter.php',
            'Libraries/Crud/CrudListRequest.php',
            'Libraries/Crud/CrudNavigationTrail.php',
        ];

        if (!empty($config['features']['createAllowed']) || !empty($config['features']['writable'])) {
            $expected[] = 'Validation/' . ($class['rules'] ?? '') . '.php';
        }

        if (in_array($architecture, ['standard', 'full'], true)) {
            $expected[] = 'Entities/' . ($class['entity'] ?? '') . '.php';

            if (!empty($config['features']['writable'])) {
                $expected[] = 'Services/' . ($class['service'] ?? '') . '.php';
            }
        }

        if ($architecture === 'full') {
            $expected[] = 'Controllers/Api/BaseApiController.php';
            $expected[] = 'Controllers/Api/V1/' . ($class['api'] ?? '') . '.php';
            $expected[] = 'API/Resources/' . ($class['resource'] ?? '') . '.php';
            if (!empty($config['features']['writable'])) {
                $expected[] = 'Validation/' . ($class['apiRules'] ?? '') . '.php';
            }
        }

        $results = [];

        // Class names must derive from the table exactly as
        // definita nel DB, senza singularizzazioni linguistiche automatiche.
        $expectedPrefix = Naming::tableClass($table);
        $actualController = (string) ($class['controller'] ?? '');
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' table naming',
            $actualController === $expectedPrefix . 'Controller'
                ? DiagnosticResult::PASS
                : DiagnosticResult::FAIL,
            $actualController === $expectedPrefix . 'Controller'
                ? 'Class name matches the table.'
                : 'Atteso ' . $expectedPrefix . 'Controller, generato ' . $actualController . '.'
        );

        // Physical field names must not be camelized or renamed.
        $fieldNames = array_keys((array) ($config['fields'] ?? []));
        $preserved = true;
        foreach ($fieldNames as $fieldName) {
            if (!isset($config['fields'][$fieldName]['name']) || $config['fields'][$fieldName]['name'] !== $fieldName) {
                $preserved = false;
                break;
            }
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' DB field naming',
            $preserved ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $preserved ? 'DB field names preserved.' : 'One or more fields were renamed.'
        );
        foreach ($expected as $relative) {
            $exists = is_file($root . str_replace('/', DIRECTORY_SEPARATOR, $relative));
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' component ' . $relative,
                $exists ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $exists ? 'Present.' : 'Missing.'
            );
        }

        $forbidden = match ($architecture) {
            'basic' => ['Entities/', 'Services/', 'Controllers/Api/V1/', 'API/Resources/'],
            'standard' => ['Controllers/Api/V1/', 'API/Resources/'],
            default => [],
        };
        foreach ($forbidden as $relative) {
            $exists = is_dir($root . str_replace('/', DIRECTORY_SEPARATOR, $relative));
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' absence ' . $relative,
                !$exists ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                !$exists ? 'Component correctly absent.' : 'Unexpected component present.'
            );
        }

        // Consolidated UI/runtime regression guards.
        $indexPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . 'index.php';
        $controllerPath = $root . 'Controllers' . DIRECTORY_SEPARATOR . ($class['controller'] ?? '') . '.php';
        $exporterPath = $root . 'Libraries' . DIRECTORY_SEPARATOR . 'Crud' . DIRECTORY_SEPARATOR . 'CrudExporter.php';
        $modelPath = $root . 'Models' . DIRECTORY_SEPARATOR . ($class['model'] ?? '') . '.php';
        $indexContent = is_file($indexPath) ? (string) file_get_contents($indexPath) : '';
        $controllerContent = is_file($controllerPath) ? (string) file_get_contents($controllerPath) : '';
        $exporterContent = is_file($exporterPath) ? (string) file_get_contents($exporterPath) : '';
        $modelContent = is_file($modelPath) ? (string) file_get_contents($modelPath) : '';
        // BaseCrudModel is shared application infrastructure, not emitted inside
        // each isolated Generated/ regression tree. Prefer an isolated copy when
        // present, otherwise inspect the real application BaseCrudModel inherited
        // by generated Models.
        $baseModelPath = $root . 'Models' . DIRECTORY_SEPARATOR . 'BaseCrudModel.php';
        if (!is_file($baseModelPath)) {
            $baseModelPath = APPPATH . 'Models' . DIRECTORY_SEPARATOR . 'BaseCrudModel.php';
        }
        $baseModelContent = is_file($baseModelPath) ? (string) file_get_contents($baseModelPath) : '';
        $servicePath = $root . 'Services' . DIRECTORY_SEPARATOR . ($class['service'] ?? '') . '.php';
        $serviceContent = is_file($servicePath) ? (string) file_get_contents($servicePath) : '';
        $entityPath = $root . 'Entities' . DIRECTORY_SEPARATOR . ($class['entity'] ?? '') . '.php';
        $entityContent = is_file($entityPath) ? (string) file_get_contents($entityPath) : '';
        $validationPath = $root . 'Validation' . DIRECTORY_SEPARATOR . ($class['rules'] ?? '') . '.php';
        $validationContent = is_file($validationPath) ? (string) file_get_contents($validationPath) : '';


        // One consolidated architecture guard protects the
        // boundaries established by the generated static architecture. The
        // generator already knows relation targets at generation-time, so
        // generated code must not re-introduce runtime class/table resolvers.
        $architectureGuardChecks = [
            'generated Model extends BaseCrudModel' => str_contains($modelContent, 'extends BaseCrudModel'),
            'Model has no dynamic Model resolver' => !str_contains($modelContent, 'new $modelClass')
                && !str_contains($modelContent, 'resolveModel('),
            'Model does not duplicate BaseCrudModel relation runtime' => !str_contains($modelContent, 'public function relationOptionRows(')
                && !str_contains($modelContent, 'public function relationRowsByIds(')
                && !str_contains($modelContent, 'public function childrenByForeignKey(')
                && !str_contains($modelContent, 'public function clearListCountCache('),
        ];

        if (in_array($architecture, ['standard', 'full'], true)) {
            $architectureGuardChecks['Service has no SQL/DB access'] = !str_contains($serviceContent, 'Database::connect(')
                && !str_contains($serviceContent, '\\Config\\Database::connect(')
                && !str_contains($serviceContent, '$this->db')
                && !str_contains($serviceContent, '->table(');
            $architectureGuardChecks['Service has no dynamic relation resolver'] = !str_contains($serviceContent, 'new $serviceClass')
                && !str_contains($serviceContent, 'new $modelClass')
                && !str_contains($serviceContent, 'resolveService(')
                && !str_contains($serviceContent, 'resolveModel(')
                && !str_contains($serviceContent, 'createRelatedViaServices')
                && !str_contains($serviceContent, 'createManyToManyRelatedViaServices');
            $entityClass = (string) ($class['entity'] ?? '');
            $architectureGuardChecks['Entity has explicit prepared-data factory'] = $entityClass !== ''
                && str_contains($entityContent, 'public static function fromArray(array $data): self')
                && str_contains($entityContent, 'return new self($data);');

            // Entity/Model write-boundary contracts apply only to writable
            // resources. SQL VIEWs are intentionally read-only: Standard/Full
            // may still generate an Entity for typed read results, but there is
            // no Service write path and the Model must not be required to accept
            // an Entity for persistence.
            if (!empty($config['features']['writable'])) {
                $architectureGuardChecks['Service uses Entity write boundary'] = $entityClass !== ''
                    && str_contains($serviceContent, 'use App\\Entities\\' . $entityClass . ';')
                    && str_contains($serviceContent, $entityClass . '::fromArray($data)');
                $architectureGuardChecks['Model write boundary accepts Entity'] = $entityClass !== ''
                    && str_contains($modelContent, 'use App\\Entities\\' . $entityClass . ';')
                    && str_contains($modelContent, $entityClass . ' $data');
            }
        }

        if ($architecture === 'full') {
            $apiPath = $root . 'Controllers' . DIRECTORY_SEPARATOR . 'Api' . DIRECTORY_SEPARATOR . 'V1'
                . DIRECTORY_SEPARATOR . ($class['api'] ?? '') . '.php';
            $resourcePath = $root . 'API' . DIRECTORY_SEPARATOR . 'Resources'
                . DIRECTORY_SEPARATOR . ($class['resource'] ?? '') . '.php';
            $apiContent = is_file($apiPath) ? (string) file_get_contents($apiPath) : '';
            $resourceContent = is_file($resourcePath) ? (string) file_get_contents($resourcePath) : '';

            $architectureGuardChecks['API controller has no SQL/dynamic relation resolver'] = !str_contains($apiContent, 'Database::connect(')
                && !str_contains($apiContent, '\\Config\\Database::connect(')
                && !str_contains($apiContent, '$this->db')
                && !str_contains($apiContent, '->table(')
                && !str_contains($apiContent, 'new $modelClass')
                && !str_contains($apiContent, 'new $serviceClass');
            $architectureGuardChecks['API Resource is output-only'] = !str_contains($resourceContent, 'writableData(')
                && !str_contains($resourceContent, 'FILTERABLE')
                && !str_contains($resourceContent, 'SORTABLE')
                && !str_contains($resourceContent, 'Database::')
                && !str_contains($resourceContent, 'Model')
                && !str_contains($resourceContent, 'Service');

            $mcpResourcePath = $root . 'Mcp' . DIRECTORY_SEPARATOR . 'Resources'
                . DIRECTORY_SEPARATOR . Naming::tableClass($table) . 'McpResource.php';
            if (is_file($mcpResourcePath)) {
                $mcpResourceContent = (string) file_get_contents($mcpResourcePath);
                $architectureGuardChecks['MCP Resource is output-only'] = !str_contains($mcpResourceContent, 'FILTERABLE')
                    && !str_contains($mcpResourceContent, 'SORTABLE')
                    && !str_contains($mcpResourceContent, 'Database::')
                    && !str_contains($mcpResourceContent, 'Model')
                    && !str_contains($mcpResourceContent, 'Service');
            }
        }

        $failedArchitectureGuards = [];
        foreach ($architectureGuardChecks as $guard => $ok) {
            if (!$ok) {
                $failedArchitectureGuards[] = $guard;
            }
        }
        $architectureGuardOk = $failedArchitectureGuards === [];
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' architecture boundary guard',
            $architectureGuardOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $architectureGuardOk
                ? 'Static relation wiring and Model/Service/API/Resource boundaries are preserved.'
                : 'Architecture boundary regression: ' . implode(', ', $failedArchitectureGuards) . '.'
        );

        $nullableForeignKeys = [];
        foreach ((array) ($config['fields'] ?? []) as $field) {
            if (!empty($field['foreignKey']) && !empty($field['nullable'])) {
                $nullableForeignKeys[] = (string) ($field['name'] ?? '');
            }
        }

        if ($nullableForeignKeys !== []) {
            $nullableFkContractOk = str_contains($controllerContent, '$this->inputProcessor->process(');
            foreach ($nullableForeignKeys as $nullableForeignKey) {
                $nullableFkContractOk = $nullableFkContractOk
                    && str_contains($controllerContent, var_export($nullableForeignKey, true));
            }
            if (in_array($architecture, ['standard', 'full'], true)) {
                $nullableFkContractOk = $nullableFkContractOk
                    && str_contains($serviceContent, 'NULLABLE_FOREIGN_KEY_FIELDS')
                    && str_contains($serviceContent, '$data[$field] = null;');
            }

            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' nullable foreign-key normalization',
                $nullableFkContractOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $nullableFkContractOk
                    ? 'Empty optional foreign-key values are normalized to NULL before persistence.'
                    : 'Nullable foreign-key normalization is missing from the generated write path.'
            );
        }

        $enabledM2MRelatedCreates = array_filter(
            (array) ($config['relationsConfig']['manyToMany'] ?? []),
            static fn (array $relation): bool =>
                !empty($relation['enabled'])
                && !empty($relation['createRelatedEnabled'])
                && !empty($relation['createRelatedAvailable'])
        );

        if ($enabledM2MRelatedCreates !== []) {
            $m2mFormPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . '_form.php';
            $m2mFieldsPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . '_fields.php';

            $m2mFormContent = is_file($m2mFormPath)
                ? (string) file_get_contents($m2mFormPath)
                : '';

            $m2mFieldsContent = is_file($m2mFieldsPath)
                ? (string) file_get_contents($m2mFieldsPath)
                : '';

            // _form.php owns the form shell; _fields.php includes one generated
            // _many_form_<relation>.php partial for each M:N relation. Those
            // partials own the M:N picker/offcanvas UI and reuse target/_fields.php.
            $m2mFormContractContent = $m2mFormContent . "\n" . $m2mFieldsContent;
            $m2mPartialContents = [];

            foreach ($enabledM2MRelatedCreates as $relationKey => $relation) {
                $safeRelationKey = preg_replace('/[^a-zA-Z0-9_]/', '_', (string) $relationKey) ?: 'relation';
                $partialPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR
                    . '_many_form_' . $safeRelationKey . '.php';

                $partialContent = is_file($partialPath)
                    ? (string) file_get_contents($partialPath)
                    : '';

                $m2mPartialContents[(string) $relationKey] = $partialContent;
                $m2mFormContractContent .= "\n" . $partialContent;

                $m2mFormContractContent .= "\n"
                    . "view('" . $table . "/_many_form_" . $safeRelationKey . "'";
            }

            $m2mRelatedCreateOk = str_contains($controllerContent, 'manyToManyRelatedCreateDataFromPost')
                && str_contains($controllerContent, 'validateManyToManyRelatedCreates')
                && str_contains($controllerContent, 'MANY_TO_MANY_RELATED_CREATE_TABLES')
                && str_contains($validationContent, 'manyToManyRelatedCreateRules')
                && str_contains($m2mFormContractContent, 'Create new ')
                && str_contains($m2mFormContractContent, 'crud-many-related-create-panel')
                && str_contains($m2mFormContractContent, 'data-bs-toggle="offcanvas"')
                && str_contains($m2mFormContractContent, 'crud-many-related-create-apply')
                && !str_contains($m2mFormContractContent, 'name="_many_related[')
                && !str_contains($m2mFormContractContent, 'data-many-related-toggle');

            foreach ($enabledM2MRelatedCreates as $relationKey => $relation) {
                $relatedTable = trim((string) ($relation['relatedTable'] ?? ''));
                if ($relatedTable === '') {
                    continue;
                }

                $safeRelationKey = preg_replace('/[^a-zA-Z0-9_]/', '_', (string) $relationKey) ?: 'relation';
                $partialContent = (string) ($m2mPartialContents[(string) $relationKey] ?? '');

                // Owner _fields.php delegates the whole M:N form block to its
                // relation partial; that partial in turn reuses target/_fields.php.
                $m2mRelatedCreateOk = $m2mRelatedCreateOk
                    && str_contains(
                        $m2mFieldsContent,
                        "view('" . $table . "/_many_form_" . $safeRelationKey . "'"
                    )
                    && $partialContent !== ''
                    && str_contains(
                        $partialContent,
                        "view('" . $relatedTable . "/_fields'"
                    )
                    && str_contains(
                        $partialContent,
                        "'formNamespace' => '" . $relatedTable . "'"
                    )
                    && str_contains(
                        $partialContent,
                        "'idNamespace' => '" . $relatedTable . "'"
                    );
            }

            if (in_array($architecture, ['standard', 'full'], true)) {
                $m2mStaticServicesOk = true;
                foreach ($enabledM2MRelatedCreates as $relation) {
                    $relatedTable = trim((string) ($relation['relatedTable'] ?? ''));
                    if ($relatedTable === '') {
                        continue;
                    }
                    $serviceClass = Naming::tableClass($relatedTable) . 'Service';
                    $m2mStaticServicesOk = $m2mStaticServicesOk
                        && str_contains($serviceContent, 'new ' . $serviceClass);
                }
                $m2mRelatedCreateOk = $m2mRelatedCreateOk
                    && !str_contains($serviceContent, 'createManyToManyRelatedViaServices')
                    && str_contains($serviceContent, 'private function create')
                    && !str_contains($serviceContent, 'MANY_TO_MANY_RELATED_CREATE_SERVICES')
                    && !str_contains($serviceContent, 'new $serviceClass')
                    && $m2mStaticServicesOk
                    && str_contains($serviceContent, '$manyToManyNew')
                    && !str_contains($modelContent, 'private function createManyToManyRelatedRecords');
            } else {
                $m2mRelatedCreateOk = $m2mRelatedCreateOk
                    && str_contains($modelContent, 'createManyToManyRelatedRecords');
            }

            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' many-to-many related create',
                $m2mRelatedCreateOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $m2mRelatedCreateOk
                    ? 'Inline target creation, validation, transaction payload, and pivot synchronization are generated.'
                    : 'The generated many-to-many related-create contract is incomplete.'
            );
        }

        // Relational read ownership must remain delegated to the Model
        // that owns the queried table. This keeps generated Models small and
        // prevents parent/child query duplication from returning in later changes.
        $relationalOwnershipOk = true;
        $hasRelationalRead = false;
        foreach ((array) ($config['fields'] ?? []) as $field) {
            $foreignKey = (array) ($field['foreignKey'] ?? []);
            $parentTable = trim((string) ($foreignKey['parentTable'] ?? ''));
            if ($parentTable === '') {
                continue;
            }
            $relationMode = strtolower((string) ($field['relationMode'] ?? $foreignKey['optionMode'] ?? 'select'));
            if ($relationMode !== 'select') {
                continue;
            }
            $hasRelationalRead = true;
            $parentModel = Naming::tableClass($parentTable) . 'Model';
            $relationalOwnershipOk = $relationalOwnershipOk
                && str_contains($modelContent, 'new ' . $parentModel)
                && str_contains($modelContent, 'relationOptionRows(');
        }
        foreach ((array) ($config['relationsConfig']['hasMany'] ?? []) as $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }
            $childTable = trim((string) ($relation['childTable'] ?? ''));
            if ($childTable === '') {
                continue;
            }
            $hasRelationalRead = true;
            $childModel = Naming::tableClass($childTable) . 'Model';
            $relationalOwnershipOk = $relationalOwnershipOk
                && str_contains($modelContent, 'new ' . $childModel)
                && str_contains($modelContent, 'childrenByForeignKey(');
        }
        if ($hasRelationalRead) {
            $relationalOwnershipOk = $relationalOwnershipOk
                && !str_contains($modelContent, 'db->table((string) $definition[\'table\'])')
                && !str_contains($modelContent, 'db->table((string) $definition[\'relatedTable\'])');
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' relational query ownership',
                $relationalOwnershipOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $relationalOwnershipOk
                    ? 'Parent and child reads are delegated to the Models that own those tables.'
                    : 'One or more relational reads are no longer delegated to the owning Model.'
            );
        }

        // Runtime namespace guard: PHP can pass lint even when an unimported class
        // viene risolta nel namespace corrente e fallisce solo a runtime.
        $usesPageNotFound = str_contains($controllerContent, 'PageNotFoundException::');
        $importsPageNotFound = str_contains(
            $controllerContent,
            'use CodeIgniter\\Exceptions\\PageNotFoundException;'
        );
        $pageNotFoundImportOk = !$usesPageNotFound || $importsPageNotFound;
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' import PageNotFoundException',
            $pageNotFoundImportOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $pageNotFoundImportOk
                ? 'Import coerente con gli utilizzi del Controller.'
                : 'Il Controller usa PageNotFoundException senza import esplicito.'
        );

        if (!empty($config['features']['readOnly']) && empty($config['features']['createAllowed'])) {
            $servicePath = $root . 'Services' . DIRECTORY_SEPARATOR . ($class['service'] ?? '') . '.php';
            $serviceContent = is_file($servicePath) ? (string) file_get_contents($servicePath) : '';
            $validationPath = $root . 'Validation' . DIRECTORY_SEPARATOR . ($class['rules'] ?? '') . '.php';
            $readOnlyClean = !str_contains($controllerContent, 'CrudInputProcessor')
                && !str_contains($controllerContent, 'SubmissionGuard')
                && !str_contains($controllerContent, 'formData(')
                && !str_contains($controllerContent, 'relatedCreateDataFromPost(')
                && !str_contains($serviceContent, 'public function create(')
                && !str_contains($serviceContent, 'public function update(')
                && !str_contains($serviceContent, 'public function delete(')
                && !str_contains($serviceContent, 'ServiceExtension')
                && !is_file($validationPath);
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' clean read-only capability',
                $readOnlyClean ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $readOnlyClean
                    ? 'VIEW/read-only output has no dead write helpers, validation, or methods.'
                    : 'Read-only code contains unreachable write components.'
            );

            if ($architecture === 'full' && !empty($config['features']['api'])) {
                $apiPath = $root . 'Controllers' . DIRECTORY_SEPARATOR . 'Api' . DIRECTORY_SEPARATOR . 'V1' . DIRECTORY_SEPARATOR
                    . ($class['api'] ?? '') . '.php';
                $apiRulesPath = $root . 'Validation' . DIRECTORY_SEPARATOR . ($class['apiRules'] ?? '') . '.php';
                $openApiPath = $root . 'OpenApi' . DIRECTORY_SEPARATOR . $table . '.yaml';
                $apiContent = is_file($apiPath) ? (string) file_get_contents($apiPath) : '';
                $openApiContent = is_file($openApiPath) ? (string) file_get_contents($openApiPath) : '';
                $apiReadOnlyClean = !str_contains($apiContent, 'public function create(')
                    && !str_contains($apiContent, 'public function update(')
                    && !str_contains($apiContent, 'public function patch(')
                    && !str_contains($apiContent, 'public function delete(')
                    && !is_file($apiRulesPath)
                    && !preg_match('/^\s{4}(post|put|patch|delete):/m', $openApiContent);
                $results[] = new DiagnosticResult(
                    'FULL API read-only capability pulita',
                    $apiReadOnlyClean ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                    $apiReadOnlyClean
                        ? 'GET-only API, without validation or OpenAPI write operations.'
                        : 'API read-only contiene componenti di write non coerenti.'
                );
            }
        }

        if (in_array($architecture, ['standard', 'full'], true) && !empty($config['features']['writable'])) {
            $servicePath = $root . 'Services' . DIRECTORY_SEPARATOR . ($class['service'] ?? '') . '.php';
            /** @var MyCrud $settings */
            $settings = config('MyCrud');
            $extensionPath = rtrim($settings->serviceExtensionPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR
                . ($class['service'] ?? '') . 'Extension.php';
            $serviceContent = is_file($servicePath) ? (string) file_get_contents($servicePath) : '';
            $extensionContent = is_file($extensionPath) ? (string) file_get_contents($extensionPath) : '';
            $extensionOk = str_contains($serviceContent, 'use App\\Services\\Extensions\\')
                && str_contains($serviceContent, 'beforeCreate(')
                && str_contains($serviceContent, 'afterDelete(')
                && str_contains($extensionContent, 'CUSTOM SERVICE EXTENSION')
                && str_contains($extensionContent, 'CUSTOMIZATION EXAMPLE')
                && str_contains($extensionContent, 'exampleApplyBusinessRule')
                && str_contains($extensionContent, 'protected function beforeCreate')
                && str_contains($extensionContent, 'protected function afterDelete');
            // prepareData() is feature-aware: tables that do not need a Create/Update
            // distinction intentionally omit the unused boolean argument. Both generated
            // signatures preserve the Extension Point ordering contract.
            $prepareCreatePos = strpos($serviceContent, '$data = $this->prepareData($data, false);');
            if ($prepareCreatePos === false) {
                $prepareCreatePos = strpos($serviceContent, '$data = $this->prepareData($data);');
            }
            $beforeCreatePos = strpos($serviceContent, '$data = $this->beforeCreate($data);');
            $prepareUpdatePos = strpos($serviceContent, '$data = $this->prepareData($data, true);');
            if ($prepareUpdatePos === false) {
                // Use the prepareData() call that belongs to update(), not the earlier
                // create()/createRelated() call.
                $updateMethodPos = strpos($serviceContent, 'public function update(');
                $prepareUpdatePos = $updateMethodPos === false
                    ? false
                    : strpos($serviceContent, '$data = $this->prepareData($data);', $updateMethodPos);
            }
            $beforeUpdatePos = strpos($serviceContent, '$data = $this->beforeUpdate($id, $data);');
            $hookOrderOk = $prepareCreatePos !== false
                && $beforeCreatePos !== false
                && $prepareCreatePos < $beforeCreatePos
                && $prepareUpdatePos !== false
                && $beforeUpdatePos !== false
                && $prepareUpdatePos < $beforeUpdatePos;
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' Service Extension',
                $extensionOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $extensionOk
                    ? 'Trait custom Service presente e collegato agli hook CRUD.'
                    : 'Service Extension o hook mancanti.'
            );
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' Service hook order',
                $hookOrderOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $hookOrderOk
                    ? 'prepareData precede beforeCreate/beforeUpdate come contratto degli Extension Point.'
                    : 'Ordine prepareData/beforeCreate-beforeUpdate non coerente.'
            );
        }

        $toolbarOk = str_contains($indexContent, 'bi-filetype-csv')
            && str_contains($indexContent, 'bi-file-earmark-word');
        if (!empty($config['features']['createAllowed'])) {
            $toolbarOk = $toolbarOk && str_contains($indexContent, 'bi-plus-circle');
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' toolbar index',
            $toolbarOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $toolbarOk ? 'Azioni Index coerenti presenti.' : 'Toolbar Index incompleta.'
        );

        // Dev30: una PK composta può creare nuovi record, ma non espone
        // ancora route che richiedono l'identità completa della singola riga.
        $routePath = $root . 'Routes' . DIRECTORY_SEPARATOR . $table . '.php';
        $routeContent = is_file($routePath) ? (string) file_get_contents($routePath) : '';
        $createViewPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . 'create.php';
        $editViewPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . 'edit.php';
        $detailViewPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . 'view.php';
        $createPolicyOk = true;
        if (!empty($config['features']['createAllowed'])) {
            $createPolicyOk = is_file($createViewPath)
                && str_contains($routeContent, "get('create'")
                && str_contains($routeContent, "post('store'");
        }
        if (!empty($config['compositePrimaryKey'])) {
            $createPolicyOk = $createPolicyOk
                && empty($config['features']['writable'])
                && empty($config['features']['recordDetail'])
                && !is_file($editViewPath)
                && !is_file($detailViewPath)
                && !str_contains($routeContent, "get('edit/")
                && !str_contains($routeContent, "post('delete/")
                && !str_contains($routeContent, "get('view/");
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' policy CREATE PK composta',
            $createPolicyOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $createPolicyOk
                ? (!empty($config['compositePrimaryKey'])
                    ? 'PK composta: Create abilitato, View/Edit/Delete protetti.'
                    : 'Policy Create coerente con lo schema.')
                : 'Policy Create/azioni record non coerente con la PK.'
        );

        // If the Builder enables "select or create new", the four
        // livelli coinvolti devono essere presenti: form, validation, controller
        // e transazione nel Model.
        $enabledRelatedCreates = [];
        foreach ((array) ($config['fields'] ?? []) as $fieldName => $field) {
            $relationCreate = (array) ($field['relationCreate'] ?? []);
            $foreignKey = (array) ($field['foreignKey'] ?? []);
            $relatedCreateSchema = (array) ($foreignKey['relatedCreate'] ?? []);

            // Keep the diagnostic applicability identical to ServiceGenerator:
            // an enabled Builder choice is actionable only when schema analysis
            // confirms that the related parent can actually be created.
            if (
                !empty($relationCreate['enabled'])
                && !empty($relatedCreateSchema['available'])
                && trim((string) ($foreignKey['parentTable'] ?? '')) !== ''
            ) {
                $enabledRelatedCreates[] = (string) $fieldName;
            }
        }
        $relatedCreateOk = true;
        if ($enabledRelatedCreates !== []) {
            $formPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . '_form.php';
            $fieldsPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR . '_fields.php';
            $rulesPath = $root . 'Validation' . DIRECTORY_SEPARATOR . ($class['rules'] ?? '') . '.php';
            $formContent = is_file($formPath) ? (string) file_get_contents($formPath) : '';
            $fieldsContent = is_file($fieldsPath) ? (string) file_get_contents($fieldsPath) : '';
            $formContractContent = $formContent . "\n" . $fieldsContent;

            // Reusable _fields.php must be safe both as the normal CRUD field view
            // and when embedded by belongsTo/M:N related-create forms. Keep this
            // check structural: the contract matters, not the exact formatting
            // chosen by FormViewGenerator.
            $fieldNamespaceContractOk = preg_match(
                '/\$embeddedRelatedCreate\s*=\s*!empty\(\$embeddedRelatedCreate\)\s*;/',
                $fieldsContent
            ) === 1
                && preg_match(
                    '/\$formNamespace\s*=\s*\(string\)\s*\(\$formNamespace\s*\?\?\s*[^)]+\)\s*;/',
                    $fieldsContent
                ) === 1
                && preg_match(
                    '/\$idNamespace\s*=\s*\(string\)\s*\(\$idNamespace\s*\?\?\s*\$formNamespace\)\s*;/',
                    $fieldsContent
                ) === 1;
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' reusable field namespace contract',
                $fieldNamespaceContractOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $fieldNamespaceContractOk
                    ? '_fields.php initializes its standalone/embedded namespaces before rendering controls.'
                    : '_fields.php uses reusable form/id namespaces without initializing the field-view contract.'
            );
            // Embedded related-create field views are terminal. A reused target
            // _fields.php may keep its FK selector and normal navigation link, but
            // must not expose another Related Create toggle/offcanvas.
            $embeddedTerminalContractOk = str_contains(
                $fieldsContent,
                '$row === null && empty($embeddedRelatedCreate)'
            );
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' embedded related create terminal',
                $embeddedTerminalContractOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $embeddedTerminalContractOk
                    ? 'Embedded _fields.php suppresses nested Related Create toggles while keeping normal FK controls.'
                    : 'Embedded _fields.php can still expose a nested Related Create toggle.'
            );

            $rulesContent = is_file($rulesPath) ? (string) file_get_contents($rulesPath) : '';
            $relatedPartialOk = true;
            foreach ($enabledRelatedCreates as $relatedField) {
                $relatedFieldConfig = (array) ($config['fields'][$relatedField] ?? []);
                $parentTable = trim((string) ($relatedFieldConfig['foreignKey']['parentTable'] ?? ''));
                $safeRelatedField = preg_replace('/[^a-zA-Z0-9_]/', '_', $relatedField);
                $legacyPartialPath = $root . 'Views' . DIRECTORY_SEPARATOR . $table . DIRECTORY_SEPARATOR
                    . '_related_create_' . $safeRelatedField . '.php';

                // belongsTo Related Create is rendered directly from owner _fields.php.
                // No intermediate _related_create_<fk>.php wrapper should survive.
                $relatedPartialOk = $relatedPartialOk
                    && $parentTable !== ''
                    && !is_file($legacyPartialPath)
                    && str_contains($fieldsContent, "view('" . $parentTable . "/_fields'")
                    && str_contains($fieldsContent, "'formNamespace' => '" . $relatedField . "'")
                    && str_contains($fieldsContent, "'idNamespace' => '" . $relatedField . "'")
                    && str_contains($fieldsContent, 'crud-related-create-fieldset')
                    && str_contains($fieldsContent, 'mycrud:start related-create ' . $relatedField)
                    && str_contains($controllerContent, "getPost('" . $relatedField . "')");
            }
            $relatedWriteChecks = [];
            if ($architecture === 'basic') {
                $relatedWriteChecks = [
                    'model metadata' => str_contains($modelContent, 'private const RELATED_CREATES'),
                    'model related writer' => str_contains($modelContent, 'private function createRelatedRecord'),
                    'model transaction' => str_contains($modelContent, 'transBegin()'),
                ];
            } else {
                // STANDARD/FULL own related-create orchestration in the Service.
                // Keep this contract structural: require explicit named Services and
                // FK assignment, but do not couple it to helper method names/spacing.
                $relatedWriteChecks = [
                    'service create signature' => str_contains($serviceContent, 'public function create(')
                        && str_contains($serviceContent, 'array $related = []'),
                    'service createRelated' => str_contains($serviceContent, 'public function createRelated(array $data): int|string')
                        && str_contains($serviceContent, '$this->model->insertRelatedPayload($data)'),
                    'service validation' => str_contains($serviceContent, 'validateCreatePayload')
                        && str_contains($serviceContent, (string) ($class['rules'] ?? '') . '::createRules()'),
                    'transaction begin' => str_contains($serviceContent, 'beginWriteTransaction()'),
                    'transaction status' => str_contains($serviceContent, 'writeTransactionStatus()'),
                    'transaction commit' => str_contains($serviceContent, 'commitWriteTransaction()'),
                    'transaction rollback' => str_contains($serviceContent, 'rollbackWriteTransaction()'),
                    'model transaction API' => (str_contains($modelContent, 'public function beginWriteTransaction') || str_contains($baseModelContent, 'public function beginWriteTransaction'))
                        && (str_contains($modelContent, 'public function writeTransactionStatus') || str_contains($baseModelContent, 'public function writeTransactionStatus'))
                        && (str_contains($modelContent, 'public function commitWriteTransaction') || str_contains($baseModelContent, 'public function commitWriteTransaction'))
                        && (str_contains($modelContent, 'public function rollbackWriteTransaction') || str_contains($baseModelContent, 'public function rollbackWriteTransaction')),
                    'no dynamic service resolver' => !str_contains($serviceContent, 'createRelatedViaServices')
                        && !str_contains($serviceContent, 'RELATED_CREATE_SERVICES')
                        && !str_contains($serviceContent, 'new $serviceClass')
                        && !str_contains($serviceContent, 'new $modelClass')
                        && !str_contains($serviceContent, 'resolveService(')
                        && !str_contains($serviceContent, 'resolveModel(')
                        && !str_contains($serviceContent, '\\Config\\Database::connect()'),
                    'no legacy model writer' => !str_contains($modelContent, 'private function createRelatedRecord'),
                ];

                foreach ($enabledRelatedCreates as $relatedField) {
                    $field = (array) ($config['fields'][$relatedField] ?? []);
                    $foreignKey = (array) ($field['foreignKey'] ?? []);
                    $parentTable = trim((string) ($foreignKey['parentTable'] ?? ''));
                    if ($parentTable === '') {
                        continue;
                    }

                    $parentStem = Naming::tableClass($parentTable);
                    $serviceClass = $parentStem . 'Service';
                    $fieldLiteral = var_export((string) $relatedField, true);

                    // Explicit static dependency known at generation-time.
                    $explicitServicePattern = '/new\\s+'
                        . preg_quote($serviceClass, '/')
                        . '\\s*\\(\\s*\\)\\s*\\)??\\s*->\\s*createRelated\\s*\\(/s';
                    $relatedInputPattern = '/\\$related\\s*\\[\\s*'
                        . preg_quote($fieldLiteral, '/')
                        . '\\s*\\]/s';
                    $fkAssignmentPattern = '/\\$data\\s*\\[\\s*'
                        . preg_quote($fieldLiteral, '/')
                        . '\\s*\\]\\s*=/s';

                    $relatedWriteChecks['static service ' . $relatedField] = preg_match($explicitServicePattern, $serviceContent) === 1;
                    $relatedWriteChecks['related payload ' . $relatedField] = preg_match($relatedInputPattern, $serviceContent) === 1;
                    $relatedWriteChecks['FK assignment ' . $relatedField] = preg_match($fkAssignmentPattern, $serviceContent) === 1;
                }
            }

            $relatedWriteOk = !in_array(false, $relatedWriteChecks, true);
            $modelRelatedSignatureOk = $architecture === 'basic'
                ? (str_contains($modelContent, 'public function createRecord(') && str_contains($modelContent, 'array $related = []'))
                : (str_contains($modelContent, 'public function createRecord(') && !str_contains($modelContent, 'array $related = []'));
            // BASIC still owns inline related-create metadata in the Model. In
            // STANDARD/FULL the Service has explicit static Service-to-Service calls,
            // so emitting RELATED_CREATES in the Model would be dead runtime metadata.
            $relatedMetadataOk = $architecture === 'basic'
                ? str_contains($modelContent, 'private const RELATED_CREATES')
                : !str_contains($modelContent, 'private const RELATED_CREATES');
            $relatedCreateOk = $relatedMetadataOk
                && $modelRelatedSignatureOk
                && $relatedWriteOk
                && str_contains($controllerContent, 'relatedCreateDataFromPost')
                && str_contains($controllerContent, 'validateRelatedCreates')
                && str_contains($rulesContent, 'relatedCreateRules')
                && str_contains($formContractContent, '_related_new[')
                && str_contains($formContractContent, 'data-bs-toggle="offcanvas"')
                && str_contains($formContractContent, 'crud-related-create-apply')
                && str_contains($formContractContent, 'crud-relation-input-group')
                && str_contains($formContractContent, 'bi-plus-circle')
                && $relatedPartialOk;
        }
        $failedRelatedChecks = [];
        if (!$relatedCreateOk && isset($relatedWriteChecks) && is_array($relatedWriteChecks)) {
            foreach ($relatedWriteChecks as $check => $ok) {
                if (!$ok) {
                    $failedRelatedChecks[] = (string) $check;
                }
            }
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' create record collegato',
            $relatedCreateOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $relatedCreateOk
                ? ($enabledRelatedCreates === []
                    ? 'No inline parent creation enabled in Builder.'
                    : 'Inline parent creation is validated and transactional.')
                : ('Supporto create parent inline incompleto.'
                    . ($failedRelatedChecks === [] ? '' : ' Failed: ' . implode(', ', $failedRelatedChecks) . '.'))
        );

        $foreignKeyFields = array_filter(
            (array) ($config['fields'] ?? []),
            static fn (array $field): bool => !empty($field['foreignKey'])
        );

        if ($foreignKeyFields === []) {
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' foreign-key navigation context',
                DiagnosticResult::SKIP,
                'Not applicable: this resource has no foreign keys.'
            );
        } else {
            $contextOk = str_contains($controllerContent, 'NAVIGATION_CONTEXT_FIELDS')
                && str_contains($controllerContent, 'navigationContextFromQuery')
                && str_contains($controllerContent, 'contextUrl');
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' foreign-key navigation context',
                $contextOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $contextOk
                    ? 'Foreign-key context propagated by Controller and redirect.'
                    : 'Foreign-key context support is incomplete.'
            );
        }

        // A real foreign key is accepted by default as
        // Create context. The value is validated by the Controller through
        // relationOptionById() prima di essere passato al form.
        $fkCreateContextOk = true;
        foreach ($foreignKeyFields as $field) {
            if (empty($field['relationNavigation']['acceptContext'])) {
                $fkCreateContextOk = false;
                break;
            }
        }
        if ($foreignKeyFields !== []) {
            $fkCreateContextOk = $fkCreateContextOk
                && str_contains($controllerContent, 'relationOptionById')
                && str_contains($controllerContent, '$context[$field] = (string) $option[\'id\'];');
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' FK precompilata nel Create',
            $fkCreateContextOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $fkCreateContextOk
                ? ($foreignKeyFields === []
                    ? 'None FK da verificare.'
                    : 'Real foreign keys accept URL context and are verified against the parent table.')
                : 'A real foreign key is not accepted/pre-filled correctly in Create.'
        );


        // The visible relation alias is tied to the record foreign key
        // (campo__label), mentre il JOIN resta isolato in un metodo del Model.
        $relationAliasOk = true;
        foreach ((array) ($config['relations']['belongsTo'] ?? []) as $fieldName => $relation) {
            $expectedAlias = (string) $fieldName . '__label';
            $parentTable = (string) ($relation['parentTable'] ?? '');
            $joinMethod = 'join' . Naming::tableClass($parentTable) . Naming::studly((string) $fieldName);
            if (
                (string) ($relation['alias'] ?? '') !== $expectedAlias
                || !str_contains($modelContent, ' AS ' . $expectedAlias)
                || !str_contains($modelContent, 'private function ' . $joinMethod . '(BaseBuilder $builder): BaseBuilder')
            ) {
                $relationAliasOk = false;
                break;
            }
        }
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' Model relation aliases and JOINs',
            $relationAliasOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $relationAliasOk
                ? 'Foreign-key labels use field__label and the parent JOIN is declared only once in the Model.'
                : 'Relation alias or Model JOIN centralization is inconsistent.'
        );

        // Each enabled hasMany relation has a dedicated partial. If the New button
        // is enabled, the parent partial must pass the exact FK, a schema-derived
        // _parent_field marker, and the navigation-only _trail to the child Create.
        //
        // Important: the current generated Controller is the PARENT controller.
        // The return-to-parent helper lives in the CHILD controller and therefore
        // cannot be required here unless this same resource is itself a child of
        // another table. Older diagnostics mixed these two directions and produced
        // false failures for root tables such as country and for pure M:N tables.
        $hasApplicableHasMany = false;
        $hasManyNewOk = true;
        $enabledPivotTables = [];
        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $manyRelation) {
            if (empty($manyRelation['enabled'])) {
                continue;
            }
            $pivotTable = trim((string) ($manyRelation['pivotTable'] ?? ''));
            if ($pivotTable !== '') {
                $enabledPivotTables[$pivotTable] = true;
            }
        }
        if (!empty($config['features']['recordDetail']) && is_file($detailViewPath)) {
            $detailContent = (string) file_get_contents($detailViewPath);
            foreach ((array) ($config['relationsConfig']['hasMany'] ?? []) as $relationKey => $relation) {
                if (empty($relation['enabled'])) {
                    continue;
                }
                $childTableForPanel = trim((string) ($relation['childTable'] ?? ''));
                if ($childTableForPanel !== '' && isset($enabledPivotTables[$childTableForPanel])) {
                    continue;
                }
                $hasApplicableHasMany = true;
                $safeKey = preg_replace('/[^A-Za-z0-9_]/', '_', (string) $relationKey) ?: 'relation';
                $partialRelative = 'Views/' . $table . '/_children_' . $safeKey . '.php';
                $partialPath = $root . $partialRelative;
                if (!is_file($partialPath)
                    || !str_contains($detailContent, $table . '/_children_' . $safeKey)) {
                    $hasManyNewOk = false;
                    break;
                }

                if (empty($relation['showCreateButton']) || empty($relation['childCreateAllowed'])) {
                    continue;
                }
                $foreignKey = (string) ($relation['foreignKey'] ?? '');
                $childTable = (string) ($relation['childTable'] ?? '');
                if ($foreignKey === '' || $childTable === '' || preg_match('/^[A-Za-z_][A-Za-z0-9_]*$/D', $foreignKey) !== 1) {
                    continue;
                }
                $partialContent = (string) file_get_contents($partialPath);
                if (!str_contains($partialContent, "site_url('{$childTable}/create')")
                    || !str_contains($partialContent, var_export($foreignKey, true) . ' =>')
                    || !str_contains($partialContent, "'_parent_field' => " . var_export($foreignKey, true))
                    || !str_contains($partialContent, "'_trail' =>")) {
                    $hasManyNewOk = false;
                    break;
                }
            }
        }
        if (!$hasApplicableHasMany) {
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' HasMany contestuale parent-child-parent',
                DiagnosticResult::SKIP,
                'Not applicable: this resource has no enabled hasMany relation.'
            );
        } else {
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' HasMany contestuale parent-child-parent',
                $hasManyNewOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $hasManyNewOk
                    ? 'Parent partial preserves the child foreign key, _parent_field and cascaded trail.'
                    : 'The hasMany parent scaffold does not correctly preserve child context.'
            );
        }

        // Dev35: the trail is navigation-only and never replaces the normal
        // schema-whitelisted foreign-key context. Parent-return helpers are required
        // only when this generated resource can itself be opened as a child through
        // one of its own real foreign keys.
        $navigationTrailPath = $root . 'Libraries/Crud/CrudNavigationTrail.php';
        $navigationTrailContent = is_file($navigationTrailPath) ? (string) file_get_contents($navigationTrailPath) : '';
        $hasOwnParentContext = str_contains($controllerContent, 'PARENT_CONTEXT_FIELDS');
        $ownParentTrailOk = !$hasOwnParentContext
            || (
                str_contains($controllerContent, 'parentContextFromQuery')
                && str_contains($controllerContent, 'parentContextFromPost')
                && str_contains($controllerContent, 'CrudNavigationTrail::ancestorsForParent')
                && str_contains($controllerContent, '$parentContext[\'url\'] ??')
            );
        $cascadeNavigationOk = $navigationTrailContent !== ''
            && str_contains($navigationTrailContent, 'final class CrudNavigationTrail')
            && str_contains($navigationTrailContent, 'IMPORTANTE: il trail non autorizza mai scritture')
            && str_contains($controllerContent, 'cascadeTrailFromQuery')
            && str_contains($controllerContent, 'cascadeTrailFromPost')
            && $ownParentTrailOk
            && str_contains($indexContent, "const cascadeTrailParam = '_trail'")
            && (!isset($formContent) || $formContent === ''
                || str_contains($formContent, 'data-trail=')
                || str_contains($formContent, 'name="_trail"'))
            && (!isset($detailContent) || $detailContent === '' || str_contains($detailContent, 'CrudNavigationTrail'));
        if ($foreignKeyFields === []) {
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' cascaded navigation',
                DiagnosticResult::SKIP,
                'Not applicable: this resource has no foreign-key parent context.'
            );
        } else {
            $results[] = new DiagnosticResult(
                strtoupper($architecture) . ' cascaded navigation',
                $cascadeNavigationOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
                $cascadeNavigationOk
                    ? 'The multi-level trail is propagated as UI context and parent-return helpers are checked only when applicable.'
                    : 'Cascaded navigation is not fully generated or separated from foreign-key context.'
            );
        }

        $exportSafetyOk = str_contains($exporterContent, 'EXPORT_UNFILTERED_LIMIT:CSV')
            && str_contains($exporterContent, 'EXPORT_UNFILTERED_LIMIT:WORD')
            && str_contains($exporterContent, 'iterateRows');
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' export safety',
            $exportSafetyOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $exportSafetyOk ? 'Chunked export with limits even without filters.' : 'Export protection is incomplete.'
        );

        $shortExportOk = str_contains($indexContent, 'simpleFilterFields')
            && str_contains($indexContent, 'sourceUrl.searchParams.get(field)')
            && str_contains($indexContent, 'params.set(field, value)');
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' short-filter export',
            $shortExportOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $shortExportOk
                ? 'CSV/Word preserve quick ?field=value filters after AJAX.'
                : 'Exports may lose quick filters from the current URL.'
        );

        // CHAR(n) is a database maximum length and must not
        // diventare automaticamente exact_length[n].
        $validationResolver = new DatabaseValidationResolver();
        $charRules = $validationResolver->rulesFor([
            'name' => 'code',
            'type' => 'char',
            'columnType' => 'char(20)',
            'maxLength' => 20,
            'nullable' => false,
            'default' => null,
            'autoIncrement' => false,
            'primary' => false,
            'attributes' => ['boolean' => [], 'values' => []],
        ], 'sample_table', 'id', false);
        $varcharRules = $validationResolver->rulesFor([
            'name' => 'label',
            'type' => 'varchar',
            'columnType' => 'varchar(20)',
            'maxLength' => 20,
            'nullable' => false,
            'default' => null,
            'autoIncrement' => false,
            'primary' => false,
            'attributes' => ['boolean' => [], 'values' => []],
        ], 'sample_table', 'id', false);
        $lengthRulesOk = in_array('max_length[20]', $charRules, true)
            && in_array('max_length[20]', $varcharRules, true)
            && !in_array('exact_length[20]', $charRules, true);
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' validazione CHAR max length',
            $lengthRulesOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $lengthRulesOk
                ? 'CHAR(n) e VARCHAR(n) generano max_length[n]; exact_length non è dedotto dal DB.'
                : 'Regressione: CHAR(n) sta generando exact_length[n].'
        );

        // DEFAULT CURRENT_TIMESTAMP + ON UPDATE CURRENT_TIMESTAMP
        // è una responsabilità del database, non del form o della validazione.
        $automaticTimestamp = [
            'name' => 'last_update',
            'type' => 'timestamp',
            'columnType' => 'timestamp',
            'defaultValue' => 'current_timestamp()',
            'extra' => 'DEFAULT_GENERATED on update CURRENT_TIMESTAMP',
            'nullable' => 'NO',
            'maxLength' => null,
            'attributes' => ['boolean' => [], 'values' => []],
            'primary' => false,
            'autoIncrement' => false,
        ];
        $databaseManaged = FieldPolicy::isDatabaseManagedTimestamp($automaticTimestamp);
        $automaticTimestamp['databaseManaged'] = $databaseManaged;
        $automaticTimestamp['default'] = $automaticTimestamp['defaultValue'];
        $managedRules = $validationResolver->rulesFor($automaticTimestamp, 'sample_table', 'id', false);
        $databaseManagedOk = $databaseManaged && $managedRules === [];
        $results[] = new DiagnosticResult(
            strtoupper($architecture) . ' timestamp automatico DB',
            $databaseManagedOk ? DiagnosticResult::PASS : DiagnosticResult::FAIL,
            $databaseManagedOk
                ? 'CURRENT_TIMESTAMP + ON UPDATE is recognized as databaseManaged and generates no validation rules.'
                : 'Regressione: un timestamp automatico DB viene trattato come input applicativo.'
        );

        return $results;
    }

    private function removeDirectory(string $path): void
    {
        if (!is_dir($path)) {
            return;
        }
        $iterator = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path, RecursiveDirectoryIterator::SKIP_DOTS),
            RecursiveIteratorIterator::CHILD_FIRST
        );
        foreach ($iterator as $item) {
            $item->isDir() ? @rmdir($item->getPathname()) : @unlink($item->getPathname());
        }
        @rmdir($path);
    }
}
