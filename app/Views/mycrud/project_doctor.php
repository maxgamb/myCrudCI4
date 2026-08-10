<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<?php
$summary = $report->summary();
$results = $report->results();
?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-activity me-1"></i>
                Doctor <?= esc($table) ?>
            </h1>
            <p class="text-muted mb-0">Controllo database e configurazione persistente del CRUD.</p>
        </div>

        <a href="<?= site_url('mycrud') ?>" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Dashboard
        </a>
    </div>

    <div class="alert alert-light border py-2 mb-3">
        <i class="bi bi-info-circle me-1"></i>
        <strong>Ambito Doctor:</strong> schema DB + <code>app/MyCrudConfig/<?= esc($table) ?>.php</code>.
        Non analizza i file operativi in <code>app/</code> né quelli in <code>app/Generated/</code>;
        per confrontare i file usa <strong>Diff</strong>.
    </div>

    <div class="d-flex flex-wrap gap-2 mb-3">
        <span class="badge text-bg-success">PASS <?= (int) ($summary['pass'] ?? 0) ?></span>
        <span class="badge text-bg-warning">WARN <?= (int) ($summary['warn'] ?? 0) ?></span>
        <span class="badge text-bg-danger">FAIL <?= (int) ($summary['fail'] ?? 0) ?></span>
        <span class="badge text-bg-secondary">SKIP <?= (int) ($summary['skip'] ?? 0) ?></span>
    </div>

    <div class="card shadow-sm">
        <div class="table-responsive">
            <table class="table table-sm align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th style="width: 90px">Stato</th>
                        <th>Controllo</th>
                        <th>Risultato</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($results as $result): ?>
                    <?php
                    [$badge, $icon] = match ($result->status) {
                        'pass' => ['text-bg-success', 'bi-check-circle'],
                        'warn' => ['text-bg-warning', 'bi-exclamation-triangle'],
                        'fail' => ['text-bg-danger', 'bi-x-circle'],
                        default => ['text-bg-secondary', 'bi-dash-circle'],
                    };
                    ?>
                    <tr>
                        <td>
                            <span class="badge <?= $badge ?>">
                                <i class="bi <?= $icon ?> me-1"></i>
                                <?= esc(strtoupper($result->status)) ?>
                            </span>
                        </td>
                        <td><strong><?= esc($result->name) ?></strong></td>
                        <td><?= esc($result->message) ?></td>
                    </tr>
                <?php endforeach ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
