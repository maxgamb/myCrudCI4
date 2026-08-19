<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>


<?php
/*
 * Parent tables: belongsTo relations of the current table.
 */
$parentTables = [];

foreach (
        $config['relations']['belongsTo'] ?? []
as $relation
) {
    $parentTable = trim(
            (string) ($relation['parentTable'] ?? '')
    );

    if ($parentTable !== '') {
        $parentTables[$parentTable] = $parentTable;
    }
}

/*
 * Child tables: hasMany relations of the current table.
 */
$childTables = [];

foreach (
        $config['relations']['hasMany'] ?? []
as $relation
) {
    $childTable = trim(
            (string) ($relation['childTable'] ?? '')
    );

    if ($childTable !== '') {
        $childTables[$childTable] = $childTable;
    }
}

ksort($parentTables);
ksort($childTables);
?>

<style>
    .mycrud-parent-tables-aside {
        position: sticky;
        top: 1rem;
        align-self: start;
        z-index: 5;
    }

    @media (max-width: 991.98px) {
        .mycrud-parent-tables-aside {
            position: static;
            top: auto;
            z-index: auto;
        }
    }
</style>

<div class="container-fluid px-3 px-lg-4">
    <div class="row g-4 align-items-start">
        <aside class="col-12 col-lg-2 col-xxl-2 mycrud-parent-tables-aside">
            <div class="card shadow-sm">
                <div class="card-header fw-semibold">
                    <i class="bi bi-diagram-2"></i>
                    Parent database tables
                </div>

                <div class="list-group list-group-flush">
                    <?php if (($databaseParentTables ?? []) === []): ?>
                        <div class="list-group-item small text-muted">
                            No parent table
                        </div>
                    <?php else: ?>
                        <?php foreach (($databaseParentTables ?? []) as $databaseParentTable): ?>
                            <a
                                class="list-group-item list-group-item-action <?= $databaseParentTable === $table ? 'active' : '' ?>"
                                href="<?= site_url('mycrud/builder/configure/' . rawurlencode((string) $databaseParentTable)) ?>"
                            >
                                <?= esc($databaseParentTable) ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </aside>

        <main class="col-12 col-lg-10 col-xxl-10">
<?php if (!empty($config['isView'])): ?>
<div class="card shadow-sm mb-4 relation-navigation">
    <div class="card-body d-flex flex-wrap justify-content-between align-items-center gap-3">
        <div>
            <div class="small text-uppercase text-muted fw-semibold mb-1">Current object</div>
            <div class="fs-5 fw-bold">
                <i class="bi bi-eye"></i>
                <?= esc($table) ?>
            </div>
        </div>
        <div class="d-flex gap-2">
            <span class="badge text-bg-info">VIEW SQL</span>
            <span class="badge text-bg-secondary">Read only</span>
        </div>
    </div>
</div>
<?php else: ?>
<div class="card shadow-sm mb-4 relation-navigation">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong>
            <i class="bi bi-share"></i>
            Relation navigation
        </strong>

        <span class="badge bg-primary">
            <?= count($parentTables) ?>
            parents
            ·
            <?= count($childTables) ?>
            children
        </span>
    </div>

    <div class="card-body">
        <div class="row g-3 align-items-stretch">

            <!-- PARENT TABLES -->
            <div class="col-12 col-lg-4">
                <div class="relation-group h-100">

                    <div class="small text-uppercase text-muted fw-semibold mb-2">
                        <i class="bi bi-arrow-left"></i>
                        Parent tables
                    </div>

                    <div class="d-flex flex-wrap gap-2">

                        <?php if ($parentTables === []): ?>

                            <span class="text-muted small">
                                No parent table
                            </span>

                        <?php else: ?>

                            <?php
                            foreach (
                                    $config['relations']['belongsTo'] ?? []
                            as $foreignKey => $relation
                            ):
                                ?>
                                <?php
                                $parentTable = (string) (
                                        $relation['parentTable'] ?? ''
                                );
                                ?>

                                <a
                                    href="<?=
                                    site_url(
                                            'mycrud/builder/configure/'
                                            . rawurlencode($parentTable)
                                    )
                                    ?>"
                                    class="btn btn-sm btn-outline-info"
                                    >
                                    <i class="bi bi-box-arrow-up-left"></i>

                                        <?= esc($parentTable) ?>

                                    <span class="badge text-bg-light ms-1">
                                <?= esc($foreignKey) ?>
                                    </span>
                                </a>
    <?php endforeach; ?>

<?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- CURRENT TABLE -->
            <div class="col-12 col-lg-4">
                <div class="relation-current h-100 text-center">

                    <div class="small text-uppercase text-muted fw-semibold mb-2">
                        Current table
                    </div>

                    <div class="fs-5 fw-bold">
                        <i class="bi bi-table"></i>
                        <?= esc($table) ?>
                    </div>

                    <div class="small text-muted mt-1">
<?= esc($config['primaryKey'] ?? 'id') ?>
                    </div>
                </div>
            </div>

            <!-- CHILD TABLES -->
            <div class="col-12 col-lg-4">
                <div class="relation-group h-100">

                    <div class="small text-uppercase text-muted fw-semibold mb-2">
                        Child tables
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <?php if ($childTables === []): ?>
                            <span class="text-muted small">
                                No child table
                            </span>
                        <?php else: ?>

                            <?php
                            foreach (
                                    $config['relations']['hasMany'] ?? []
                            as $relation
                            ):
                                ?>
                                <?php
                                $childTable = (string) (
                                        $relation['childTable'] ?? ''
                                );

                                $foreignKey = (string) (
                                        $relation['foreignKey'] ?? ''
                                );
                                ?>

                                <a
                                    href="<?=
                                site_url(
                                        'mycrud/builder/configure/'
                                        . rawurlencode($childTable)
                                )
                                ?>"
                                    class="btn btn-sm btn-outline-success"
                                    >
        <?= esc($childTable) ?>

                                    <span class="badge text-bg-light ms-1">
                                <?= esc($foreignKey) ?>
                                    </span>

                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
    <?php endforeach; ?>

<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>
<!--CORPO-->


<div class="container-fluid py-4 px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-sliders"></i>
                Configure <?= !empty($config['isView']) ? 'view' : 'table' ?>: <?= esc($table) ?>
                <?php if (!empty($config['isView'])): ?>
                    <span class="badge text-bg-info align-middle ms-2">VIEW SQL</span>
                    <span class="badge text-bg-secondary align-middle">Read only</span>
                <?php endif; ?>
            </h1>
            <small class="text-muted">
                Configure the application intent first. Drag fields to change their generated order; technical options are grouped as advanced settings.
            </small>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary" id="expandAllTop">
                <i class="bi bi-arrows-expand"></i> Expand
            </button>
            <button type="button" class="btn btn-outline-secondary" id="collapseAllTop">
                <i class="bi bi-arrows-collapse"></i> Collapse
            </button>
            <button type="button" class="btn btn-primary" id="showPreview">
                <i class="bi bi-eye"></i> Preview
            </button>
        </div>
    </div>

    <?php if (session('message')): ?>
        <div class="alert alert-success"><?= esc(session('message')) ?></div>
<?php endif; ?>

        <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
<?php endif; ?>

    <div class="card border-primary-subtle bg-primary-subtle mb-4">
        <div class="card-body py-3">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                <div>
                    <div class="fw-semibold"><i class="bi bi-signpost-split me-1"></i>Recommended workflow</div>
                    <div class="small text-body-secondary mt-1">
                        1. Choose architecture &nbsp;→&nbsp; 2. Configure relations and form layout &nbsp;→&nbsp; 3. Review fields &nbsp;→&nbsp; 4. Save, then generate to staging.
                    </div>
                </div>
                <span class="badge text-bg-primary">
                    <?= esc(ucfirst((string) ($config['architecture'] ?? 'basic'))) ?> architecture
                </span>
            </div>
        </div>
    </div>

    <?php if (!empty($config['isView'])): ?>
        <div class="alert alert-info d-flex gap-2 align-items-start" role="alert">
            <i class="bi bi-eye mt-1"></i>
            <div>
                <strong>SQL VIEW detected.</strong>
                myCrudCI4 generates a read-only scaffold: list, filters, pagination, export
                and, with Full architecture, GET API. Create, Edit, Delete, Soft Delete, and relations for
                write operations are not generated. The underlying VIEW is not modified.
            </div>
        </div>
    <?php endif; ?>

    <style>
        .builder-section-anchor {
            scroll-margin-top: 88px;
        }

        .field-block[hidden] {
            display: none !important;
        }

        .field-block .card-header {
            cursor: default;
        }

        .builder-config-layout {
            display: grid;
            grid-template-columns: 210px minmax(0, 1fr);
            gap: 1rem;
            align-items: start;
            width: 100%;
        }

        .builder-config-nav {
            min-width: 0;
            align-self: start;
            position: sticky;
            top: 1rem;
            z-index: 10;
            max-height: calc(100vh - 2rem);
            overflow-y: auto;
            overscroll-behavior: contain;
            scrollbar-width: thin;
        }

        .builder-config-content {
            min-width: 0;
            width: 100%;
        }

        .builder-config-sidebar {
            position: static;
            max-height: none;
            overflow: visible;
        }

        .builder-config-sidebar .list-group-item {
            border-left: 0;
            border-right: 0;
            white-space: nowrap;
        }

        .builder-config-sidebar .list-group-item:first-child {
            border-top: 0;
        }

        .builder-config-sidebar .list-group-item:last-child {
            border-bottom: 0;
        }

        .builder-nav-status {
            min-width: 3.25rem;
            text-align: center;
            font-weight: 500;
        }

        .builder-nav-status.is-active {
            color: var(--bs-success-text-emphasis);
            background: var(--bs-success-bg-subtle) !important;
            border-color: var(--bs-success-border-subtle) !important;
        }

        @media (max-width: 1199.98px) {
            .builder-config-layout {
                grid-template-columns: 1fr;
            }

            .builder-config-nav {
                position: static;
                top: auto;
                z-index: auto;
                max-height: none;
                overflow: visible;
            }

            .builder-config-sidebar .list-group {
                display: flex;
                flex-direction: row;
                flex-wrap: wrap;
            }

            .builder-config-sidebar .list-group-item {
                width: auto;
                border: 1px solid var(--bs-border-color);
                margin: 0 .25rem .25rem 0;
                border-radius: var(--bs-border-radius);
            }

            .builder-config-sidebar .builder-nav-group {
                display: none;
            }
        }
    </style>

    <?php
    $builderStatusArchitecture = ucfirst((string) ($config['architecture'] ?? 'basic'));
    $builderStatusRelations = !empty($config['features']['relations']) ? 'On' : 'Off';
    $builderStatusSections = count(array_values((array) ($config['formSections'] ?? [])));
    $builderStatusFields = count((array) ($config['fields'] ?? []));
    $builderStatusApi = ((string) ($config['architecture'] ?? 'basic')) === 'full' ? 'Full' : 'Off';
    $builderShieldInstalled = class_exists(\CodeIgniter\Shield\Filters\TokenAuth::class);
    $builderCrudShieldAuth = (string) ($config['crudSecurity']['auth'] ?? 'none');
    $builderApiShieldAuth = (string) ($config['apiSecurity']['auth'] ?? 'none');
    $builderStatusShield = ($builderCrudShieldAuth === 'shield_session' && $builderApiShieldAuth === 'shield_tokens')
        ? 'Web + API'
        : ($builderCrudShieldAuth === 'shield_session'
            ? 'Web'
            : ($builderApiShieldAuth === 'shield_tokens' ? 'API' : ($builderShieldInstalled ? 'Ready' : 'Missing')));
    $builderStatusMcp = !empty($config['mcp']['enabled']) ? 'On' : 'Off';
    ?>

    <form method="post" id="builderForm">
        <input
            type="hidden"
            name="fieldsConfigJson"
            id="fieldsConfigJson"
            value=""
        >
        <input
            type="hidden"
            name="fieldOrderJson"
            id="fieldOrderJson"
            value="<?= esc(json_encode(array_values((array) ($config['order'] ?? [])), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>"
        >
