<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/**
 * Generates initial tests that can be reliably derived from the CRUD configuration.
 *
 * Tests are first written to staging:
 *   app/Generated/Tests/Generated/MyCrud/<Resource>/
 *
 * The `mycrud:publish` command then publishes them to:
 *   tests/Generated/MyCrud/<Resource>/
 *
 * No fixtures or application data are invented. Generated tests verify
 * structural contracts, validation policy, and API Resource behavior without
 * modifying the database.
 */
final class TestScaffoldGenerator
{
    use GeneratorTrait;

    public function generate(array $config, bool $force = false): array
    {
        $table = (string) ($config['table'] ?? '');
        $architecture = (string) ($config['architecture'] ?? 'basic');
        $classes = (array) ($config['classes'] ?? []);
        $entityBase = $this->studly($table);
        $namespace = 'Tests\\Generated\\MyCrud\\' . $entityBase;
        $pathBase = 'Generated/Tests/Generated/MyCrud/' . $entityBase . '/';

        $files = [];

        $files['structure'] = $this->writeGenerated(
            $pathBase . $entityBase . 'StructureTest.php',
            $this->structureTest($config, $namespace, $entityBase),
            $force
        );

        if (!empty($config['features']['createAllowed']) || !empty($config['features']['writable'])) {
            $files['validation'] = $this->writeGenerated(
                $pathBase . $entityBase . 'ValidationContractTest.php',
                $this->validationTest($config, $namespace, $entityBase),
                $force
            );
        }

        if ((string) ($config['crudSecurity']['auth'] ?? 'none') === 'shield_session') {
            $files['web_security'] = $this->writeGenerated(
                $pathBase . $entityBase . 'WebSecurityContractTest.php',
                $this->webSecurityTest($config, $namespace, $entityBase),
                $force
            );
        }

        if ($architecture === 'full' && !empty($config['features']['api'])) {
            $files['api_resource'] = $this->writeGenerated(
                $pathBase . $entityBase . 'ApiResourceContractTest.php',
                $this->apiResourceTest($config, $namespace, $entityBase),
                $force
            );

            $files['api_architecture'] = $this->writeGenerated(
                $pathBase . $entityBase . 'ApiArchitectureContractTest.php',
                $this->apiArchitectureTest($config, $namespace, $entityBase),
                $force
            );

            $files['openapi'] = $this->writeGenerated(
                $pathBase . $entityBase . 'OpenApiContractTest.php',
                $this->openApiTest($config, $namespace, $entityBase),
                $force
            );

            if ((string) ($config['apiSecurity']['auth'] ?? 'none') === 'shield_tokens') {
                $files['api_security'] = $this->writeGenerated(
                    $pathBase . $entityBase . 'ApiSecurityContractTest.php',
                    $this->apiSecurityTest($config, $namespace, $entityBase),
                    $force
                );
            }

            if (!empty($config['mcp']['enabled'])) {
                $files['mcp_foundation'] = $this->writeGenerated(
                    $pathBase . $entityBase . 'McpFoundationContractTest.php',
                    $this->mcpFoundationTest($config, $namespace, $entityBase),
                    $force
                );
            }
        }

        if (!empty($config['mcp']['enabled'])) {
            $files['mcp_resource_security'] = $this->writeGenerated(
                $pathBase . $entityBase . 'McpResourceSecurityContractTest.php',
                $this->mcpResourceSecurityTest($config, $namespace, $entityBase),
                $force
            );
        }

        if ($this->hasRelationalContract($config)) {
            $files['relations'] = $this->writeGenerated(
                $pathBase . $entityBase . 'RelationalContractTest.php',
                $this->relationalContractTest($config, $namespace, $entityBase),
                $force
            );
        }

        $files['readme'] = $this->writeGenerated(
            $pathBase . 'README.md',
            $this->readme($config, $entityBase),
            $force
        );

        return $files;
    }

    private function structureTest(array $config, string $namespace, string $entityBase): string
    {
        $classes = (array) ($config['classes'] ?? []);
        $expected = [];

        $expected[] = 'App\\Models\\' . (string) ($classes['model'] ?? ($entityBase . 'Model'));
        $expected[] = 'App\\Controllers\\' . (string) ($classes['controller'] ?? ($entityBase . 'Controller'));

        if (!empty($config['features']['createAllowed']) || !empty($config['features']['writable'])) {
            $expected[] = 'App\\Validation\\' . (string) ($classes['rules'] ?? ($entityBase . 'Rules'));
        }

        if (!empty($config['features']['entity'])) {
            $expected[] = 'App\\Entities\\' . (string) ($classes['entity'] ?? ($entityBase . 'Entity'));
        }

        if (!empty($config['features']['service']) && empty($config['isView'])) {
            $expected[] = 'App\\Services\\' . (string) ($classes['service'] ?? ($entityBase . 'Service'));
        }

        if (!empty($config['features']['api'])) {
            $expected[] = 'App\\Controllers\\Api\\V1\\' . (string) ($classes['api'] ?? ($entityBase . 'ApiController'));
            $expected[] = 'App\\API\\Resources\\' . (string) ($classes['resource'] ?? ($entityBase . 'Resource'));

            $apiCapabilities = (array) ($config['apiCapabilities'] ?? []);
            if (!empty($apiCapabilities['create']) || !empty($apiCapabilities['update'])) {
                $expected[] = 'App\\Validation\\' . (string) ($classes['apiRules'] ?? ($entityBase . 'ApiRules'));
            }
        }

        $expectedCode = var_export(array_values(array_unique($expected)), true);

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use CodeIgniter\Test\CIUnitTestCase;

/**
 * Structural smoke test generated by myCrudCI4.
 *
 * Verifies that the components required by the architecture are published and
 * loadable through the autoloader. It does not access application data.
 */
final class {$entityBase}StructureTest extends CIUnitTestCase
{
    private const EXPECTED_CLASSES = {$expectedCode};

    public function testGeneratedClassesAreAutoloadable(): void
    {
        foreach (self::EXPECTED_CLASSES as \$class) {
            \$this->assertTrue(
                class_exists(\$class),
                'Generated class is not autoloadable: ' . \$class
            );
        }
    }
}

PHP;
    }

    private function validationTest(array $config, string $namespace, string $entityBase): string
    {
        $rules = (string) (($config['classes']['rules'] ?? '') ?: ($entityBase . 'Rules'));
        $createAllowed = !empty($config['features']['createAllowed']);
        $writable = !empty($config['features']['writable']);

        $forbidden = [];
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);
        $softDeleteField = (string) ($config['softDelete']['field'] ?? 'deleted_at');

