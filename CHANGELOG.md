## 2.9.1-RC1 — Release Candidate 1

- Freezes the 2.9.1 feature set after the full RC readiness matrix passed for `film`, `customer`, `staff`, `store`, and `rental`.
- Promotes the validated architecture baseline: explicit generation-time relation methods, Model-owned reads, Service-owned writes/transactions where enabled, and capability-aware generated contracts.
- Includes Dashboard, Shield CRUD/API separation, MCP read-only scaffolding, OpenAPI capability handling, CLI documentation coverage, and Builder/architecture regression guards.
- Includes the stabilized relation UI: persistent M2M form widths, inline Search/New actions, and one global `relationOffcanvasWidth = 640` for Related Create offcanvas panels.
- RC1 is a stabilization release: no new feature work is intended before final 2.9.1; only release-blocking regressions should change this baseline.

## 2.9.1-dev24-fix11-fix49 — Global Related Create offcanvas width

- Adds `Config\MyCrud::$relationOffcanvasWidth = 640` as one project-wide width for Related Create offcanvas panels.
- Applies the same width to belongsTo and many-to-many Related Create panels.
- Keeps Builder `formWidth`, Bootstrap grid widths, relation persistence, and runtime relation behavior unchanged.
- Uses `min(640px, 100vw)` semantics so the panel stays viewport-safe on small screens.
- Adds a regression guard to keep both offcanvas variants wired to the global project config.

## 2.9.1-dev24-fix11-fix48 — RC false-positive cleanup

- OpenAPI generated contract tests now accept an empty `paths` section when every API capability is disabled, while still checking the OpenAPI document and components.
- Generated PHP formatting regression now tests formatter behavior instead of fragile source-string escaping.
- No runtime, API generator, Model, Service, Shield, MCP, Dashboard, or Builder behavior changed.

## 2.9.1-dev24-fix11-fix47 — M2M form width persistence

- Persists `relationsConfig.manyToMany[*].formWidth` in `app/MyCrudConfig/<table>.php`.
- Normalizes the persisted width against `Config\MyCrud::$bootstrapFieldWidths` and uses the project M2M panel width only as fallback.
- Preserves the Builder-selected M2M width through save → reload → regenerate → generated View.
- Adds a regression guard for the complete M2M width persistence boundary.

## 2.9.1-dev24-fix11-fix46 — Many-to-many inline actions and Builder width

- M2M Search and New-related actions now share one Bootstrap input group.
- M2M form panel width is configurable per relation in Builder and persisted as `formWidth`.
- Project `relationPanelWidths['manyToMany']` remains the default for new/unconfigured relations.
- No runtime architecture changes.

## 2.9.1-dev24-fix11-fix45 — Generated code readability and configurable UI widths

- normalizes generated PHP whitespace for clear, compact source without changing executable structure;
- adds stable HTML section comments to generated Create/Form/Detail Views for developer navigation;
- moves Builder **Width Bootstrap** choices to `Config\\MyCrud::$bootstrapFieldWidths` and adds `defaultBootstrapFieldWidth`;
- adds project-wide generated relation width defaults in `Config\\MyCrud::$relationPanelWidths`;
- defaults N:N relation panels to full width (`12`) while keeping related-create field grids configurable;
- keeps the selected field width in each persistent CRUD configuration; global config defines allowed choices/defaults only;
- adds `GeneratedUiConfigurabilityTest` to the RC architecture/Builder gate.

## 2.9.1-dev24-fix11-fix44 — MCP publish lifecycle synchronization

- treats generated `Mcp/` artifacts as generator-owned publish outputs, like generated PHPUnit contracts;
- SAFE `mycrud:publish` now refreshes changed MCP manifests, tools, relation tools, and resources without requiring `--force`;
- removes stale table-owned MCP artifacts when the current generation no longer expects them, preventing disabled `read`/`relations` capabilities from remaining discoverable at runtime;
- adds `REMOVED` / `WOULD REMOVE` publish reporting and applies the same behavior through `mycrud:publish-all`;
- adds `PublishManagedArtifactsTest` to the RC architecture/Builder gate;
- no changes to CRUD Model/Service, REST, Shield, Dashboard, or Builder runtime behavior.

## 2.9.1-dev24-fix11-fix43 — M2M Related Create contract final alignment

- Removes the last legacy positive expectation for `manyToManyRelatedCreateRelationOptions()` from generated relational contract tests.
- M2M Related Create tests now enforce the current static generation-time architecture: `manyToManyFormOptions()`, `manyToManySelected()`, `relationRowsByIds()`, generated rules, and concrete related Service references when Service architecture is enabled.
- Explicitly rejects the legacy generic M2M Related Create relation-options adapter instead of requiring it.
- Fixes indentation in the generated Service contract block.
- Adds a regression guard so the legacy positive expectation cannot return.

## 2.9.1-dev24-fix11-fix42 — Generated API Resource contract escaping fix

- fixes PHP syntax generated by `ApiResourceContractTest::testResourceIsOutputOnly()` when checking `App\\Models` / `App\\Services`;
- removes the unsafe trailing namespace separator from the generated single-quoted test literals;
- adds a regression guard for the safe namespace fragments used by generated output-only Resource contracts;
- no runtime, Model, Service, API Resource, Shield, Dashboard, or Builder behavior changes.

## 2.9.1-dev24-fix11-fix41 — Generated contract architecture alignment

- aligns generated API Resource tests with the output-only boundary without fragile regexes;
- aligns Related Create tests with explicit generated relation methods instead of the removed generic `relatedCreateRelationOptions` requirement;
- aligns M2M tests with explicit generation-time methods (`manyToManyFormOptions`, `manyToManySelected`, relation-specific sync methods) and rejects legacy generic dispatchers;
- preserves Model-read / Service-write transaction ownership;
- adds a regression guard for TestScaffoldGenerator architecture drift.

