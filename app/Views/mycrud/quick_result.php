<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<?php $summary = $report['summary']; ?>
<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1"><?= $report['dryRun'] ? 'Simulation complete' : 'Generation complete' ?></h1>
            <div class="text-muted">
                <?= esc(ucfirst($report['architecture'])) ?> · <?= number_format((float) $report['durationSeconds'], 3, ',', '.') ?> secondi
            </div>
        </div>
        <div class="d-flex gap-2">
            <a class="btn btn-outline-secondary" href="<?= site_url('mycrud/quick/report/' . rawurlencode($reportFile)) ?>">
                <i class="bi bi-download"></i> JSON report
            </a>
            <a class="btn btn-primary" href="<?= site_url('mycrud/quick') ?>">
                <i class="bi bi-arrow-repeat"></i> New operation
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <?php foreach ([
            ['Tables OK', $summary['tablesOk'], 'success'],
            ['Failed', $summary['tablesFailed'], 'danger'],
            ['Created', $summary['created'], 'primary'],
            ['Overwritten', $summary['overwritten'], 'warning'],
            ['Skipped', $summary['skipped'], 'secondary'],
            ['Planned', $summary['planned'], 'info'],
        ] as [$label, $value, $color]): ?>
            <div class="col-6 col-lg-2">
                <div class="card border-<?= esc($color) ?> h-100">
                    <div class="card-body text-center">
                        <div class="fs-3 fw-bold text-<?= esc($color) ?>"><?= (int) $value ?></div>
                        <div class="small"><?= esc($label) ?></div>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="accordion" id="quickResults">
        <?php foreach ($report['tables'] as $table => $result): ?>
            <?php $id = 'table_' . md5($table); ?>
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#<?= esc($id) ?>">
                        <i class="bi <?= $result['status'] === 'error' ? 'bi-x-circle text-danger' : 'bi-check-circle text-success' ?> me-2"></i>
                        <?= esc($table) ?>
                    </button>
                </h2>
                <div id="<?= esc($id) ?>" class="accordion-collapse collapse" data-bs-parent="#quickResults">
                    <div class="accordion-body">
                        <?php if ($result['status'] === 'error'): ?>
                            <div class="alert alert-danger mb-0"><?= esc($result['message']) ?></div>
                        <?php else: ?>
                            <div class="small text-body-secondary mb-2">
                                <i class="bi bi-sliders me-1"></i>
                                Configuration: <strong><?= (($result['configSource'] ?? 'database') === 'database+saved-config') ? 'DB + saved configuration' : 'solo DB' ?></strong>
                                <?php if (!empty($result['schemaDrift'])): ?>
                                    <span class="badge text-bg-warning ms-1">schema drift rilevato</span>
                                <?php endif ?>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-sm align-middle mb-0">
                                    <thead><tr><th>Component</th><th>Status</th><th>Path</th></tr></thead>
                                    <tbody>
                                    <?php foreach ($result['files'] as $component => $file): ?>
                                        <tr>
                                            <td><code><?= esc($component) ?></code></td>
                                            <td><span class="badge text-bg-secondary"><?= esc($file['status']) ?></span></td>
                                            <td class="small text-break"><?= esc($file['path']) ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<?= $this->endSection() ?>
