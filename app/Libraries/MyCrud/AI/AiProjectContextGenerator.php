<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\AI;

use App\Libraries\MyCrud\Config\CrudConfigRepository;
use App\Libraries\MyCrud\Core\CrudConfigurationService;
use App\Libraries\MyCrud\Core\Naming;
use App\Libraries\MyCrud\MyCrudVersion;
use App\Libraries\MyCrud\Schema\TableFilter;
use CodeIgniter\Database\BaseConnection;
use Config\Database;
use RuntimeException;
use Throwable;

/**
 * Generates a project map designed for AI agents.
 *
 * The context is derived exclusively from the DB schema, configurations
 * persistenti e convenzioni myCrudCI4. Non vengono esportati dati applicativi,
 * credenziali, valori di .env o altri segreti.
 */
final class AiProjectContextGenerator
{
    private BaseConnection $db;
    private CrudConfigRepository $repository;
    private CrudConfigurationService $configuration;

    public function __construct(
        ?BaseConnection $db = null,
        ?CrudConfigRepository $repository = null,
        ?CrudConfigurationService $configuration = null,
    ) {
        $this->db = $db ?? Database::connect();
        $this->repository = $repository ?? new CrudConfigRepository();
        $this->configuration = $configuration ?? new CrudConfigurationService();
    }

    /**
     * Generates the global context and one Markdown file for each configured CRUD.
     *
     * @return array{root:string,files:list<string>,crudCount:int,dbTableCount:int}
     */
    public function generateProject(): array
    {
        $snapshot = $this->buildProjectSnapshot();
        $rootFile = ROOTPATH . 'AI_PROJECT_CONTEXT.md';
        $docsRoot = ROOTPATH . 'docs' . DIRECTORY_SEPARATOR . 'ai';
        $crudRoot = $docsRoot . DIRECTORY_SEPARATOR . 'crud';

        $this->ensureDirectory($crudRoot);

        $files = [];
        $this->atomicWrite($rootFile, $this->projectMarkdown($snapshot));
        $files[] = $rootFile;

        $projectJson = $docsRoot . DIRECTORY_SEPARATOR . 'project.json';
        $this->atomicWrite(
            $projectJson,
            json_encode($snapshot, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR) . PHP_EOL
        );
        $files[] = $projectJson;

        foreach ((array) ($snapshot['crud'] ?? []) as $table => $crud) {
            $path = $crudRoot . DIRECTORY_SEPARATOR . $table . '.md';
            $this->atomicWrite($path, $this->crudMarkdown((array) $crud));
            $files[] = $path;
        }

        return [
            'root' => ROOTPATH,
            'files' => $files,
            'crudCount' => count((array) ($snapshot['crud'] ?? [])),
            'dbTableCount' => count((array) ($snapshot['database']['tables'] ?? [])),
        ];
    }

    /**
     * Rigenera soltanto il documento di un CRUD.
     *
     * @return array{root:string,files:list<string>,crudCount:int,dbTableCount:int}
     */
    public function generateCrud(string $table): array
    {
        $table = $this->assertTable($table);
        $snapshot = $this->buildCrudSnapshot($table);
        $crudRoot = ROOTPATH . 'docs' . DIRECTORY_SEPARATOR . 'ai' . DIRECTORY_SEPARATOR . 'crud';
        $this->ensureDirectory($crudRoot);

        $path = $crudRoot . DIRECTORY_SEPARATOR . $table . '.md';
        $this->atomicWrite($path, $this->crudMarkdown($snapshot));

        return [
            'root' => ROOTPATH,
            'files' => [$path],
            'crudCount' => 1,
            'dbTableCount' => 1,
        ];
    }