## 2.9.1-dev24-fix11-fix40 — RC contract gate alignment

- fixes `ApiResourceContractTest` output-only regex generation with a namespace-safe pattern;
- aligns MCP read-only contracts with the current Model-owned read architecture;
- aligns transaction ownership checks: Service owns transactional orchestration when the Service layer is enabled, Model only in Basic/no-Service flows;
- updates unique nested-FK contract to protect static generation-time filtering instead of obsolete runtime metadata markers;
- fixes `CliDocumentationCoverageTest` `$name` interpolation;
- makes the Shield route contract independent from PHP quote style for `permission:` filters.

## 2.9.1-dev24-fix11-fix38

- Fixed generated Web Shield contract test heredoc escaping and SessionAuth contract.
- Fixed Shield and CLI RC-gate test false negatives.
- Improved release-check defect summaries.

## 2.9.1-dev24-fix11-fix36

## 2.9.1-dev24-fix11-fix38

- Added `mycrud:release-check <table> [table ...]` as the RC-readiness gate.
- Composes existing CRUD/relations, generated-test, API/OpenAPI, query-layer, Dashboard, Shield, CLI-doc and architecture/Builder checks.
- Supports a multi-table release matrix and returns non-zero on any failed gate.
- Spark command inventory is now 19 commands.


- Audited all Spark commands registered in `app/Commands/`.
- `docs/CLI.md` is now the canonical complete inventory of all 18 `mycrud:*` commands.
- Added missing `mycrud:test-dashboard` to the CLI reference.
- Usage examples now mirror each command class `$usage` declaration.
- README points to the canonical CLI inventory instead of implying its abbreviated examples are complete.
- Added regression coverage to keep command registration and CLI documentation synchronized.

## 2.9.1-dev24-fix11-fix35

- consolidates current project documentation around the frozen dev24 architecture, Dashboard 2.0 object boundary, Builder intent-first workflow, and independent Shield Web/API security;
- changes **Parent database tables** to sticky-only navigation: the card follows page scrolling and no longer has an internal max-height/overflow scroller;
- replaces the obsolete scroll-specific Builder regression with `BuilderParentTablesStickyUxTest`;
- updates README, workflow, configuration, testing, API/Shield, roadmap, feature matrix, in-app docs, contributor guidance, and AI project context;
- no CRUD, Dashboard DTO, Model/Service, REST, MCP, or persistence contract changes.

## 2.9.1-dev24-fix11-fix33

- restores independent CodeIgniter Shield settings for **Web CRUD** and **REST API**;
- adds persistent `crudSecurity` configuration with Shield session authentication and per-action permissions;
- keeps existing `apiSecurity` Bearer token authentication and API permissions unchanged;
- generated web route groups use Shield `session` authentication when enabled;
- configured CRUD permissions generate explicit `permission:<name>` filters on the corresponding routes;
- adds generated WebSecurity contract tests and source-level regression guards;
- no Dashboard 2.0 boundary changes.

## 2.9.1-dev24-fix11-fix32

- restores the existing CodeIgniter Shield integration as a dedicated, visible **Security / Shield** Builder panel;
- keeps `apiSecurity[auth]` and per-capability Shield permissions unchanged;
- removes Shield controls from the collapsed API Capabilities details so the feature is discoverable again;
- adds a Shield status badge (`On`, `Ready`, `Missing`) to the Builder navigation;
- no changes to generated Shield route/OpenAPI/test contracts or runtime security behavior.

## 2.9.1-dev24-fix11-fix31

- Makes the **Parent database tables** list independently scrollable in the main Builder.
- Keeps the panel header visible while navigating long table lists.
- Uses a compact desktop max-height and a more generous mobile limit.
- Leaves Builder configuration, generation, Dashboard 2.0, and runtime contracts unchanged.
- Adds `BuilderParentTablesScrollUxTest`.

## 2.9.1-dev24-fix11-fix30

### Builder configuration status UX

- Adds compact live status badges to the Builder sidebar for Architecture, Relations, Form Sections, Fields, API, and MCP.
- Mirrors the active architecture and configured section count in the corresponding section headers.
- Statuses update immediately while editing without changing persisted configuration or generated runtime code.
- Keeps the intent-first workflow and staging-only generation boundary introduced in fix28.
- Adds `BuilderConfigurationStatusUxTest`.

## 2.9.1-dev24-fix11-fix29

### Dashboard equal-height row cards

- Dashboard widget rows now use Bootstrap stretch alignment.
- Each generated widget column is a flex container and each widget card fills the row height with `h-100 w-100`.
- Equal height is resolved per responsive wrapped row; no fixed global widget height is introduced.
- KPI, chart, recent-record, and quick-link widgets share the same row-height contract.
- Dashboard DTO/Service/Model boundaries remain unchanged.

## 2.9.1-dev24-fix11-fix28

- General Builder UX consolidation only; generated runtime architecture is unchanged.
- Adds an intent-first recommended workflow for Architecture → Relations/Form layout → Fields → Generation.
- Separates Core workflow navigation from Advanced API/MCP configuration.
- API and MCP technical settings are collapsed by default to reduce visual noise while preserving all submitted values.
- Field configuration guidance is collapsed by default.
- Generation action now explicitly says `Generate to staging` and reminds that output is limited to `app/Generated/`.
- Moves the overwrite switch into an Advanced generation control and labels it `Overwrite staging files`.
- Adds `BuilderIntentFirstUxTest` to protect the Builder UX contract.

## 2.9.1-dev24-fix11-fix27

### Dashboard Recent DTO guard false-positive fix