<?= csrf_field() ?>
        <input type="hidden" name="table" value="<?= esc($table) ?>">

        <div class="builder-config-layout">
            <aside class="builder-config-nav">
                <div class="card shadow-sm builder-config-sidebar">
                    <div class="card-header fw-semibold">
                        <i class="bi bi-list-ul me-1"></i>
                        Configuration
                    </div>
                    <div class="list-group list-group-flush">
                        <div class="list-group-item py-2 small text-uppercase text-muted fw-semibold bg-body-tertiary builder-nav-group">Core workflow</div>
                        <a class="list-group-item list-group-item-action py-2 d-flex align-items-center justify-content-between gap-2" href="#builder-architecture">
                            <span><i class="bi bi-box me-2"></i>Architecture</span>
                            <span class="badge text-bg-light border builder-nav-status" id="builderStatusArchitecture"><?= esc($builderStatusArchitecture) ?></span>
                        </a>
                        <a class="list-group-item list-group-item-action py-2 d-flex align-items-center justify-content-between gap-2" href="#builder-relations">
                            <span><i class="bi bi-diagram-3 me-2"></i>Relations</span>
                            <span class="badge text-bg-light border builder-nav-status" id="builderStatusRelations"><?= esc($builderStatusRelations) ?></span>
                        </a>
                        <a class="list-group-item list-group-item-action py-2 d-flex align-items-center justify-content-between gap-2" href="#builder-form-sections">
                            <span><i class="bi bi-layout-text-window-reverse me-2"></i>Form Sections</span>
                            <span class="badge text-bg-light border builder-nav-status" id="builderStatusSections"><?= $builderStatusSections ?></span>
                        </a>
                        <a class="list-group-item list-group-item-action py-2 d-flex align-items-center justify-content-between gap-2" href="#builder-fields">
                            <span><i class="bi bi-input-cursor-text me-2"></i>Fields</span>
                            <span class="badge text-bg-light border builder-nav-status" id="builderStatusFields"><?= $builderStatusFields ?></span>
                        </a>
                        <a class="list-group-item list-group-item-action py-2 d-flex align-items-center justify-content-between gap-2" href="#builder-generation">
                            <span><i class="bi bi-gear me-2"></i>Generation</span>
                            <span class="badge text-bg-light border builder-nav-status">Staging</span>
                        </a>
                        <div class="list-group-item py-2 small text-uppercase text-muted fw-semibold bg-body-tertiary builder-nav-group">Advanced</div>
                        <a class="list-group-item list-group-item-action py-2 d-flex align-items-center justify-content-between gap-2" href="#builder-shield">
                            <span><i class="bi bi-shield-lock me-2"></i>Shield</span>
                            <span class="badge text-bg-light border builder-nav-status" id="builderStatusShield"><?= esc($builderStatusShield) ?></span>
                        </a>
                        <a class="list-group-item list-group-item-action py-2 d-flex align-items-center justify-content-between gap-2" href="#builder-api">
                            <span><i class="bi bi-braces me-2"></i>API</span>
                            <span class="badge text-bg-light border builder-nav-status" id="builderStatusApi"><?= esc($builderStatusApi) ?></span>
                        </a>
                        <a class="list-group-item list-group-item-action py-2 d-flex align-items-center justify-content-between gap-2" href="#builder-mcp">
                            <span><i class="bi bi-cpu me-2"></i>MCP</span>
                            <span class="badge text-bg-light border builder-nav-status" id="builderStatusMcp"><?= esc($builderStatusMcp) ?></span>
                        </a>
                    </div>
                </div>
            </aside>

            <div class="builder-config-content">
        <div class="card shadow-sm mb-4 builder-section-anchor" id="builder-architecture">
            <div class="card-header d-flex align-items-center justify-content-between gap-2">
                <strong>Architecture</strong>
                <span class="badge text-bg-light border" id="builderHeaderArchitecture"><?= esc($builderStatusArchitecture) ?></span>
            </div>

            <div class="card-body">
                <?php $selectedArchitecture = (string) ($config['architecture'] ?? 'basic'); ?>
                <div class="row g-3">
                    <?php foreach ([
                        'basic' => [
                            'title' => 'Basic',
                            'icon' => 'bi-box',
                            'description' => !empty($config['isView']) ? 'Read-only access: Model, Controller, Views, CI4 Pager, filters, and export.' : 'CRUD, validation, Bootstrap AJAX, CI4 Pager, indexed filters, CSV and Word HTML.',
                        ],
                        'standard' => [
                            'title' => 'Standard',
                            'icon' => 'bi-layers',
                            'description' => !empty($config['isView']) ? 'Everything in Basic, with Entity and Service as an extensible scaffold.' : 'Everything in Basic, with Entity and Service.',
                        ],
                        'full' => [
                            'title' => 'Full',
                            'icon' => 'bi-rocket-takeoff',
                            'description' => !empty($config['isView']) ? 'Everything in Standard, with GET API, Resource, and read-only OpenAPI.' : 'Everything in Standard, with REST API v1, Resource, API validation, and OpenAPI.',
                        ],
                    ] as $value => $architecture): ?>
                        <div class="col-12 col-lg-4">
                            <label class="card h-100 border architecture-card <?= $selectedArchitecture === $value ? 'border-primary' : '' ?>">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input architecture-radio"
                                            type="radio"
                                            name="architecture"
                                            id="architecture_<?= esc($value) ?>"
                                            value="<?= esc($value) ?>"
                                            <?= $selectedArchitecture === $value ? 'checked' : '' ?>
                                        >
                                        <span class="form-check-label fw-bold">
                                            <i class="bi <?= esc($architecture['icon']) ?>"></i>
                                            <?= esc($architecture['title']) ?>
                                        </span>
                                    </div>
                                    <p class="small text-muted mt-2 mb-0">
                                        <?= esc($architecture['description']) ?>
                                    </p>
                                </div>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <hr>

                <?php if (!empty($config['isView'])): ?>
                    <div class="alert alert-light border mb-0">
                        <i class="bi bi-lock"></i>
                        Foreign-key relations, CRUD-managed timestamps, and soft delete do not apply to a VIEW.
                    </div>
                <?php else: ?>
                <div class="row g-3">
                    <?php
                    $featureLabels = [
                        'relations' => 'Relations FK',
                        'timestamps' => 'Timestamp',
                        'softDeletes' => 'Soft delete',
                    ];
                    ?>

                    <?php foreach ($featureLabels as $feature => $label): ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input feature-check"
                                    type="checkbox"
                                    name="features[<?= esc($feature) ?>]"
                                    value="1"
                                    id="feature_<?= esc($feature) ?>"
                                    <?= !empty($config['features'][$feature]) ? 'checked' : '' ?>
                                    <?= (($feature === 'softDeletes' && empty($config['softDelete']['available'])) || (!empty($config['isView']) && in_array($feature, ['relations', 'softDeletes'], true))) ? 'disabled' : '' ?>
                                >
                                <label class="form-check-label" for="feature_<?= esc($feature) ?>">
                                    <?= esc($label) ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <?php endif; ?>

                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i>
                    <?php if (!empty($config['isView'])): ?>
                        The VIEW uses the same list engine: Bootstrap AJAX, CI4 Pager, configurable server-side filters,
                        CSV and Word HTML. Full adds GET API, Resource, and read-only OpenAPI.
                    <?php else: ?>
                        The list engine is shared: Bootstrap AJAX, CI4 Pager, indexed server-side filters,
                        CSV and Word HTML. The differences concern the Entity, Service, and API layers.
                    <?php endif; ?>
                </div>

                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <label for="filtersSummary" class="form-label">Filter section title</label>
                        <input
                            type="text"
                            class="form-control"
                            id="filtersSummary"
                            name="list[filtersSummary]"
                            value="<?= esc($config['list']['filtersSummary'] ?? 'Search filters') ?>"
                            maxlength="120"
                        >
                    </div>
                </div>
            </div>
        </div>



        <div class="card shadow-sm mb-4 builder-section-anchor" id="builder-api">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong><i class="bi bi-braces me-1"></i> API Capabilities</strong>
                <span class="badge text-bg-secondary">Advanced · Full</span>
            </div>
            <div class="card-body pt-2">
                <details class="builder-advanced-details">
                    <summary class="fw-semibold py-1"><i class="bi bi-chevron-right me-1"></i>Configure API <span class="text-muted fw-normal ms-1">Open only when Full API behavior needs customization.</span></summary>
                    <div class="pt-3">
                <?php
                $apiCapabilities = (array) ($config['apiCapabilities'] ?? []);
                $apiCapabilityLabels = [
                    'list' => ['List', 'GET paginated list'],
                    'read' => ['Detail', 'GET single record'],
                    'create' => ['Create', 'POST new record'],
                    'update' => ['Update', 'PUT/PATCH record'],
                    'delete' => ['Delete', 'DELETE record'],
                    'trash' => ['Trash', 'GET deleted records'],
                    'restore' => ['Restore', 'POST restore'],
                    'forceDelete' => ['Force Delete', 'DELETE permanently'],
                ];
                $apiCapabilityAvailable = [
                    'list' => true,
                    'read' => !empty($config['features']['recordDetail']),
                    'create' => !empty($config['features']['createAllowed']),
                    'update' => !empty($config['features']['writable']) && !empty($config['features']['recordDetail']),
                    'delete' => !empty($config['features']['writable']) && !empty($config['features']['recordDetail']),
                    'trash' => !empty($config['features']['writable']) && !empty($config['features']['softDeletes']),
                    'restore' => !empty($config['features']['writable']) && !empty($config['features']['softDeletes']),
                    'forceDelete' => !empty($config['features']['writable']) && !empty($config['features']['softDeletes']),
                ];
                ?>
                <p class="text-muted small">
                    REST operations are independent from web CRUD actions.
                    Routes, ApiController, OpenAPI e test generati usano la stessa capability map.
                </p>

                <div class="row g-3" id="apiCapabilitiesGrid">
                    <?php foreach ($apiCapabilityLabels as $capability => [$label, $description]): ?>
                        <?php $available = !empty($apiCapabilityAvailable[$capability]); ?>
                        <div class="col-12 col-md-6 col-xl-3">
                            <div class="border rounded p-3 h-100 <?= $available ? '' : 'bg-body-tertiary text-muted' ?>">
                                <div class="form-check form-switch">
                                    <input
                                        class="form-check-input api-capability-check"
                                        type="checkbox"
                                        name="apiCapabilities[<?= esc($capability) ?>]"
                                        value="1"
                                        id="api_capability_<?= esc($capability) ?>"
                                        data-schema-available="<?= $available ? '1' : '0' ?>"
                                        <?= !empty($apiCapabilities[$capability]) ? 'checked' : '' ?>
                                        <?= $available ? '' : 'disabled' ?>
                                    >
                                    <label class="form-check-label fw-semibold" for="api_capability_<?= esc($capability) ?>">
                                        <?= esc($label) ?>
                                    </label>
                                </div>
                                <div class="small mt-1"><?= esc($description) ?></div>
                            </div>
                        </div>
                    <?php endforeach ?>
                </div>

                <div class="alert alert-light border mt-3">
                    <strong>Full default:</strong> all schema-compatible capabilities are enabled.
                    Disabling a capability removes the related route and OpenAPI operation.
                </div>

                    </div>
                </details>
            </div>
        </div>

        <?php
        $crudSecurity = (array) ($config['crudSecurity'] ?? []);
        $crudAuth = (string) ($crudSecurity['auth'] ?? 'none');
        $crudPermissions = (array) ($crudSecurity['permissions'] ?? []);
        $apiSecurity = (array) ($config['apiSecurity'] ?? []);
        $apiAuth = (string) ($apiSecurity['auth'] ?? 'none');
        $apiPermissions = (array) ($apiSecurity['permissions'] ?? []);
        $shieldInstalled = class_exists(\CodeIgniter\Shield\Filters\TokenAuth::class);
        $securityCapabilities = [
            'list' => 'List',
            'read' => 'Detail',
            'create' => 'Create',
            'update' => 'Update',
            'delete' => 'Delete',
            'trash' => 'Trash',
            'restore' => 'Restore',
            'forceDelete' => 'Force Delete',
        ];
        if (array_filter(
            (array) ($config['fields'] ?? []),
            static fn (array $field): bool => in_array(
                strtolower((string) ($field['inputType'] ?? '')),
                ['file', 'image'],
                true
            )
        ) !== []) {
            $securityCapabilities['upload'] = 'Upload';
        }
        ?>

        <div class="card shadow-sm mb-4 builder-section-anchor" id="builder-shield">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <strong><i class="bi bi-shield-lock me-1"></i> Security / Shield</strong>
                    <div class="small text-muted mt-1">Independent Shield protection for Web CRUD and REST API.</div>
                </div>
                <div class="d-flex align-items-center gap-2">
                    <span class="badge text-bg-secondary">Advanced · Full</span>
                    <?php if ($shieldInstalled): ?>
                        <span class="badge text-bg-success">Shield detected</span>
                    <?php else: ?>
                        <span class="badge text-bg-secondary">Shield not installed</span>
                    <?php endif ?>
                </div>
            </div>
            <div class="card-body">
                <h3 class="h6 mb-1"><i class="bi bi-window me-1"></i>Web CRUD</h3>
                <div class="small text-muted mb-3">Session authentication and optional action permissions for generated browser routes.</div>

                <div class="row g-3">
                    <div class="col-12 col-xl-4">
                        <label class="form-label" for="crud_security_auth">Web authentication</label>
                        <select class="form-select" id="crud_security_auth" name="crudSecurity[auth]">
                            <option value="none" <?= $crudAuth === 'none' ? 'selected' : '' ?>>None</option>
                            <option value="shield_session" <?= $crudAuth === 'shield_session' ? 'selected' : '' ?> <?= $shieldInstalled ? '' : 'disabled' ?>>Shield — Session</option>
                        </select>
                        <div class="form-text">Uses Shield's <code>session</code> filter on the generated CRUD route group.</div>
                    </div>
                    <div class="col-12 col-xl-8">
                        <div class="alert alert-info mb-0">Optional permissions add explicit <code>permission:name.permission</code> filters to individual CRUD routes.</div>
                    </div>
                </div>

                <?php $crudSecurityCapabilities = [
                    'list' => 'List / Export',
                    'read' => 'Detail',
                    'create' => 'Create',
                    'update' => 'Edit / Update',
                    'delete' => 'Delete',
                    'trash' => 'Trash',
                    'restore' => 'Restore',
                    'forceDelete' => 'Force Delete',
                ]; ?>
                <div class="table-responsive mt-3">
                    <table class="table table-sm align-middle mb-0">
                        <thead><tr><th>Web capability</th><th>Optional Shield permission</th></tr></thead>
                        <tbody>
                        <?php foreach ($crudSecurityCapabilities as $capability => $label): ?>
                            <tr>
                                <th class="text-nowrap"><?= esc($label) ?></th>
                                <td><input type="text" class="form-control form-control-sm crud-permission-input" name="crudSecurity[permissions][<?= esc($capability) ?>]" value="<?= esc((string) ($crudPermissions[$capability] ?? '')) ?>" placeholder="Example: <?= esc($table) ?>.<?= esc(strtolower($capability)) ?>" pattern="[A-Za-z0-9][A-Za-z0-9._-]*" <?= $shieldInstalled ? '' : 'disabled' ?>></td>
                            </tr>
                        <?php endforeach ?>
                        </tbody>
                    </table>
                </div>

                <hr class="my-4">
                <h3 class="h6 mb-1"><i class="bi bi-braces me-1"></i>REST API</h3>
                <div class="small text-muted mb-3">Bearer token authentication and optional permissions. Available with Full architecture.</div>
                <?php if ((string) ($config['architecture'] ?? 'basic') !== 'full'): ?>
                    <div class="alert alert-light border">REST API Shield settings are applied when <strong>Full</strong> architecture is enabled.</div>
                <?php endif ?>

                <div class="row g-3">
                    <div class="col-12 col-xl-4">
                        <label class="form-label" for="api_security_auth">API authentication</label>
                        <select class="form-select" id="api_security_auth" name="apiSecurity[auth]">
                            <option value="none" <?= $apiAuth === 'none' ? 'selected' : '' ?>>None</option>
                            <option
                                value="shield_tokens"
                                <?= $apiAuth === 'shield_tokens' ? 'selected' : '' ?>
                                <?= $shieldInstalled ? '' : 'disabled' ?>
                            >
                                Shield — Bearer Access Token
                            </option>
                        </select>
                        <div class="form-text">
                            Uses Shield's <code>tokens</code> filter and <code>Authorization: Bearer ...</code>.
                        </div>
                    </div>

                    <div class="col-12 col-xl-8">
                        <?php if (!$shieldInstalled): ?>
                            <div class="alert alert-warning mb-0">
                                Install and configure the official CodeIgniter Shield package to enable token authentication. myCrudCI4 keeps Shield optional.
                            </div>
                        <?php else: ?>
                            <div class="alert alert-info mb-0">
                                Permissions are optional. Empty permissions require only token authentication; configured permissions add the explicit <code>permission:name.permission</code> route filter.
                            </div>
                        <?php endif ?>
                    </div>
                </div>

                <div class="table-responsive mt-3">
                    <table class="table table-sm align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Capability</th>
                                <th>Optional Shield permission</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($securityCapabilities as $capability => $label): ?>
                                <tr>
                                    <th class="text-nowrap"><?= esc($label) ?></th>
                                    <td>
                                        <input
                                            type="text"
                                            class="form-control form-control-sm api-permission-input"
                                            name="apiSecurity[permissions][<?= esc($capability) ?>]"
                                            value="<?= esc((string) ($apiPermissions[$capability] ?? '')) ?>"
                                            placeholder="Example: <?= esc($table) ?>.<?= esc(strtolower($capability)) ?>"
                                            pattern="[A-Za-z0-9][A-Za-z0-9._-]*"
                                            <?= $shieldInstalled ? '' : 'disabled' ?>
                                        >
                                    </td>
                                </tr>
                            <?php endforeach ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="card shadow-sm mb-4 builder-section-anchor" id="builder-mcp">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong><i class="bi bi-cpu me-1"></i> MCP Foundation</strong>
                <span class="badge text-bg-secondary">Advanced · Optional</span>
            </div>
            <div class="card-body pt-2">
                <details class="builder-advanced-details">
                    <summary class="fw-semibold py-1"><i class="bi bi-chevron-right me-1"></i>Configure MCP <span class="text-muted fw-normal ms-1">Optional integration; closed by default.</span></summary>
                    <div class="pt-3">
                <?php $mcpConfig = (array) ($config['mcp'] ?? []); ?>

                <div class="row g-3">
                    <div class="col-12 col-xl-4">
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="mcp[enabled]"
                                value="1"
                                id="mcp_enabled"
                                <?= !empty($mcpConfig['enabled']) ? 'checked' : '' ?>
                            >
                            <label class="form-check-label fw-semibold" for="mcp_enabled">
                                Enable MCP for this table
                            </label>
                        </div>

                        <div class="form-text">
                            Generates the MCP manifest, read-only CRUD tools, relation tools, and dedicated MCP Resource.
                        </div>
                    </div>

                    <div class="col-12 col-xl-4">
                        <label class="form-label" for="mcp_server_name">Server name</label>
                        <input
                            type="text"
                            class="form-control"
                            id="mcp_server_name"
                            name="mcp[serverName]"
                            maxlength="80"
                            value="<?= esc((string) ($mcpConfig['serverName'] ?? 'myCrudCI4')) ?>"
                        >
                    </div>

                    <div class="col-6 col-xl-2">
                        <label class="form-label">Transport</label>
                        <input class="form-control" value="STDIO" readonly>
                    </div>

                    <div class="col-6 col-xl-2">
                        <label class="form-label">Mode</label>
                        <input class="form-control" value="Read only" readonly>
                    </div>
                </div>

                <?php $mcpCapabilities = (array) ($mcpConfig['capabilities'] ?? []); ?>

                <div class="row g-3 mt-1">
                    <div class="col-12 col-md-6 col-xl-3">
                        <div class="border rounded p-3 h-100">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="mcp[capabilities][list]"
                                    value="1"
                                    id="mcp_capability_list"
                                    <?= !empty($mcpCapabilities['list']) ? 'checked' : '' ?>
                                >
                                <label class="form-check-label fw-semibold" for="mcp_capability_list">
                                    List
                                </label>
                            </div>
                            <div class="small text-muted mt-1">
                                Generates <code>list_<?= esc($table) ?></code>.
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <?php $mcpReadAvailable = !empty($config['features']['recordDetail']); ?>
                        <div class="border rounded p-3 h-100 <?= $mcpReadAvailable ? '' : 'bg-body-tertiary text-muted' ?>">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="mcp[capabilities][read]"
                                    value="1"
                                    id="mcp_capability_read"
                                    <?= !empty($mcpCapabilities['read']) ? 'checked' : '' ?>
                                    <?= $mcpReadAvailable ? '' : 'disabled' ?>
                                >
                                <label class="form-check-label fw-semibold" for="mcp_capability_read">
                                    Detail
                                </label>
                            </div>
                            <div class="small text-muted mt-1">
                                Generates <code>get_<?= esc($table) ?></code>.
                            </div>
                        </div>
                    </div>

                    <div class="col-12 col-md-6 col-xl-3">
                        <?php
                        $mcpRelationsAvailable = !empty($config['features']['relations'])
                            && (
                                (array) ($config['relations']['belongsTo'] ?? []) !== []
                                || array_filter(
                                    (array) ($config['relationsConfig']['hasMany'] ?? []),
                                    static fn (array $relation): bool => !empty($relation['enabled'])
                                ) !== []
                            );
                        ?>
                        <div class="border rounded p-3 h-100 <?= $mcpRelationsAvailable ? '' : 'bg-body-tertiary text-muted' ?>">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input"
                                    type="checkbox"
                                    name="mcp[capabilities][relations]"
                                    value="1"
                                    id="mcp_capability_relations"
                                    <?= !empty($mcpCapabilities['relations']) ? 'checked' : '' ?>
                                    <?= $mcpRelationsAvailable ? '' : 'disabled' ?>
                                >
                                <label class="form-check-label fw-semibold" for="mcp_capability_relations">
                                    Relations
                                </label>
                            </div>
                            <div class="small text-muted mt-1">
                                Generates read-only tools for enabled foreign keys and hasMany relations.
                            </div>
                        </div>
                    </div>
                </div>

                <div class="alert alert-success mt-3 mb-0">
                    <strong>Field configuration:</strong>
                    MCP resta locale/STDIO e read-only. Non eredita automaticamente Shield/API.
                    Exposed fields are controlled by <em>MCP visible</em>,
                    independently from <em>API visible</em>.
                    For the STDIO runtime, use <code>php spark mycrud:mcp-serve <?= esc($table) ?> --no-header</code>.
                </div>
                    </div>
                </details>
            </div>
        </div>