        foreach ((array) ($config['fields'] ?? []) as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name === '') {
                continue;
            }

            if (
                (!empty($field['primary']) && !empty($field['autoIncrement']))
                || !empty($field['databaseManaged'])
                || (!empty($config['features']['softDeletes']) && $name === $softDeleteField)
                || ($timestampsEnabled && in_array($name, ['created_at', 'updated_at'], true))
                || in_array(strtolower((string) ($field['inputType'] ?? '')), ['file', 'image'], true)
            ) {
                $forbidden[] = $name;
            }
        }

        $forbiddenCode = var_export(array_values(array_unique($forbidden)), true);

        $m2mRelatedCreateKeys = [];
        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $relationKey => $relation) {
            if (!empty($relation['enabled'])
                && !empty($relation['createRelatedEnabled'])
                && !empty($relation['createRelatedAvailable'])
            ) {
                $m2mRelatedCreateKeys[] = (string) $relationKey;
            }
        }
        $m2mRelatedCreateKeysCode = var_export($m2mRelatedCreateKeys, true);

        $createMethod = $createAllowed ? <<<PHP
    public function testCreateRulesAreStructurallyValid(): void
    {
        \$rules = {$rules}::createRules();
        \$this->assertIsArray(\$rules);

        foreach (self::FORBIDDEN_RULE_FIELDS as \$field) {
            \$this->assertArrayNotHasKey(
                \$field,
                \$rules,
                'Framework/DB-managed/upload field present in create rules: ' . \$field
            );
        }
    }

PHP : '';

        $updateMethod = $writable ? <<<PHP
    public function testUpdateRulesAreStructurallyValid(): void
    {
        \$rules = {$rules}::updateRules('1');
        \$this->assertIsArray(\$rules);

        foreach (self::FORBIDDEN_RULE_FIELDS as \$field) {
            \$this->assertArrayNotHasKey(
                \$field,
                \$rules,
                'Framework/DB-managed/upload field present in update rules: ' . \$field
            );
        }
    }

PHP : '';

        $m2mRelatedCreateMethod = ($createAllowed && $m2mRelatedCreateKeys !== []) ? <<<PHP
    public function testManyToManyRelatedCreateRulesMatchConfiguration(): void
    {
        \$rules = {$rules}::manyToManyRelatedCreateRules();
        \$this->assertIsArray(\$rules);

        foreach (self::MANY_TO_MANY_RELATED_CREATE_KEYS as \$relationKey) {
            \$this->assertArrayHasKey(
                \$relationKey,
                \$rules,
                'Missing related-create validation rules for relation: ' . \$relationKey
            );
            \$this->assertNotSame([], \$rules[\$relationKey]);
        }
    }

PHP : '';


        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use App\Validation\\{$rules};
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Contract test for generated rules.
 *
 * Does not verify custom business rules: it checks the policies that myCrudCI4
 * can derive directly from configuration.
 */
final class {$entityBase}ValidationContractTest extends CIUnitTestCase
{
    private const FORBIDDEN_RULE_FIELDS = {$forbiddenCode};
    private const MANY_TO_MANY_RELATED_CREATE_KEYS = {$m2mRelatedCreateKeysCode};

{$createMethod}{$updateMethod}{$m2mRelatedCreateMethod}    public function testValidationMessagesReturnArray(): void
    {
        \$this->assertIsArray({$rules}::messages());
    }
}

PHP;
    }

    private function apiResourceTest(array $config, string $namespace, string $entityBase): string
    {
        $resource = (string) (($config['classes']['resource'] ?? '') ?: ($entityBase . 'Resource'));
        $pk = (string) ($config['primaryKey'] ?? 'id');

        $readable = [];
        $writable = [];
        $softDeleteField = (string) ($config['softDelete']['field'] ?? 'deleted_at');
        $timestampsEnabled = !empty($config['features']['timestamps'])
            && isset($config['fields']['created_at'], $config['fields']['updated_at']);

        foreach ((array) ($config['fields'] ?? []) as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name === '') {
                continue;
            }

            $ui = (array) ($field['ui'] ?? []);
            $attributes = (array) ($field['attributes']['boolean'] ?? []);
            $primaryAuto = !empty($field['primary']) && !empty($field['autoIncrement']);
            $managedField = !empty($field['databaseManaged'])
                || (!empty($config['features']['softDeletes']) && $name === $softDeleteField)
                || ($timestampsEnabled && in_array($name, ['created_at', 'updated_at'], true));

            if (!array_key_exists('apiVisible', $ui) || !empty($ui['apiVisible'])) {
                $readable[] = $name;
            }

            $inputType = strtolower((string) ($field['inputType'] ?? 'text'));
            if (
                !empty($config['features']['writable'])
                && !in_array($inputType, ['file', 'image'], true)
                && !$primaryAuto
                && !$managedField
                && !empty($ui['visibleForm'])
                && !in_array('disabled', $attributes, true)
                && !in_array('readonly', $attributes, true)
            ) {
                $writable[] = $name;
            }
        }

        foreach ((array) ($config['relations']['belongsTo'] ?? []) as $fieldName => $relation) {
            $fieldUi = (array) ($config['fields'][$fieldName]['ui'] ?? []);
            $alias = (string) ($relation['alias'] ?? '');
            if (
                $alias !== ''
                && (!array_key_exists('apiVisible', $fieldUi) || !empty($fieldUi['apiVisible']))
            ) {
                $readable[] = $alias;
            }
        }

        if (!in_array($pk, $readable, true)) {
            array_unshift($readable, $pk);
        }

        $readableCode = var_export(array_values(array_unique($readable)), true);
        $writableCode = var_export(array_values(array_unique($writable)), true);

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use App\API\Resources\\{$resource};
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Contract test della Resource REST: puro, senza accesso al database.
 */
final class {$entityBase}ApiResourceContractTest extends CIUnitTestCase
{
    private const READABLE = {$readableCode};

    public function testResourceMakeExposesOnlyReadableFields(): void
    {
        \$source = [];
        foreach (self::READABLE as \$field) {
            \$source[\$field] = 'readable-' . \$field;
        }
        \$source['__unknown_field__'] = 'must-not-survive';

        \$result = {$resource}::make(\$source);

        \$this->assertSame(
            array_values(self::READABLE),
            array_values(array_keys(\$result))
        );
        \$this->assertArrayNotHasKey('__unknown_field__', \$result);
    }