- Fixes `mycrud:test-dashboard` falsely failing whenever a generated Model Entity is normalized with `toArray()` before `RecentRecord::collection()`.
- The guard now protects the actual runtime contract: source Entities may be normalized before DTO construction, while `RecentRecord` instances must remain typed objects through `DashboardWidget` and the View.
- Keeps the runtime smoke test as the authoritative typed-record verification.
- No Dashboard runtime, query, DTO, Controller, View, or Model-wiring behavior changed.

## 2.9.1-dev24-fix11-fix26

### Dashboard 2.0 baseline freeze + architecture guard

- Freezes the validated Dashboard 2.0 runtime contract: Builder/configuration arrays stop at generation/composition boundaries; Dashboard runtime data remains typed DTO objects through Controller and View.
- Adds a dedicated `DashboardBaselineGuardTest` to prevent reintroduction of dynamic Model resolution, DTO-to-array conversion at the View boundary, or object access against Builder configuration arrays.
- Extends `mycrud:test-dashboard` with a static Model wiring guard for generated recent-record widgets.
- Adds a Dashboard 2.0 baseline document with ownership rules, extension rules, smoke-test workflow, and the verified Sakila acceptance profile.
- No new Dashboard feature and no change to existing DTO/Service/Model ownership.

## 2.9.1-dev24-fix11-fix25

- Dashboard Builder now uses configured/human field labels in value, group, filter and global-period selectors.
- Empty widget titles now resolve to semantic generated titles (for example `Total Rental Duration` and `Film Count by Release Year`).
- Grouped-chart Builder guidance warns about primary-key grouping, relation/high-cardinality grouping, exact-date grouping, and local filters that collapse the grouped dimension.
- Dashboard 2.0 DTO/object boundaries and static Model wiring are unchanged.

## 2.9.1-dev24-fix11-fix24

- Dashboard Recent records are relation-aware at generation-time: selected belongsTo fields use explicit generated Model option methods and human labels.
- Added per-widget FK label cache to avoid duplicate relation lookups.
- Dashboard Builder now warns when a Recent widget is too narrow for its selected columns and recommends width 6/8/12 without forcing it.
- Dashboard DTO/object boundaries remain unchanged.

## 2.9.1-dev24-fix11-fix23

- Dashboard presentation-only polish; no change to Entity/DTO/Service/Controller architecture boundaries.
- Recent-record tables now keep headers readable, horizontally scroll when needed, and truncate long cell content with the full value available in the native title tooltip.
- Aggregate KPI subtitles now use configured field labels instead of raw database identifiers when available.
- Added a presentation regression guard for recent-table UX and aggregate labels.

## 2.9.1-dev24-fix11-fix22

- Added `php spark mycrud:test-dashboard`.
- Added staging contract checks for Dashboard array/config vs DTO/object boundaries.
- Added published runtime smoke test for `DashboardData`, `DashboardWidget`, `Kpi`, `SeriesPoint`, and `RecentRecord`.
- `mycrud:test-all <table>` now includes Dashboard regression checks when a generated Dashboard is present.

## 2.9.1-dev24-fix11-fix21

- Completed the Dashboard configuration/runtime boundary: Builder widget definitions remain arrays inside generated `DashboardService::build()`, while `DashboardWidget` DTO objects are created only for the presentation runtime.
- Removed residual `->get()` and `->type` accesses from configuration-array code paths in `DashboardGenerator`.
- Fixed a duplicated `$dateRange = [` line in the generated `DashboardController`.
- Strengthened Dashboard boundary regression tests.

## 2.9.1-dev24-fix11-fix20

- Fixed DashboardGenerator generation-time widget handling: Builder/dashboard configuration widgets remain arrays and are accessed with array syntax.
- Preserved the runtime object-first contract: DashboardData, DashboardWidget and RecentRecord remain DTO objects through Controller and View.
- Prevents `Call to a member function get() on array` while resolving Dashboard Builder configuration.
- Added a regression guard for the config-array / DTO-object boundary.

## 2.9.1-dev24-fix11-fix19

- Completed the Dashboard 2.0 object-first View boundary.
- `DashboardController` now passes `DashboardData` directly to the View and reads the title through the DTO object.
- Generated Dashboard Views consume `DashboardData` and `DashboardWidget` objects instead of flattening them to arrays.
- Recent widgets keep `RecentRecord` DTO objects until rendering; `RecentRecord::value()` provides explicit field access.
- Configuration payloads such as filter/date-range definitions intentionally remain arrays because they are serializable configuration, not domain/view records.
- Added a regression contract for the object View boundary.

## 2.9.1-dev24-fix11-fix18

- Dashboard 2.0 foundation: typed DashboardData/DashboardWidget/RecentRecord DTOs.
- Recent widgets normalize generated Entities before the View boundary.
- Replaced runtime `new $modelClass()` Dashboard wiring with generation-time concrete Model classes.
- Dashboard publish now includes the new DTO files.

## 2.9.1-dev24-fix11-fix17

- Added contributor/developer architecture guides and numbered architecture invariants.
- Added an end-to-end feature development checklist and feature impact matrix.
- Aligned `mycrud:ai-context` with the contributor architecture contract.
- No intentional CRUD runtime behavior change.

## 2.9.1-dev24-fix11-fix16

- Added a disabled/commented `exampleApplyBusinessRule()` customization method to newly created persistent ServiceExtension files, with guidance to call it explicitly from CRUD hooks only after adapting it to real fields.
- Clarified that ServiceExtension custom code must contain application rules/side effects only: SQL/query composition remains in Models and cross-resource writes use concrete explicit Services rather than runtime resolvers.
- Extended `mycrud:ai-context` project JSON/Markdown and CRUD Markdown with a safe-customization map, ServiceExtension path, hook contract, query owner, explicit/static relation rule, and the example method workflow.
- Updated AI architecture guidance for `BaseCrudModel`, REST READ vs WRITE, PATCH/upload Service paths, output-only API/MCP Resources, and MCP Tool query policy.
- Added a regression contract ensuring newly generated ServiceExtensions keep the customization example while remaining protected create-only files.