<div id="builder-relations" class="builder-section-anchor"></div>

<?php if (!empty($config['relationsConfig']['hasMany'])): ?>

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <strong>
                        <i class="bi bi-diagram-3"></i>
                        Child relations (hasMany scaffolding)
                    </strong>
                </div>

                <div class="card-body">

                    <div class="row g-3">

    <?php
    foreach (
            $config['relationsConfig']['hasMany']
    as $relationKey => $relation
    ):
        $isPivotHasMany = array_filter(
            (array) ($config['relationsConfig']['manyToMany'] ?? []),
            static fn (array $m2m): bool =>
                (string) ($m2m['pivotTable'] ?? '') === (string) ($relation['childTable'] ?? '')
        ) !== [];
        ?>

                            <div class="col-12 col-lg-6 col-xxl-4">

                                <div class="card h-100 border shadow-sm">

                                    <div class="card-header d-flex justify-content-between align-items-center">

                                        <div>
                                            <strong>
        <?= esc($relation['title']) ?>
                                            </strong>

                                            <div class="small text-muted">
        <?= esc($relation['childTable']) ?>.
        <?= esc($relation['foreignKey']) ?>
                                            </div>
                                            <?php if ($isPivotHasMany): ?>
                                                <div class="mt-1 mb-1">
                                                    <span class="badge text-bg-info">
                                                        <i class="bi bi-tools me-1"></i>Technical pivot
                                                    </span>
                                                </div>
                                                <div class="small text-primary mt-1">
                                                    <i class="bi bi-diagram-2 me-1"></i>
                                                    <strong>Technical pivot hasMany.</strong>
                                                    Disabled by default because the same pivot is represented as a many-to-many relation below.
                                                    Enable it only if you also want to expose the pivot table itself as a child panel.
                                                </div>
                                            <?php endif ?>
                                        </div>

                                        <div class="form-check form-switch mb-0">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="relationsConfig[hasMany][<?= esc($relationKey) ?>][enabled]"
                                                value="1"
                                                id="relation_enabled_<?= esc(md5($relationKey)) ?>"
        <?=
        !empty($relation['enabled']) ? 'checked' : ''
        ?>
                                                >

                                            <label
                                                class="form-check-label"
                                                for="relation_enabled_<?= esc(md5($relationKey)) ?>"
                                                >
                                                Enabled
                                            </label>
                                        </div>
                                    </div>

                                    <div class="card-body">

                                        <div class="row g-3">

                                            <div class="col-12">

                                                <label class="form-label">
                                                    Title
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="relationsConfig[hasMany][<?= esc($relationKey) ?>][title]"
                                                    value="<?= esc($relation['title']) ?>"
                                                    >
                                            </div>

                                            <div class="col-md-8">

                                                <label class="form-label">
                                                    Icon
                                                </label>

                                                <div class="input-group">

                                                    <span class="input-group-text">
                                                        <i class="bi <?=
        esc(
                $relation['icon'] ?? 'bi-diagram-3'
        )
        ?>"></i>
                                                    </span>

                                                    <input
                                                        type="text"
                                                        class="form-control relation-icon-input"
                                                        name="relationsConfig[hasMany][<?= esc($relationKey) ?>][icon]"
                                                        value="<?=
        esc(
                $relation['icon'] ?? 'bi-diagram-3'
        )
        ?>"
                                                        >
                                                </div>
                                            </div>

                                            <div class="col-md-4">

                                                <label class="form-label">
                                                    Limit
                                                </label>

                                                <input
                                                    type="number"
                                                    min="1"
                                                    max="200"
                                                    class="form-control"
                                                    name="relationsConfig[hasMany][<?= esc($relationKey) ?>][limit]"
                                                    value="<?=
        (int) (
        $relation['limit'] ?? 20
        )
        ?>"
                                                    >
                                            </div>

                                            <div class="col-12">

                                                <div class="form-check">

                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="relationsConfig[hasMany][<?= esc($relationKey) ?>][showCount]"
                                                        value="1"
                                                        id="relation_count_<?= esc(md5($relationKey)) ?>"
        <?=
        !empty($relation['showCount']) ? 'checked' : ''
        ?>
                                                        >

                                                    <label
                                                        class="form-check-label"
                                                        for="relation_count_<?= esc(md5($relationKey)) ?>"
                                                        >
                                                        Show count
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="relationsConfig[hasMany][<?= esc($relationKey) ?>][collapsible]"
                                                        value="1" id="relation_collapse_<?= esc(md5($relationKey)) ?>"
                                                        <?= !empty($relation['collapsible']) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="relation_collapse_<?= esc(md5($relationKey)) ?>">
                                                        <i class="bi bi-arrows-collapse me-1"></i>Collapsible child panel
                                                    </label>
                                                </div>

                                                <div class="form-check">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="relationsConfig[hasMany][<?= esc($relationKey) ?>][collapsed]"
                                                        value="1" id="relation_collapsed_<?= esc(md5($relationKey)) ?>"
                                                        <?= !empty($relation['collapsed']) ? 'checked' : '' ?>>
                                                    <label class="form-check-label" for="relation_collapsed_<?= esc(md5($relationKey)) ?>">
                                                        <i class="bi bi-chevron-right me-1"></i>Collapsed by default
                                                    </label>
                                                </div>

                                                <div class="form-check">

                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="relationsConfig[hasMany][<?= esc($relationKey) ?>][showCreateButton]"
                                                        value="1"
                                                        id="relation_create_<?= esc(md5($relationKey)) ?>"
        <?=
        !empty($relation['showCreateButton']) ? 'checked' : ''
        ?>
        <?=
        empty($relation['childCreateAllowed']) ? 'disabled' : ''
        ?>
                                                        >

                                                    <label
                                                        class="form-check-label"
                                                        for="relation_create_<?= esc(md5($relationKey)) ?>"
                                                        >
                                                        New child button
                                                    </label>
                                                </div>

                                                <div class="form-check">

                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="relationsConfig[hasMany][<?= esc($relationKey) ?>][showViewAllButton]"
                                                        value="1"
                                                        id="relation_all_<?= esc(md5($relationKey)) ?>"
        <?=
        !empty($relation['showViewAllButton']) ? 'checked' : ''
        ?>
                                                        >

                                                    <label
                                                        class="form-check-label"
                                                        for="relation_all_<?= esc(md5($relationKey)) ?>"
                                                        >
                                                        View all button
                                                    </label>
                                                </div>

                                                <div class="form-check">

                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="relationsConfig[hasMany][<?= esc($relationKey) ?>][showViewButton]"
                                                        value="1"
                                                        id="relation_view_<?= esc(md5($relationKey)) ?>"
        <?=
        !empty($relation['showViewButton']) ? 'checked' : ''
        ?>
                                                        >

                                                    <label
                                                        class="form-check-label"
                                                        for="relation_view_<?= esc(md5($relationKey)) ?>"
                                                        >
                                                        Detail button
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-12">

                                                <label class="form-label d-block">
                                                    Columns
                                                </label>

                                                <div class="border rounded p-2 related-columns">

        <?php
        foreach (
                $relation['columns'] ?? []
        as $column
        ):
            ?>

                                                        <div class="form-check">

                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                name="relationsConfig[hasMany][<?= esc($relationKey) ?>][columns][]"
                                                                value="<?= esc($column) ?>"
                                                                id="relation_column_<?=
                                                                esc(
                                                                        md5(
                                                                                $relationKey
                                                                                . '_'
                                                                                . $column
                                                                        )
                                                                )
                                                                ?>"
                                                                checked
                                                                >

                                                            <label
                                                                class="form-check-label"
                                                                for="relation_column_<?=
                                                                esc(
                                                                        md5(
                                                                                $relationKey
                                                                                . '_'
                                                                                . $column
                                                                        )
                                                                )
                                                                ?>"
                                                                >
            <?= esc($column) ?>
                                                            </label>
                                                        </div>

        <?php endforeach; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                <?php endforeach; ?>

                    </div>
                </div>
            </div>

