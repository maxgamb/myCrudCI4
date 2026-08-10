<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = 'customer_id';
$rowId = $row->{$primaryKey} ?? '';
$navigationContext = (array) ($navigationContext ?? []);
$navigationQuery = $navigationContext === [] ? '' : '?' . http_build_query($navigationContext);
$formAction = site_url('customer/update/' . rawurlencode((string) $rowId)) . $navigationQuery;
?>

<div class="container py-4 pb-0">
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
            <li class="breadcrumb-item"><a href="<?= site_url('customer') . $navigationQuery ?>">customer</a></li>
            <li class="breadcrumb-item active" aria-current="page">Modifica</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">customer</h1>
            <small class="text-muted">Modifica record</small>
        </div>
        <div class="d-flex flex-wrap justify-content-end gap-2">
        <a href="<?= site_url('customer/create') . $navigationQuery ?>" class="btn btn-primary" title="Nuovo record">
            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> Nuovo
        </a>
        <a href="<?= site_url('customer') . $navigationQuery ?>" class="btn btn-outline-secondary" title="Torna alla lista">
            <i class="bi bi-list-ul me-1" aria-hidden="true"></i> Lista
        </a>
        <a href="<?= site_url('customer/view/' . rawurlencode((string) $rowId)) . $navigationQuery ?>" class="btn btn-outline-info" title="Visualizza record">
            <i class="bi bi-eye me-1" aria-hidden="true"></i> Visualizza
        </a>
        <form method="post" action="<?= site_url('customer/delete/' . rawurlencode((string) $rowId)) . $navigationQuery ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
            <?= csrf_field() ?>
            <?php foreach ($navigationContext as $contextField => $contextValue): ?>
                <input type="hidden" name="_context[<?= esc((string) $contextField) ?>]" value="<?= esc((string) $contextValue) ?>">
            <?php endforeach; ?>
            <button type="submit" class="btn btn-outline-danger" title="Cancella record">
                <i class="bi bi-trash me-1" aria-hidden="true"></i> Cancella
            </button>
        </form>
        </div>
    </div>
</div>

<?= view('customer/_form', [
    'formTitle'         => 'Modifica record',
    'formIcon'          => 'bi-pencil-square',
    'formAction'        => $formAction,
    'row'               => $row ?? null,
    'errors'            => $errors ?? [],
    'options'           => $options ?? [],
    'context'           => [],
    'contextLabels'     => [],
    'navigationContext' => $navigationContext,
    'submissionToken'   => $submissionToken ?? '',
]) ?>

<?= $this->endSection() ?>
