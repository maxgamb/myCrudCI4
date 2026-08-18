<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<style>
    .mycrud-docs {
        --docs-nav-width: 260px;
    }

    .mycrud-docs .docs-hero {
        background:
            radial-gradient(circle at top right, rgba(13, 110, 253, .10), transparent 34%),
            var(--bs-body-bg);
    }

    .mycrud-docs .docs-nav {
        position: sticky;
        top: 1rem;
        max-height: calc(100vh - 2rem);
        overflow-y: auto;
        scrollbar-width: thin;
    }

    .mycrud-docs .docs-nav .nav-link {
        color: var(--bs-body-color);
        border-radius: .45rem;
        padding: .42rem .65rem;
        font-size: .92rem;
    }

    .mycrud-docs .docs-nav .nav-link:hover,
    .mycrud-docs .docs-nav .nav-link:focus {
        background: var(--bs-tertiary-bg);
    }

    .mycrud-docs .docs-nav .docs-nav-title {
        font-size: .73rem;
        letter-spacing: .05em;
        text-transform: uppercase;
        color: var(--bs-secondary-color);
        font-weight: 700;
        margin: .9rem .65rem .25rem;
    }

    .mycrud-docs .docs-section {
        scroll-margin-top: 1rem;
    }

    .mycrud-docs .docs-section > .card-header {
        background: var(--bs-body-bg);
    }

    .mycrud-docs .docs-code {
        background: #1f2328;
        color: #f0f3f6;
        border-radius: .55rem;
        padding: .9rem 1rem;
        margin: 0;
        overflow-x: auto;
        font-size: .88rem;
    }

    .mycrud-docs .docs-path {
        font-family: var(--bs-font-monospace);
        background: var(--bs-tertiary-bg);
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: .4rem;
        padding: .5rem .7rem;
        overflow-wrap: anywhere;
    }

    .mycrud-docs .docs-step {
        position: relative;
        height: 100%;
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: .6rem;
        padding: 1rem;
    }

    .mycrud-docs .docs-step-number {
        width: 2rem;
        height: 2rem;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: var(--bs-primary);
        color: #fff;
        font-weight: 700;
        margin-bottom: .65rem;
    }

    .mycrud-docs .docs-kpi {
        border-left: .25rem solid var(--bs-primary);
    }

    .mycrud-docs .docs-feature {
        border: var(--bs-border-width) solid var(--bs-border-color);
        border-radius: .55rem;
        padding: .8rem;
        height: 100%;
    }

    @media (max-width: 991.98px) {
        .mycrud-docs .docs-nav {
            position: static;
            max-height: none;
        }
    }
</style>