<?php endif; ?>

<?php if (!empty($config['relationsConfig']['manyToMany'])): ?>
<div class="card shadow-sm mb-4 border-primary-subtle">
    <div class="card-header">
        <strong><i class="bi bi-diagram-2"></i> Many-to-many relations (pivot scaffolding)</strong>
    </div>
    <div class="card-body">
        <div class="alert alert-light border small">
            <strong>Semantic many-to-many layer.</strong>
            Only pure pivots are proposed here: two foreign keys and no additional application field.
            Use this section for selection, synchronization, related-record creation, and N:N View behavior.
            Enriched pivots remain standard hasMany relations because their extra application fields must be managed explicitly.
        </div>
        <div class="row g-3">
        <?php foreach ($config['relationsConfig']['manyToMany'] as $relationKey => $relation): ?>
            <div class="col-12 col-lg-6">
                <div class="card h-100 border">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div>
                            <strong><?= esc($relation['title']) ?></strong>
                            <div class="small text-muted">
                                <?= esc($relation['relatedTable']) ?> via <?= esc($relation['pivotTable']) ?>
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox"
                                name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][enabled]" value="1"
                                id="m2m_enabled_<?= esc(md5($relationKey)) ?>" <?= !empty($relation['enabled']) ? 'checked' : '' ?>>
                            <label class="form-check-label" for="m2m_enabled_<?= esc(md5($relationKey)) ?>">Enabled</label>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label class="form-label">Title</label>
                                <input class="form-control" name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][title]" value="<?= esc($relation['title']) ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Limit preview</label>
                                <input type="number" min="1" max="200" class="form-control" name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][limit]" value="<?= (int) ($relation['limit'] ?? 20) ?>">
                            </div>
                            <div class="col-md-2">
                                <label class="form-label">Form width</label>
                                <select class="form-select" name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][formWidth]">
                                    <?php
                                    $m2mConfiguredWidths = array_filter(
                                        (array) (config('MyCrud')->bootstrapFieldWidths ?? []),
                                        static fn (mixed $label, mixed $width): bool => (int) $width >= 1 && (int) $width <= 12,
                                        ARRAY_FILTER_USE_BOTH
                                    );
                                    if ($m2mConfiguredWidths === []) {
                                        $m2mConfiguredWidths = [12 => 'col-md-12', 6 => 'col-md-6'];
                                    }
                                    $m2mCurrentWidth = (int) ($relation['formWidth'] ?? config('MyCrud')->relationPanelWidths['manyToMany'] ?? 12);
                                    ?>
                                    <?php foreach ($m2mConfiguredWidths as $width => $bootstrapClass): ?>
                                        <option value="<?= esc((string) $width) ?>" <?= $m2mCurrentWidth === (int) $width ? 'selected' : '' ?>>
                                            <?= esc((string) $bootstrapClass) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][showCount]" value="1" id="m2m_count_<?= esc(md5($relationKey)) ?>" <?= !empty($relation['showCount']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="m2m_count_<?= esc(md5($relationKey)) ?>">Show count</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][showViewButton]" value="1" id="m2m_view_<?= esc(md5($relationKey)) ?>" <?= !empty($relation['showViewButton']) ? 'checked' : '' ?> <?= empty($relation['relatedRecordDetail']) ? 'disabled' : '' ?>>
                                    <label class="form-check-label" for="m2m_view_<?= esc(md5($relationKey)) ?>">Related record detail link</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][createEnabled]" value="1" id="m2m_create_<?= esc(md5($relationKey)) ?>" <?= !empty($relation['createEnabled']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="m2m_create_<?= esc(md5($relationKey)) ?>"><i class="bi bi-plus-square me-1"></i>Select in Create</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][editEnabled]" value="1" id="m2m_edit_<?= esc(md5($relationKey)) ?>" <?= !empty($relation['editEnabled']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="m2m_edit_<?= esc(md5($relationKey)) ?>"><i class="bi bi-pencil-square me-1"></i>Synchronize in Edit</label>
                                </div>
                                <div class="form-check">
                                    <input
                                        class="form-check-input"
                                        type="checkbox"
                                        name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][createRelatedEnabled]"
                                        value="1"
                                        id="m2m_create_related_<?= esc(md5($relationKey)) ?>"
                                        <?= !empty($relation['createRelatedEnabled']) ? 'checked' : '' ?>
                                        <?= empty($relation['createRelatedAvailable']) ? 'disabled' : '' ?>
                                    >
                                    <label class="form-check-label" for="m2m_create_related_<?= esc(md5($relationKey)) ?>">
                                        <i class="bi bi-plus-circle me-1"></i>Create new related record
                                        <?php if (!empty($relation['createRelatedAvailable'])): ?>
                                            <span class="badge text-bg-success ms-1">Available</span>
                                        <?php else: ?>
                                            <span class="badge text-bg-secondary ms-1">Unavailable</span>
                                        <?php endif ?>
                                    </label>
                                    <?php if (empty($relation['createRelatedAvailable'])): ?>
                                        <?php
                                        $createRelatedReason = (string) ($relation['createRelatedUnavailableReason'] ?? '');
                                        $createRelatedReasonLabel = match ($createRelatedReason) {
                                            'nested_foreign_key' => 'Target contains a foreign-key field that cannot be resolved safely by the inline selector.',
                                            'no_writable_fields' => 'Target has no writable fields available for inline creation.',
                                            'primary_key_not_writable' => 'Target primary key cannot be resolved safely.',
                                            'required_unsupported_fields' => 'Target has required fields not supported by the inline form.',
                                            'target_is_view' => 'Target is a SQL VIEW and is read-only.',
                                            'target_requires_single_primary_key' => 'Target must expose exactly one primary key.',
                                            default => 'Target schema is not compatible with inline creation.',
                                        };
                                        ?>
                                        <div class="small text-muted">
                                            <span class="badge text-bg-secondary me-1">Unavailable</span>
                                            <?= esc($createRelatedReasonLabel) ?>
                                        </div>
                                    <?php else: ?>
                                        <div class="small text-success">
                                            <span class="badge text-bg-success me-1">Available</span>
                                            Creates one new <?= esc((string) ($relation['relatedTable'] ?? 'related')) ?> record
                                            inside the main CRUD transaction and automatically selects it.
                                        </div>
                                    <?php endif ?>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][collapsible]" value="1" id="m2m_collapse_<?= esc(md5($relationKey)) ?>" <?= !empty($relation['collapsible']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="m2m_collapse_<?= esc(md5($relationKey)) ?>"><i class="bi bi-arrows-collapse me-1"></i>Collapsible panel in View</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" name="relationsConfig[manyToMany][<?= esc($relationKey) ?>][collapsed]" value="1" id="m2m_collapsed_<?= esc(md5($relationKey)) ?>" <?= !empty($relation['collapsed']) ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="m2m_collapsed_<?= esc(md5($relationKey)) ?>"><i class="bi bi-chevron-right me-1"></i>Collapsed by default</label>
                                </div>
                            </div>
                            <div class="col-12 small text-muted">
                                Model scaffold: <code>get…Via<?= esc($relation['pivotTable']) ?>()</code>, <code>attach…()</code>, <code>detach…()</code>, <code>sync…()</code>. Create/Edit can manage the many-to-many selection within the same transaction.
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
        </div>
    </div>