## 2.9.1-dev24-fix11-fix15
- Frozen the dev24 architecture baseline after fix14 reached FAIL 0 in the reported regression suite.
- Added a consolidated BASIC/STANDARD/FULL architecture boundary guard to `mycrud:test-all`.
- Guard prevents dynamic Model/Service relation resolvers, SQL in Services/API controllers, Resource boundary leaks, and duplication of BaseCrudModel runtime in concrete generated Models.
- Preserves explicit generation-time Model-to-Model and Service-to-Service relation calls.
- Updated README and added a frozen-baseline architecture document.
- No CRUD runtime behavior changes from fix14.

## 2.9.1-dev24-fix11-fix13

## 2.9.1-dev24-fix11-fix14

- Fix regression diagnostic `create record collegato` for STANDARD/FULL after BaseCrudModel consolidation.
- `ArchitectureRegressionRunner` now resolves the shared `app/Models/BaseCrudModel.php` when the isolated Generated tree does not contain it.
- Keeps transaction API validation strict (`beginWriteTransaction`, `writeTransactionStatus`, `commitWriteTransaction`, `rollbackWriteTransaction`) without requiring duplicated methods in every generated Model.
- No generated runtime behavior changed; static Model/Service relation wiring, REST/MCP boundaries, and Related Create Offcanvas UI are unchanged.


### Related Create diagnostic: structural static-service contract
- Fixes the remaining STANDARD/FULL false negative in `create record collegato`.
- The regression runner now validates the actual generated architecture: explicit `XxxService()->createRelated()` calls, related payload use, FK assignment, and transaction boundaries.
- Removes coupling to exact helper names/formatting and to legacy Model-owned related-create persistence.
- Failure messages now list the specific failed sub-checks instead of only `Supporto create parent inline incompleto.`
- Runtime generation is unchanged: no changes to Service, Model, REST, MCP, OpenAPI, or Related Create Offcanvas UI.

## 2.9.1-dev24-fix11-fix12

- Relaxed the `create record collegato` regression contract for STANDARD/FULL without weakening the static architecture boundary.
- Diagnostic applicability now mirrors `ServiceGenerator`: only relationCreate entries that are enabled, schema-compatible (`foreignKey.relatedCreate.available`) and backed by a real parent table are checked.
- Static Service-to-Service related-create wiring is validated structurally with whitespace-tolerant patterns instead of exact generated formatting.
- The contract still rejects dynamic relation/service resolution (`new $serviceClass`, `new $modelClass`, resolver methods and runtime relation maps).
- No runtime, UI, REST, OpenAPI, MCP, Model or Service behavior changed.


## 2.9.1-dev24-fix11-fix11
- Fixed the STANDARD/FULL `create record collegato` regression contract after static Service-to-Service related-create wiring.
- The diagnostic now validates the exact generated helper method per FK relation (for example `createLanguageForLanguageId()`).
- Requires explicit `(new RelatedService())->createRelated($payload)` calls and explicit FK assignment in the current Service.
- Rejects generic related-create dispatchers, runtime class resolution, and dynamic Model/Service resolvers.
- No generated CRUD runtime behavior changes from fix10; REST PATCH/upload, MCP boundary, Offcanvas UI, BaseCrudModel, and explicit relation architecture are preserved.
## 2.9.1-dev24-fix11-fix9
- REST Resource is now strictly output-only: READABLE + make()/collection() only.
- REST filter/sort policies moved from Resource to generated ApiController constants.
- Binary file/image fields are excluded from normal REST writable payloads and remain on the multipart CrudUploadManager path.
- API architecture contract now guards Resource purity and upload-path generation.
- Preserves fix7 Offcanvas UI, BaseCrudModel consolidation, and explicit/static relation wiring.

## 2.9.1-dev24-fix11-fix8
- Aligned REST API architecture with the static Model/Service boundaries.
- Generated API Controllers use Models for reads and Services for writes; no SQL or dynamic relation resolution is generated in the API layer.
- REST input whitelisting moved from Resource to ApiController; generated Resources are now output-only serializers.
- API upload helpers/constants are generated only when upload fields are actually exposed.
- Added generated API architecture contract tests and strengthened Resource/OpenAPI contracts.
- OpenAPI explicitly remains free from Web-only Related Create/Offcanvas transport fields.
- Preserves fix7 Related Create Offcanvas UI and explicit/static relational wiring.

## 2.9.1-dev24-fix11-fix7 - Offcanvas regression merge

- Restores the Related Create many-to-many offcanvas UI from fix11-fix4 on top of fix11-fix6.
- Preserves explicit/static relational wiring and regression-recovery diagnostics.
- Adds diagnostics preventing the old inline toggle UI from returning.


## 2.9.1-dev24-fix11-fix6
- Regression-diagnostic recovery after the feature-aware dead-code cleanup.
- Service hook-order diagnostics now accept both `prepareData($data)` and `prepareData($data, $isUpdate)` while preserving prepare-before-extension ordering.
- Standard/Full Related Create diagnostics now recognize transaction primitives inherited from `BaseCrudModel` and no longer require dead `RELATED_CREATES` metadata in concrete Models.
- Cascaded-navigation diagnostics accept the generated hidden `_trail` form field as well as legacy `data-trail` markup.
- No dynamic relation resolver was reintroduced: generated cross-resource reads/writes remain explicit Model-to-Model and Service-to-Service calls.
- No runtime CRUD behavior change intended; this fix aligns regression contracts with the dev24 static architecture.
## 2.9.1-dev24-fix11-fix1