    /** @return array<string,mixed> */
    public function buildProjectSnapshot(): array
    {
        $dbTables = TableFilter::validTables($this->db);
        $configured = $this->repository->tables();
        $configuredLookup = array_fill_keys($configured, true);

        $crud = [];
        foreach ($configured as $table) {
            try {
                $crud[$table] = $this->buildCrudSnapshot($table);
            } catch (Throwable $exception) {
                // An orphaned configuration remains useful to the map: the agent must
                // sapere che esiste ma che lo DB schema corrente non la risolve.
                $saved = $this->repository->load($table) ?? [];
                $crud[$table] = $this->orphanSnapshot($table, $saved, $exception->getMessage());
            }
        }

        $unconfigured = array_values(array_filter(
            $dbTables,
            static fn (string $table): bool => !isset($configuredLookup[$table])
        ));

        return [
            'formatVersion' => 1,
            'generatedBy' => 'myCrudCI4',
            'generatorVersion' => MyCrudVersion::VERSION,
            'developerGuides' => [
                'contributing' => 'CONTRIBUTING.md',
                'architecture' => 'docs/development/ARCHITECTURE.md',
                'architectureRules' => 'docs/development/ARCHITECTURE_RULES.md',
                'addingFeature' => 'docs/development/ADDING_A_FEATURE.md',
                'featureMatrix' => 'docs/development/FEATURE_MATRIX.md',
            ],
            'generatedAt' => date(DATE_ATOM),
            'framework' => [
                'name' => 'CodeIgniter 4',
                'version' => defined('CodeIgniter\\CodeIgniter::CI_VERSION')
                    ? constant('CodeIgniter\\CodeIgniter::CI_VERSION')
                    : '4.x',
                'php' => PHP_VERSION,
            ],
            'conventions' => [
                'databaseFieldNaming' => 'preserve_exact_db_names',
                'tableClassNaming' => 'studly_without_singularization',
                'generatedStaging' => 'app/Generated/',
                'runtimeNamespace' => 'App\\Libraries\\Crud',
                'runtimePath' => 'app/Libraries/Crud/',
                'crudConfigPath' => 'app/MyCrudConfig/',
                'menuConfigPath' => 'app/MyCrudConfig/Project/Menu.php',
                'routesStrategy' => 'modular',
                'routesPath' => 'app/Routes/',
                'applicationLayout' => 'app/Views/layouts/default_app.php',
                'frontend' => ['Bootstrap 5', 'Bootstrap Icons', 'vanilla JavaScript'],
                'viewStructure' => [
                    'breadcrumb' => 'Every generated main CRUD view starts with a Bootstrap breadcrumb.',
                    'pageHeading' => 'Every generated main CRUD view has exactly one page-level h1 containing the table name.',
                    'pageContext' => 'A small text under h1 identifies List, New record, Edit record, Record details, or Trash.',
                    'cardHeading' => 'Inner form/detail card headings use h2 to preserve a single h1 per page.',
                ],
                'relationalCreate' => [
                    'mode' => 'select_existing_or_create_parent_inline',
                    'transaction' => 'parent_and_current_record_same_transaction',
                    'foreignKeyAuthority' => 'server_generated_parent_primary_key',
                    'databaseManagedFields' => 'never_written_by_inline_parent_payload',
                ],
            ],
            'architectureRules' => [
                'basic' => 'Controller -> Model -> Database',
                'standard' => 'Controller -> Service -> Model -> Database',
                'fullWeb' => 'Controller -> Service -> Model -> Database',
                'fullApiRead' => 'API Controller -> Model -> Resource -> JSON',
                'fullApiWrite' => 'API Controller -> Service -> Model',
                'modelBase' => 'Concrete generated Models extend App\Models\BaseCrudModel; relation targets remain explicit in concrete Models.',
                'mcpRead' => 'MCP Tool -> Model -> MCP Resource',
                'entity' => 'Standard/Full write payloads become an Entity after Service preparation/hooks and before Model persistence; list/export/projection queries may remain object/array.',
                'entityFactory' => 'Entity::fromArray($data) constructs the Entity from already prepared data; it does not validate the payload. Generated validation remains a Service responsibility.',
                'regeneration' => 'During scaffolding, regeneration with --force is expected. After operational application code has been customized, destructive regeneration must not be used indiscriminately: inspect differences and preserve project-specific behavior.',
            ],
            'database' => [
                'tables' => $dbTables,
                'configuredTables' => $configured,
                'unconfiguredTables' => $unconfigured,
            ],
            'crud' => $crud,
            'agentRules' => $this->agentRules(),
        ];
    }