</div>
<?php endif; ?>


        <?php
        $formSections = array_values((array) ($config['formSections'] ?? []));
        ?>
        <div class="card shadow-sm mb-4" id="builder-form-sections">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <strong><i class="bi bi-layout-text-window-reverse me-1"></i> Form Sections</strong>
                        <span class="badge text-bg-light border" id="builderHeaderSections"><?= $builderStatusSections ?> configured</span>
                    </div>
                    <div class="small text-muted">Groups fields in Create/Edit. No drag &amp; drop: use ↑ and ↓.</div>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="addFormSection">
                    <i class="bi bi-plus-circle me-1"></i> New section
                </button>
            </div>
            <div class="card-body">
                <div class="alert alert-light border py-2 small mb-3">
                    Fields without a section are automatically shown under <strong>General</strong>.
                    Deleting a section moves its fields back to General.
                </div>

                <div id="formSectionsList" class="vstack gap-2">
                    <?php foreach ($formSections as $section): ?>
                        <?php
                        $sectionId = (string) ($section['id'] ?? '');
                        if ($sectionId === '') {
                            continue;
                        }
                        ?>
                        <div class="border rounded p-3 form-section-item" data-section-id="<?= esc($sectionId) ?>">
                            <input type="hidden" name="formSectionOrder[]" value="<?= esc($sectionId) ?>">
                            <div class="row g-2 align-items-end">
                                <div class="col-lg-3">
                                    <label class="form-label small mb-1">Title</label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm js-section-title"
                                        name="formSections[<?= esc($sectionId) ?>][title]"
                                        value="<?= esc((string) ($section['title'] ?? '')) ?>"
                                        maxlength="120"
                                        required
                                    >
                                </div>
                                <div class="col-lg-4">
                                    <label class="form-label small mb-1">Description <span class="text-muted">(optional)</span></label>
                                    <input
                                        type="text"
                                        class="form-control form-control-sm"
                                        name="formSections[<?= esc($sectionId) ?>][description]"
                                        value="<?= esc((string) ($section['description'] ?? '')) ?>"
                                        maxlength="255"
                                    >
                                </div>
                                <div class="col-lg-2">
                                    <label class="form-label small mb-1">Width</label>
                                    <select
                                        class="form-select form-select-sm js-section-width"
                                        name="formSections[<?= esc($sectionId) ?>][width]"
                                    >
                                        <?php for ($sectionWidth = 12; $sectionWidth >= 1; $sectionWidth--): ?>
                                            <option
                                                value="<?= $sectionWidth ?>"
                                                <?= (int) ($section['width'] ?? 12) === $sectionWidth ? 'selected' : '' ?>
                                            >
                                                col-<?= $sectionWidth ?>
                                            </option>
                                        <?php endfor; ?>
                                    </select>
                                </div>
                                <div class="col-lg-3">
                                    <div class="d-flex flex-wrap gap-1 justify-content-lg-end">
                                        <button type="button" class="btn btn-sm btn-outline-secondary js-section-up" title="Move up" aria-label="Move section up">
                                            <i class="bi bi-arrow-up"></i>
                                        </button>
                                        <button type="button" class="btn btn-sm btn-outline-secondary js-section-down" title="Move down" aria-label="Move section down">
                                            <i class="bi bi-arrow-down"></i>
                                        </button>
                                        <div class="form-check form-switch ms-1 d-flex align-items-center">
                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="formSections[<?= esc($sectionId) ?>][collapsed]"
                                                value="1"
                                                id="section_collapsed_<?= esc($sectionId) ?>"
                                                <?= !empty($section['collapsed']) ? 'checked' : '' ?>
                                            >
                                            <label class="form-check-label small ms-1" for="section_collapsed_<?= esc($sectionId) ?>">Collapsed</label>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-danger js-section-delete" title="Delete section" aria-label="Delete section">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div id="noFormSections" class="text-muted small <?= $formSections !== [] ? 'd-none' : '' ?>">
                    No custom section. All fields are in General.
                </div>
            </div>
        </div>

        <template id="formSectionTemplate">
            <div class="border rounded p-3 form-section-item" data-section-id="__ID__">
                <input type="hidden" name="formSectionOrder[]" value="__ID__">
                <div class="row g-2 align-items-end">
                    <div class="col-lg-3">
                        <label class="form-label small mb-1">Title</label>
                        <input type="text" class="form-control form-control-sm js-section-title" name="formSections[__ID__][title]" value="New section" maxlength="120" required>
                    </div>
                    <div class="col-lg-4">
                        <label class="form-label small mb-1">Description <span class="text-muted">(optional)</span></label>
                        <input type="text" class="form-control form-control-sm" name="formSections[__ID__][description]" value="" maxlength="255">
                    </div>
                    <div class="col-lg-2">
                        <label class="form-label small mb-1">Width</label>
                        <select class="form-select form-select-sm js-section-width" name="formSections[__ID__][width]">
                            <?php for ($sectionWidth = 12; $sectionWidth >= 1; $sectionWidth--): ?>
                                <option value="<?= $sectionWidth ?>" <?= $sectionWidth === 12 ? 'selected' : '' ?>>col-<?= $sectionWidth ?></option>
                            <?php endfor; ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <div class="d-flex flex-wrap gap-1 justify-content-lg-end">
                            <button type="button" class="btn btn-sm btn-outline-secondary js-section-up" title="Move up"><i class="bi bi-arrow-up"></i></button>
                            <button type="button" class="btn btn-sm btn-outline-secondary js-section-down" title="Move down"><i class="bi bi-arrow-down"></i></button>
                            <div class="form-check form-switch ms-1 d-flex align-items-center">
                                <input class="form-check-input" type="checkbox" name="formSections[__ID__][collapsed]" value="1" id="section_collapsed___ID__">
                                <label class="form-check-label small ms-1" for="section_collapsed___ID__">Collapsed</label>
                            </div>
                            <button type="button" class="btn btn-sm btn-outline-danger js-section-delete" title="Delete section"><i class="bi bi-trash"></i></button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <div class="card shadow-sm mb-3 builder-section-anchor" id="builder-fields">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <strong><i class="bi bi-input-cursor-text me-1"></i> Fields</strong>
                        <span class="badge text-bg-light border"><?= $builderStatusFields ?> schema fields</span>
                    </div>
                    <span class="badge text-bg-secondary ms-1"><?= count($config['fields'] ?? []) ?></span>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <div class="input-group input-group-sm" style="max-width: 280px;">
                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                        <input type="search" class="form-control" id="fieldSearch" placeholder="Search field...">
                    </div>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="expandAll">
                        <i class="bi bi-arrows-expand me-1"></i> Expand
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" id="collapseAll">
                        <i class="bi bi-arrows-collapse me-1"></i> Collapse
                    </button>
                </div>
            </div>
            <div class="card-body border-top">
                <details class="border rounded p-3 bg-body-tertiary">
                    <summary class="fw-semibold">
                        <i class="bi bi-info-circle me-1"></i> Field configuration guide
                    </summary>
                    <div class="mt-3 small">
                        <p class="mb-3">
                            Each field card combines <strong>schema facts</strong> detected from the database
                            with <strong>application choices</strong> saved by the Builder.
                            Database structure remains authoritative: primary keys, foreign keys, nullability,
                            DB-managed timestamps, and physical column names are not redefined here.
                        </p>

                        <div class="row g-3">
                            <div class="col-12 col-xl-6">
                                <div class="border rounded bg-body p-3 h-100">
                                    <div class="fw-semibold mb-2"><i class="bi bi-ui-checks-grid me-1"></i>Form & layout</div>
                                    <ul class="mb-0 ps-3">
                                        <li><strong>Input type</strong>: chooses the generated HTML control.</li>
                                        <li><strong>Label</strong>: user-facing caption; DB column name is unchanged.</li>
                                        <li><strong>Bootstrap width</strong>: controls the field column width in Create/Edit.</li>
                                        <li><strong>Form section</strong>: groups the field inside the configured form section.</li>
                                        <li><strong>Initial value in Create</strong>: only pre-fills new records; Edit and submitted values take precedence.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-12 col-xl-6">
                                <div class="border rounded bg-body p-3 h-100">
                                    <div class="fw-semibold mb-2"><i class="bi bi-eye me-1"></i>Visibility & data exposure</div>
                                    <ul class="mb-0 ps-3">
                                        <li><strong>Visible in list</strong>: column appears in the Index table.</li>
                                        <li><strong>Visible in form</strong>: field appears in Create/Edit when schema policy allows it.</li>
                                        <li><strong>Visible in details</strong>: field appears in the record View.</li>
                                        <li><strong>Exportable</strong>: field may be included in CSV/Word export.</li>
                                        <li><strong>API visible</strong> and <strong>MCP visible</strong> are independent exposure choices.</li>
                                        <li><strong>Sensitive</strong>: marks the field as intentionally restricted; it is never inferred only from its name.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-12 col-xl-6">
                                <div class="border rounded bg-body p-3 h-100">
                                    <div class="fw-semibold mb-2"><i class="bi bi-search me-1"></i>List filtering & sorting</div>
                                    <ul class="mb-0 ps-3">
                                        <li><strong>Searchable</strong>: enables the field in the dynamic server-side filter when allowed by the index policy.</li>
                                        <li><strong>Sortable</strong>: enables server-side ordering when the generated query layer permits it.</li>
                                        <li>PRIMARY, UNIQUE, and leading-index badges explain why a field is suitable for efficient filtering/sorting.</li>
                                        <li><strong>INDEX non-leading</strong> means the column belongs to an index but does not lead it; it may not be efficient as a standalone filter.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-12 col-xl-6">
                                <div class="border rounded bg-body p-3 h-100">
                                    <div class="fw-semibold mb-2"><i class="bi bi-shield-check me-1"></i>Validation & HTML attributes</div>
                                    <ul class="mb-0 ps-3">
                                        <li><strong>required</strong>: server-side validation remains authoritative; non-nullable writable DB fields are required automatically.</li>
                                        <li><strong>readonly</strong>: value is displayed but should not be edited by the user.</li>
                                        <li><strong>disabled</strong>: control is disabled and does not submit a browser value.</li>
                                        <li><strong>maxlength, min, max, step, pattern, placeholder</strong>: refine generated HTML and validation-compatible behavior.</li>
                                        <li>DB-managed fields ignore form settings that would incorrectly make them writable.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="border rounded bg-body p-3">
                                    <div class="fw-semibold mb-2"><i class="bi bi-diagram-2 me-1"></i>Foreign-key fields</div>
                                    <div class="row g-2">
                                        <div class="col-12 col-lg-6">
                                            <ul class="mb-0 ps-3">
                                                <li><strong>Full select / AJAX</strong>: controls how parent options are loaded.</li>
                                                <li><strong>Display value/template</strong>: changes the human-readable label, never the stored FK value.</li>
                                                <li><strong>Quick filter</strong>: enables convenient navigation/filtering by that FK.</li>
                                                <li><strong>Link to parent</strong>: exposes navigation to the related parent record.</li>
                                            </ul>
                                        </div>
                                        <div class="col-12 col-lg-6">
                                            <ul class="mb-0 ps-3">
                                                <li><strong>Accept FK from URL</strong>: safely pre-fills Create after server-side parent validation.</li>
                                                <li><strong>New parent link</strong>: navigates to a separate parent Create page.</li>
                                                <li><strong>Select or create new</strong>: creates the parent inline inside the main transaction and therefore replaces the separate New-parent navigation pattern.</li>
                                                <li>Nullable empty FK values are normalized to <code>NULL</code> before persistence.</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="alert alert-warning mt-3 mb-0">
                            <strong>Rule of thumb:</strong>
                            use the Builder to decide presentation, navigation, exposure, and application behavior.
                            Do not use it to override database truth. If the schema changes, regenerate so myCrudCI4 can merge the saved choices onto the current DB schema.
                        </div>
                    </div>
                </details>
            </div>
        </div>

        <?php $tableStats = (array) ($config['tableStats'] ?? []); ?>
        <div class="alert alert-light border d-flex flex-wrap gap-3 align-items-center">
            <strong>Schema:</strong>
            <span>Estimated rows: <?= number_format((int) ($tableStats['rowEstimate'] ?? 0), 0, ',', '.') ?></span>
            <span>Fields: <?= count($config['fields'] ?? []) ?></span>
            <span class="text-muted">Indexes are shown for each field; mycrud:doctor provides the complete analysis.</span>
        </div>

        <div id="sortableFields">