## 2.9.1-dev24-fix11-fix5 — Dead Code & Explicit Relation Cleanup

- Related Create empty adapters now live in `BaseCrudModel`; child Models override them only when nested relation options really exist.
- Generated relation code keeps dependencies explicit and static (`new AddressModel()`, `new ActorModel()`, etc.); no runtime model/table resolver is introduced.
- Select belongsTo methods now return ready-to-render options directly, removing the generated `RELATION_SEARCHES` map and `toRelationOptions()` dispatcher.
- `OWN_SPATIAL_FIELDS` and GIS-specific Related Create persistence are emitted only for tables that actually own spatial fields.
- `Service::prepareData()` receives the Update flag only when a generated normalization branch actually needs it.
- Removed the unused `Throwable` import from generated Models; PHPDoc uses `\Throwable` directly.
- Relation display templates accept both `{field}` and `{{field}}` consistently, including SQL labels.
- Generated relational contracts now explicitly reject dynamic class/table resolution and verify transaction helpers through `BaseCrudModel`.


- Restored safe Related Create UI defaults for Quick/generate-all.
- Added persistent customization markers for belongsTo and M2M Related Create.
- Migrates legacy snapshots so old technical `false` defaults no longer hide `New` actions.
- Keeps explicit Builder disabled choices authoritative after the next save.

## 2.9.1-dev24-fix8

## 2.9.1-dev24-fix11 - BaseCrudModel Consolidation

- Introduced `App\Models\BaseCrudModel` as the shared runtime base for generated CRUD Models.
- Generated Models now extend `BaseCrudModel` instead of `CodeIgniter\Model` directly.
- Moved common list-filter execution, row-count cache, transaction primitives, owned-table relation helpers, and API link generation into the base class.
- Preserved explicit generated Model-to-Model calls for belongsTo, hasMany, and many-to-many relations; no runtime Model/table resolver was introduced.
- Generated schema/filter constants consumed by the base class are now protected, while resource-specific relation methods remain in each generated Model.
- Removed the superseded `RelationalQuerySupport` trait from the clean package baseline.


### Model Slim & PHPDoc Consolidation

- pruned unused/empty relation metadata constants from generated Models;
- removed dead Controller relation variables when features are disabled;
- removed unused `$isUpdate` argument from generated many-to-many POST parsing;
- fixed Service validation calls to pass generated custom messages;
- retained only currently-used generic owned-table query primitives;
- preserved explicit parent/child/M2M method generation and PHPDoc boundaries.

## 2.9.1-dev24-fix7

- Removes unused generated controller scaffolding when uploads or M2M related-create are not enabled.
- Standard/Full Services now own explicit M2M write orchestration; Models expose named pivot sync methods and persist only their own table/pivots.
- Standard/Full Models no longer receive generic M2M payloads in createRecord()/updateRecord(); Basic keeps its self-contained write path.
- Restores generated Validation::messages() usage inside Services.
- Expands PHPDoc for generated Controllers, Services, Models, relation helpers, transactions, upload helpers, and write operations.
- Keeps relation wiring static and named; runtime table-name resolution is not reintroduced.

## 2.9.1-dev24-fix6

- Generated explicit named relation methods in Models and Services.
- Removed generic Service related-create dispatchers.
- Added named belongsTo search/find methods.
- Added named many-to-many option, selected-ID and pivot-sync methods.
- Pivot SQL remains local; target reads validate through target Models.

## 2.9.1-dev24-fix5
- Completes many-to-many ownership cleanup: target-table reads and target-ID validation are delegated statically to target Models.
- Current Models keep ownership of their own tables and pivot tables only.
- Removes generated relation-specific M2M attach/detach/sync methods duplicated by `applyManyToMany()`.
- Adds `relationRowsByIds()` for safe owned-table reuse and fixes Controller runtime initialization formatting.

## 2.9.1-dev24-fix4 - Architecture Boundary Packaging Fix

- Fixes the generated Controller read dependency so `$model` is initialized and used consistently; the legacy `$gateway` symbol is rejected/normalized.
- Keeps Standard/Full reads on the generated Model and writes on the generated Service.
- Ships the archive with project files at ZIP root (no wrapper directory), so extracting over the project actually updates `app/` and documentation.
- Carries forward the feature-aware/static ModelGenerator from dev24-fix3.

# 2.9.1-dev24-fix1 - Feature-Aware Service Cleanup

- Services now validate normal create/update operations with their own generated Rules, not only related creation.
- Service method signatures are generated from the actual features of each table: unused related/M2M parameters are omitted.
- Transaction boilerplate is generated only when cross-resource writes can actually occur.
- Data-normalization constants and branches are emitted only when the schema requires them.
- Non-M2M Models expose `updateRecord()` instead of the legacy `updateRecordWithManyToMany()` name; Basic/Standard/Full callers are generated accordingly.
- Generated comments describe the responsibility of each remaining branch.
- No new runtime resolver or dynamic wiring was introduced.

# 2.9.1-dev24 - Legacy Architecture Cleanup

- Removes legacy read-only pass-through methods from generated Services.
- Standard/Full Controllers now read directly from the generated Model and use the Service only for writes.
- REST API and read-only MCP tools now read directly from the Model; writes continue through the Service.
- Consolidates Related Create normalization into the single `prepareData()` path; `prepareRelatedData()` is no longer generated.
- Keeps write orchestration, validation, Extension Points, related Service calls, and transaction coordination in the Service.
- Keeps SQL, query helpers, relation options, hasMany/M2M reads, export reads, and transaction primitives in the Model.
- Adds regression contracts that reject reintroduction of legacy Service read pass-through methods.


