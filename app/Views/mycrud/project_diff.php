<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-file-diff me-1"></i>
                <?= esc($title ?? 'Diff') ?>
            </h1>
            <p class="text-muted mb-0">Confronto non distruttivo con app/ operativo.</p>
        </div>

        <a href="<?= site_url('mycrud') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Dashboard
        </a>
    </div>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= esc($error) ?></div>
    <?php elseif (is_array($report)): ?>
        <?php $summary = (array) ($report['summary'] ?? []); ?>

        <?php if (!empty($report['schemaDrift'])): ?>
            <div class="alert alert-warning">
                <i class="bi bi-exclamation-triangle me-1"></i>
                Schema DB modificato rispetto alla saved configuration.
            </div>
        <?php endif ?>

        <div class="row g-3 mb-3">
            <div class="col-md-4">
                <div class="card shadow-sm"><div class="card-body">
                    <div class="text-muted small">Nuovi</div>
                    <div class="fs-3 fw-semibold text-success"><?= (int) ($summary['new'] ?? 0) ?></div>
                </div></div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm"><div class="card-body">
                    <div class="text-muted small">Editti</div>
                    <div class="fs-3 fw-semibold text-warning"><?= (int) ($summary['changed'] ?? 0) ?></div>
                </div></div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm"><div class="card-body">
                    <div class="text-muted small">Invariati</div>
                    <div class="fs-3 fw-semibold"><?= (int) ($summary['unchanged'] ?? 0) ?></div>
                </div></div>
            </div>
        </div>

        <?php foreach (['crud' => 'File CRUD', 'shared' => 'File condivisi'] as $category => $heading): ?>
            <?php
            $categoryRows = array_filter(
                (array) ($report['files'] ?? []),
                static fn (array $row): bool => ($row['category'] ?? 'crud') === $category
                    && ($row['status'] ?? '') !== 'unchanged'
            );
            ?>

            <div class="card shadow-sm mb-3">
                <div class="card-header"><strong><?= esc($heading) ?></strong></div>
                <?php if ($categoryRows === []): ?>
                    <div class="card-body text-muted">No changes.</div>
                <?php else: ?>
                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Status</th>
                                    <th>File</th>
                                    <th class="text-end">Righe</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($categoryRows as $relative => $row): ?>
                                <?php
                                $status = (string) ($row['status'] ?? '');
                                $details = (array) ($row['details'] ?? []);
                                ?>
                                <tr>
                                    <td>
                                        <span class="badge <?= $status === 'new' ? 'text-bg-success' : 'text-bg-warning' ?>">
                                            <?= esc(strtoupper($status)) ?>
                                        </span>
                                    </td>
                                    <td><code><?= esc((string) $relative) ?></code></td>
                                    <td class="text-end text-nowrap">
                                        +<?= (int) ($details['added'] ?? 0) ?> /
                                        -<?= (int) ($details['removed'] ?? 0) ?>
                                    </td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif ?>
            </div>
        <?php endforeach ?>

        <div class="alert alert-info mb-0">
            <i class="bi bi-shield-check me-1"></i>
            Il diff non ha modificato alcun file.
        </div>
    <?php endif ?>
</div>

<?= $this->endSection() ?>