<?php foreach ($config['order'] as $fieldName): ?>
    <?php
    $field = $config['fields'][$fieldName];
    $fk = $field['foreignKey'];
    $allowedTypes = [
        'text', 'number', 'email', 'password', 'date',
        'datetime-local', 'time', 'textarea', 'select',
        'checkbox', 'radio', 'url', 'tel', 'file', 'image',
        'hidden', 'range', 'color', 'search'
    ];
    ?>
                <div class="card shadow-sm mb-3 field-block"
                     data-field="<?= esc($fieldName) ?>">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <span class="drag-handle fs-4" title="Drag to reorder">☰</span>
                            <strong><?= esc($fieldName) ?></strong>
                            <span class="badge text-bg-light border js-field-summary-type">
                                <?= esc((string) ($field['inputType'] ?? 'text')) ?>
                            </span>
                            <span class="badge text-bg-light border js-field-summary-width">
                                col-<?= (int) ($field['width'] ?? 6) ?>
                            </span>
                            <?php
                            $fieldSectionId = (string) ($field['section'] ?? '');
                            $fieldSectionTitle = 'General';
                            foreach ($formSections as $summarySection) {
                                if ((string) ($summarySection['id'] ?? '') === $fieldSectionId) {
                                    $fieldSectionTitle = (string) ($summarySection['title'] ?? 'Section');
                                    break;
                                }
                            }
                            ?>
                            <span class="badge text-bg-light border js-field-summary-section">
                                <i class="bi bi-folder2-open me-1"></i><?= esc($fieldSectionTitle) ?>
                            </span>

    <?php if ($field['primary']): ?>
                                <span class="badge bg-secondary">PK</span>
    <?php endif; ?>

    <?php if (!empty($field['databaseManaged'])): ?>
                                <span
                                    class="badge text-bg-info"
                                    title="Managed by database: <?= esc((string) ($field['default'] ?? '')) ?>; <?= esc((string) ($field['extra'] ?? '')) ?>"
                                >
                                    <i class="bi bi-database-lock"></i> DB managed
                                </span>
    <?php endif; ?>

    <?php if ($fk): ?>
                                <span class="badge bg-warning text-dark">
                                    FK → <?= esc($fk['parentTable']) ?>
                                </span>
                                <?php if ((int) ($field['relationRowEstimate'] ?? 0) > 0): ?>
                                    <span class="badge text-bg-light">
                                        ~<?= number_format((int) $field['relationRowEstimate'], 0, ',', '.') ?> rows
                                    </span>
                                <?php endif; ?>
    <?php endif; ?>

    <?php $indexInfo = (array) ($field['index'] ?? []); ?>
    <?php if (!empty($indexInfo['primary'])): ?>
                                <span class="badge text-bg-dark">PRIMARY</span>
    <?php elseif (!empty($indexInfo['unique'])): ?>
                                <span class="badge text-bg-success">UNIQUE</span>
    <?php elseif (!empty($indexInfo['leading'])): ?>
                                <span class="badge text-bg-primary">INDEX</span>
    <?php elseif (!empty($indexInfo['indexed'])): ?>
                                <span class="badge text-bg-secondary">INDEX non-leading</span>
    <?php else: ?>
                                <span class="badge text-bg-light">No index</span>
    <?php endif; ?>
                        </div>

                        <button type="button"
                                class="btn btn-sm btn-outline-secondary toggle-field">
                            <i class="bi bi-chevron-down"></i>
                        </button>
                    </div>

                    <div class="card-body field-body d-none">
                        <div class="row g-3">
                            <div class="col-lg-4">
                                <label class="form-label">🧩 Input type</label>
                                <select
                                    name="inputType[<?= esc($fieldName) ?>]"
                                    class="form-select input-type"
                                    <?= !empty($field['databaseManaged']) ? 'disabled' : '' ?>
                                    >
                                    <?php
                                    $icons = [
                                        'text' => '📝', 'number' => '🔢', 'email' => '✉️',
                                        'password' => '🔐', 'date' => '📅', 'datetime-local' => '⏰',
                                        'time' => '🕒', 'textarea' => '✍️', 'select' => '📂',
                                        'checkbox' => '☑️', 'radio' => '🔘', 'url' => '🌐',
                                        'tel' => '📞', 'file' => '📁', 'image' => '🖼️', 'hidden' => '🙈',
                                        'range' => '🎚️', 'color' => '🎨', 'search' => '🔍',
                                    ];
                                    ?>
    <?php foreach ($allowedTypes as $type): ?>
                                        <option
                                            value="<?= esc($type) ?>"
        <?= $field['inputType'] === $type ? 'selected' : '' ?>
                                            >
        <?= esc(($icons[$type] ?? '') . ' ' . $type) ?>
                                        </option>
    <?php endforeach; ?>
                                </select>
                                <?php if (!empty($field['databaseManaged'])): ?>
                                    <div class="form-text text-info-emphasis">
                                        Managed by the DB with CURRENT_TIMESTAMP: no input is generated and the value is not sent in INSERT/UPDATE.
                                    </div>
                                <?php else: ?>
                                    <div class="form-text">
                                        Changes the generated form control only; it does not change the physical database column type.
                                    </div>
                                <?php endif; ?>
                            </div>

                            <?php if ($fk): ?>
                                <div class="col-lg-4">
                                    <label class="form-label">🔄 Relation loading</label>
                                    <select name="relationMode[<?= esc($fieldName) ?>]" class="form-select">
                                        <option value="select" <?= ($field['relationMode'] ?? 'select') === 'select' ? 'selected' : '' ?>>Full select</option>
                                        <option value="ajax" <?= ($field['relationMode'] ?? '') === 'ajax' ? 'selected' : '' ?>>Select AJAX</option>
                                    </select>
                                    <div class="form-text">
                                        <?php if (($field['relationMode'] ?? '') === 'ajax'): ?>
                                            AJAX is recommended because of the related table size.
                                        <?php else: ?>
                                            AJAX avoids loading all options when the related table is large.
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($fk): ?>
                                <?php
                                $displayFields = array_values((array) ($fk['availableDisplayFields'] ?? []));
                                $selectedDisplayField = (string) ($field['relationDisplayField'] ?? $fk['displayField'] ?? $fk['parentKey'] ?? '');
                                $navigation = (array) ($field['relationNavigation'] ?? []);
                                ?>

                                <div class="col-lg-4">
                                    <label class="form-label">🏷️ Display value</label>
                                    <select
                                        name="relationDisplayField[<?= esc($fieldName) ?>]"
                                        class="form-select"
                                    >
                                        <?php foreach ($displayFields as $displayField): ?>
                                            <option
                                                value="<?= esc($displayField) ?>"
                                                <?= $selectedDisplayField === $displayField ? 'selected' : '' ?>
                                            >
                                                <?= esc($displayField) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">
                                        Text displayed instead of the foreign-key value, for example 5 → “Hotel Ateneo”.
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <label class="form-label">🧾 Display template <span class="text-muted">(optional)</span></label>
                                    <input
                                        type="text"
                                        name="relationDisplayTemplate[<?= esc($fieldName) ?>]"
                                        value="<?= esc($field['relationDisplayTemplate'] ?? '') ?>"
                                        class="form-control"
                                        placeholder="Example: {last_name} {first_name}"
                                    >
                                    <div class="form-text">
                                        When provided, overrides the single field. Available fields:
                                        <?= esc(implode(', ', $displayFields)) ?>.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label d-block">🧭 Relation navigation</label>
                                    <input type="hidden" name="relationNavigation[<?= esc($fieldName) ?>][]" value="">

                                    <?php
                                    $navigationFlags = [
                                        'quickFilter' => '⚡ Quick filter in table',
                                        'parentLink' => '🔗 Link to parent record',
                                        'acceptContext' => '📥 Accept foreign key from URL in Create',
                                        'createParentLink' => '↗️ “New parent” link in form',
                                    ];
                                    ?>

                                    <?php foreach ($navigationFlags as $navFlag => $navLabel): ?>
                                        <?php
                                        $relatedCreateEnabled = !empty($field['relationCreate']['enabled']);
                                        $disableCreateParentLink = $navFlag === 'createParentLink' && $relatedCreateEnabled;
                                        ?>
                                        <div class="form-check form-check-inline">
                                            <input
                                                type="checkbox"
                                                class="form-check-input<?= $navFlag === 'createParentLink' ? ' js-create-parent-link' : '' ?>"
                                                name="relationNavigation[<?= esc($fieldName) ?>][]"
                                                value="<?= esc($navFlag) ?>"
                                                id="<?= esc($fieldName . '_nav_' . $navFlag) ?>"
                                                data-field="<?= esc($fieldName) ?>"
                                                <?= (!$disableCreateParentLink && !empty($navigation[$navFlag])) ? 'checked' : '' ?>
                                                <?= $disableCreateParentLink ? 'disabled' : '' ?>
                                            >
                                            <label
                                                class="form-check-label"
                                                for="<?= esc($fieldName . '_nav_' . $navFlag) ?>"
                                            >
                                                <?= esc($navLabel) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>

                                    <div class="form-text">
                                        The foreign key received via URL is validated against the parent table before pre-filling hidden, select, AJAX select, or standard input fields.
                                    </div>
                                </div>

                                <?php $relatedCreate = (array) ($field['relationCreate'] ?? []); ?>
                                <div class="col-12">
                                    <label class="form-label d-block">➕ Related record creation</label>
                                    <?php if (!empty($relatedCreate['available'])): ?>
                                        <div class="form-check">
                                            <input
                                                type="checkbox"
                                                class="form-check-input js-related-create"
                                                name="relationCreate[<?= esc($fieldName) ?>]"
                                                value="1"
                                                id="<?= esc($fieldName . '_related_create') ?>"
                                                data-field="<?= esc($fieldName) ?>"
                                                <?= !empty($relatedCreate['enabled']) ? 'checked' : '' ?>
                                            >
                                            <label class="form-check-label" for="<?= esc($fieldName . '_related_create') ?>">
                                                ➕ Allow “Select or create new” in the same form
                                            </label>
                                        </div>
                                        <div class="form-text">
                                            The new parent record is created in the same transaction; the generated key is used as the current record foreign key.
                                            When this option is enabled, the “New parent” link is disabled to avoid leaving and losing the current form.
                                        </div>
                                    <?php else: ?>
                                        <div class="form-text text-muted">
                                            Unavailable: the parent must be a BASE TABLE with a single primary key and required fields manageable by the form.
                                        </div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>

                            <div class="col-lg-4">
                                <label class="form-label">🏷️ Label</label>
                                <input
                                    type="text"
                                    name="label[<?= esc($fieldName) ?>]"
                                    value="<?= esc($field['label'] ?? '') ?>"
                                    placeholder="<?= esc($field['defaultLabel'] ?? $fieldName) ?>"
                                    class="form-control field-label"
                                    >
                                <div class="form-text">
                                    User-facing text only. The database column name and generated property name remain unchanged.
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">↔️ Width Bootstrap</label>
                                <select
                                    name="width[<?= esc($fieldName) ?>]"
                                    class="form-select width-select"
                                    >
    <?php
                                    $configuredWidths = array_filter(
                                        (array) (config('MyCrud')->bootstrapFieldWidths ?? []),
                                        static fn (mixed $label, mixed $width): bool => (int) $width >= 1 && (int) $width <= 12,
                                        ARRAY_FILTER_USE_BOTH
                                    );
                                    if ($configuredWidths === []) {
                                        $configuredWidths = [12 => 'col-md-12', 6 => 'col-md-6'];
                                    }
                                    $currentWidth = (int) ($field['width'] ?? config('MyCrud')->defaultBootstrapFieldWidth ?? 6);
                                    ?>
                                    <?php foreach ($configuredWidths as $width => $bootstrapClass): ?>
                                        <option
                                            value="<?= esc((string) $width) ?>"
                                            <?= $currentWidth === (int) $width ? 'selected' : '' ?>
                                        >
                                            <?= esc((string) $bootstrapClass) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text">
                                    Bootstrap grid width used by Create/Edit. For example, <code>col-md-6</code> places two equal fields on the same row when space allows.
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-label">🗂️ Form section</label>
                                <select
                                    name="section[<?= esc($fieldName) ?>]"
                                    class="form-select js-field-section"
                                    data-field="<?= esc($fieldName) ?>"
                                >
                                    <option value="">General</option>
                                    <?php foreach ($formSections as $formSection): ?>
                                        <?php $formSectionId = (string) ($formSection['id'] ?? ''); ?>
                                        <?php if ($formSectionId !== ''): ?>
                                            <option
                                                value="<?= esc($formSectionId) ?>"
                                                <?= (string) ($field['section'] ?? '') === $formSectionId ? 'selected' : '' ?>
                                            >
                                                <?= esc((string) ($formSection['title'] ?? $formSectionId)) ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                                <div class="form-text">
                                    Section used in Create/Edit forms. If not selected: General.
                                </div>
                            </div>

                            <?php
                            $temporalType = strtolower((string) ($field['type'] ?? ''));
                            $temporalInput = strtolower((string) ($field['inputType'] ?? ''));
                            $supportsInitialValue = empty($config['isView']) && empty($field['databaseManaged'])
                                && (in_array($temporalType, ['date', 'datetime', 'timestamp', 'time'], true)
                                    || in_array($temporalInput, ['date', 'datetime-local', 'time'], true));
                            ?>
                            <?php if ($supportsInitialValue): ?>
                            <div class="col-lg-8">
                                <label class="form-label"><i class="bi bi-calendar2-check me-1"></i>Initial value in Create</label>
                                <div class="row g-2">
                                    <div class="col-md-5">
                                        <?php $initialMode = (string) ($field['initialValue']['mode'] ?? 'none'); ?>
                                        <select
                                            name="initialValue[<?= esc($fieldName) ?>][mode]"
                                            class="form-select js-initial-value-mode"
                                            data-field="<?= esc($fieldName) ?>"
                                            data-temporal-type="<?= esc($temporalType) ?>"
                                            data-input-type="<?= esc($temporalInput) ?>"
                                        >
                                            <option value="none" <?= $initialMode === 'none' ? 'selected' : '' ?>>None</option>
                                            <option value="today" <?= $initialMode === 'today' ? 'selected' : '' ?>>Current date</option>
                                            <option value="now" <?= $initialMode === 'now' ? 'selected' : '' ?>>Current date and time</option>
                                            <option value="time" <?= $initialMode === 'time' ? 'selected' : '' ?>>Current time</option>
                                            <option value="custom" <?= $initialMode === 'custom' ? 'selected' : '' ?>>Custom value</option>
                                        </select>
                                    </div>
                                    <div class="col-md-7">
                                        <input
                                            type="text"
                                            class="form-control js-initial-value-custom"
                                            name="initialValue[<?= esc($fieldName) ?>][custom]"
                                            data-field="<?= esc($fieldName) ?>"
                                            value="<?= esc($field['initialValue']['custom'] ?? '') ?>"
                                            placeholder=""
                                        >
                                    </div>
                                </div>
                                <div class="form-text">Create initial value only. old(), context, and Edit take precedence. Automatic DB fields remain exclusively database-managed.</div>
                            </div>
                            <?php endif; ?>

                            <?php if (empty($config['isView'])): ?>
                            <div class="col-lg-4">
                                <label class="form-label d-block">⚙️ Boolean attributes</label>

                                        <?php foreach (['required' => '⭐', 'readonly' => '🔒', 'disabled' => '🚫'] as $attribute => $icon): ?>
                                    <div class="form-check form-check-inline">
                                        <input
                                            type="checkbox"
                                            class="form-check-input attribute-boolean"
                                            name="attrBool[<?= esc($fieldName) ?>][]"
                                            value="<?= esc($attribute) ?>"
                                            id="<?= esc($fieldName . '_' . $attribute) ?>"
                                            <?= !empty($field['databaseManaged']) ? 'disabled' : '' ?>
                                                <?php
                                                $checked = in_array($attribute, $field['attributes']['boolean'] ?? [], true);
                                                if ($attribute === 'required' && empty($field['databaseManaged']) && (($field['nullable'] ?? true) === false) && empty($field['autoIncrement']) && !in_array('disabled', $field['attributes']['boolean'] ?? [], true)
                                                ) {
                                                    $checked = true;
                                                }
                                                ?>
        <?= $checked ? 'checked' : '' ?>
                                            >
                                        <label
                                            class="form-check-label"
                                            for="<?= esc($fieldName . '_' . $attribute) ?>"
                                            >
        <?= $icon ?> <?= esc($attribute) ?>
                                        </label>
                                    </div>
    <?php endforeach; ?>
                            </div>

                            <?php endif; ?>

                            <div class="col-12">
                                <label class="form-label d-block">🧭 CRUD and API behavior</label>
                                <input type="hidden" name="ui[<?= esc($fieldName) ?>][]" value="">
                                <?php
                                $uiFlags = [
                                    'searchable' => '🔍 Searchable',
                                    'sortable' => '↕️ Sortable',
                                    'visibleIndex' => '📋 Visible in list',
                                    'visibleView' => '👁️ Visible in details',
                                    'sensitive' => '🔐 Sensitive',
                                    'exportable' => '📄 Exportable CSV/Word',
                                    'apiVisible' => '🔌 API visible',
                                    'mcpVisible' => '🤖 MCP visible',
                                ];
                                if (empty($config['isView'])) {
                                    $uiFlags = array_slice($uiFlags, 0, 3, true)
                                        + ['visibleForm' => '🧾 Visible in form']
                                        + array_slice($uiFlags, 3, null, true);
                                }
                                ?>
                                <?php foreach ($uiFlags as $flag => $flagLabel): ?>
                                    <div class="form-check form-check-inline">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            name="ui[<?= esc($fieldName) ?>][]"
                                            value="<?= esc($flag) ?>"
                                            id="<?= esc($fieldName . '_ui_' . $flag) ?>"
                                            <?= ($flag === 'visibleForm' && (!empty($field['databaseManaged']) || !empty($config['isView']))) ? 'disabled' : '' ?>
                                            <?= !empty($field['ui'][$flag]) ? 'checked' : '' ?>
                                        >
                                        <label class="form-check-label" for="<?= esc($fieldName . '_ui_' . $flag) ?>">
                                            <?= esc($flagLabel) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                                <div class="form-text">
                                    <?php if (!empty($config['isView'])): ?>
                                        For a VIEW, search and sorting are explicit developer choices: myCrudCI4 does not invent underlying indexes.
                                    <?php else: ?>
                                        <strong>Searchable</strong> controls dynamic filtering;
                                        <strong>Sortable</strong> controls server-side ordering;
                                        visibility flags independently control Index, Create/Edit, Detail, API, MCP, and export exposure.
                                    <?php endif; ?>
                                </div>
                            </div>

                            <?php if (empty($config['isView'])): ?>
                            <div class="col-lg-8">
                                <label class="form-label">🛠️ Attributes with values</label>
                                <div class="row g-2">
    <?php foreach (['maxlength', 'minlength', 'min', 'max', 'step', 'pattern', 'placeholder'] as $attribute): ?>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><?= esc($attribute) ?></span>
                                                <input
                                                    type="text"
                                                    name="attrVal[<?= esc($fieldName) ?>][<?= esc($attribute) ?>]"
                                                    value="<?= esc($field['attributes']['values'][$attribute] ?? '') ?>"
                                                    class="form-control"
                                                    >
                                            </div>
                                        </div>
    <?php endforeach; ?>
                                </div>
                                <div class="form-text mt-2">
                                    These values are presentation/validation hints for generated controls.
                                    They do not alter the database schema.
                                </div>
                            </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