<div class="container-fluid py-4 mycrud-docs">
    <section class="card shadow-sm border-0 docs-hero mb-4">
        <div class="card-body p-4">
            <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                <div>
                    <div class="text-primary fw-semibold small mb-1">INTERNAL DOCUMENTATION</div>
                    <h1 class="h2 mb-2">
                        <i class="bi bi-braces-asterisk me-2"></i>myCrudCI4
                    </h1>
                    <p class="text-muted mb-0">
                        Database-driven CodeIgniter 4 CRUD generator with Builder, safe staging,
                        API/OpenAPI, tests, Shield, and MCP.
                    </p>
                </div>

                <div class="text-end">
                    <span class="badge text-bg-dark fs-6 mb-2">
                        <?= esc($version ?? '') ?>
                    </span>
                    <div class="small text-muted">2.9.0 · STABLE</div>
                </div>
            </div>

            <hr class="my-4">

            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <div class="docs-feature">
                        <div class="small text-muted">Staging</div>
                        <strong>app/Generated/</strong>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="docs-feature">
                        <div class="small text-muted">Architectures</div>
                        <strong>Basic · Standard · Full</strong>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="docs-feature">
                        <div class="small text-muted">API</div>
                        <strong>REST + OpenAPI</strong>
                    </div>
                </div>
                <div class="col-6 col-md-3">
                    <div class="docs-feature">
                        <div class="small text-muted">MCP</div>
                        <strong>STDIO · Read only</strong>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <aside class="col-12 col-lg-3 col-xl-2">
            <div class="card shadow-sm docs-nav">
                <div class="card-header">
                    <strong><i class="bi bi-list-ul me-1"></i>Contents</strong>
                </div>

                <div class="card-body p-2">
                    <input
                        type="search"
                        class="form-control form-control-sm mb-2"
                        id="docsSearch"
                        placeholder="Search documentation..."
                        autocomplete="off"
                    >

                    <nav id="docsNavigation">
                        <div class="docs-nav-title">Getting started</div>
                        <a class="nav-link" href="#quick-start">Quick start</a>
                        <a class="nav-link" href="#architecture">Architecture</a>
                        <a class="nav-link" href="#paths">Paths</a>

                        <div class="docs-nav-title">Builder</div>
                        <a class="nav-link" href="#builder">Configuration</a>
                        <a class="nav-link" href="#dashboard-builder">Dashboard Builder</a>
                        <a class="nav-link" href="#builder-fields-reference">Fields reference</a>
                        <a class="nav-link" href="#form-sections">Form Sections</a>
                        <a class="nav-link" href="#relations">Relations</a>
                        <a class="nav-link" href="#relation-layer-reference">Pivot layers</a>
                        <a class="nav-link" href="#uploads">Upload</a>
                        <a class="nav-link" href="#extensions">Extension Points</a>

                        <div class="docs-nav-title">CLI and tests</div>
                        <a class="nav-link" href="#cli">Spark commands</a>
                        <a class="nav-link" href="#tests">Test</a>
                        <a class="nav-link" href="#diagnostics">Diagnostics</a>

                        <div class="docs-nav-title">Integrations</div>
                        <a class="nav-link" href="#api">API / OpenAPI</a>
                        <a class="nav-link" href="#shield">Shield</a>
                        <a class="nav-link" href="#mcp">MCP</a>

                        <div class="docs-nav-title">System</div>
                        <a class="nav-link" href="#configuration">Global configuration</a>
                        <a class="nav-link" href="#release">2.9 status</a>
                    </nav>
                </div>
            </div>
        </aside>

        <main class="col-12 col-lg-9 col-xl-10">
            <section id="quick-start" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-play-circle me-2"></i>Quick start</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-primary">
                        <strong>Recommended approach:</strong>
                        configure the CRUD in the <strong>Builder</strong>, save the persistent configuration, then use <strong>Quick</strong> or <strong>CLI</strong> to execute the operational workflow.
                    </div>

                    <div class="docs-path mb-3">
                        Builder = decides what to generate &nbsp;·&nbsp;
                        Quick / CLI = execute what has already been configured
                    </div>

                    <div class="row g-3 mb-4">
                        <?php foreach ([
                            ['1', 'Database schema', 'PK, FK, types, indexes'],
                            ['2', 'Builder', 'Configure CRUD, fields, sections, relations, API, MCP'],
                            ['3', 'Save config', 'app/MyCrudConfig/<table>.php'],
                            ['4', 'Quick / CLI', 'Executes the saved configuration'],
                            ['5', 'Generate', 'Writes to app/Generated/'],
                            ['6', 'Diff / Review', 'Review changes'],
                            ['7', 'Publish', 'Publishes to app/ and tests/'],
                            ['8', 'Test', 'Verifies the published CRUD'],
                        ] as [$number, $title, $description]): ?>
                            <div class="col-12 col-md-6 col-xl-3">
                                <div class="docs-step">
                                    <span class="docs-step-number"><?= esc($number) ?></span>
                                    <div class="fw-semibold"><?= esc($title) ?></div>
                                    <div class="small text-muted"><?= esc($description) ?></div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <h3 class="h6">Logical workflow</h3>
                    <pre class="docs-code mb-3"><code>DATABASE
   ↓
BUILDER
   ↓
app/MyCrudConfig/&lt;table&gt;.php
   ↓
┌──────────────┬──────────────┐
│ Quick        │ CLI          │
└──────┬───────┴──────┬───────┘
       ↓              ↓
        app/Generated/
              ↓
         Diff / Review
              ↓
           Publish
              ↓
      app/ + tests/
              ↓
      Test Generated</code></pre>

                    <h3 class="h6">CLI execution</h3>
                    <pre class="docs-code"><code>php spark mycrud:generate film --force