    /** @return array<string,mixed> */
    public function buildCrudSnapshot(string $table): array
    {
        $table = $this->assertTable($table);
        $resolved = $this->configuration->resolve($table, true);
        $config = (array) $resolved['config'];
        $architecture = strtolower((string) ($config['architecture'] ?? 'basic'));
        $class = Naming::tableClass($table);
        $primaryKey = (string) ($config['primaryKey'] ?? 'id');
        $primaryKeys = array_values(array_map('strval', (array) ($config['primaryKeys'] ?? [$primaryKey])));
        $tableType = strtoupper((string) ($config['tableType'] ?? 'BASE TABLE'));
        $isView = !empty($config['isView']);
        $features = (array) ($config['features'] ?? []);

        $fields = [];
        $belongsTo = [];
        foreach ((array) ($config['fields'] ?? []) as $name => $field) {
            $field = (array) $field;
            $ui = (array) ($field['ui'] ?? []);
            $index = (array) ($field['index'] ?? []);
            $fk = (array) ($field['foreignKey'] ?? []);

            $item = [
                'name' => (string) $name,
                'type' => (string) ($field['columnType'] ?? $field['type'] ?? ''),
                'nullable' => (bool) ($field['nullable'] ?? false),
                'primary' => (bool) ($field['primary'] ?? false),
                'autoIncrement' => (bool) ($field['autoIncrement'] ?? false),
                'databaseManaged' => (bool) ($field['databaseManaged'] ?? false),
                'default' => $field['default'] ?? null,
                'extra' => (string) ($field['extra'] ?? ''),
                'inputType' => (string) ($field['inputType'] ?? 'text'),
                'searchable' => (bool) ($ui['searchable'] ?? false),
                'sortable' => (bool) ($ui['sortable'] ?? false),
                'visibleIndex' => (bool) ($ui['visibleIndex'] ?? false),
                'visibleForm' => (bool) ($ui['visibleForm'] ?? false),
                'visibleView' => (bool) ($ui['visibleView'] ?? false),
                'exportable' => (bool) ($ui['exportable'] ?? false),
                'apiVisible' => (bool) ($ui['apiVisible'] ?? false),
                'index' => [
                    'indexed' => (bool) ($index['indexed'] ?? false),
                    'leading' => (bool) ($index['leading'] ?? false),
                    'primary' => (bool) ($index['primary'] ?? false),
                    'unique' => (bool) ($index['unique'] ?? false),
                    'indexes' => array_values((array) ($index['indexes'] ?? [])),
                ],
            ];

            if ($fk !== []) {
                $relation = [
                    'field' => (string) $name,
                    'parentTable' => (string) ($fk['parentTable'] ?? ''),
                    'parentKey' => (string) ($fk['parentKey'] ?? ''),
                    'mode' => (string) ($field['relationMode'] ?? 'select'),
                    'displayField' => (string) ($field['relationDisplayField'] ?? ''),
                    'displayTemplate' => (string) ($field['relationDisplayTemplate'] ?? ''),
                    'navigation' => (array) ($field['relationNavigation'] ?? []),
                    'relatedCreate' => [
                        'available' => !empty($field['relationCreate']['available']),
                        'enabled' => !empty($field['relationCreate']['enabled']),
                        'behavior' => 'select existing parent or create a new parent in a Bootstrap Offcanvas using a dedicated parent-field partial',
                        'transactional' => true,
                        'foreignKeyAssignedServerSide' => true,
                        'ui' => 'bootstrap-input-group + bootstrap-offcanvas',
                        'relationActions' => 'standard FK select uses one Bootstrap input-group; parent open = bi-box-arrow-up-right, relational create = bi-plus-circle + New',
                        'partial' => '_related_create_<foreign-key>.php',
                        'loadsFullParentCreateView' => false,
                    ],
                ];
                $item['foreignKey'] = $relation;
                $belongsTo[] = $relation;
            }

            $fields[] = $item;
        }

        $hasMany = [];
        foreach ((array) ($config['relationsConfig']['hasMany'] ?? []) as $key => $relation) {
            $relation = (array) $relation;
            if (empty($relation['enabled'])) {
                continue;
            }
            $hasMany[] = [
                'key' => (string) $key,
                'title' => (string) ($relation['title'] ?? ''),
                'childTable' => (string) ($relation['childTable'] ?? ''),
                'foreignKey' => (string) ($relation['foreignKey'] ?? ''),
                'childCreateAllowed' => !empty($relation['childCreateAllowed']),
                'showCreateButton' => !empty($relation['showCreateButton']),
                'showViewAllButton' => !empty($relation['showViewAllButton']),
                'showViewButton' => !empty($relation['showViewButton']),
                'contextualCreate' => !empty($relation['showCreateButton']) && !empty($relation['childCreateAllowed']),
                'returnToParentAfterCreate' => !empty($relation['showCreateButton']) && !empty($relation['childCreateAllowed']),
                'partial' => '_children_' . (preg_replace('/[^A-Za-z0-9_]/', '_', (string) $key) ?: 'relation') . '.php',
                'columns' => array_values((array) ($relation['columns'] ?? [])),
            ];
        }

        $manyToMany = [];
        foreach ((array) ($config['relationsConfig']['manyToMany'] ?? []) as $key => $relation) {
            if (empty($relation['enabled'])) {
                continue;
            }
            $manyToMany[] = [
                'key' => (string) $key,
                'pivotTable' => (string) ($relation['pivotTable'] ?? ''),
                'relatedTable' => (string) ($relation['relatedTable'] ?? ''),
                'ownPivotField' => (string) ($relation['ownPivotField'] ?? ''),
                'relatedPivotField' => (string) ($relation['relatedPivotField'] ?? ''),
                'scaffold' => ['read', 'attach', 'detach', 'sync'],
                'selectorUi' => 'search-checkbox-badges',
                'selectorBehavior' => 'single UI for all N:N relations; local options now, AJAX can reuse the same UI later',
                'formLayout' => 'project-configurable via Config\\MyCrud::$relationPanelWidths[\'manyToMany\']; full width on mobile',
                'relatedCreateOffcanvas' => 'single project-wide width via Config\\MyCrud::$relationOffcanvasWidth (default 640px) for belongsTo and many-to-many panels',
            ];
        }

        return [
            'table' => $table,
            'dbStatus' => 'present',
            'architecture' => $architecture,
            'primaryKey' => $primaryKey,
            'primaryKeys' => $primaryKeys,
            'tableType' => $tableType,
            'isView' => $isView,
            'readOnly' => !empty($features['readOnly']),
            'createAllowed' => !empty($features['createAllowed']),
            'readOnlyReason' => (string) ($features['readOnlyReason'] ?? ''),
            'config' => [
                'saved' => (bool) ($resolved['saved'] ?? false),
                'path' => $resolved['configPath'] ? $this->relativePath((string) $resolved['configPath']) : null,
                'savedVersion' => $resolved['savedVersion'] ?? null,
                'schemaDrift' => (bool) ($resolved['schemaDrift'] ?? false),
            ],
            'components' => $this->components($table, $class, $architecture),
            'features' => $features,
            'fields' => $fields,
            'relations' => [
                'belongsTo' => $belongsTo,
                'hasMany' => $hasMany,
                'manyToMany' => $manyToMany,
            ],
            'developmentGuidance' => $this->guidanceFor($architecture, $class),
            'customization' => $this->customizationFor($architecture, $class),
        ];
    }

    /** @return array<string,mixed> */
    private function orphanSnapshot(string $table, array $saved, string $reason): array
    {
        $architecture = strtolower((string) ($saved['architecture'] ?? 'basic'));
        $class = Naming::tableClass($table);

        return [
            'table' => $table,
            'dbStatus' => 'missing',
            'architecture' => $architecture,
            'primaryKey' => null,
            'primaryKeys' => [],
            'tableType' => 'UNKNOWN',
            'isView' => false,
            'readOnly' => true,
            'createAllowed' => false,
            'readOnlyReason' => 'database_table_missing',
            'config' => [
                'saved' => true,
                'path' => $this->relativePath($this->repository->pathFor($table)),
                'savedVersion' => (string) (($saved['_meta']['generatorVersion'] ?? '')),
                'schemaDrift' => true,
            ],
            'components' => $this->components($table, $class, $architecture),
            'features' => (array) ($saved['features'] ?? []),
            'fields' => array_keys((array) ($saved['fields'] ?? [])),
            'relations' => ['belongsTo' => [], 'hasMany' => [], 'manyToMany' => []],
            'warning' => 'Configuration exists but the table cannot be resolved in the current DB: ' . $reason,
            'developmentGuidance' => $this->guidanceFor($architecture, $class),
            'customization' => $this->customizationFor($architecture, $class),
        ];
    }

