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
 * Genera una mappa del progetto pensata per agenti IA.
 *
 * Il contesto viene derivato esclusivamente da schema DB, configurazioni
 * persistenti e convenzioni myCrudGpt. Non vengono esportati dati applicativi,
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
     * Genera il contesto globale e un file Markdown per ogni CRUD configurato.
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
                // Una configurazione orfana resta utile alla mappa: l'agente deve
                // sapere che esiste ma che lo schema DB corrente non la risolve.
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
            'generatedBy' => 'myCrudGpt',
            'generatorVersion' => MyCrudVersion::VERSION,
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
                    'pageContext' => 'A small text under h1 identifies Elenco, Nuovo record, Modifica record, Dettaglio record or Cestino.',
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
                'fullApi' => 'API Controller -> Service -> Model -> Resource -> JSON',
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
                        'relationActions' => 'standard FK select uses one Bootstrap input-group; parent open = bi-box-arrow-up-right, relational create = bi-plus-circle + Nuovo',
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
                'columns' => array_values((array) ($relation['columns'] ?? [])),
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
            ],
            'developmentGuidance' => $this->guidanceFor($architecture, $class),
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
            'relations' => ['belongsTo' => [], 'hasMany' => []],
            'warning' => 'Configurazione presente ma tabella non risolvibile nel DB corrente: ' . $reason,
            'developmentGuidance' => $this->guidanceFor($architecture, $class),
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
            $guidance[] = 'Put business logic in ' . $class . 'Service when it is not simple HTTP coordination.';
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
            'When working on a CRUD, also read docs/ai/crud/<table>.md.',
            'Never rename database fields (hotel_id must not become hotelId).',
            'Never singularize table-derived class names (clienti -> ClientiController).',
            'Respect Basic/Standard/Full responsibilities.',
            'Do not move generated runtime dependencies under App\\Libraries\\MyCrud.',
            'Do not introduce React, Vue, HTMX or other frontend frameworks unless explicitly requested.',
            'Do not modify the database automatically.',
            'Do not infer business meaning from field names when it is not explicitly configured.',
            'Treat app/Generated/ as staging and app/ as the operational application.',
            'Preserve generated CRUD page structure: Bootstrap breadcrumb + one table-name h1 + small page context; inner card headings are h2.',
            'Relational Create uses a Bootstrap input-group for the standard FK select/actions plus a Bootstrap Offcanvas and a dedicated parent-field partial that overlays the current view without changing its layout, never the full parent create view; the generated parent PK is the only authority for the current record FK.',
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
            '> This file is generated by myCrudGpt. Read it before modifying the application.',
            '',
            '## Project identity',
            '',
            '- Framework: CodeIgniter 4',
            '- Generator: myCrudGpt ' . MyCrudVersion::VERSION,
            '- Configured CRUDs: ' . count($crud),
            '- Database tables visible to myCrudGpt: ' . count((array) ($db['tables'] ?? [])),
            '',
            '## Core architecture rules',
            '',
            '- **Basic:** `Controller -> Model -> Database`',
            '- **Standard:** `Controller -> Service -> Model -> Database`',
            '- **Full web:** `Controller -> Service -> Model -> Database`',
            '- **Full API:** `API Controller -> Service -> Model -> Resource -> JSON`',
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
            '- A `<small class="text-muted">` under the page `h1` identifies the context: Elenco, Nuovo record, Modifica record, Dettaglio record or Cestino.',
            '- Inner form/detail card headings use `h2`; do not introduce a second page-level `h1`.',
            '- Relational Create can select an existing belongsTo parent from a standard FK input-group or create a new one inside a Bootstrap Offcanvas rendered from a dedicated parent-field partial that overlays the current view; the full parent create page is never embedded. Parent and current record are written in the same transaction and the generated parent PK is imposed server-side as the FK.',
            '- Do not introduce another frontend framework unless explicitly requested.',
            '- `app/MyCrudConfig/` stores developer decisions; the live database remains authoritative for physical schema.',
            '- `app/Generated/` is staging. Do not assume staged files are the operational application.',
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
            '2. Identify the CRUD involved.',
            '3. Read `docs/ai/crud/<table>.md` for that CRUD.',
            '4. Inspect the existing operational files before proposing changes.',
            '5. Respect the architecture level and naming conventions.',
            '6. Do not replace developer decisions with naming heuristics.',
            '7. Do not modify the database unless explicitly asked.',
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
            '- A muted small label identifies the current context (Elenco / Nuovo record / Modifica record / Dettaglio record / Cestino).',
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
            throw new RuntimeException('Nome tabella non valido: ' . $table);
        }

        if (!$this->repository->exists($table) && !in_array($table, TableFilter::validTables($this->db), true)) {
            throw new RuntimeException('Tabella/configurazione non trovata: ' . $table);
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