php spark mycrud:diff film
php spark mycrud:publish film --dry-run
php spark mycrud:publish film
php spark mycrud:test-generated film</code></pre>

                    <div class="alert alert-light border mt-3 mb-0">
                        <strong>Note:</strong>
                        Quick should not become a second Builder.
                        If the table does not have persistent configuration yet, the correct path is <strong>Configure in Builder</strong>.
                    </div>
                </div>
            </section>

            <section id="architecture" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-layers me-2"></i>Architecture</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table align-middle mb-3">
                            <thead>
                                <tr>
                                    <th>Level</th>
                                    <th>Generates</th>
                                    <th>Purpose</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>Basic</th>
                                    <td>Model, Controller, Validation, Views, Routes</td>
                                    <td>Complete web CRUD</td>
                                </tr>
                                <tr>
                                    <th>Standard</th>
                                    <td>Basic + Entity + Service + Extension</td>
                                    <td>Separated application logic</td>
                                </tr>
                                <tr>
                                    <th>Full</th>
                                    <td>Standard + REST API + Resource + OpenAPI</td>
                                    <td>API, Shield, MCP</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="alert alert-info mb-0">
                        <strong>Principle:</strong> Controllers, API, and MCP must not contain DB queries.
                        Logic flows through the generated Service and Model.
                    </div>
                </div>
            </section>

            <section id="paths" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-folder2-open me-2"></i>Main paths</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <?php foreach ([
                            ['app/MyCrudConfig/', 'Persistent per-table configurations'],
                            ['app/Generated/', 'Safe generation staging area'],
                            ['app/Services/Extensions/', 'Persistent developer custom code'],
                            ['tests/Generated/MyCrud/', 'Published generated contract tests'],
                            ['writable/uploads/', 'Runtime upload storage'],
                            ['app/OpenApi/', 'Published OpenAPI specifications'],
                            ['app/Mcp/', 'Published MCP Resources, tools, and manifests'],
                        ] as [$path, $description]): ?>
                            <div class="col-12 col-xl-6">
                                <div class="docs-path"><strong><?= esc($path) ?></strong></div>
                                <div class="small text-muted mt-1"><?= esc($description) ?></div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </section>

            <section id="builder" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-sliders me-2"></i>Builder</h2>
                </div>
                <div class="card-body">
                    <p>
                        The Builder stores application-level decisions only; the DB schema remains authoritative
                        for columns, types, primary keys, foreign keys, and indexes.
                    </p>

                    <div class="alert alert-success">
                        <strong>Builder role:</strong>
                        is the single point where you decide <em>what</em> must be generated.
                        Quick, CLI, and Regenerate must reuse the same saved configuration without creating a second configuration model.
                    </div>

                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-2">
                        <?php foreach ([
                            'Architecture',
                            'API Capabilities',
                            'API Security',
                            'MCP',
                            'Relations',
                            'Form Sections',
                            'Input type',
                            'Label',
                            'Bootstrap width',
                            'Visibility',
                            'Filters / sorting',
                            'Export',
                            'Upload',
                            'Preview',
                        ] as $item): ?>
                            <div class="col">
                                <div class="docs-feature">
                                    <i class="bi bi-check2-circle text-success me-1"></i><?= esc($item) ?>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </section>

            <section id="builder-fields-reference" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-input-cursor-text me-2"></i>Fields configuration reference
                    </h2>
                </div>
                <div class="card-body">
                    <p>
                        The Fields area combines schema metadata with application-level choices.
                        The database remains authoritative for physical names, types, keys,
                        nullability, defaults, and DB-managed timestamps.
                    </p>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle">
                            <thead>
                                <tr>
                                    <th>Setting</th>
                                    <th>Effect</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Input type</td><td>Create/Edit control</td><td>Does not change the DB column type.</td></tr>
                                <tr><td>Label</td><td>User-facing caption</td><td>DB/property names stay unchanged.</td></tr>
                                <tr><td>Bootstrap width</td><td>Form grid layout</td><td><code>col-md-6</code> usually means two fields per row.</td></tr>
                                <tr><td>Form section</td><td>Create/Edit grouping</td><td>Unassigned fields use <em>General</em>.</td></tr>
                                <tr><td>Initial value</td><td>Create prefill</td><td><code>old()</code>, URL context, Edit, and DB-managed values take precedence.</td></tr>
                                <tr><td>Searchable</td><td>Dynamic filtering</td><td>Index policy is still enforced.</td></tr>
                                <tr><td>Sortable</td><td>Server-side ordering</td><td>The query layer validates the field again.</td></tr>
                                <tr><td>Visible in list/form/details</td><td>Independent web exposure</td><td>DB-managed fields cannot be made writable.</td></tr>
                                <tr><td>API visible</td><td>REST exposure</td><td>Independent from MCP visibility.</td></tr>
                                <tr><td>MCP visible</td><td>MCP field exposure</td><td>Independent from API visibility.</td></tr>
                                <tr><td>Exportable</td><td>CSV/Word output</td><td>Export safety limits still apply.</td></tr>
                                <tr><td>Sensitive</td><td>Explicit restricted-field policy</td><td>Not inferred only from the field name.</td></tr>
                                <tr><td>HTML attributes</td><td>Control/validation hints</td><td>Do not alter the database schema.</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <h3 class="h6 mt-4">Foreign-key fields</h3>
                    <ul>
                        <li><strong>Full select / AJAX</strong> controls parent-option loading.</li>
                        <li><strong>Display value/template</strong> changes the readable label, not the stored FK.</li>
                        <li><strong>Quick filter</strong> adds relation-aware filtering/navigation.</li>
                        <li><strong>Link to parent</strong> opens the related parent record.</li>
                        <li><strong>Accept FK from URL</strong> enables safe, server-validated Create context.</li>
                        <li><strong>Select or create new</strong> creates the parent in the same transaction.</li>
                    </ul>

                    <div class="alert alert-info mb-0">
                        Nullable foreign-key controls submitted empty are normalized from
                        <code>''</code> to <code>NULL</code> before persistence.
                    </div>
                </div>
            </section>

            <section id="dashboard-builder" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-grid-1x2 me-2"></i>Application Dashboard Builder</h2>
                </div>
                <div class="card-body">
                    <p>
                        The generated application Dashboard reuses configured CRUD code instead of
                        duplicating record retrieval.
                    </p>
                    <div class="docs-path mb-3">
                        CRUD Model / Entity → DashboardService → View
                    </div>
                    <div class="docs-path mb-3">
                        Aggregate query → DashboardQuery → Kpi / SeriesPoint DTO → DashboardService
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-lg-4">
                            <div class="docs-feature">
                                <strong>KPI Count</strong>
                                <div class="small text-muted mt-1">Aggregate count represented by a Dashboard DTO.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="docs-feature">
                                <strong>Recent records</strong>
                                <div class="small text-muted mt-1">Reuses the generated CRUD Model and its Entity return type.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="docs-feature">
                                <strong>Quick link</strong>
                                <div class="small text-muted mt-1">Navigation to an existing generated CRUD.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="docs-feature">
                                <strong>KPI Aggregate</strong>
                                <div class="small text-muted mt-1">SUM / AVG / MIN / MAX on numeric CRUD fields.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-4">
                            <div class="docs-feature">
                                <strong>Grouped chart</strong>
                                <div class="small text-muted mt-1">COUNT or numeric aggregate grouped by a configured field.</div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-light border mt-3 mb-0">
                        Persistent configuration:
                        <code>app/MyCrudConfig/Dashboards/main.php</code>.
                        Generation first writes to <code>app/Generated/</code>.
                    </div>
                </div>
            </section>

            <section id="dashboard-presentation" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-funnel me-2"></i>Widget presentation & filters
                    </h2>
                </div>
                <div class="card-body">
                    <p>
                        KPI widgets support decimals, prefix, and suffix without changing the
                        underlying numeric DTO value.
                    </p>
                    <p>
                        Data widgets can define one safe field/operator/value filter. Filter fields
                        come from the current configured CRUD and are revalidated at generation time.
                    </p>
                    <div class="docs-path mb-3">
                        Builder filter → schema validation → DashboardQuery / CRUD Model → Widget
                    </div>
                    <p class="mb-0">
                        Recent-record widgets reuse CRUD <strong>Visible in list</strong> fields and labels.
                        When the Model returns an Entity, field values are read through Entity properties
                        so casts/accessors can participate.
                    </p>
                </div>
            </section>

            <section id="dashboard-global-date" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-calendar-range me-2"></i>Global Dashboard period
                    </h2>
                </div>
                <div class="card-body">
                    <p>
                        The generated Dashboard can expose one global <strong>From / To</strong> period.
                        Each widget maps the period to its own DATE/DATETIME/TIMESTAMP field.
                    </p>
                    <div class="docs-path mb-3">
                        Dashboard From/To → validated Controller input → widget date-field mapping → Model / DashboardQuery
                    </div>
                    <p class="mb-0">
                        Local widget filters remain independent and can be combined with the global period.
                    </p>
                </div>
            </section>

            <section id="dashboard-productivity" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-eye me-2"></i>Dashboard Builder productivity
                    </h2>
                </div>
                <div class="card-body">
                    <p>
                        Widget cards include a live structural preview so layout and configuration
                        can be reviewed before Generate/Publish.
                    </p>
                    <p>
                        <strong>Recent records</strong> can explicitly select and order their columns.
                        The generated Dashboard still validates those fields against the current CRUD.
                    </p>
                    <p class="mb-0">
                        Grouped charts using a date field can group by exact value, day, month, or year.
                    </p>
                </div>
            </section>

            <section id="dashboard-global-filters" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-funnel-fill me-2"></i>Generic Dashboard-wide filters
                    </h2>
                </div>
                <div class="card-body">
                    <p>
                        Up to three global filters can be configured in addition to the global
                        From/To period.
                    </p>
                    <div class="docs-path mb-3">
                        Global filter value → widget field mapping → DashboardQuery / existing CRUD Model
                    </div>
                    <p class="mb-0">
                        Each widget can map the same global filter to a different field.
                        Mappings and filter identifiers are revalidated during Dashboard generation.
                    </p>
                </div>
            </section>

            <section id="form-sections" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-layout-three-columns me-2"></i>Form Sections</h2>
                </div>
                <div class="card-body">
                    <p>
                        Create/Edit forms can be organized into collapsible sections without changing validation, Service, Model, or payload.
                    </p>

                    <div class="row g-3">
                        <div class="col-12 col-xl-5">
                            <div class="docs-kpi border rounded p-3 h-100">
                                <strong>Configurable</strong>
                                <ul class="small mb-0 mt-2">
                                    <li>Title</li>
                                    <li>Description</li>
                                    <li>Open / closed</li>
                                    <li>Bootstrap width 1–12</li>
                                    <li>Order</li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-12 col-xl-7">
                            <div class="docs-path mb-2">
                                <code>row g-3 → col-* → details.crud-form-section</code>
                            </div>
                            <p class="small text-muted mb-0">
                                In version 2.9 the width <code>col-*</code> is applied to an outer wrapper.
                                This allows Bootstrap gutters to create real horizontal and vertical spacing between sections.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

            <section id="relations" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-diagram-3 me-2"></i>Relations</h2>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th>Type</th>
                                    <th>Support</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th>belongsTo / FK</th>
                                    <td>Select, AJAX, label, parent link, context URL, Relational Create</td>
                                </tr>
                                <tr>
                                    <th>hasMany</th>
                                    <td>Child preview, count, limit, collapsible panel</td>
                                </tr>
                                <tr>
                                    <th>N:N</th>
                                    <td>Pure pivot, existing-record selection, Create/Edit synchronization, inline related create</td>
                                </tr>
                                <tr>
                                    <th>Cascaded Navigation</th>
                                    <td>Multi-level trail for breadcrumbs and contextual return</td>
                                </tr>
                                <tr>
                                    <th>SQL VIEW</th>
                                    <td>Conservative read-only scaffolding</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </section>

            <section id="relation-layer-reference" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0">
                        <i class="bi bi-diagram-3 me-2"></i>Pure pivot: hasMany vs many-to-many
                    </h2>
                </div>
                <div class="card-body">
                    <p>
                        A pure pivot can appear in both relation sections because the two switches
                        control different generated behaviors.
                    </p>

                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <div class="border rounded p-3 h-100">
                                <strong>Technical pivot hasMany</strong>
                                <p class="small text-muted mt-2 mb-0">
                                    Exposes the pivot table itself as a child panel: columns, count,
                                    detail button, View all, and direct child navigation.
                                </p>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="border rounded p-3 h-100">
                                <strong>Semantic many-to-many</strong>
                                <p class="small text-muted mt-2 mb-0">
                                    Manages the target relation: select existing records, synchronize
                                    pivot rows, create new related records, and N:N View behavior.
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="alert alert-light border mt-3 mb-0">
                        Recommended default: keep the technical pivot hasMany disabled unless the
                        application must expose the pivot table itself.
                    </div>
                </div>
            </section>

            <section id="uploads" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-upload me-2"></i>File / image upload</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-12 col-lg-5">
                            <div class="docs-path">writable/uploads/</div>
                        </div>
                        <div class="col-12 col-lg-7">
                            <div class="docs-path">&lt;table&gt;_&lt;id&gt;_&lt;field&gt;_&lt;random&gt;.&lt;ext&gt;</div>
                        </div>
                    </div>

                    <p class="mt-3 mb-2">
                        Maximum size and allowed extensions are centralized in
                        <code>app/Config/MyCrud.php</code>.
                    </p>

                    <div class="alert alert-light border mb-0">
                        Web CRUD and multipart API reuse the same <code>CrudUploadManager</code>.
                    </div>
                </div>
            </section>

            <section id="extensions" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-plugin me-2"></i>Service Extension Points</h2>
                </div>
                <div class="card-body">
                    <div class="docs-path mb-3">app/Services/Extensions/</div>

                    <pre class="docs-code"><code>beforeCreate()
