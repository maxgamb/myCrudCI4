<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$navigationContext = (array) ($navigationContext ?? []);
$navigationQuery = $navigationContext === [] ? '' : '?' . http_build_query($navigationContext);
?>

<div class="container py-4 pb-0">
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('film') . $navigationQuery ?>">film</a></li>
            <li class="breadcrumb-item active" aria-current="page">Nuovo</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">film</h1>
            <small class="text-muted">Nuovo record</small>
        </div>
        <div class="d-flex flex-wrap justify-content-end gap-2">
        <a href="<?= site_url('film') . $navigationQuery ?>" class="btn btn-outline-secondary" title="Torna alla lista">
            <i class="bi bi-list-ul me-1" aria-hidden="true"></i> Lista
        </a>
        </div>
    </div>
</div>

<?= view('film/_form', [
    'formTitle'         => 'Nuovo record',
    'formIcon'          => 'bi-plus-circle',
    'formAction'        => site_url('film/store') . $navigationQuery,
    'row'               => $row ?? null,
    'errors'            => $errors ?? [],
    'options'           => $options ?? [],
    'context'           => $context ?? [],
    'contextLabels'     => $contextLabels ?? [],
    'navigationContext' => $navigationContext,
    'submissionToken'   => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