    public function testResourceIsOutputOnly(): void
    {
        \$path = APPPATH . 'API/Resources/{$resource}.php';
        \$php = (string) file_get_contents(\$path);

        \$this->assertStringNotContainsString('writableData(', \$php);
        \$this->assertStringNotContainsString('filterableFields(', \$php);
        \$this->assertStringNotContainsString('sortableFields(', \$php);
        \$this->assertStringNotContainsString('FILTERABLE', \$php);
        \$this->assertStringNotContainsString('SORTABLE', \$php);
        \$this->assertStringNotContainsString('Database::connect', \$php);
        \$this->assertStringNotContainsString('->db', \$php);
        \$this->assertStringNotContainsString('App\\\\Models', \$php);
        \$this->assertStringNotContainsString('App\\\\Services', \$php);
    }
}

PHP;
    }

    private function apiArchitectureTest(array $config, string $namespace, string $entityBase): string
    {
        $classes = (array) ($config['classes'] ?? []);
        $api = (string) ($classes['api'] ?? ($entityBase . 'ApiController'));
        $model = (string) ($classes['model'] ?? ($entityBase . 'Model'));
        $service = (string) ($classes['service'] ?? ($entityBase . 'Service'));
        $resource = (string) ($classes['resource'] ?? ($entityBase . 'Resource'));
        $caps = (array) ($config['apiCapabilities'] ?? []);
        $hasRead = !empty($caps['list']) || !empty($caps['read']) || !empty($caps['trash']);
        $hasWrite = !empty($caps['create']) || !empty($caps['update']) || !empty($caps['delete'])
            || !empty($caps['restore']) || !empty($caps['forceDelete']);
        $hasApiUpload = false;
        foreach ((array) ($config['fields'] ?? []) as $field) {
            if (!is_array($field)) {
                continue;
            }
            $ui = (array) ($field['ui'] ?? []);
            $inputType = strtolower((string) ($field['inputType'] ?? $ui['inputType'] ?? 'text'));
            if (in_array($inputType, ['file', 'image'], true) && (!empty($caps['create']) || !empty($caps['update']))) {
                $hasApiUpload = true;
                break;
            }
        }
        $readAssertion = $hasRead
            ? "        \$this->assertStringContainsString('private readonly {$model} \$model', \$php);\n"
            : '';
        $writeAssertion = $hasWrite
            ? "        \$this->assertStringContainsString('private readonly {$service} \$service', \$php);\n"
            : '';
        $uploadAssertions = $hasApiUpload
            ? "        \$this->assertStringContainsString('CrudUploadManager', \$php);\n        \$this->assertStringContainsString('private const UPLOAD_FIELDS', \$php);\n        \$this->assertStringContainsString('public function upload(', \$php);\n"
            : '';
        $patchServiceAssertion = !empty($caps['update'])
            ? "        \$this->assertStringContainsString('->patch(\$id, \$data)', \$php);\n"
            : '';
        $uploadServiceAssertion = $hasApiUpload
            ? "        \$this->assertStringContainsString('->updateUploads(\$id, \$uploadData)', \$php);\n"
            : '';
        $serviceMethodAssertions = '';
        if (!empty($caps['update']) || $hasApiUpload) {
            $serviceMethodAssertions .= "        \$service = (string) file_get_contents(APPPATH . 'Services/{$service}.php');\n";
            if (!empty($caps['update'])) {
                $serviceMethodAssertions .= "        \$this->assertStringContainsString('public function patch(', \$service);\n";
            }
            if ($hasApiUpload) {
                $serviceMethodAssertions .= "        \$this->assertStringContainsString('public function updateUploads(', \$service);\n";
            }
        }

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use CodeIgniter\Test\CIUnitTestCase;

/** Guards the generated REST architecture boundary. */
final class {$entityBase}ApiArchitectureContractTest extends CIUnitTestCase
{
    public function testApiControllerUsesModelForReadsAndServiceForWritesWithoutSql(): void
    {
        \$path = APPPATH . 'Controllers/Api/V1/{$api}.php';
        \$this->assertFileExists(\$path);
        \$php = (string) file_get_contents(\$path);

{$readAssertion}{$writeAssertion}{$uploadAssertions}{$patchServiceAssertion}{$uploadServiceAssertion}        \$this->assertStringNotContainsString('Database::connect', \$php);
        \$this->assertStringNotContainsString('->db->', \$php);
        \$this->assertStringNotContainsString('->table(', \$php);
        \$this->assertDoesNotMatchRegularExpression('/new\\s+\\$[A-Za-z_]/', \$php);
        \$this->assertStringNotContainsString("['table']", \$php);
    }

    public function testServiceExposesExplicitPatchAndUploadUseCasesWhenApplicable(): void
    {
{$serviceMethodAssertions}        \$this->assertTrue(true);
    }

    public function testResourceRemainsOutputOnly(): void
    {
        \$resource = (string) file_get_contents(APPPATH . 'API/Resources/{$resource}.php');
        \$this->assertStringNotContainsString('writableData(', \$resource);
        \$this->assertStringNotContainsString('filterableFields(', \$resource);
        \$this->assertStringNotContainsString('sortableFields(', \$resource);
        \$this->assertStringNotContainsString('FILTERABLE', \$resource);
        \$this->assertStringNotContainsString('SORTABLE', \$resource);
        \$this->assertStringNotContainsString('Database::connect', \$resource);
        \$this->assertStringNotContainsString('->db', \$resource);
    }
}

PHP;
    }

    private function openApiTest(array $config, string $namespace, string $entityBase): string
    {
        $table = (string) $config['table'];
        $operationBase = $entityBase !== '' ? $entityBase : 'Resource';

        $caps = (array) ($config['apiCapabilities'] ?? []);
        $expectedOps = [];

        foreach ([
            'list' => 'list',
            'read' => 'get',
            'create' => 'create',
            'update' => 'update',
            'delete' => 'delete',
            'trash' => 'listDeleted',
            'restore' => 'restore',
            'forceDelete' => 'forceDelete',
        ] as $capability => $operationPrefix) {
            if (!empty($caps[$capability])) {
                $expectedOps[] = $operationPrefix . $operationBase;
            }
        }

        if (!empty($caps['update'])) {
            $expectedOps[] = 'patch' . $operationBase;
        }

        $expectedOpsCode = var_export(array_values(array_unique($expectedOps)), true);
        $hasUploadFields = false;
        foreach ((array) ($config['fields'] ?? []) as $field) {
            if (in_array(strtolower((string) ($field['inputType'] ?? '')), ['file', 'image'], true)) {
                $hasUploadFields = true;
                break;
            }
        }
        if ($hasUploadFields && !empty($caps['update'])) {
            $expectedOps[] = 'upload' . $operationBase;
            $expectedOpsCode = var_export(array_values(array_unique($expectedOps)), true);
        }

        $multipartAssertions = $hasUploadFields && (!empty($caps['create']) || !empty($caps['update']))
            ? <<<'PHP'
        $this->assertStringContainsString('multipart/form-data:', $yaml);
        $this->assertStringContainsString('format: binary', $yaml);
PHP
            : '';

        $pathAssertions = $expectedOps === []
            ? <<<PHP
        \$this->assertStringContainsString('paths:', \$yaml);
        \$this->assertStringContainsString('components:', \$yaml);
        \$this->assertStringNotContainsString('/api/v1/{$table}', \$yaml);
PHP
            : <<<PHP
        \$this->assertStringContainsString('/api/v1/{$table}', \$yaml);
PHP;

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use CodeIgniter\Test\CIUnitTestCase;

/**
 * Verifies the published OpenAPI contract without requiring external YAML parsers.
 */
final class {$entityBase}OpenApiContractTest extends CIUnitTestCase
{
    private const EXPECTED_OPERATION_IDS = {$expectedOpsCode};

    public function testOpenApiFileContainsExpectedOperations(): void
    {
        \$path = APPPATH . 'OpenApi/{$table}.yaml';

        \$this->assertFileExists(\$path);

        \$yaml = (string) file_get_contents(\$path);
        \$this->assertStringContainsString('openapi: 3.0.3', \$yaml);
{$pathAssertions}

        foreach (self::EXPECTED_OPERATION_IDS as \$operationId) {
            \$this->assertStringContainsString(
                'operationId: ' . \$operationId,
                \$yaml,
                'operationId OpenAPI mancante: ' . \$operationId
            );
        }

{$multipartAssertions}
        // Web Related Create/Offcanvas transport is intentionally not part of REST.
        \$this->assertStringNotContainsString('_related_new', \$yaml);
        \$this->assertStringNotContainsString('_related:', \$yaml);
        \$this->assertStringNotContainsString('_many_new', \$yaml);
        \$this->assertStringNotContainsString('_many_related', \$yaml);
        \$this->assertStringNotContainsString('offcanvas', strtolower(\$yaml));
    }
}

PHP;
    }

    private function mcpResourceSecurityTest(
        array $config,
        string $namespace,
        string $entityBase
    ): string {
        $expected = [];

        foreach ((array) ($config['fields'] ?? []) as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name !== '' && !empty($field['ui']['mcpVisible'])) {
                $expected[] = $name;
            }
        }

        $pk = (string) ($config['primaryKey'] ?? '');
        if ($pk !== '' && !in_array($pk, $expected, true)) {
            array_unshift($expected, $pk);
        }

        $expectedCode = var_export(array_values(array_unique($expected)), true);

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use App\Mcp\Resources\\{$entityBase}McpResource;
use CodeIgniter\Test\CIUnitTestCase;