afterCreate()
beforeUpdate()
afterUpdate()
beforeDelete()
afterDelete()</code></pre>

                    <h3 class="h6 mt-4">Customization example</h3>
                    <pre class="docs-code"><code>protected function beforeCreate(array $data): array
{
    // After uncommenting/adapting the generated example helper:
    return $this-&gt;exampleApplyBusinessRule($data);
}

// Keep SQL in the Model. For cross-resource writes use
// an explicit concrete Service, never a dynamic resolver.</code></pre>

                    <p class="small text-muted mt-3 mb-0">
                        Extensions are persistent and must not be overwritten by regeneration.
                        New extension files include a disabled/commented <code>exampleApplyBusinessRule()</code> helper.
                        Adapt it to real fields and call it explicitly from a hook only when needed.
                    </p>
                </div>
            </section>

            <section id="cli" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-terminal me-2"></i>Spark commands</h2>
                </div>
                <div class="card-body">
                    <div class="accordion" id="cliAccordion">
                        <?php
                        $cliGroups = [
                            'Generation' => [
                                ['mycrud:generate <table>', 'Generates one CRUD in staging'],
                                ['mycrud:generate-all', 'Generates all persistent configurations'],
                                ['mycrud:regenerate <table>', 'Regenerates from persistent configuration'],
                            ],
                            'Review and publishing' => [
                                ['mycrud:diff <table>', 'Compares new generation with current code'],
                                ['mycrud:publish <table> --dry-run', 'Simulates publishing'],
                                ['mycrud:publish <table>', 'Publishes in SAFE mode'],
                                ['mycrud:publish <table> --force', 'Publishes with explicit overwrite'],
                            ],
                            'Test' => [
                                ['mycrud:test <table>', 'Focused generator test'],
                                ['mycrud:test-all <table>', 'Generator regression suite'],
                                ['mycrud:test-generated <table>', 'Published CRUD tests'],
                            ],
                            'Diagnostics' => [
                                ['mycrud:doctor [table]', 'Project/schema diagnostics'],
                                ['mycrud:benchmark <table>', 'Benchmark query'],
                                ['mycrud:explain <table>', 'EXPLAIN representative queries'],
                                ['mycrud:check-api <table>', 'Checks API/OpenAPI'],
                                ['mycrud:check-query-layer <table>', 'Checks Query Layer'],
                                ['mycrud:ai-context [table]', 'Generates AI context + customization/architecture guidance'],
                            ],
                            'MCP' => [
                                ['mycrud:mcp-doctor [table]', 'Checks manifest, SDK, and tools'],
                                ['mycrud:mcp-serve <table> --no-header', 'Run MCP STDIO read-only'],
                            ],
                        ];
                        ?>
                        <?php foreach ($cliGroups as $index => $commands): ?>
                            <?php
                            $slug = strtolower(preg_replace('/[^a-zA-Z0-9]+/', '-', (string) $index));
                            $heading = 'cli_' . trim($slug, '-');
                            ?>
                            <div class="accordion-item">
                                <h3 class="accordion-header">
                                    <button
                                        class="accordion-button <?= $index === 'Generation' ? '' : 'collapsed' ?>"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#<?= esc($heading) ?>"
                                    >
                                        <?= esc($index) ?>
                                    </button>
                                </h3>
                                <div
                                    id="<?= esc($heading) ?>"
                                    class="accordion-collapse collapse <?= $index === 'Generation' ? 'show' : '' ?>"
                                    data-bs-parent="#cliAccordion"
                                >
                                    <div class="accordion-body p-0">
                                        <div class="table-responsive">
                                            <table class="table table-sm mb-0">
                                                <tbody>
                                                    <?php foreach ($commands as [$command, $description]): ?>
                                                        <tr>
                                                            <td class="text-nowrap px-3 py-2">
                                                                <code>php spark <?= esc($command) ?></code>
                                                            </td>
                                                            <td class="px-3 py-2"><?= esc($description) ?></td>
                                                        </tr>
                                                    <?php endforeach ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </section>

            <section id="tests" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-check2-square me-2"></i>Test Scaffolding</h2>
                </div>
                <div class="card-body">
                    <div class="row g-3 mb-3">
                        <div class="col-12 col-xl-6">
                            <div class="docs-feature">
                                <strong>Generator tests</strong>
                                <pre class="docs-code mt-2"><code>php spark mycrud:test-all film
