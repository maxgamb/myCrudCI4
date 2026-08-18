<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<?php
$summary = (array) ($project['summary'] ?? []);
$rows = (array) ($project['rows'] ?? []);
$version = (string) ($project['version'] ?? '');
?>

<div class="container-fluid py-4">

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-speedometer2 me-1"></i>
                Project Dashboard
            </h1>
            <p class="text-muted mb-0">
                Status of configured CRUDs and database tables available in the project.
            </p>
        </div>

        <span class="badge text-bg-dark fs-6">
            myCrudCI4 <?= esc($version) ?>
        </span>
    </div>

    <?php if (session('message')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-1"></i>
            <?= esc(session('message')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <?php if (session('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="bi bi-exclamation-triangle me-1"></i>
            <?= esc(session('error')) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    <?php endif ?>

    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-xl-2">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">DB tables</div>
                    <div class="fs-3 fw-semibold"><?= (int) ($summary['dbTables'] ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Configured CRUDs</div>
                    <div class="fs-3 fw-semibold"><?= (int) ($summary['configured'] ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Basic</div>
                    <div class="fs-3 fw-semibold"><?= (int) ($summary['basic'] ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Standard</div>
                    <div class="fs-3 fw-semibold"><?= (int) ($summary['standard'] ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Full</div>
                    <div class="fs-3 fw-semibold"><?= (int) ($summary['full'] ?? 0) ?></div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-4 col-xl-2">
            <div class="card shadow-sm h-100">
                <div class="card-body">
                    <div class="text-muted small">Operational</div>
                    <div class="fs-3 fw-semibold"><?= (int) ($summary['operational'] ?? 0) ?></div>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex flex-wrap gap-2 mb-3">
        <a href="<?= site_url('mycrud/builder') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle me-1"></i>
            Configure CRUD
        </a>

        <a href="<?= site_url('mycrud/quick') ?>" class="btn btn-outline-primary">
            <i class="bi bi-lightning-charge me-1"></i>
            Quick generation
        </a>

        <a href="<?= site_url('mycrud/tools/menu') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-list me-1"></i>
            Menu Builder
        </a>

        <a href="<?= site_url('mycrud/tools/ai-context') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-robot me-1"></i>
            AI Context
        </a>

        <a href="<?= site_url('mycrud/docs') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-book me-1"></i>
            Documentation
        </a>

        <form method="post" action="<?= site_url('mycrud/project/generate-all') ?>" class="d-inline">
            <?= csrf_field() ?>
            <button
                type="submit"
                class="btn btn-success"
                onclick="return confirm('Regeneratere tutti i Configured CRUDs in app/Generated/?');"
            >
                <i class="bi bi-arrow-repeat me-1"></i>
                Generate all
            </button>
        </form>
    </div>

    <div class="card shadow-sm">
        <div class="card-header bg-body d-flex flex-wrap justify-content-between align-items-center gap-2">
            <strong>Project</strong>

            <div class="d-flex gap-2">
                <input
                    id="projectSearch"
                    type="search"
                    class="form-control form-control-sm"
                    placeholder="Search table..."
                    autocomplete="off"
                >

                <select id="projectFilter" class="form-select form-select-sm">
                    <option value="all">All</option>
                    <option value="configured">Configured</option>
                    <option value="unconfigured">Not configured</option>
                    <option value="operational">Operational</option>
                    <option value="staged">In staging</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-sm table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>Table</th>
                        <th>Architecture</th>
                        <th>Config</th>
                        <th>DB</th>
                        <th class="text-end">Rows ~</th>
                        <th class="text-center">Relations</th>
                        <th>Status</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>

                <tbody id="projectRows">
                <?php foreach ($rows as $row): ?>
                    <?php
                    $table = (string) ($row['table'] ?? '');
                    $architecture = (string) ($row['architecture'] ?? '');
                    $configured = !empty($row['configured']);
                    $dbExists = !empty($row['dbExists']);
                    $operational = !empty($row['operational']);
                    $staged = !empty($row['staged']);
                    ?>
                    <tr
                        data-table="<?= esc(strtolower($table)) ?>"
                        data-configured="<?= $configured ? '1' : '0' ?>"
                        data-operational="<?= $operational ? '1' : '0' ?>"
                        data-staged="<?= $staged ? '1' : '0' ?>"
                    >
                        <td>
                            <i class="bi bi-table me-1 text-muted"></i>
                            <strong><?= esc($table) ?></strong>

                            <?php if (!empty($row['configError'])): ?>
                                <div class="small text-danger">
                                    <?= esc((string) $row['configError']) ?>
                                </div>
                            <?php endif ?>
                        </td>

                        <td>
                            <?php if ($architecture !== ''): ?>
                                <?php
                                $architectureClass = match ($architecture) {
                                    'full' => 'text-bg-primary',
                                    'standard' => 'text-bg-info',
                                    default => 'text-bg-secondary',
                                };
                                ?>
                                <span class="badge <?= $architectureClass ?>">
                                    <?= esc(ucfirst($architecture)) ?>
                                </span>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif ?>
                        </td>

                        <td>
                            <?php if ($configured): ?>
                                <span class="badge text-bg-success">Saved</span>
                                <?php if (!empty($row['savedVersion'])): ?>
                                    <div class="small text-muted mt-1">
                                        <?= esc((string) $row['savedVersion']) ?>
                                    </div>
                                <?php endif ?>
                            <?php else: ?>
                                <span class="badge text-bg-light border text-dark">Not configured</span>
                            <?php endif ?>
                        </td>

                        <td>
                            <?php if ($dbExists): ?>
                                <span class="text-success">
                                    <i class="bi bi-check-circle-fill"></i>
                                    Present
                                </span>
                            <?php else: ?>
                                <span class="text-danger">
                                    <i class="bi bi-x-circle-fill"></i>
                                    Missing
                                </span>
                            <?php endif ?>
                        </td>

                        <td class="text-end">
                            <?= number_format((int) ($row['rowEstimate'] ?? 0), 0, ',', '.') ?>
                        </td>

                        <td class="text-center">
                            <?= (int) ($row['relationCount'] ?? 0) ?>
                        </td>

                        <td>
                            <?php if ($operational): ?>
                                <span class="badge text-bg-success">Operational</span>
                            <?php elseif ($staged): ?>
                                <span class="badge text-bg-warning">Staging</span>
                            <?php elseif ($configured): ?>
                                <span class="badge text-bg-secondary">Configured</span>
                            <?php else: ?>
                                <span class="badge text-bg-light border text-dark">Needs configuration</span>
                            <?php endif ?>
                        </td>

                        <td class="text-end text-nowrap">
                            <div class="btn-group btn-group-sm" role="group">
                                <?php if ($dbExists): ?>
                                    <a
                                        href="<?= site_url('mycrud/builder/configure/' . $table) ?>"
                                        class="btn btn-outline-primary"
                                        title="Configure"
                                    >
                                        <i class="bi bi-sliders"></i>
                                    </a>
                                <?php endif ?>

                                <?php if ($configured && $dbExists): ?>
                                    <form
                                        method="post"
                                        action="<?= site_url('mycrud/project/generate/' . $table) ?>"
                                        class="d-inline"
                                    >
                                        <?= csrf_field() ?>
                                        <button
                                            type="submit"
                                            class="btn btn-outline-success rounded-0"
                                            title="Generate in staging"
                                        >
                                            <i class="bi bi-gear"></i>
                                        </button>
                                    </form>

                                    <a
                                        href="<?= site_url('mycrud/project/diff/' . $table) ?>"
                                        class="btn btn-outline-warning"
                                        title="Diff"
                                    >
                                        <i class="bi bi-file-diff"></i>
                                    </a>
                                <?php endif ?>

                                <?php if ($dbExists): ?>
                                    <a
                                        href="<?= site_url('mycrud/project/doctor/' . $table) ?>"
                                        class="btn btn-outline-secondary"
                                        title="Doctor"
                                    >
                                        <i class="bi bi-activity"></i>
                                    </a>
                                <?php endif ?>

                                <?php if ($operational): ?>
                                    <a
                                        href="<?= site_url($table) ?>"
                                        class="btn btn-outline-dark"
                                        title="Open CRUD"
                                        target="_blank"
                                    >
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                <?php endif ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>

        <div id="projectEmpty" class="card-body text-center text-muted d-none">
            No table matches the selected filter.
        </div>
    </div>

</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
(() => {
    const search = document.getElementById('projectSearch');
    const filter = document.getElementById('projectFilter');
    const rows = Array.from(document.querySelectorAll('#projectRows tr'));
    const empty = document.getElementById('projectEmpty');

    const apply = () => {
        const term = (search.value || '').trim().toLowerCase();
        const mode = filter.value;
        let visible = 0;

        rows.forEach((row) => {
            const matchesText = !term || row.dataset.table.includes(term);
            const matchesMode = mode === 'all'
                || (mode === 'configured' && row.dataset.configured === '1')
                || (mode === 'unconfigured' && row.dataset.configured === '0')
                || (mode === 'operational' && row.dataset.operational === '1')
                || (mode === 'staged' && row.dataset.staged === '1');

            const show = matchesText && matchesMode;
            row.classList.toggle('d-none', !show);
            if (show) visible++;
        });

        empty.classList.toggle('d-none', visible !== 0);
    };

    search.addEventListener('input', apply);
    filter.addEventListener('change', apply);
})();
</script>
<?= $this->endSection() ?>