final class {$entityBase}McpResourceSecurityContractTest extends CIUnitTestCase
{
    private const EXPECTED_READABLE = {$expectedCode};

    public function testMcpResourceExposesOnlyMcpVisibleFields(): void
    {
        \$source = [];
        foreach (self::EXPECTED_READABLE as \$field) {
            \$source[\$field] = 'visible-' . \$field;
        }
        \$source['__not_mcp_visible__'] = 'must-not-survive';

        \$result = {$entityBase}McpResource::make(\$source);

        \$this->assertSame(
            array_values(self::EXPECTED_READABLE),
            array_values(array_keys(\$result))
        );
        \$this->assertArrayNotHasKey('__not_mcp_visible__', \$result);
    }

    public function testMcpProjectionDoesNotDependOnApiResource(): void
    {
        \$path = APPPATH . 'Mcp/Resources/{$entityBase}McpResource.php';
        \$this->assertFileExists(\$path);

        \$php = (string) file_get_contents(\$path);
        \$this->assertStringNotContainsString('App\\\\API\\\\Resources', \$php);
        \$this->assertStringNotContainsString('apiVisible', \$php);
        \$this->assertStringNotContainsString('FILTERABLE', \$php);
        \$this->assertStringNotContainsString('SORTABLE', \$php);
        \$this->assertStringNotContainsString('filterableFields(', \$php);
        \$this->assertStringNotContainsString('sortableFields(', \$php);
    }
}