php spark mycrud:test-dashboard</code></pre>
                            </div>
                        </div>
                        <div class="col-12 col-xl-6">
                            <div class="docs-feature">
                                <strong>Published CRUD tests</strong>
                                <pre class="docs-code mt-2"><code>php spark mycrud:test-generated film</code></pre>
                            </div>
                        </div>
                    </div>

                    <p class="mb-2">Full architecture can generate contract tests for:</p>
                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-2 small">
                        <?php foreach ([
                            'Structure',
                            'Validation',
                            'API Resource',
                            'OpenAPI',
                            'Shield Security',
                            'MCP Foundation',
                            'MCP Resource Security',
                        ] as $test): ?>
                            <div class="col">
                                <div class="docs-feature"><?= esc($test) ?></div>
                            </div>
                        <?php endforeach ?>
                    </div>
                </div>
            </section>

            <section id="diagnostics" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-activity me-2"></i>Diagnostics</h2>
                </div>
                <div class="card-body">
                    <pre class="docs-code"><code>php spark mycrud:doctor film
php spark mycrud:benchmark film
php spark mycrud:explain film
php spark mycrud:check-api film
php spark mycrud:check-query-layer film
php spark mycrud:mcp-doctor film</code></pre>
                </div>
            </section>

            <section id="api" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-braces me-2"></i>REST API / OpenAPI</h2>
                </div>
                <div class="card-body">
                    <p>Available in <strong>Full</strong>.</p>

                    <div class="row g-3 mb-3">
                        <?php foreach ([
                            ['List', 'GET collection'],
                            ['Detail', 'GET record'],
                            ['Create', 'POST record'],
                            ['Update', 'PUT / PATCH'],
                            ['Delete', 'DELETE'],
                            ['Trash', 'Soft-deleted list'],
                            ['Restore', 'Restore'],
                            ['Force Delete', 'Permanent delete'],
                        ] as [$name, $description]): ?>
                            <div class="col-6 col-md-4 col-xl-3">
                                <div class="docs-feature">
                                    <strong><?= esc($name) ?></strong>
                                    <div class="small text-muted"><?= esc($description) ?></div>
                                </div>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <p class="mb-2">OpenAPI generates stable operation IDs, for example:</p>
                    <pre class="docs-code"><code>listFilm