    /** @return array<string,string> */
    private function components(string $table, string $class, string $architecture): array
    {
        $components = [
            'controller' => 'app/Controllers/' . $class . 'Controller.php',
            'model' => 'app/Models/' . $class . 'Model.php',
            'validation' => 'app/Validation/' . $class . 'Rules.php',
            'views' => 'app/Views/' . $table . '/',
            'routes' => 'app/Routes/' . $table . '.php',
            'languageIt' => 'app/Language/it/' . $class . '.php',
            'languageEn' => 'app/Language/en/' . $class . '.php',
        ];

        if (in_array($architecture, ['standard', 'full'], true)) {
            $components['service'] = 'app/Services/' . $class . 'Service.php';
            $components['serviceExtension'] = 'app/Services/Extensions/' . $class . 'ServiceExtension.php';
            $components['entity'] = 'app/Entities/' . $class . 'Entity.php';
        }

        if ($architecture === 'full') {
            $components['apiController'] = 'app/Controllers/Api/V1/' . $class . 'ApiController.php';
            $components['apiBaseController'] = 'app/Controllers/Api/BaseApiController.php';
            $components['apiResource'] = 'app/API/Resources/' . $class . 'Resource.php';
            $components['apiValidation'] = 'app/Validation/' . $class . 'ApiRules.php';
        }

        return $components;
    }

    /** @return array<string,mixed> */
    private function customizationFor(string $architecture, string $class): array
    {
        $standardOrFull = in_array($architecture, ['standard', 'full'], true);

        return [
            'generatedCodePolicy' => 'Do not patch app/Generated/ as a customization strategy; regenerate from configuration instead.',
            'operationalCodePolicy' => 'Published app/ files are normal application code. Inspect them before editing or republishing; destructive regeneration may overwrite customized operational files.',
            'entityPolicy' => $standardOrFull
                ? 'Entity represents one record: casts, dates, accessors/mutators and record-local behavior. Service prepares/validates input and owns transactions/cross-resource business logic; Entity never queries the database.'
                : 'Basic does not require an Entity write boundary.',
            'entityFactoryPolicy' => $standardOrFull
                ? 'Entity::fromArray($data) constructs the Entity from already prepared data; it does not validate the payload. Generated validation remains a Service responsibility.'
                : null,
            'regenerationPolicy' => 'During scaffolding, regeneration with --force is expected. After operational application code has been customized, review differences before destructive regeneration and preserve project-specific behavior.',
            'serviceExtensionAvailable' => $standardOrFull,
            'serviceExtension' => $standardOrFull
                ? 'app/Services/Extensions/' . $class . 'ServiceExtension.php'
                : null,
            'serviceExtensionPolicy' => $standardOrFull
                ? 'Persistent create-only customization point. Use before/after CRUD hooks for application rules and side effects; never put SQL here.'
                : 'Basic has no persistent ServiceExtension. Prefer Builder/generator configuration; move to Standard/Full when durable business hooks are required.',
            'hookOrder' => $standardOrFull
                ? 'prepareData -> validation -> beforeCreate/beforeUpdate -> Entity -> Model persistence -> afterCreate/afterUpdate'
                : null,
            'queryOwner' => $class . 'Model',
            'relationPolicy' => 'When the related resource is known at generation-time, call the concrete Model/Service explicitly. Never introduce runtime class/table resolvers.',
            'exampleMethod' => $standardOrFull ? 'exampleApplyBusinessRule(array $data): array' : null,
            'exampleUsage' => $standardOrFull ? 'It is generated commented/disabled. Uncomment, rename/adapt it to real fields, then call it explicitly from beforeCreate/beforeUpdate only when needed.' : null,
        ];
    }

    /** @return list<string> */
    private function guidanceFor(string $architecture, string $class): array
    {
        $guidance = [
            'Preserve exact database field names in PHP arrays and objects.',
            'Do not singularize class names derived from table names.',
            'Keep database access in ' . $class . 'Model.',
            'Keep HTTP coordination in ' . $class . 'Controller.',
            'Preserve the generated view hierarchy: Bootstrap breadcrumb, one page-level h1 with the table name, then a small page-context label.',
            'Keep inner form/detail card titles at h2 so generated pages contain only one h1.',
            'For Relational Create, use a Bootstrap input-group for the standard FK select/actions and a Bootstrap Offcanvas with a dedicated parent-field partial that overlays the current view without changing its layout; never embed the full parent create page and never trust a parent foreign key supplied by the browser: use the primary key generated server-side inside the transaction.',
        ];

        if (in_array($architecture, ['standard', 'full'], true)) {
            $guidance[] = 'Use ' . $class . 'Entity for one-record typing, dates, accessors/mutators and record-local behavior. It must not query the database or orchestrate other resources.';
            $guidance[] = $class . 'Entity::fromArray($data) constructs the Entity from already prepared data; it does not validate the payload. Generated validation remains a Service responsibility.';
            $guidance[] = 'Write flow: Service prepareData/validation/hooks -> Entity -> Model persistence. List, export and joined projection queries may continue to return object/array.';
            $guidance[] = 'Put generated business orchestration in ' . $class . 'Service. Put developer custom Service logic in app/Services/Extensions/' . $class . 'ServiceExtension.php; that file is created directly outside app/Generated/, is create-only, and must never be overwritten.';
            $guidance[] = 'Available Service extension hooks are beforeCreate/afterCreate, beforeUpdate/afterUpdate and beforeDelete/afterDelete. Keep SQL/query composition in the Model.';
            $guidance[] = 'The generated ServiceExtension contains a disabled/commented customization example named exampleApplyBusinessRule(). Uncomment, rename/adapt and call it explicitly from a hook only when needed; example helpers must not execute automatically.';
            $guidance[] = 'For cross-resource writes, call the concrete generated Service explicitly (for example new CustomerService()->createRelated(...)); never introduce dynamic service/model/table resolvers.';
        }

        if ($architecture === 'full') {
            $guidance[] = 'Web and REST API must share business logic through ' . $class . 'Service.';
            $guidance[] = 'Use the generated Resource for the external JSON representation.';
        }

        return $guidance;
    }