PHP;
    }

    private function mcpFoundationTest(array $config, string $namespace, string $entityBase): string
    {
        $table = (string) ($config['table'] ?? '');
        $caps = (array) ($config['mcp']['capabilities'] ?? []);
        $expectedTools = [];

        if (!empty($caps['list'])) {
            $expectedTools[] = 'list_' . strtolower(preg_replace('/[^a-zA-Z0-9_.-]+/', '_', $table));
        }
        if (!empty($caps['read'])) {
            $expectedTools[] = 'get_' . strtolower(preg_replace('/[^a-zA-Z0-9_.-]+/', '_', $table));
        }

        if (!empty($caps['relations'])) {
            foreach ((array) ($config['relations']['belongsTo'] ?? []) as $field => $relation) {
                if ((string) ($relation['parentTable'] ?? '') !== '') {
                    $expectedTools[] = substr(strtolower(
                        'get_' . $table . '_' . preg_replace('/[^a-zA-Z0-9_.-]+/', '_', (string) $field)
                    ), 0, 128);
                }
            }

            foreach ((array) ($config['relationsConfig']['hasMany'] ?? []) as $relation) {
                if (empty($relation['enabled'])) {
                    continue;
                }
                $childTable = (string) ($relation['childTable'] ?? '');
                $foreignKey = (string) ($relation['foreignKey'] ?? '');
                if ($childTable !== '' && $foreignKey !== '') {
                    $expectedTools[] = substr(strtolower(
                        'list_' . $table . '_' . $childTable . '_by_' . $foreignKey
                    ), 0, 128);
                }
            }
        }

        $expectedTools = array_values(array_unique($expectedTools));
        $expectedToolsCode = var_export($expectedTools, true);
        $relationToolsExpected = !empty($caps['relations']);
        $relationAssertion = $relationToolsExpected
            ? <<<PHP
        \$relationPath = APPPATH . 'Mcp/Tools/{$entityBase}RelationTools.php';
        \$this->assertFileExists(\$relationPath);

        \$relationPhp = (string) file_get_contents(\$relationPath);
        \$this->assertStringContainsString('McpTool', \$relationPhp);
        \$this->assertStringContainsString('App\\\\Models\\\\', \$relationPhp);
        \$this->assertStringNotContainsString('Database::connect', \$relationPhp);
        \$this->assertStringNotContainsString('db_connect(', \$relationPhp);
PHP
            : '';

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use CodeIgniter\Test\CIUnitTestCase;

final class {$entityBase}McpFoundationContractTest extends CIUnitTestCase
{
    private const EXPECTED_TOOLS = {$expectedToolsCode};

    public function testPublishedMcpManifestDeclaresReadOnlyTools(): void
    {
        \$path = APPPATH . 'Mcp/Manifests/{$table}.json';
        \$this->assertFileExists(\$path);

        \$manifest = json_decode((string) file_get_contents(\$path), true, 512, JSON_THROW_ON_ERROR);

        \$this->assertSame('myCrudCI4-mcp-foundation', \$manifest['format'] ?? null);
        \$this->assertSame('2026-07-28', \$manifest['targetProtocol'] ?? null);
        \$this->assertSame('stdio', \$manifest['server']['transport'] ?? null);
        \$this->assertSame('read_only', \$manifest['server']['mode'] ?? null);
        \$this->assertSame(self::EXPECTED_TOOLS, \$manifest['mcp']['tools'] ?? []);
        \$this->assertSame(self::EXPECTED_TOOLS !== [], (bool) (\$manifest['mcp']['toolsGenerated'] ?? false));
    }

    public function testPublishedReadOnlyToolsUseModelLayer(): void
    {
        \$path = APPPATH . 'Mcp/Tools/{$entityBase}Tools.php';
        \$this->assertFileExists(\$path);

        \$php = (string) file_get_contents(\$path);
        \$this->assertStringContainsString('McpTool', \$php);
        \$this->assertStringContainsString('App\\\\Models\\\\', \$php);
        \$this->assertStringNotContainsString('Database::connect', \$php);
        \$this->assertStringNotContainsString('db_connect(', \$php);

{$relationAssertion}    }
}

PHP;
    }

    private function webSecurityTest(array $config, string $namespace, string $entityBase): string
    {
        $table = (string) ($config['table'] ?? '');
        $permissions = array_values(array_filter(
            array_map('strval', (array) ($config['crudSecurity']['permissions'] ?? [])),
            static fn (string $permission): bool => $permission !== ''
        ));
        $permissionsExport = var_export($permissions, true);

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use CodeIgniter\Shield\Filters\SessionAuth;
use PHPUnit\Framework\TestCase;

final class {$entityBase}WebSecurityContractTest extends TestCase
{
    public function testGeneratedWebRoutesUseShieldSessionAuthentication(): void
    {
        self::assertTrue(class_exists(SessionAuth::class), 'CodeIgniter Shield is required by generated web security.');

        \$path = APPPATH . 'Routes/{$table}.php';
        self::assertFileExists(\$path);
        \$routes = (string) file_get_contents(\$path);
        self::assertStringContainsString("'filter' => 'session'", \$routes);

        foreach ({$permissionsExport} as \$permission) {
            self::assertStringContainsString('permission:' . \$permission, \$routes);
        }
    }
}
PHP;
    }

    private function apiSecurityTest(array $config, string $namespace, string $entityBase): string
    {
        $table = (string) ($config['table'] ?? '');
        $permissions = array_filter(
            (array) ($config['apiSecurity']['permissions'] ?? []),
            static fn ($value): bool => trim((string) $value) !== ''
        );
        $permissionsCode = var_export(array_map('strval', $permissions), true);

        return <<<PHP
<?php

declare(strict_types=1);

namespace {$namespace};

use CodeIgniter\Test\CIUnitTestCase;
use CodeIgniter\Shield\Filters\TokenAuth;

/**
 * Contract test for generated Shield API protection.
 */
final class {$entityBase}ApiSecurityContractTest extends CIUnitTestCase
{
    private const PERMISSIONS = {$permissionsCode};

    public function testShieldTokenFilterIsInstalled(): void
    {
        \$this->assertTrue(
            class_exists(TokenAuth::class),
            'CodeIgniter Shield non è installato ma la API richiede shield_tokens.'
        );
    }

    public function testPublishedRoutesUseTokenAndConfiguredPermissionFilters(): void
    {
        \$path = APPPATH . 'Routes/{$table}.php';
        \$this->assertFileExists(\$path);

        \$routes = (string) file_get_contents(\$path);
        \$this->assertStringContainsString("'filter' => 'tokens'", \$routes);

        foreach (self::PERMISSIONS as \$permission) {
            \$this->assertStringContainsString(
                "'filter' => 'permission:" . \$permission . "'",
                \$routes,
                'Shield permission missing from routes: ' . \$permission
            );
        }
    }

    public function testOpenApiDeclaresBearerAuthentication(): void
    {
        \$path = APPPATH . 'OpenApi/{$table}.yaml';
        \$this->assertFileExists(\$path);

        \$yaml = (string) file_get_contents(\$path);
        \$this->assertStringContainsString('bearerAuth:', \$yaml);
        \$this->assertStringContainsString('scheme: bearer', \$yaml);
        \$this->assertStringContainsString('authenticator: shield_tokens', \$yaml);
    }
}

PHP;
    }

    private function hasRelationalContract(array $config): bool
    {
        foreach ((array) ($config['fields'] ?? []) as $field) {
            if (!empty($field['relationCreate']['enabled'])
                && !empty($field['foreignKey']['relatedCreate']['available'])
            ) {
                return true;
            }
        }

        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $relation) {
            if (!empty($relation['enabled'])) {
                return true;
            }
        }

        foreach ((array) ($config['relationsConfig']['hasMany'] ?? []) as $relation) {
            if (!empty($relation['enabled'])) {
                return true;
            }
        }

        return false;
    }

    private function relationalContractTest(array $config, string $namespace, string $entityBase): string
    {
        $classes = (array) ($config['classes'] ?? []);
        $model = (string) ($classes['model'] ?? ($entityBase . 'Model'));
        $controller = (string) ($classes['controller'] ?? ($entityBase . 'Controller'));
        $rules = (string) (($classes['rules'] ?? '') ?: ($entityBase . 'Rules'));
        $service = (string) ($classes['service'] ?? ($entityBase . 'Service'));
        $serviceEnabled = !empty($config['features']['service']);

        $relatedCreateFields = [];
        $uniqueNestedFk = false;
        foreach ((array) ($config['fields'] ?? []) as $field) {
            $name = (string) ($field['name'] ?? '');
            if ($name === ''
                || empty($field['relationCreate']['enabled'])
                || empty($field['foreignKey']['relatedCreate']['available'])
            ) {
                continue;
            }
            $relatedCreateFields[] = $name;
            foreach ((array) ($field['foreignKey']['relatedCreate']['fields'] ?? []) as $relatedField) {
                if (!empty($relatedField['foreignKey']) && !empty($relatedField['unique'])) {
                    $uniqueNestedFk = true;
                    break 2;
                }
            }
        }

        $manyToManyKeys = [];
        $manyToManyRelatedCreateKeys = [];
        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $key => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }
            $manyToManyKeys[] = (string) $key;
            if (!empty($relation['createRelatedEnabled']) && !empty($relation['createRelatedAvailable'])) {
                $manyToManyRelatedCreateKeys[] = (string) $key;
            }
        }

        $relatedServiceReferences = [];
        foreach ((array) ($config['fields'] ?? []) as $fieldName => $field) {
            $relationCreate = (array) ($field['relationCreate'] ?? []);
            $foreignKey = (array) ($field['foreignKey'] ?? []);
            $relatedCreateSchema = (array) ($foreignKey['relatedCreate'] ?? []);
            $parentTable = trim((string) ($foreignKey['parentTable'] ?? ''));
            if (!empty($relationCreate['enabled']) && !empty($relatedCreateSchema['available']) && $parentTable !== '') {
                $relatedServiceReferences[] = \App\Libraries\MyCrud\Core\Naming::tableClass($parentTable) . 'Service';
            }
        }

        $manyToManyServiceReferences = [];
        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $relation) {
            $relatedTable = trim((string) ($relation['relatedTable'] ?? ''));
            if (!empty($relation['enabled']) && !empty($relation['createRelatedEnabled']) && !empty($relation['createRelatedAvailable']) && $relatedTable !== '') {
                $manyToManyServiceReferences[] = \App\Libraries\MyCrud\Core\Naming::tableClass($relatedTable) . 'Service';
            }
        }

        $hasManyKeys = [];
        $parentModelReferences = [];
        foreach ((array) ($config['fields'] ?? []) as $fieldName => $field) {
            $foreignKey = (array) ($field['foreignKey'] ?? []);
            $parentTable = trim((string) ($foreignKey['parentTable'] ?? ''));
            if ($parentTable === '') {
                continue;
            }
            $relationMode = strtolower((string) ($field['relationMode'] ?? $foreignKey['optionMode'] ?? 'select'));
            if ($relationMode === 'select') {
                $parentModelReferences[] = \App\Libraries\MyCrud\Core\Naming::tableClass($parentTable) . 'Model';
            }
        }

        $childModelReferences = [];
        foreach ((array) ($config['relationsConfig']['hasMany'] ?? []) as $key => $relation) {
            if (!empty($relation['enabled'])) {
                $hasManyKeys[] = (string) $key;
                $childTable = trim((string) ($relation['childTable'] ?? ''));
                if ($childTable !== '') {
                    $childModelReferences[] = \App\Libraries\MyCrud\Core\Naming::tableClass($childTable) . 'Model';
                }
            }
        }

        $expectsModelTransaction = !$serviceEnabled
            && ($relatedCreateFields !== [] || $manyToManyKeys !== [] || $manyToManyRelatedCreateKeys !== []);
        $expectsServiceRelatedTransaction = $serviceEnabled
            && ($relatedCreateFields !== [] || $manyToManyKeys !== [] || $manyToManyRelatedCreateKeys !== []);

        $template = <<<'PHP'
