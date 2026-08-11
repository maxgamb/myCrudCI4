<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$navigationContext = (array) ($navigationContext ?? []);
$parentContext = (array) ($parentContext ?? []);
$navigationQuery = $navigationContext === [] ? '' : '?' . http_build_query($navigationContext);
?>

<div class="container py-4 pb-0">
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('address') . $navigationQuery ?>">address</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nuovo</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">address</h1>
            <small class="text-muted">Nuovo record</small>
        </div>
        <div class="d-flex flex-wrap justify-content-end gap-2">
        <?php if (!empty($parentContext['url'])): ?>
            <a href="<?= esc((string) $parentContext['url']) ?>" class="btn btn-outline-secondary" title="Torna al record padre">
                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
                <?= esc((string) ($parentContext['label'] ?? 'Padre')) ?>
            </a>
        <?php else: ?>
            <a href="<?= site_url('address') . $navigationQuery ?>" class="btn btn-outline-secondary" title="Torna alla lista">
                <i class="bi bi-list-ul me-1" aria-hidden="true"></i> Lista
            </a>
        <?php endif; ?>
        </div>
    </div>
</div>

<?= view('address/_form', [
    'formTitle'         => 'Nuovo record',
    'formIcon'          => 'bi-plus-circle',
    'formAction'        => site_url('address/store') . $navigationQuery,
    'row'               => $row ?? null,
    'errors'            => $errors ?? [],
    'options'           => $options ?? [],
    'context'           => $context ?? [],
    'contextLabels'     => $contextLabels ?? [],
    'navigationContext' => $navigationContext,
    'parentContext'     => $parentContext,
    'submissionToken'   => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