    /** @return list<string> */
    private function agentRules(): array
    {
        return [
            'Read AI_PROJECT_CONTEXT.md before changing the project.',
            'When modifying myCrudCI4 itself, read CONTRIBUTING.md and docs/development/ARCHITECTURE.md plus ARCHITECTURE_RULES.md before changing generators.',
            'For a new generator feature, follow docs/development/ADDING_A_FEATURE.md and evaluate the feature impact matrix.',
            'When working on a CRUD, also read docs/ai/crud/<table>.md.',
            'Never rename database fields (hotel_id must not become hotelId).',
            'Never singularize table-derived class names (clienti -> ClientiController).',
            'Respect Basic/Standard/Full responsibilities.',
            'Entity boundary: in Standard/Full writes, the Service prepares and validates application data, applies before hooks, then creates the generated Entity before Model persistence. Entity owns one-record casts/dates/accessors/mutators/record-local behavior only; no SQL, transactions or cross-resource orchestration.',
            'Entity factory: Entity::fromArray($data) constructs an Entity from already prepared data; it does not validate the payload. Generated validation remains a Service responsibility.',
            'Do not force Entity hydration for list/export/join projections: optimized query results may remain object/array.',
            'Regeneration lifecycle: during scaffolding, regeneration with --force is expected. After operational application code has been customized, do not use destructive regeneration indiscriminately; inspect differences and preserve project-specific behavior.',
            'Do not move generated runtime dependencies under App\\Libraries\\MyCrud.',
            'Do not introduce React, Vue, HTMX or other frontend frameworks unless explicitly requested.',
            'Do not modify the database automatically.',
            'Treat SQL VIEW objects as read-only developer scaffolding: keep list/filter/sort/export and GET-only API capabilities, hide write-only Builder controls, generate no create/edit/delete/soft-delete or relational writes, and do not infer underlying indexes, foreign keys or VIEW updatability.',
            'Do not infer business meaning from field names when it is not explicitly configured.',
            'Treat app/Generated/ as staging and app/ as the operational application.',
            'Preserve generated CRUD page structure: Bootstrap breadcrumb + one table-name h1 + small page context; inner card headings are h2.',
            'Relational Create uses a Bootstrap input-group for the standard FK select/actions plus a Bootstrap Offcanvas and a dedicated parent-field partial that overlays the current view without changing its layout, never the full parent create view; the generated parent PK is the only authority for the current record FK.',
            'HasMany scaffolding uses dedicated child partials and contextual parent → child → parent navigation: New child passes the real FK plus a schema-whitelisted _parent_field, and a successful child Create returns to the parent detail; it does not generate recursive inline editing.',
            'Cascaded Navigation propagates a navigation-only _trail across parent/child levels, including belongsTo parent links and contextual toolbar flows. Breadcrumb segments prefer descriptive record labels (name/title or composite first_name+last_name when available). The trail is used only for breadcrumbs and return links; it never authorizes writes or determines FK values. Direct FK context remains schema-whitelisted and server-validated.',
            'Service Extension Points: writable Standard/Full CRUDs have app/Services/<Entity>Service.php plus app/Services/Extensions/<Entity>ServiceExtension.php. The extension trait lives directly in app/Services/Extensions/ outside staging, is create-only and must never be overwritten; app/Generated/ may be deleted safely without losing it; use its before/after create/update/delete hooks for custom application logic, while SQL remains in the Model.',
            'Date/Time defaults: writable temporal fields may define a Create-only initial value (none/today/now/time/custom). old(), context and Edit values take precedence; databaseManaged timestamps remain DB-authoritative and never receive form defaults.',
            'Relation panels: hasMany and many-to-many sections in detail views may be Bootstrap-collapse panels with configurable initial open/closed state; keep header, count and actions visible while collapsing only the related table/content.',
            'Code quality: generated Controller, Model and Service classes use uniform PHPDoc to document layer responsibilities, array shapes, exceptions, relational side effects and extension points. Comments should explain non-obvious behavior rather than repeat method names.',
            'Capability-aware generation: generated classes expose only operations supported by the resource. SQL VIEWs are read-only with no form helpers, write validation, write Service methods or ServiceExtension; create-only composite-key resources do not expose update/delete; normal writable CRUDs keep all documented ServiceExtension hooks.',
            'Capability/PHPDoc consistency: create-only Controllers import PageNotFoundException when FK context helpers can throw 404; Read + Create resources are documented as such; ServiceExtension/write contract is prepareData -> validation -> beforeCreate/beforeUpdate -> Entity -> Model persistence -> afterCreate/afterUpdate.',
            'Service extensions: app/Services/Extensions/<Entity>ServiceExtension.php is persistent custom code outside app/Generated; its hooks are documented and should orchestrate application logic while SQL remains in the Model.',
            'Frozen architecture boundary: concrete generated Models extend BaseCrudModel, but relation targets remain explicit/static in concrete Models and Services. BaseCrudModel owns only reusable current-table infrastructure; never add runtime relation resolvers.',
            'Customization workflow: do not patch app/Generated/. For Standard/Full business customization use the persistent ServiceExtension hooks. Keep queries in Models; use explicit concrete Services for cross-resource writes. The generated exampleApplyBusinessRule() remains commented/disabled until the developer explicitly adapts and enables it.',
            'REST boundary: API Controller owns HTTP input/filter/sort policy, READ uses Model, WRITE uses Service, Resource is output-only. PATCH and upload write paths remain explicit Service methods.',
            'Shield boundary: Web CRUD security and REST API security are independent. Web CRUD uses generated session/permission route filters from crudSecurity; REST uses generated token/permission filters from apiSecurity. Do not introduce a runtime security resolver.',
            'Builder UI boundary: Parent database tables is sticky navigation on desktop and follows the page scroll. Do not reintroduce a nested internal vertical scroller for this panel.',
            'MCP boundary: MCP Tool owns filter/sort input policy, Model owns reads, MCP Resource is output-only.',
            'Dashboard boundary: aggregate/statistical reads use DashboardQuery; Recent widgets reuse concrete generated Models wired at generation-time; Entity/object results are normalized through Dashboard DTOs before the View boundary. Never use runtime new $modelClass() when the Dashboard generator already knows the Model.',
            'Prefer existing project conventions over generic framework rewrites.',
        ];
    }