## 2.9.1-dev23-fix1 - Service DB Boundary Fix
- Removed direct `Database::connect()` usage from generated Services.
- Service transaction orchestration now delegates begin/status/commit/rollback to the generated primary Model.
- Generated Models expose explicit write-transaction boundary methods; SQL/DB access remains in Models.
- Updated relational architecture regression contracts and generated PHPUnit contracts accordingly.
- `mycrud:check-query-layer` can remain strict: Services contain no direct DB connection/query calls.

## 2.9.1-dev23 - Service Validation & CLI Workflow Consolidation

- Related `Service::createRelated()` now validates its own resource with the generated `<Resource>Rules::createRules()` before persistence.
- Static relational Service wiring remains unchanged; no runtime registry/resolver was added.
- Added `php spark mycrud:publish-all` with `--dry-run` and `--force`, symmetric with `generate-all`.
- Updated CLI/workflow documentation around `generate-all -> publish-all -> table customization`.

## 2.9.1-dev22-fix2 — Explicit SKIP diagnostics

- `mycrud:test-all` now renders skipped diagnostics explicitly as `SKIP` instead of a generic dash.
- Many-to-many related-create persistence distinguishes between tables with no M2M relation and tables whose M2M relations do not support related-create.
- No CRUD generation/runtime behavior changed.

## 2.9.1-dev22-fix1 — Static Relational Wiring

- replaces dynamic Service maps with explicit generated Service class calls;
- Related Create in STANDARD/FULL now emits direct calls such as `(new AddressService())->createRelated(...)`;
- M2M Related Create emits direct target Service calls such as `(new ActorService())->createRelated(...)`;
- parent/child Model delegation is emitted with explicit generated Model class names (`new LanguageModel()`, `new InventoryModel()`);
- removes runtime `class_exists()` / `method_exists()` dispatch for generated relational dependencies;
- updates generated relational contract tests and architecture regression diagnostics to enforce static wiring.


## 2.9.1-dev22 — Relational Reuse Consolidation

- Consolidated relational query ownership introduced in dev19.
- Consolidated Related Create Service reuse introduced in dev20.
- Consolidated M2M Related Create Service reuse introduced in dev21.
- Added generated contract checks for parent/child Model delegation.
- Added generated contract checks preventing relational write logic from drifting back into the main Model in Standard/Full.
- Added architecture regression checks for relational query ownership.
- No new runtime layer or dependency mechanism.
# 2.9.1-dev21

## M2M Service Reuse
- STANDARD/FULL M2M Related Create now delegates target creation to the generated Service of the target resource.
- The current Model remains responsible for pivot validation/synchronization and SQL on its own/pivot tables.
- BASIC keeps the existing Model-based M2M Related Create path because it has no Service layer.
- Create and Edit open a wider Service transaction when a new M2M target is created, then pass only resolved target IDs to the Model.
- Generated relational contract tests and architecture regression checks now enforce Service reuse for STANDARD/FULL and the legacy Model path for BASIC.
- Expected bootstrap remains `php spark mycrud:generate-all`, so related Services exist before table customization.

# 2.9.1-dev20

- STANDARD/FULL Related Create now delegates parent writes to the generated parent Service.
- Added generated `Service::createRelated()` and `Model::insertRelatedPayload()` reuse points.
- Related writes remain atomic through a transaction owned by the originating Service.
- BASIC keeps its existing Model-local Related Create implementation.
- Preserved nullable/default/date-time/spatial normalization for inline-created records.
- Updated relational generated tests and architecture regression diagnostics for Service reuse.

# 2.9.1-dev19-fix3

## Regression runner: nullable FK write-path contract

- Fixed a false negative in `ArchitectureRegressionRunner` for nullable foreign-key normalization.
- Generated controllers use the injected runtime instance call `$this->inputProcessor->process(...)`; the regression suite was still looking for the obsolete static token `CrudInputProcessor::process`.
- No generated CRUD runtime behavior was changed: `CrudInputProcessor` already normalizes empty nullable FK values to `null`, and Standard/Full Services retain the same defensive normalization.

# 2.9.1-dev19-fix2

- Fix publish/test synchronization: generated PHPUnit contracts under `tests/Generated/` are now refreshed on normal `mycrud:publish`, without requiring `--force`.
- Keeps SAFE publish semantics unchanged for application code.
- Prevents stale contract expectations after relationship scaffolding changes (for example Film MCP hasMany tools).

# myCrudCI4 2.9.1-dev19-fix1 — Relational Model FQCN Generation Fix

- Fixes invalid generated PHP such as `new \App\Models\{LanguageModel}()` in belongsTo option loaders.
- Fixes the same class-name interpolation bug in generated hasMany child loaders.
- Generated classes now use valid fully-qualified names, e.g. `new \App\Models\LanguageModel()`.
- No architectural behavior changes from dev19.

# myCrudCI4 2.9.1-dev19 — Relational Query Ownership

- Reorganizes generated relational reads around a simple ownership rule: the Model that owns a table executes that table's query.
- BelongsTo option readers generated in a consuming Model now delegate to the generated parent Model instead of composing SQL against the parent table.
- HasMany readers generated for a parent now delegate to the generated child Model instead of composing SQL against the child table.
- Adds two small reusable, schema-whitelisted Model methods: `relationOptionRows()` and `childrenByForeignKey()`.
- Keeps Controllers query-free and preserves existing Service/Controller public contracts, so generated UI does not need to change.
- Keeps JOIN queries that represent the main resource in the main resource Model.
- Does not introduce a registry, dependency graph, service locator, or new runtime framework. The design assumes the normal `mycrud:generate-all` workflow creates all generated Models first.
- Related Create write reuse is intentionally deferred: dev19 changes query ownership only, minimizing regression risk.

# myCrudCI4 2.9.1-dev18 — GIS Point Field UX