createFilm
getFilm
updateFilm
patchFilm
deleteFilm
uploadFilm</code></pre>

                    <div class="alert alert-info mt-3 mb-0">
                        Real uploads are described as <code>multipart/form-data</code> with <code>format: binary</code>.
                    </div>
                </div>
            </section>

            <section class="card shadow-sm mb-4 docs-section">
                <div class="card-header"><h2 class="h5 mb-0"><i class="bi bi-layout-sidebar me-2"></i>Builder navigation</h2></div>
                <div class="card-body">
                    <p class="mb-0">The <strong>Parent database tables</strong> card is sticky on desktop and follows the page scroll. The table list intentionally has no internal vertical scrollbar, so the Builder keeps one predictable scroll container.</p>
                </div>
            </section>

            <section id="shield" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-shield-lock me-2"></i>Security / Shield</h2>
                </div>
                <div class="card-body">
                    <p>
                        Shield is optional and has two independent settings. Web CRUD can use session authentication,
                        while Full REST APIs can use Bearer Access Tokens.
                    </p>

                    <div class="row g-3">
                        <div class="col-12 col-lg-6">
                            <div class="border rounded p-3 h-100">
                                <strong>Web CRUD</strong>
                                <pre class="docs-code mt-2 mb-2"><code>filter: session</code></pre>
                                <div class="small text-muted">Optional permissions can be assigned to list, detail, create, update, delete and soft-delete actions.</div>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="border rounded p-3 h-100">
                                <strong>REST API</strong>
                                <pre class="docs-code mt-2 mb-2"><code>Authorization: Bearer &lt;token&gt;</code></pre>
                                <div class="small text-muted">Token authentication and API permissions remain independent from Web CRUD security.</div>
                            </div>
                        </div>
                    </div>

                    <p class="mt-3 mb-2">Example permission names:</p>
                    <pre class="docs-code"><code>film.list