<?php endforeach; ?>
        </div>


        <div class="sticky-bottom bg-light border-top py-3 mt-4 builder-section-anchor" id="builder-generation">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <a href="<?= site_url('mycrud') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Tables
                </a>

                <div class="d-flex flex-wrap align-items-center justify-content-end gap-2">
                    <div class="small text-muted me-2 d-none d-xl-block">
                        <i class="bi bi-shield-check me-1"></i>Generation writes only to <code>app/Generated/</code>.
                    </div>

                    <details class="me-1 position-relative">
                        <summary class="btn btn-sm btn-outline-secondary">Advanced</summary>
                        <div class="border rounded bg-body p-2 mt-2 position-absolute end-0 shadow-sm" style="min-width: 300px; z-index: 20;">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" name="force" value="1" id="force">
                                <label class="form-check-label fw-semibold" for="force">Overwrite staging files</label>
                                <div class="form-text">Use when regenerating files already present in <code>app/Generated/</code>.</div>
                            </div>
                        </div>
                    </details>

                    <button
                        type="submit"
                        formaction="<?= site_url('mycrud/builder/save') ?>"
                        class="btn btn-outline-success"
                        >
                        <i class="bi bi-floppy"></i> Save configuration
                    </button>

                    <button
                        type="submit"
                        formaction="<?= site_url('mycrud/builder/generate') ?>"
                        class="btn btn-warning"
                        >
                        <i class="bi bi-gear"></i> Generate to staging
                    </button>
                </div>
            </div>
        </div>
            </div>
        </div>
    </form>
</div>
        </main>
    </div>
</div>