    /** @param array<string,mixed> $snapshot */
    private function accessMode(array $crud): string
    {
        if (empty($crud['readOnly'])) {
            return 'read/write';
        }
        if (!empty($crud['createAllowed'])) {
            return 'create-only (record actions protected)';
        }
        return 'read-only';
    }

    private function projectMarkdown(array $snapshot): string
    {
        $crud = (array) ($snapshot['crud'] ?? []);
        $db = (array) ($snapshot['database'] ?? []);

        $lines = [
            '# AI Project Context',
            '',
            '> This file is generated by myCrudCI4. Read it before modifying the application.',
            '',
            '## Project identity',
            '',
            '- Framework: CodeIgniter 4',
            '- Generator: myCrudCI4 ' . MyCrudVersion::VERSION,
            '- Configured CRUDs: ' . count($crud),
            '- Database tables visible to myCrudCI4: ' . count((array) ($db['tables'] ?? [])),
            '',
            '## Core architecture rules',
            '',
            '- **Basic:** `Controller -> Model -> Database`',
            '- **Standard:** `Controller -> Service -> Model -> Database`',
            '- **Full web:** `Controller -> Service -> Model -> Database`',
            '- **Full API READ:** `API Controller -> Model -> Resource -> JSON`',
            '- **Full API WRITE:** `API Controller -> Service -> Model`',
            '- **MCP READ:** `MCP Tool -> Model -> MCP Resource`',
            '- **Dashboard aggregate:** `DashboardController -> DashboardService -> DashboardQuery -> DB`',
            '- **Dashboard recent records:** `DashboardController -> DashboardService -> concrete Model -> Entity/object -> Dashboard DTO -> View`',
            '- **Standard/Full WRITE record boundary:** `Controller -> Service (prepare/validate/hooks) -> Entity -> Model -> Database`',
            '',
            '## Non-negotiable project conventions',
            '',
            '- Preserve database field names exactly. `hotel_id` stays `hotel_id`; do not convert it to `hotelId`.',
            '- Do not singularize class names derived from tables. `clienti` maps to `ClientiController`, `ClientiModel`, etc.',
            '- Operational runtime helpers belong to `App\\Libraries\\Crud`, not `App\\Libraries\\MyCrud`.',
            '- CRUD routes are modular under `app/Routes/<table>.php`.',
            '- Application layout: `app/Views/layouts/default_app.php`.',
            '- Frontend baseline: Bootstrap 5, Bootstrap Icons and vanilla JavaScript.',
            '- Every generated main CRUD view starts with a Bootstrap breadcrumb and has exactly one page-level `h1` containing the table name.',
            '- A `<small class="text-muted">` under the page `h1` identifies the context: List, New record, Edit record, Record details, or Trash.',
            '- Inner form/detail card headings use `h2`; do not introduce a second page-level `h1`.',
            '- Relational Create can select an existing belongsTo parent from a standard FK input-group or create a new one inside a Bootstrap Offcanvas rendered from a dedicated parent-field partial that overlays the current view; the full parent create page is never embedded. Parent and current record are written in the same transaction and the generated parent PK is imposed server-side as the FK.',
            '- Do not introduce another frontend framework unless explicitly requested.',
            '- `app/MyCrudConfig/` stores developer decisions; the live database remains authoritative for physical schema.',
            '- `app/Generated/` is staging. Do not assume staged files are the operational application.',
            '- `Entity::fromArray($data)` constructs an Entity from already prepared data; it does not validate the payload. Generated validation remains a Service responsibility.',
            '- During scaffolding, regeneration with `--force` is expected. After operational application code has been customized, do not use destructive regeneration indiscriminately: inspect differences and preserve project-specific behavior.',
            '',
            '## Generated CRUD view structure',
            '',
            '```text',
            'Breadcrumb',
            'Table-name h1',
            'small page context',
            'Toolbar',
            'Page content / card (h2 for internal title)',
            '```',
            '',
            'The structure above is a project convention and must be preserved when an AI modifies generated or operational CRUD views.',
            '',
            '## Safe customization workflow',
            '',
            '1. Configure behavior in Builder/myCrud config when the change belongs to generated scaffolding.',
            '2. Never treat `app/Generated/` as a place for persistent manual edits.',
            '3. During scaffolding, regeneration with `--force` is expected. After operational application code has been customized, inspect differences before destructive regeneration and preserve project-specific behavior.',
            '4. In Standard/Full, use the Entity for one-record casts, dates, accessors/mutators and record-local behavior; never put SQL, transactions or cross-resource orchestration in it.',
            '5. `Entity::fromArray($data)` constructs the Entity from already prepared data; it does not validate the payload. Generated validation remains a Service responsibility.',
            '6. In Standard/Full, put persistent business rules and side effects in `app/Services/Extensions/<Entity>ServiceExtension.php`.',
            '7. Call custom helper methods explicitly from `beforeCreate`, `afterCreate`, `beforeUpdate`, `afterUpdate`, `beforeDelete` or `afterDelete`.',
            '8. Keep SQL/query composition in the concrete Model. For cross-resource writes call a concrete generated Service explicitly; do not resolve Model/Service/table names dynamically.',
            '9. The generated ServiceExtension contains a commented/disabled `exampleApplyBusinessRule()` example; uncomment, rename/adapt it to real fields before calling it.',
            '',
            'Example:',
            '',
            '```php',
            'protected function beforeCreate(array $data): array',
            '{',
            '    return $this->exampleApplyBusinessRule($data);',
            '}',
            '```',
            '',
            '## Important paths',
            '',
            '- Operational application: `app/`',
            '- Generated staging: `app/Generated/`',
            '- Persistent CRUD configs: `app/MyCrudConfig/`',
            '- Persistent menu config: `app/MyCrudConfig/Project/Menu.php`',
            '- Runtime CRUD libraries: `app/Libraries/Crud/`',
            '- Modular routes: `app/Routes/`',
            '- Detailed AI project map: `docs/ai/project.json`',
            '- CRUD-specific AI notes: `docs/ai/crud/<table>.md`',
            '- Generator contribution guide: `CONTRIBUTING.md`',
            '- Generator architecture: `docs/development/ARCHITECTURE.md`',
            '- Architecture invariants: `docs/development/ARCHITECTURE_RULES.md`',
            '- New-feature workflow: `docs/development/ADDING_A_FEATURE.md`',
            '- Feature impact matrix: `docs/development/FEATURE_MATRIX.md`',
            '',
            '## CRUD map',
            '',
            '| Table | Architecture | DB | Type | Primary key(s) | Mode | Main controller |',
            '| --- | --- | --- | --- | --- | --- | --- |',
        ];

        foreach ($crud as $table => $item) {
            $item = (array) $item;
            $components = (array) ($item['components'] ?? []);
            $lines[] = sprintf(
                '| `%s` | %s | %s | `%s` | `%s` | %s | `%s` |',
                $this->md((string) $table),
                ucfirst((string) ($item['architecture'] ?? 'basic')),
                ($item['dbStatus'] ?? 'present') === 'present' ? 'present' : 'missing',
                $this->md((string) ($item['tableType'] ?? 'UNKNOWN')),
                $this->md(implode(', ', array_map('strval', (array) ($item['primaryKeys'] ?? [])))),
                $this->accessMode($item),
                $this->md((string) ($components['controller'] ?? ''))
            );
        }

        $lines = array_merge($lines, [
            '',
            '## How an AI agent should work',
            '',
            '1. Read this file.',
            '2. If modifying myCrudCI4 itself, read `CONTRIBUTING.md` and `docs/development/ARCHITECTURE_RULES.md` before generator code.',
            '3. Identify the CRUD involved.',
            '4. Read `docs/ai/crud/<table>.md` for that CRUD.',
            '5. Inspect the existing operational files before proposing changes.',
            '6. Respect the architecture level and naming conventions.',
            '7. Do not replace developer decisions with naming heuristics.',
            '8. Do not modify the database unless explicitly asked.',
            '',
            '## Safety note',
            '',
            'This context intentionally contains schema and architecture metadata only. It does not export application rows, database credentials, `.env` values, passwords or secrets.',
            '',
        ]);

        return implode(PHP_EOL, $lines);
    }