film.read
film.create
film.update
film.delete
film.upload</code></pre>

                    <div class="alert alert-warning mt-3 mb-0">
                        myCrudCI4 does not install Shield automatically. If a saved configuration requires Shield
                        but the package is unavailable, generation is blocked.
                    </div>
                </div>
            </section>

            <section id="mcp" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-cpu me-2"></i>MCP</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        MCP in 2.9 is intentionally <strong>STDIO local + read-only</strong>.
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-12 col-lg-6">
                            <div class="docs-feature">
                                <strong>CRUD tools</strong>
                                <pre class="docs-code mt-2"><code>list_film
get_film</code></pre>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="docs-feature">
                                <strong>Relation tools</strong>
                                <pre class="docs-code mt-2"><code>get_film_language_id
list_film_inventory_by_film_id</code></pre>
                            </div>
                        </div>
                    </div>

                    <p>
                        MCP fields are independent from the API and use:
                        <strong>🤖 MCP visible</strong>.
                    </p>

                    <div class="docs-path mb-3">
                        App\Mcp\Resources\FilmMcpResource
                    </div>

                    <pre class="docs-code"><code>MCP client
    ↓
McpTool
    ↓
Service
    ↓
Model
    ↓
Database</code></pre>

                    <div class="row g-3 mt-1">
                        <div class="col-12 col-lg-6">
                            <div class="alert alert-light border mb-0">
                                <strong>Security boundary:</strong><br>
                                local_process / STDIO
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="alert alert-light border mb-0">
                                <strong>REST/Shield inherited:</strong><br>
                                no
                            </div>
                        </div>
                    </div>

                    <h3 class="h6 mt-4">MCP PHPDoc</h3>
                    <p class="small">
                        Generated tools keep <code>#[McpTool]</code> for discovery, name, and title.
                        Technical description, parameters, and return shape are documented
                        in standard PHPDoc so the code remains readable by IDEs and static-analysis tools.
                    </p>

                    <pre class="docs-code"><code>/**
 * Returns the read-only details of a film.
 *
 * @param string $id Record primary key.
 * @return array&lt;string,mixed&gt;
 */