<?php

declare(strict_types=1);

namespace __NAMESPACE__;

use App\Validation\__RULES__;
use CodeIgniter\Test\CIUnitTestCase;

/**
 * Non-destructive relational contract checks generated by myCrudCI4.
 *
 * The test intentionally inspects generated source and validation metadata.
 * It does not create fixtures and does not write to the database.
 */
final class __ENTITY__RelationalContractTest extends CIUnitTestCase
{
    private const RELATED_CREATE_FIELDS = __RELATED_FIELDS__;
    private const MANY_TO_MANY_KEYS = __M2M_KEYS__;
    private const MANY_TO_MANY_RELATED_CREATE_KEYS = __M2M_RELATED_KEYS__;
    private const HAS_MANY_KEYS = __HAS_MANY_KEYS__;
    private const PARENT_MODEL_REFERENCES = __PARENT_MODEL_REFERENCES__;
    private const CHILD_MODEL_REFERENCES = __CHILD_MODEL_REFERENCES__;
    private const RELATED_SERVICE_REFERENCES = __RELATED_SERVICE_REFERENCES__;
    private const MANY_TO_MANY_SERVICE_REFERENCES = __M2M_SERVICE_REFERENCES__;
    private const EXPECTS_MODEL_CREATE_TRANSACTION = __EXPECTS_MODEL_TRANSACTION__;
    private const EXPECTS_SERVICE_RELATED_TRANSACTION = __EXPECTS_SERVICE_RELATED_TRANSACTION__;
    private const SERVICE_ENABLED = __SERVICE_ENABLED__;
    private const EXPECTS_UNIQUE_NESTED_FK_FILTER = __EXPECTS_UNIQUE_FILTER__;

    public function testRelatedCreateValidationMatchesConfiguredFields(): void
    {
        if (self::RELATED_CREATE_FIELDS === []) {
            self::assertTrue(true);
            return;
        }

        $rules = __RULES__::relatedCreateRules();
        foreach (self::RELATED_CREATE_FIELDS as $field) {
            self::assertArrayHasKey($field, $rules, 'Missing Related Create rules for: ' . $field);
            self::assertNotSame([], (array) $rules[$field]);
        }
    }

    public function testRelatedCreateControllerAndModelHooksArePresent(): void
    {
        if (self::RELATED_CREATE_FIELDS === []) {
            self::assertTrue(true);
            return;
        }

        $controllerPath = APPPATH . 'Controllers/__CONTROLLER__.php';
        $modelPath = APPPATH . 'Models/__MODEL__.php';
        self::assertFileExists($controllerPath);
        self::assertFileExists($modelPath);

        $controller = (string) file_get_contents($controllerPath);
        $model = (string) file_get_contents($modelPath);

        self::assertStringContainsString('relatedCreateDataFromPost', $controller);
        self::assertStringContainsString('validateRelatedCreates', $controller);
        if (self::PARENT_MODEL_REFERENCES !== []) {
            self::assertStringContainsString('relationOptionRows(', $model);
        }

        if (self::SERVICE_ENABLED) {
            $servicePath = APPPATH . 'Services/__SERVICE__.php';
            self::assertFileExists($servicePath);
            $service = (string) file_get_contents($servicePath);
            self::assertStringNotContainsString('createRelatedViaServices', $service);
            self::assertStringContainsString('private function create', $service);
            self::assertStringContainsString('public function createRelated', $service);
            self::assertStringContainsString('validateCreatePayload', $service);
            self::assertStringContainsString('__RULES__::createRules()', $service);
            self::assertStringNotContainsString('RELATED_CREATE_SERVICES', $service);
            self::assertStringNotContainsString('new $serviceClass', $service);
            foreach (self::RELATED_SERVICE_REFERENCES as $relatedService) {
                self::assertStringContainsString('new ' . $relatedService, $service);
            }
            self::assertStringContainsString('insertRelatedPayload', $model);
            self::assertStringNotContainsString('private function createRelatedRecord', $model);
            return;
        }

        self::assertStringContainsString('createRelatedRecord', $model);
    }