    /** @param array<string,mixed> $crud */
    private function crudMarkdown(array $crud): string
    {
        $table = (string) ($crud['table'] ?? '');
        $architecture = ucfirst((string) ($crud['architecture'] ?? 'basic'));
        $components = (array) ($crud['components'] ?? []);
        $relations = (array) ($crud['relations'] ?? []);
        $lines = [
            '# CRUD: ' . $table,
            '',
            '- Architecture: **' . $architecture . '**',
            '- Database status: **' . (string) ($crud['dbStatus'] ?? 'unknown') . '**',
            '- Primary key(s): `' . $this->md(implode(', ', array_map('strval', (array) ($crud['primaryKeys'] ?? [])))) . '`',
            '- DB object type: **' . $this->md((string) ($crud['tableType'] ?? 'UNKNOWN')) . '**',
            '- Access mode: **' . $this->accessMode($crud) . '**',
            '- Read-only reason: `' . $this->md((string) ($crud['readOnlyReason'] ?? '')) . '`',
            '',
            '## Components',
            '',
        ];

        foreach ($components as $name => $path) {
            $lines[] = '- **' . $this->md((string) $name) . ':** `' . $this->md((string) $path) . '`';
        }

        if (!empty($crud['warning'])) {
            $lines = array_merge($lines, ['', '## Warning', '', (string) $crud['warning']]);
        }

        $lines = array_merge($lines, [
            '',
            '## View structure',
            '',
            '- Main views use Bootstrap breadcrumb navigation.',
            '- The page-level `h1` contains the table name: `' . $this->md($table) . '`.',
            '- A muted small label identifies the current context (List / New record / Edit record / Record details / Trash).',
            '- Internal form/detail card titles use `h2`, not another `h1`.',
        ]);

        $fields = (array) ($crud['fields'] ?? []);
        if ($fields !== []) {
            $lines = array_merge($lines, [
                '',
                '## Database fields',
                '',
                '| Field | Type | PK | Nullable | Input | Search | Sort | FK |',
                '| --- | --- | --- | --- | --- | --- | --- | --- |',
            ]);

            foreach ($fields as $field) {
                if (!is_array($field)) {
                    $lines[] = '| `' . $this->md((string) $field) . '` |  |  |  |  |  |  |  |';
                    continue;
                }
                $fk = (array) ($field['foreignKey'] ?? []);
                $fkText = $fk === [] ? '' : ((string) ($fk['parentTable'] ?? '') . '.' . (string) ($fk['parentKey'] ?? ''));
                $lines[] = sprintf(
                    '| `%s` | `%s` | %s | %s | `%s` | %s | %s | `%s` |',
                    $this->md((string) ($field['name'] ?? '')),
                    $this->md((string) ($field['type'] ?? '')),
                    !empty($field['primary']) ? 'yes' : '',
                    !empty($field['nullable']) ? 'yes' : 'no',
                    $this->md((string) ($field['inputType'] ?? '')),
                    !empty($field['searchable']) ? 'yes' : '',
                    !empty($field['sortable']) ? 'yes' : '',
                    $this->md($fkText)
                );
            }
        }

        $belongsTo = (array) ($relations['belongsTo'] ?? []);
        if ($belongsTo !== []) {
            $lines = array_merge($lines, ['', '## BelongsTo / foreign keys', '']);
            foreach ($belongsTo as $relation) {
                $relation = (array) $relation;
                $line = '- `' . $this->md((string) ($relation['field'] ?? '')) . '` -> `'
                    . $this->md((string) ($relation['parentTable'] ?? '')) . '.'
                    . $this->md((string) ($relation['parentKey'] ?? '')) . '`';
                $display = trim((string) ($relation['displayTemplate'] ?? '')) !== ''
                    ? (string) $relation['displayTemplate']
                    : (string) ($relation['displayField'] ?? '');
                if ($display !== '') {
                    $line .= ' (display: `' . $this->md($display) . '`)';
                }
                $relatedCreate = (array) ($relation['relatedCreate'] ?? []);
                if (!empty($relatedCreate['enabled'])) {
                    $line .= ' — **Relational Create enabled**: select existing from the FK input-group or create parent in a Bootstrap Offcanvas using a dedicated parent-field partial (not the full parent create page); generated parent PK is assigned server-side as FK in the same transaction.';
                }
                $lines[] = $line;
            }
        }

        $hasMany = (array) ($relations['hasMany'] ?? []);
        if ($hasMany !== []) {
            $lines = array_merge($lines, ['', '## HasMany', '']);
            foreach ($hasMany as $relation) {
                $relation = (array) $relation;
                $lines[] = '- `' . $this->md((string) ($relation['childTable'] ?? $relation['key'] ?? ''))
                    . '` via `' . $this->md((string) ($relation['foreignKey'] ?? '')) . '`';
            }
        }

        $features = array_keys(array_filter(
            (array) ($crud['features'] ?? []),
            static fn (mixed $value): bool => $value === true
        ));
        if ($features !== []) {
            $lines = array_merge($lines, ['', '## Enabled features', '', implode(', ', array_map(static fn (string $f): string => '`' . $f . '`', $features))]);
        }

        $customization = (array) ($crud['customization'] ?? []);
        if ($customization !== []) {
            $lines = array_merge($lines, ['', '## Safe customization', '']);
            $lines[] = '- Generated staging policy: ' . (string) ($customization['generatedCodePolicy'] ?? '');
            $lines[] = '- Operational code policy: ' . (string) ($customization['operationalCodePolicy'] ?? '');
            $lines[] = '- Regeneration policy: ' . (string) ($customization['regenerationPolicy'] ?? '');
            if (!empty($customization['entityFactoryPolicy'])) {
                $lines[] = '- Entity factory: ' . (string) $customization['entityFactoryPolicy'];
            }
            $lines[] = '- Query owner: `' . $this->md((string) ($customization['queryOwner'] ?? '')) . '`.';
            $lines[] = '- Relation rule: ' . (string) ($customization['relationPolicy'] ?? '');
            if (!empty($customization['serviceExtensionAvailable'])) {
                $lines[] = '- Persistent Service extension: `' . $this->md((string) ($customization['serviceExtension'] ?? '')) . '`.';
                $lines[] = '- Hook contract: `' . $this->md((string) ($customization['hookOrder'] ?? '')) . '`.';
                $lines[] = '- Example helper: `' . $this->md((string) ($customization['exampleMethod'] ?? '')) . '` — ' . (string) ($customization['exampleUsage'] ?? '');
                $lines = array_merge($lines, [
                    '',
                    '```php',
                    'protected function beforeCreate(array $data): array',
                    '{',
                    '    return $this->exampleApplyBusinessRule($data);',
                    '}',
                    '```',
                ]);
            } else {
                $lines[] = '- ' . (string) ($customization['serviceExtensionPolicy'] ?? '');
            }
        }

        $lines = array_merge($lines, ['', '## Development guidance', '']);
        foreach ((array) ($crud['developmentGuidance'] ?? []) as $rule) {
            $lines[] = '- ' . (string) $rule;
        }
        $lines[] = '';

        return implode(PHP_EOL, $lines);
    }