- Added Latitude/Longitude editor for POINT fields in Related Create.
- Automatic WKT conversion to POINT(longitude latitude).
- Client-side coordinate bounds and restoration from WKT state.
- No change to relational transaction/persistence contracts.

# myCrudCI4 2.9.1-dev17 — Relational Integrity Consolidation

- Adds generated non-destructive relational contract tests when a CRUD uses Related Create, hasMany or many-to-many relations.
- Contracts verify Related Create validation keys, controller/model hooks, M2M persistence hooks, hasMany detail loader generation and atomic transaction boundaries.
- Adds a regression contract for UNIQUE nested FK filtering introduced in dev16.
- Adds internal RelationResolver regression tests for required spatial fields (`POINT`/WKT) and UNIQUE nested foreign keys.
- Fixes a duplicated method declaration in the generated ValidationContractTest template.
- Keeps database writes out of generated contract tests: tests inspect generated source/metadata only.

## 2.9.1-dev16 — Related Create Unique FK Filtering

**Status: STABLE baseline for Related Create.**
- Filters already-consumed values from nested FK selects when the FK on the inline-created record is UNIQUE.
- Prevents predictable `is_unique` failures such as reusing an existing `store.manager_staff_id`.
- Schema-driven and generic; database constraints and validation remain unchanged.


## 2.9.1-dev15 — Related Create DB Diagnostics

- Related Create INSERT failures now expose the underlying database error code/message.
- The generated Model logs the DB failure before rolling back.
- No schema-specific default values are invented for required spatial fields.

# Changelog

## 2.9.1-dev13

### Many-to-many Related Create FK Fix

- removes the blanket `nested_foreign_key` block for N:N target creation;
- allows target foreign keys that can be resolved with generated select controls;
- keeps unsupported/AJAX nested relations unavailable;
- generates nested FK option lists through Model/Service, never from the View;
- renders nested target FKs as selects in the N:N inline-create form;
- validates nested FK existence server-side before the target INSERT;
- adds a RelationResolver regression test for the Sakila-style Film/Language case.


## 2.9.1-dev12

### Dashboard Global Filters

- adds up to three generic Dashboard-wide filters;
- supports text/number runtime inputs;
- supports controlled operators (`eq`, `neq`, `gt`, `gte`, `lt`, `lte`, `contains`, `starts_with`);
- adds per-widget global-filter field mappings;
- validates global filter IDs and widget mappings during generation;
- applies mapped global filters to aggregate DashboardQuery operations;
- applies mapped global filters to reused CRUD Models for Recent records;
- keeps local widget filters and global date filters composable.


## 2.9.1-dev11

### Dashboard Builder Productivity

- adds live structural widget preview in the Builder;
- adds explicit ordered Recent-record column selection;
- persists Recent column choices/order;
- validates selected Recent fields against the current CRUD;
- adds grouped-chart date grouping: raw, day, month, year;
- exposes date grouping only for current DATE/DATETIME/TIMESTAMP fields;
- adds driver-aware grouping expressions for MySQL/MariaDB, PostgreSQL, and SQLite.


## 2.9.1-dev10

### Dashboard 3-column grid

- displays Dashboard widgets as responsive cards;
- 3 cards per row on desktop, 2 on tablet, 1 on mobile;
- adapts core widget controls to a vertical/compact card layout;
- keeps advanced Presentation, Global period, and Local filter panels collapsed;
- preserves drag-and-drop ordering across the responsive grid;
- preserves all Dashboard behavior from dev9.


## 2.9.1-dev9

### Dashboard Builder UI Consolidation

- replaces tall flat widget forms with compact widget cards;
- keeps only core/type-specific controls always visible;
- moves Presentation, Global period, and Local filter into collapsible panels;
- adds live widget summary in each card header;
- adds dedicated drag handle and Sortable visual feedback;
- preserves all dev8 Dashboard behavior and persistent configuration.


## 2.9.1-dev8

### Dashboard Global Date Filter

- adds Dashboard-wide From/To period control;
- each widget maps the global period to its own date/datetime/timestamp field;
- date fields are derived from current CRUD schema;
- generated Controller validates `YYYY-MM-DD`;
- reversed From/To values are normalized;
- aggregate widgets apply the period in `DashboardQuery`;
- Recent records apply the same period to the reused CRUD Model;
- local widget filters and global date range can be combined.


## 2.9.1-dev7

### Dashboard Presentation & Filters

- compacts KPI cards;
- adds KPI decimals, prefix, and suffix formatting;
- adds one optional safe filter per widget;
- supports `eq`, `neq`, `gt`, `gte`, `lt`, `lte`, `contains`, and `starts_with`;
- revalidates filter fields against the current CRUD schema;
- Recent records use CRUD `Visible in list` fields and configured labels;
- Entity-backed recent rows are read through Entity properties;
- chart group/filter presentation uses configured labels where available.


## 2.9.1-dev6

### Dashboard Analytics

- adds KPI `SUM`, `AVG`, `MIN`, `MAX`;
- adds grouped statistics;
- adds bar, line, and doughnut charts;
- Dashboard Builder derives numeric/groupable fields from current CRUD schema;
- generator revalidates field compatibility before code generation;
- grouped results use `SeriesPoint` DTOs;
- aggregate SQL remains isolated in `DashboardQuery`;
- normal record widgets continue to reuse existing CRUD Models/Entities.


## 2.9.1-dev5

### Application Dashboard foundation

- adds `/mycrud/dashboard` Dashboard Builder;
- stores persistent Dashboard config in `app/MyCrudConfig/Dashboards/main.php`;
- adds KPI Count, Recent records, and Quick link widgets;
- reuses generated CRUD Models/Entities for record-shaped data;
- introduces lightweight `Kpi` and `SeriesPoint` DTOs for aggregate/dashboard data;
- adds `DashboardQuery` reserved for aggregate/statistical queries;
- generates Dashboard Controller, Service, View, DTOs, query layer, and route to safe staging;
- adds safe Dashboard publish flow;
- updates README, internal docs, and configuration docs.