<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-eye"></i> Preview form
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sectionsList = document.getElementById('formSectionsList');
        const sectionTemplate = document.getElementById('formSectionTemplate');
        const addSectionButton = document.getElementById('addFormSection');
        const noSections = document.getElementById('noFormSections');

        function sectionItems() {
            return sectionsList ? Array.from(sectionsList.querySelectorAll('.form-section-item')) : [];
        }

        function refreshSectionSelects() {
            const sections = sectionItems().map(function (item) {
                const titleInput = item.querySelector('.js-section-title');
                return {
                    id: String(item.dataset.sectionId || ''),
                    title: String(titleInput?.value || '').trim() || 'Section'
                };
            }).filter(section => section.id !== '');

            document.querySelectorAll('.js-field-section').forEach(function (select) {
                const current = String(select.value || '');
                select.innerHTML = '';

                const general = document.createElement('option');
                general.value = '';
                general.textContent = 'General';
                select.appendChild(general);

                sections.forEach(function (section) {
                    const option = document.createElement('option');
                    option.value = section.id;
                    option.textContent = section.title;
                    select.appendChild(option);
                });

                select.value = sections.some(section => section.id === current) ? current : '';
            });

            noSections?.classList.toggle('d-none', sections.length > 0);

            document.querySelectorAll('.field-block').forEach(function (block) {
                const select = block.querySelector('.js-field-section');
                const badge = block.querySelector('.js-field-summary-section');
                if (!select || !badge) return;
                const text = select.options[select.selectedIndex]?.textContent || 'General';
                badge.innerHTML = '<i class="bi bi-folder2-open me-1"></i>' + text;
            });
        }

        function bindSectionItem(item) {
            item.querySelector('.js-section-up')?.addEventListener('click', function () {
                const previous = item.previousElementSibling;
                if (previous) {
                    sectionsList.insertBefore(item, previous);
                }
            });

            item.querySelector('.js-section-down')?.addEventListener('click', function () {
                const next = item.nextElementSibling;
                if (next) {
                    sectionsList.insertBefore(next, item);
                }
            });

            item.querySelector('.js-section-delete')?.addEventListener('click', function () {
                const id = String(item.dataset.sectionId || '');
                document.querySelectorAll('.js-field-section').forEach(function (select) {
                    if (select.value === id) {
                        select.value = '';
                    }
                });
                item.remove();
                refreshSectionSelects();
            });

            item.querySelector('.js-section-title')?.addEventListener('input', refreshSectionSelects);
        }

        sectionItems().forEach(bindSectionItem);

        addSectionButton?.addEventListener('click', function () {
            if (!sectionsList || !sectionTemplate) return;

            const id = 'section_' + Date.now().toString(36) + '_' + Math.random().toString(36).slice(2, 7);
            const html = sectionTemplate.innerHTML.replaceAll('__ID__', id);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            const item = wrapper.firstElementChild;
            if (!item) return;

            sectionsList.appendChild(item);
            bindSectionItem(item);
            refreshSectionSelects();

            const title = item.querySelector('.js-section-title');
            title?.focus();
            title?.select();
        });

        refreshSectionSelects();

        const sortableElement = document.getElementById('sortableFields');
        const fieldOrderInput = document.getElementById('fieldOrderJson');

        function updateOrder() {
            if (!sortableElement || !fieldOrderInput) {
                return;
            }

            const order = Array.from(
                sortableElement.querySelectorAll(':scope > .field-block')
            )
                .map(block => block.dataset.field || '')
                .filter(Boolean);

            fieldOrderInput.value = JSON.stringify(order);
        }

        if (sortableElement && fieldOrderInput) {
            new Sortable(sortableElement, {
                animation: 150,
                handle: '.drag-handle',
                ghostClass: 'border-warning',
                onEnd: updateOrder
            });

            updateOrder();
        }

        const builderForm = document.getElementById('builderForm');
        const fieldsConfigInput = document.getElementById('fieldsConfigJson');

        /**
         * Converts names such as:
         *
         * fields[title][inputType]
         * fields[title][attributes][boolean][]
         *
         * into token lists compatible with the existing PHP POST structure.
         */
        function fieldInputTokens(name) {
            const tokens = [];

            name.replace(/([^[\]]+)|\[([^\]]*)\]/g, function (_, plain, bracket) {
                tokens.push(plain !== undefined ? plain : bracket);
                return '';
            });

            return tokens;
        }

        function setNestedFieldValue(root, tokens, value) {
            let current = root;

            tokens.forEach(function (token, index) {
                const last = index === tokens.length - 1;
                const next = tokens[index + 1];

                if (token === '') {
                    if (!Array.isArray(current)) {
                        return;
                    }

                    if (last) {
                        current.push(value);
                        return;
                    }

                    const child = next === '' ? [] : {};
                    current.push(child);
                    current = child;
                    return;
                }

                if (last) {
                    if (Object.prototype.hasOwnProperty.call(current, token)) {
                        if (!Array.isArray(current[token])) {
                            current[token] = [current[token]];
                        }

                        current[token].push(value);
                    } else {
                        current[token] = value;
                    }

                    return;
                }

                if (
                    !Object.prototype.hasOwnProperty.call(current, token)
                    || current[token] === null
                    || typeof current[token] !== 'object'
                ) {
                    current[token] = next === '' ? [] : {};
                }

                current = current[token];
            });
        }

        function updateFieldsConfigJson() {
            if (!builderForm || !fieldsConfigInput) {
                return;
            }

            const fields = {};
            const formData = new FormData(builderForm);

            for (const [name, rawValue] of formData.entries()) {
                if (typeof name !== 'string' || !name.startsWith('fields[')) {
                    continue;
                }

                const tokens = fieldInputTokens(name);

                if (tokens.shift() !== 'fields' || tokens.length === 0) {
                    continue;
                }

                const value = typeof rawValue === 'string'
                    ? rawValue
                    : rawValue.name;

                setNestedFieldValue(fields, tokens, value);
            }

            fieldsConfigInput.value = JSON.stringify(fields);
        }

        if (builderForm) {
            builderForm.addEventListener('submit', function () {
                // Always synchronize the drag/drop order immediately before submit.
                updateOrder();

                // Collapse the potentially thousands of fields[...] variables
                // into one JSON POST variable.
                updateFieldsConfigJson();

                // Prevent individual fields[...] controls from being submitted.
                // They have already been serialized into fieldsConfigJson.
                builderForm
                    .querySelectorAll('[name^="fields["]')
                    .forEach(function (control) {
                        control.disabled = true;
                    });
            });
        }

        document.querySelectorAll('.toggle-field').forEach(function (button) {
            button.addEventListener('click', function () {
                const body = button.closest('.card').querySelector('.field-body');
                const icon = button.querySelector('i');

                body.classList.toggle('d-none');
                icon.className = body.classList.contains('d-none')
                        ? 'bi bi-chevron-down'
                        : 'bi bi-chevron-up';
            });
        });

        function expandAllFields() {
            document.querySelectorAll('.field-block:not([hidden]) .field-body').forEach(body => body.classList.remove('d-none'));
            document.querySelectorAll('.field-block:not([hidden]) .toggle-field i').forEach(icon => icon.className = 'bi bi-chevron-up');
        }

        function collapseAllFields() {
            document.querySelectorAll('.field-body').forEach(body => body.classList.add('d-none'));
            document.querySelectorAll('.toggle-field i').forEach(icon => icon.className = 'bi bi-chevron-down');
        }

        ['expandAll', 'expandAllTop'].forEach(function (id) {
            document.getElementById(id)?.addEventListener('click', expandAllFields);
        });
        ['collapseAll', 'collapseAllTop'].forEach(function (id) {
            document.getElementById(id)?.addEventListener('click', collapseAllFields);
        });

        const fieldSearch = document.getElementById('fieldSearch');
        fieldSearch?.addEventListener('input', function () {
            const needle = fieldSearch.value.trim().toLocaleLowerCase();
            document.querySelectorAll('.field-block').forEach(function (block) {
                const haystack = [
                    block.dataset.field || '',
                    block.querySelector('.js-field-summary-type')?.textContent || '',
                    block.querySelector('.js-field-summary-section')?.textContent || ''
                ].join(' ').toLocaleLowerCase();

                block.hidden = needle !== '' && !haystack.includes(needle);
            });
        });

        function updateFieldSummary(block) {
            const type = block.querySelector('.input-type')?.value || 'text';
            const width = block.querySelector('.width-select')?.value || '<?= (int) (config('MyCrud')->defaultBootstrapFieldWidth ?? 6) ?>';
            const sectionSelect = block.querySelector('.js-field-section');
            const sectionText = sectionSelect?.options[sectionSelect.selectedIndex]?.textContent || 'General';

            const typeBadge = block.querySelector('.js-field-summary-type');
            const widthBadge = block.querySelector('.js-field-summary-width');
            const sectionBadge = block.querySelector('.js-field-summary-section');

            if (typeBadge) typeBadge.textContent = type;
            if (widthBadge) widthBadge.textContent = 'col-' + width;
            if (sectionBadge) sectionBadge.innerHTML = '<i class="bi bi-folder2-open me-1"></i>' + sectionText;
        }

        document.querySelectorAll('.field-block').forEach(function (block) {
            block.querySelector('.input-type')?.addEventListener('change', function () { updateFieldSummary(block); });
            block.querySelector('.width-select')?.addEventListener('change', function () { updateFieldSummary(block); });
            block.querySelector('.js-field-section')?.addEventListener('change', function () { updateFieldSummary(block); });
            updateFieldSummary(block);
        });

        function previewControl(type) {
            switch (type) {
                case 'textarea':
                    return '<textarea class="form-control"></textarea>';
                case 'select':
                    return '<select class="form-select"><option>Select...</option></select>';
                case 'checkbox':
                    return '<div class="form-check"><input type="checkbox" class="form-check-input"></div>';
                case 'radio':
                    return '<div class="form-check"><input type="radio" class="form-check-input"></div>';
                case 'hidden':
                    return '<div class="form-text">Field nascosto</div>';
                default:
                    return '<input type="' + type + '" class="form-control">';
            }
        }

        // Le architetture Basic, Standard e Full condividono lo stesso Builder dei fields.

        // Relational Create and the “New parent” link are alternative UX paths.
        // Inline creation preserves the current form data, so when it is enabled
        // the link to the separate parent Create page is turned off and disabled.
        function syncRelatedCreateParentLink(fieldName) {
            const relatedCreate = document.querySelector('.js-related-create[data-field="' + CSS.escape(fieldName) + '"]');
            const createParentLink = document.querySelector('.js-create-parent-link[data-field="' + CSS.escape(fieldName) + '"]');
            if (!relatedCreate || !createParentLink) {
                return;
            }

            if (relatedCreate.checked) {
                createParentLink.checked = false;
                createParentLink.disabled = true;
                createParentLink.title = 'Disabled: the new parent is created in the same form.';
            } else {
                createParentLink.disabled = false;
                createParentLink.title = '';
            }
        }

        document.querySelectorAll('.js-related-create').forEach(function (checkbox) {
            const fieldName = checkbox.dataset.field || '';
            checkbox.addEventListener('change', function () {
                syncRelatedCreateParentLink(fieldName);
            });
            syncRelatedCreateParentLink(fieldName);
        });

        document.querySelectorAll('.field-block').forEach(function (block) {
            const disabled = block.querySelector('input[value="disabled"]');
            const required = block.querySelector('input[value="required"]');
            if (!disabled || !required)
                return;
            const sync = () => {
                required.checked = disabled.checked ? false : required.checked;
                required.disabled = disabled.checked;
            };
            disabled.addEventListener('change', sync);
            sync();
        });

        document.getElementById('showPreview').addEventListener('click', function () {
            const escapeHtml = (value) => String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');

            const configuredSections = sectionItems().map(function (item) {
                const id = String(item.dataset.sectionId || '');
                const title = String(item.querySelector('.js-section-title')?.value || '').trim() || 'Section';
                const descriptionInput = item.querySelector('input[name$="[description]"]');
                const description = String(descriptionInput?.value || '').trim();
                const collapsed = Boolean(item.querySelector('input[name$="[collapsed]"]')?.checked);
                const width = item.querySelector('.js-section-width')?.value || '12';
                return {id, title, description, collapsed, width};
            }).filter(section => section.id !== '');

            const groups = new Map();
            groups.set('', []);

            configuredSections.forEach(function (section) {
                groups.set(section.id, []);
            });

            document.querySelectorAll('.field-block').forEach(function (block) {
                const type = block.querySelector('.input-type')?.value || 'text';
                if (type === 'hidden') {
                    return;
                }

                const labelInput = block.querySelector('.field-label');
                const label = labelInput?.value.trim() || labelInput?.placeholder || block.dataset.field;
                const width = block.querySelector('.width-select')?.value || '<?= (int) (config('MyCrud')->defaultBootstrapFieldWidth ?? 6) ?>';
                const sectionId = block.querySelector('.js-field-section')?.value || '';

                const fieldHtml = `
                    <div class="col-md-${escapeHtml(width)}">
                        <label class="form-label">${escapeHtml(label)}</label>
                        ${previewControl(type)}
                    </div>
                `;

                if (!groups.has(sectionId)) {
                    groups.set(sectionId, []);
                }
                groups.get(sectionId).push(fieldHtml);
            });

            let html = '<form class="row g-3">';

            if (configuredSections.length === 0) {
                html += (groups.get('') || []).join('');
            } else {
                const renderSection = function (section, fields) {
                    if (!fields || fields.length === 0) return '';

                    const description = section.description
                        ? `<div class="small text-muted mt-1 mb-2">${escapeHtml(section.description)}</div>`
                        : '';
                    const open = section.collapsed ? '' : ' open';

                    const width = String(section.width || '12');
                    return `
                        <div class="col-${escapeHtml(width)} crud-form-section-col">
                            <details class="w-100 h-100 border rounded p-3 crud-form-section"${open}>
                                <summary class="fw-semibold">${escapeHtml(section.title)}</summary>
                                ${description}
                                <div class="row g-3 mt-1">
                                    ${fields.join('')}
                                </div>
                            </details>
                        </div>
                    `;
                };

                html += renderSection(
                    {title: 'General', description: '', collapsed: false, width: '12'},
                    groups.get('') || []
                );

                configuredSections.forEach(function (section) {
                    html += renderSection(section, groups.get(section.id) || []);
                });
            }

            html += '</form>';

            document.getElementById('previewContent').innerHTML = html;
            bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('previewModal')
                    ).show();
        });
    });
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const architectureRadios = document.querySelectorAll('.architecture-radio');
    const capabilityInputs = document.querySelectorAll('.api-capability-check');

    const syncApiCapabilities = () => {
        const selected = document.querySelector('.architecture-radio:checked');
        const full = selected && selected.value === 'full';

        capabilityInputs.forEach((input) => {
            const schemaAvailable = input.dataset.schemaAvailable === '1';
            input.disabled = !(full && schemaAvailable);
        });
    };

    architectureRadios.forEach((radio) => radio.addEventListener('change', syncApiCapabilities));
    syncApiCapabilities();
});
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const architectureRadios = document.querySelectorAll('.architecture-radio');
    const mcpEnabled = document.getElementById('mcp_enabled');
    const mcpServerName = document.getElementById('mcp_server_name');

    const syncMcpFoundation = () => {
        const selected = document.querySelector('.architecture-radio:checked');
        const full = selected && selected.value === 'full';
        if (mcpEnabled) {
            mcpEnabled.disabled = !full;
        }
        if (mcpServerName) {
            mcpServerName.disabled = !full;
        }
    };

    architectureRadios.forEach((radio) => radio.addEventListener('change', syncMcpFoundation));
    syncMcpFoundation();
});

    // Initial Create value preview.
    // The right-hand field is editable only in "custom" mode; in automatic
    // modes it becomes a live example based on the browser's local date/time.
    const padInitialValuePart = (value) => String(value).padStart(2, '0');

    const initialValueExample = (mode, temporalType, inputType) => {
        const now = new Date();
        const yyyy = now.getFullYear();
        const mm = padInitialValuePart(now.getMonth() + 1);
        const dd = padInitialValuePart(now.getDate());
        const hh = padInitialValuePart(now.getHours());
        const ii = padInitialValuePart(now.getMinutes());
        const ss = padInitialValuePart(now.getSeconds());

        if (mode === 'none') {
            return 'No initial value';
        }

        if (mode === 'today') {
            return `${yyyy}-${mm}-${dd}`;
        }

        if (mode === 'time') {
            return `${hh}:${ii}:${ss}`;
        }

        if (mode === 'now') {
            return inputType === 'datetime-local'
                ? `${yyyy}-${mm}-${dd}T${hh}:${ii}`
                : `${yyyy}-${mm}-${dd} ${hh}:${ii}:${ss}`;
        }

        if (mode === 'custom') {
            if (inputType === 'date' || temporalType === 'date') {
                return 'e.g. 2026-08-15';
            }
            if (inputType === 'time' || temporalType === 'time') {
                return 'e.g. 14:30:00';
            }
            if (inputType === 'datetime-local') {
                return 'e.g. 2026-08-15T14:30';
            }
            return 'e.g. 2026-08-15 14:30:00';
        }

        return '';
    };

    const refreshInitialValuePreview = (select) => {
        const field = String(select.dataset.field || '');
        if (field === '') {
            return;
        }

        const input = document.querySelector(
            `.js-initial-value-custom[data-field="${CSS.escape(field)}"]`
        );
        if (!input) {
            return;
        }

        const mode = String(select.value || 'none');
        const temporalType = String(select.dataset.temporalType || '');
        const inputType = String(select.dataset.inputType || '');

        input.placeholder = initialValueExample(mode, temporalType, inputType);
        input.readOnly = mode !== 'custom';
        input.classList.toggle('bg-body-tertiary', mode !== 'custom');

        if (mode !== 'custom') {
            input.value = '';
        }
    };

    document.querySelectorAll('.js-initial-value-mode').forEach((select) => {
        refreshInitialValuePreview(select);
        select.addEventListener('change', () => refreshInitialValuePreview(select));
    });

</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const setStatus = (id, value, active = false) => {
        const element = document.getElementById(id);
        if (!element) return;
        element.textContent = value;
        element.classList.toggle('is-active', active);
    };

    const syncBuilderStatus = () => {
        const architecture = document.querySelector('.architecture-radio:checked')?.value || 'basic';
        const architectureLabel = architecture.charAt(0).toUpperCase() + architecture.slice(1);
        setStatus('builderStatusArchitecture', architectureLabel, true);
        const headerArchitecture = document.getElementById('builderHeaderArchitecture');
        if (headerArchitecture) headerArchitecture.textContent = architectureLabel;

        const relationsEnabled = Boolean(document.getElementById('feature_relations')?.checked);
        setStatus('builderStatusRelations', relationsEnabled ? 'On' : 'Off', relationsEnabled);

        const sectionCount = document.querySelectorAll('#formSectionsList .form-section-item').length;
        setStatus('builderStatusSections', String(sectionCount), sectionCount > 0);
        const headerSections = document.getElementById('builderHeaderSections');
        if (headerSections) headerSections.textContent = `${sectionCount} configured`;

        const fieldCount = document.querySelectorAll('#sortableFields .field-block').length;
        setStatus('builderStatusFields', String(fieldCount), fieldCount > 0);

        setStatus('builderStatusApi', architecture === 'full' ? 'Full' : 'Off', architecture === 'full');

        const crudShieldSelect = document.getElementById('crud_security_auth');
        const apiShieldSelect = document.getElementById('api_security_auth');
        const crudShieldOption = crudShieldSelect?.querySelector('option[value="shield_session"]');
        const apiShieldOption = apiShieldSelect?.querySelector('option[value="shield_tokens"]');
        const crudShieldEnabled = crudShieldSelect?.value === 'shield_session';
        const apiShieldEnabled = apiShieldSelect?.value === 'shield_tokens';
        const shieldAvailable = (Boolean(crudShieldOption) && !crudShieldOption.disabled)
            || (Boolean(apiShieldOption) && !apiShieldOption.disabled);
        const shieldLabel = crudShieldEnabled && apiShieldEnabled
            ? 'Web + API'
            : (crudShieldEnabled ? 'Web' : (apiShieldEnabled ? 'API' : (shieldAvailable ? 'Ready' : 'Missing')));
        setStatus('builderStatusShield', shieldLabel, crudShieldEnabled || apiShieldEnabled);

        const mcpEnabled = Boolean(document.getElementById('mcp_enabled')?.checked) && architecture === 'full';
        setStatus('builderStatusMcp', mcpEnabled ? 'On' : 'Off', mcpEnabled);
    };

    document.getElementById('builderForm')?.addEventListener('change', syncBuilderStatus);
    document.getElementById('addFormSection')?.addEventListener('click', () => window.setTimeout(syncBuilderStatus, 0));
    document.getElementById('formSectionsList')?.addEventListener('click', (event) => {
        if (event.target.closest('.js-section-delete')) {
            window.setTimeout(syncBuilderStatus, 0);
        }
    });

    syncBuilderStatus();
});
</script>
<?= $this->endSection() ?>