    public function testManyToManyContractsRemainGenerated(): void
    {
        if (self::MANY_TO_MANY_KEYS === []) {
            self::assertTrue(true);
            return;
        }

        $modelPath = APPPATH . 'Models/__MODEL__.php';
        self::assertFileExists($modelPath);
        $model = (string) file_get_contents($modelPath);
        self::assertStringContainsString('manyToManyFormOptions', $model);
        self::assertStringContainsString('manyToManySelected', $model);
        self::assertStringContainsString('relationRowsByIds(', $model);
        self::assertStringNotContainsString('applyManyToMany', $model, 'Legacy generic M2M dispatcher found.');
        self::assertStringNotContainsString('validManyToManyTargetIds', $model, 'Legacy generic M2M validator found.');

        if (self::MANY_TO_MANY_RELATED_CREATE_KEYS !== []) {
            $rules = __RULES__::manyToManyRelatedCreateRules();
            foreach (self::MANY_TO_MANY_RELATED_CREATE_KEYS as $key) {
                self::assertArrayHasKey($key, $rules, 'Missing M2M Related Create rules for: ' . $key);
            }
            // The generated Model may override the BaseCrudModel default when
            // an inline-created M:N target contains nested foreign keys. The
            // override is valid as long as its dependencies are statically
            // wired; the legacy problem was runtime class/table resolution,
            // not the public contract name itself.
            if (str_contains($model, 'function manyToManyRelatedCreateRelationOptions(')) {
                self::assertStringNotContainsString(
                    'new $modelClass',
                    $model,
                    'Dynamic Model resolution found in M2M Related Create options.'
                );
                self::assertStringNotContainsString(
                    'Database::connect(',
                    $model,
                    'Direct database resolver found in M2M Related Create options.'
                );
            }

            if (self::SERVICE_ENABLED) {
                $servicePath = APPPATH . 'Services/__SERVICE__.php';
                self::assertFileExists($servicePath);
                $service = (string) file_get_contents($servicePath);
                self::assertStringNotContainsString('createManyToManyRelatedViaServices', $service);
                self::assertStringContainsString('private function create', $service);
                self::assertStringNotContainsString('MANY_TO_MANY_RELATED_CREATE_SERVICES', $service);
                self::assertStringNotContainsString('new $serviceClass', $service);
                foreach (self::MANY_TO_MANY_SERVICE_REFERENCES as $relatedService) {
                    self::assertStringContainsString('new ' . $relatedService, $service);
                }
                self::assertStringNotContainsString('private function createManyToManyRelatedRecords', $model);
                return;
            }

            self::assertStringContainsString('createManyToManyRelatedRecords', $model);
        }
    }

    public function testHasManyDetailLoaderIsPresentWhenConfigured(): void
    {
        if (self::HAS_MANY_KEYS === []) {
            self::assertTrue(true);
            return;
        }

        $modelPath = APPPATH . 'Models/__MODEL__.php';
        self::assertFileExists($modelPath);
        $model = (string) file_get_contents($modelPath);
        self::assertStringContainsString('function loadHasMany', $model);
    }

    public function testRelationalReadQueriesAreDelegatedToOwningModels(): void
    {
        if (self::PARENT_MODEL_REFERENCES === [] && self::CHILD_MODEL_REFERENCES === []) {
            self::assertTrue(true);
            return;
        }

        $modelPath = APPPATH . 'Models/__MODEL__.php';
        self::assertFileExists($modelPath);
        $model = (string) file_get_contents($modelPath);

        foreach (self::PARENT_MODEL_REFERENCES as $parentModel) {
            self::assertStringContainsString('new ' . $parentModel, $model, 'Parent query is not delegated to ' . $parentModel);
        }
        foreach (self::CHILD_MODEL_REFERENCES as $childModel) {
            self::assertStringContainsString('new ' . $childModel, $model, 'Child query is not delegated to ' . $childModel);
        }

        // Relation ownership must be visible in generated PHP. Dynamic class/table
        // resolution would hide the dependency graph and is intentionally forbidden.
        self::assertStringNotContainsString('new $', $model);
        self::assertStringNotContainsString('Database::connect(', $model);
        self::assertStringNotContainsString("->db->table(\$definition", $model);
        self::assertStringNotContainsString("->db->table((string) \$definition", $model);

        if (self::PARENT_MODEL_REFERENCES !== []) {
            self::assertStringContainsString('relationOptionRows(', $model);
        }
        if (self::CHILD_MODEL_REFERENCES !== []) {
            self::assertStringContainsString('childrenByForeignKey(', $model);
        }
    }

    public function testRelationalWritesStayInServicesWhenServiceLayerExists(): void
    {
        if (!self::SERVICE_ENABLED) {
            self::assertTrue(true);
            return;
        }

        if (self::RELATED_CREATE_FIELDS === [] && self::MANY_TO_MANY_RELATED_CREATE_KEYS === []) {
            self::assertTrue(true);
            return;
        }

        $servicePath = APPPATH . 'Services/__SERVICE__.php';
        $modelPath = APPPATH . 'Models/__MODEL__.php';
        self::assertFileExists($servicePath);
        self::assertFileExists($modelPath);
        $service = (string) file_get_contents($servicePath);
        $model = (string) file_get_contents($modelPath);

        if (self::RELATED_CREATE_FIELDS !== []) {
            self::assertStringNotContainsString('createRelatedViaServices', $service);
            self::assertStringContainsString('private function create', $service);
            self::assertStringNotContainsString('private function createRelatedRecord', $model);
        }
        if (self::MANY_TO_MANY_RELATED_CREATE_KEYS !== []) {
            self::assertStringNotContainsString('createManyToManyRelatedViaServices', $service);
            self::assertStringContainsString('private function create', $service);
            self::assertStringNotContainsString('private function createManyToManyRelatedRecords', $model);
        }
    }