#[McpTool(
    name: 'get_film',
    title: 'Get film'
)]</code></pre>

                    <pre class="docs-code mt-3"><code>php spark mycrud:mcp-serve film --no-header</code></pre>
                </div>
            </section>

            <section id="configuration" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-gear me-2"></i>Global configuration</h2>
                </div>
                <div class="card-body">
                    <div class="docs-path mb-3">app/Config/MyCrud.php</div>

                    <p>Contains shared library settings, including:</p>

                    <div class="row row-cols-1 row-cols-md-2 row-cols-xl-3 g-2">
                        <?php foreach ([
                            'generatedPath',
                            'crudConfigPath',
                            'defaultArchitecture',
                            'Pager / export',
                            'FK AJAX thresholds',
                            'Upload extensions / size',
                            'testScaffolding',
                        ] as $setting): ?>
                            <div class="col">
                                <div class="docs-feature"><code><?= esc($setting) ?></code></div>
                            </div>
                        <?php endforeach ?>
                    </div>

                    <h3 class="h6 mt-4">Per-table configuration</h3>
                    <div class="docs-path">app/MyCrudConfig/&lt;table&gt;.php</div>
                </div>
            </section>

            <section id="release" class="card shadow-sm mb-4 docs-section">
                <div class="card-header">
                    <h2 class="h5 mb-0"><i class="bi bi-flag me-2"></i>myCrudCI4 2.9.0 STABLE</h2>
                </div>
                <div class="card-body">
                    <div class="alert alert-success">
                        <strong>Status:</strong> stable release of the 2.9 line.
                        The consolidation phase is complete.
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-3">
                            <tbody>
                                <tr><th>Workflow</th><td>Builder → Config → Quick/CLI → Generateste → Diff → Publish → Test</td><td><span class="badge text-bg-success">STABLE</span></td></tr>
                                <tr><th>CRUD</th><td>Basic / Standard / Full</td><td><span class="badge text-bg-success">STABLE</span></td></tr>
                                <tr><th>API</th><td>Capabilities, OpenAPI, multipart upload</td><td><span class="badge text-bg-success">STABLE</span></td></tr>
                                <tr><th>Security</th><td>Optional Shield protection for Web CRUD and REST API</td><td><span class="badge text-bg-success">STABLE</span></td></tr>
                                <tr><th>Test</th><td>Regression + Generated Contract Tests</td><td><span class="badge text-bg-success">STABLE</span></td></tr>
                                <tr><th>MCP</th><td>STDIO locale, read-only, CRUD/relations, Resource dedicata</td><td><span class="badge text-bg-success">STABLE</span></td></tr>
                                <tr><th>Builder</th><td>Form Sections, upload, relations, API, MCP</td><td><span class="badge text-bg-success">STABLE</span></td></tr>
                            </tbody>
                        </table>
                    </div>

                    <p class="small text-muted mb-0">
                        Future features must start from this stable baseline and pass again
                        through staging, regression, and contract tests before entering a new release.
                    </p>
                </div>
            </section>
        </main>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const search = document.getElementById('docsSearch');
    const sections = Array.from(document.querySelectorAll('.docs-section'));
    const links = Array.from(document.querySelectorAll('#docsNavigation .nav-link'));

    if (!search) {
        return;
    }

    const normalize = (value) => String(value || '').toLocaleLowerCase();

    search.addEventListener('input', () => {
        const query = normalize(search.value).trim();

        sections.forEach((section) => {
            const visible = query === '' || normalize(section.innerText).includes(query);
            section.classList.toggle('d-none', !visible);
        });

        links.forEach((link) => {
            const target = document.querySelector(link.getAttribute('href'));
            link.classList.toggle('d-none', Boolean(target?.classList.contains('d-none')));
        });
    });
});
</script>

<?= $this->endSection() ?>