    private function assertTable(string $table): string
    {
        $table = trim($table);
        if ($table === '' || preg_match('/^[a-zA-Z_][a-zA-Z0-9_]*$/', $table) !== 1) {
            throw new RuntimeException('Invalid table name: ' . $table);
        }

        if (!$this->repository->exists($table) && !in_array($table, TableFilter::validTables($this->db), true)) {
            throw new RuntimeException('Table/configuration not found: ' . $table);
        }

        return $table;
    }

    private function atomicWrite(string $path, string $content): void
    {
        $this->ensureDirectory(dirname($path));
        $tmp = $path . '.tmp-' . bin2hex(random_bytes(4));
        if (file_put_contents($tmp, $content, LOCK_EX) === false) {
            throw new RuntimeException('Impossibile scrivere il file temporaneo: ' . $tmp);
        }
        if (!rename($tmp, $path)) {
            @unlink($tmp);
            throw new RuntimeException('Impossibile pubblicare il file: ' . $path);
        }
    }

    private function ensureDirectory(string $directory): void
    {
        if (!is_dir($directory) && !mkdir($directory, 0755, true) && !is_dir($directory)) {
            throw new RuntimeException('Impossibile creare la directory: ' . $directory);
        }
    }

    private function relativePath(string $path): string
    {
        $root = rtrim(str_replace('\\', '/', ROOTPATH), '/');
        $normalized = str_replace('\\', '/', $path);

        return str_starts_with($normalized, $root . '/')
            ? substr($normalized, strlen($root) + 1)
            : $normalized;
    }

    private function md(string $value): string
    {
        return str_replace('|', '\\|', $value);
    }
}