## 2.9.1-dev4

### Builder UX & Fields guidance

- clarifies technical pivot hasMany vs semantic many-to-many configuration;
- marks pure-pivot hasMany cards as `Technical pivot`;
- adds detailed Fields guidance directly in `/mycrud/builder/configure/<table>`;
- documents form/layout, visibility, filtering/sorting, API/MCP, validation,
  foreign-key navigation, initial values, and DB-managed behavior;
- expands `/mycrud/docs` and `docs/CONFIGURATION.md`;
- no schema or CRUD persistence behavior change.


## 2.9.1-dev3-CONSO

### Consolidation candidate

- removes duplicated M:N related-create availability UI;
- adds persistent-config regression for `createRelatedEnabled`;
- adds generator regression for nullable foreign-key normalization;
- adds generator regression for M:N inline related creation;
- extends generated validation contract tests for M:N related-create rules;
- updates `/mycrud/docs`, README, configuration docs, and test docs;
- no new runtime feature.


## 2.9.1-dev2-fix12

### Nullable foreign-key normalization

- converts empty-string values to `NULL` for nullable FK fields;
- fixes optional belongsTo selects such as Sakila `film.original_language_id`;
- applies the rule in web input processing and generated Services;
- required foreign keys are unchanged.


## 2.9.1-dev2-fix11

### M2M related-create persistence

- persists `createRelatedEnabled` in `app/MyCrudConfig/<table>.php`;
- fixes generated Create/Edit forms not showing inline related creation after Save + Generate;
- adds regression checks for Builder → persistent config → generator flow.


## 2.9.1-dev2-fix10

### M2M related-create availability

- verifies Sakila-style `actor` and `category` targets as compatible with inline creation;
- adds explicit availability reason metadata;
- Builder always shows related-create availability status;
- Builder explains why a relation is unavailable instead of silently hiding the reason;
- `Actor` resolves to writable fields `first_name`, `last_name`;
- `Category` resolves to writable field `name`.


## 2.9.1-dev2-fix9

### Many-to-many Create new related record

- optional per-relation Builder setting;
- inline Create/Edit target form;
- server-side target validation;
- target creation inside the main CRUD transaction;
- new target ID automatically included in pivot synchronization;
- conservative first scope: simple target table, single PK, no nested FK fields.


## 2.9.1-dev2

### English Technical Documentation

- framework technical documentation is English-first;
- README and core docs consolidated in English;
- generated MCP PHPDoc translated to English;
- internal `/mycrud/docs` technical content moved toward English;
- application-facing UI remains localizable.

## 2.9.1-dev1

### MCP PHPDoc Consolidation

- `#[McpTool]` remains responsible for MCP discovery, name, and title;
- standard PHPDoc documents purpose, parameters, and return shapes;
- no runtime MCP behavior changes.

## 2.9.0 — STABLE

Release stabile della linea 2.9 di myCrudCI4.

### Workflow e CLI

- persistent configuration per table;
- staging sicuro in `app/Generated/`;
- `mycrud:generate`;
- `mycrud:generate-all`;
- `mycrud:regenerate`;
- `mycrud:diff`;
- `mycrud:publish` con `--dry-run` e modalità SAFE;
- `mycrud:test-generated`;
- diagnostica `doctor`, `benchmark`, `explain`, `check-api`, `check-query-layer`;
- `mycrud:ai-context`.

### Builder

- architetture Basic / Standard / Full;
- Form Sections con larghezza Bootstrap configurabile;
- spacing corretto tra sezioni;
- foreign-key / hasMany / many-to-many relations;
- upload file e immagini;
- API Capabilities;
- API Security;
- MCP Capabilities;
- visibilità REST e MCP indipendenti.

### API / OpenAPI

- REST API v1 per architettura Full;
- operationId OpenAPI stabili;
- capability per singola operazione;
- upload `multipart/form-data`;
- endpoint dedicato per sostituzione upload;
- integrazione opzionale CodeIgniter Shield;
- permission per capability API.

### Test

- Test Scaffolding;
- contract test Structure;
- Validation Contract;
- API Resource Contract;
- OpenAPI Contract;
- Shield Security Contract;
- MCP Foundation Contract;
- MCP Resource Security Contract;
- runner `mycrud:test-generated`.

### MCP

- MCP manifest per table;
- transport STDIO locale;
- modalità read-only;
- tool `list_*` e `get_*`;
- tool relazionali belongsTo e hasMany;
- Service layer obbligatorio;
- no direct DB access from tools;
- Resource MCP dedicata;
- `mcpVisible` independent from `apiVisible`;
- `mycrud:mcp-doctor`;
- `mycrud:mcp-serve <table> --no-header`.

### Consolidation

La 2.9.0 STABLE promuove l'ultimo candidato testato senza introdurre nuove feature.


## 2.9.1-dev24-fix10
- Fixed false HasMany context failures for root parent resources.
- HasMany parent-child-parent diagnostics now run only for enabled hasMany relations.
- Pure M:N resources report the HasMany diagnostic as SKIP when no hasMany relation applies.
- Cascaded-navigation diagnostics require child return helpers only when the current resource has its own parent context.
- No runtime architecture or generated CRUD behavior changes from fix9.

## 2.9.1-dev24-fix9
- Fixed Service validation method calls to include generated custom messages.
- Consolidated repeated owned-table relational query helpers into `RelationalQuerySupport`.
- Reduced generated Model size while preserving explicit Model-to-Model relation wiring.
- Generate Service transaction bridge methods only when a configured use-case needs them.
- Expanded PHPDoc for relational query ownership and shared runtime operations.