    public function testServiceContainsWriteUseCasesOnly(): void
    {
        if (!self::SERVICE_ENABLED) {
            self::assertTrue(true);
            return;
        }

        $servicePath = APPPATH . 'Services/__SERVICE__.php';
        self::assertFileExists($servicePath);
        $service = (string) file_get_contents($servicePath);

        // Read-only pass-through methods belonged to the legacy Service design.
        foreach ([
            'function listPage(',
            'function exportRows(',
            'function countExportRows(',
            'function exportFields(',
            'function apiList(',
            'function relationOptions(',
            'function relatedCreateRelationOptions(',
            'function searchRelationOptions(',
            'function relationOptionById(',
            'function loadHasMany(',
            'function manyToManyFormOptions(',
            'function manyToManySelected(',
            'function manyToManyRelatedCreateRelationOptions(',
            'function deletedList(',
            'function prepareRelatedData(',
        ] as $legacyMethod) {
            self::assertStringNotContainsString($legacyMethod, $service, 'Legacy Service pass-through found: ' . $legacyMethod);
        }
    }

    public function testAtomicCreateKeepsTransactionBoundaries(): void
    {
        if (self::EXPECTS_MODEL_CREATE_TRANSACTION) {
            $modelPath = APPPATH . 'Models/__MODEL__.php';
            self::assertFileExists($modelPath);
            $model = (string) file_get_contents($modelPath);
            self::assertStringContainsString('$this->db->transBegin()', $model);
            self::assertStringContainsString('$this->db->transCommit()', $model);
            self::assertStringContainsString('$this->db->transRollback()', $model);
        }

        if (self::EXPECTS_SERVICE_RELATED_TRANSACTION) {
            $servicePath = APPPATH . 'Services/__SERVICE__.php';
            self::assertFileExists($servicePath);
            $service = (string) file_get_contents($servicePath);
            self::assertStringNotContainsString('\Config\Database::connect()', $service);
            self::assertStringContainsString('beginWriteTransaction()', $service);
            self::assertStringContainsString('commitWriteTransaction()', $service);
            self::assertStringContainsString('rollbackWriteTransaction()', $service);

            $baseModelPath = APPPATH . 'Models/BaseCrudModel.php';
            self::assertFileExists($baseModelPath);
            $baseModel = (string) file_get_contents($baseModelPath);
            self::assertStringContainsString('public function beginWriteTransaction', $baseModel);
            self::assertStringContainsString('public function writeTransactionStatus', $baseModel);
            self::assertStringContainsString('public function commitWriteTransaction', $baseModel);
            self::assertStringContainsString('public function rollbackWriteTransaction', $baseModel);
        }

        if (!self::EXPECTS_MODEL_CREATE_TRANSACTION && !self::EXPECTS_SERVICE_RELATED_TRANSACTION) {
            self::assertTrue(true);
        }
    }

    public function testUniqueNestedForeignKeyFilteringContractIsPreserved(): void
    {
        if (!self::EXPECTS_UNIQUE_NESTED_FK_FILTER) {
            self::assertTrue(true);
            return;
        }

        $modelPath = APPPATH . 'Models/__MODEL__.php';
        self::assertFileExists($modelPath);
        $model = (string) file_get_contents($modelPath);
        // Unique nested-FK filtering is emitted explicitly at generation time.
        // Runtime metadata/resolver markers must not return.
        self::assertStringNotContainsString('uniqueConsumerTable', $model);
        self::assertStringNotContainsString('uniqueConsumerField', $model);
        self::assertStringContainsString('relationOptionRows(', $model);
        self::assertStringContainsString('array_values(array_filter(', $model);
        self::assertStringContainsString('!in_array(', $model);
    }
}

PHP;

        return strtr($template, [
            '__NAMESPACE__' => $namespace,
            '__RULES__' => $rules,
            '__ENTITY__' => $entityBase,
            '__CONTROLLER__' => $controller,
            '__MODEL__' => $model,
            '__SERVICE__' => $service,
            '__RELATED_FIELDS__' => var_export(array_values(array_unique($relatedCreateFields)), true),
            '__M2M_KEYS__' => var_export(array_values(array_unique($manyToManyKeys)), true),
            '__M2M_RELATED_KEYS__' => var_export(array_values(array_unique($manyToManyRelatedCreateKeys)), true),
            '__HAS_MANY_KEYS__' => var_export(array_values(array_unique($hasManyKeys)), true),
            '__PARENT_MODEL_REFERENCES__' => var_export(array_values(array_unique($parentModelReferences)), true),
            '__CHILD_MODEL_REFERENCES__' => var_export(array_values(array_unique($childModelReferences)), true),
            '__RELATED_SERVICE_REFERENCES__' => var_export(array_values(array_unique($relatedServiceReferences)), true),
            '__M2M_SERVICE_REFERENCES__' => var_export(array_values(array_unique($manyToManyServiceReferences)), true),
            '__EXPECTS_MODEL_TRANSACTION__' => $expectsModelTransaction ? 'true' : 'false',
            '__EXPECTS_SERVICE_RELATED_TRANSACTION__' => $expectsServiceRelatedTransaction ? 'true' : 'false',
            '__SERVICE_ENABLED__' => $serviceEnabled ? 'true' : 'false',
            '__EXPECTS_UNIQUE_FILTER__' => $uniqueNestedFk ? 'true' : 'false',
        ]);
    }

    private function readme(array $config, string $entityBase): string
    {
        $architecture = (string) ($config['architecture'] ?? 'basic');
        $table = (string) ($config['table'] ?? '');

        return <<<MD
# {$entityBase} generated tests

Generated by myCrudCI4 for table `{$table}` using **{$architecture}** architecture.

These tests intentionally avoid generated fixtures and destructive database operations.

They cover only contracts that myCrudCI4 can derive safely:

- generated class autoloadability;
- validation policy exclusions;
- REST Resource readable/writable filtering (Full);
- published OpenAPI operation IDs (Full);
- Shield token/permission route contracts when API security is enabled;
- relational source/validation contracts for Related Create, M2M, hasMany and atomic create when configured.

After publishing the CRUD, the tests are copied to:

```text
tests/Generated/MyCrud/{$entityBase}/
```

Run them with the PHPUnit/Test command used by your CodeIgniter 4 project.

Application-specific behavior should be added as separate tests maintained by the developer.
MD;
    }

    private function studly(string $value): string
    {
        $parts = preg_split('/[^a-zA-Z0-9]+/', $value) ?: [$value];

        $result = implode('', array_map(
            static fn (string $part): string => ucfirst(strtolower($part)),
            $parts
        ));

        return $result !== '' ? $result : 'Crud';
    }
}
