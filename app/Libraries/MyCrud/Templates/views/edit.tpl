<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$primaryKey = '{{PRIMARY_KEY}}';
$rowId = $row->{$primaryKey} ?? '';
$navigationContext = (array) ($navigationContext ?? []);
$cascadeTrail = (array) ($cascadeTrail ?? []);
$navigationParams = $navigationContext;
$encodedTrail = \App\Libraries\Crud\CrudNavigationTrail::encode($cascadeTrail);
if ($encodedTrail !== '') $navigationParams['_trail'] = $encodedTrail;
$navigationQuery = $navigationParams === [] ? '' : '?' . http_build_query($navigationParams);
$formAction = site_url('{{ROUTE}}/update/' . rawurlencode((string) $rowId)) . $navigationQuery;
?>

<!-- mycrud:start page-header -->
<div class="container py-4 pb-0">
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
            <?php $trailPrefix = []; ?>
            <?php foreach ($cascadeTrail as $segment): ?>
                <?php
                $segmentQuery = \App\Libraries\Crud\CrudNavigationTrail::encode($trailPrefix);
                $segmentUrl = site_url((string) $segment['table'] . '/view/' . rawurlencode((string) $segment['id']));
                if ($segmentQuery !== '') $segmentUrl .= '?_trail=' . rawurlencode($segmentQuery);
                ?>
                <li class="breadcrumb-item"><a href="<?= esc($segmentUrl) ?>"><?= esc((string) $segment['label']) ?></a></li>
                <?php $trailPrefix[] = $segment; ?>
            <?php endforeach; ?>
            <li class="breadcrumb-item"><a href="<?= site_url('{{ROUTE}}') . $navigationQuery ?>">{{TABLE}}</a></li>
            <li class="breadcrumb-item active" aria-current="page">Edit</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">{{TABLE}}</h1>
            <small class="text-muted">Edit record</small>
        </div>
        <div class="d-flex flex-wrap justify-content-end gap-2">
        <a href="<?= site_url('{{ROUTE}}/create') . $navigationQuery ?>" class="btn btn-primary" title="New record">
            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> New
        </a>
        <a href="<?= site_url('{{ROUTE}}') . $navigationQuery ?>" class="btn btn-outline-secondary" title="Back to list">
            <i class="bi bi-list-ul me-1" aria-hidden="true"></i> List
        </a>
        <a href="<?= site_url('{{ROUTE}}/view/' . rawurlencode((string) $rowId)) . $navigationQuery ?>" class="btn btn-outline-info" title="Visualizza record">
            <i class="bi bi-eye me-1" aria-hidden="true"></i> Visualizza
        </a>
        <form method="post" action="<?= site_url('{{ROUTE}}/delete/' . rawurlencode((string) $rowId)) . $navigationQuery ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
            <?= csrf_field() ?>
            <?php foreach ($navigationContext as $contextField => $contextValue): ?>
                <input type="hidden" name="_context[<?= esc((string) $contextField) ?>]" value="<?= esc((string) $contextValue) ?>">
            <?php endforeach; ?>
            <?php if ($encodedTrail !== ''): ?>
                <input type="hidden" name="_trail" value="<?= esc($encodedTrail) ?>">
            <?php endif; ?>
            <button type="submit" class="btn btn-outline-danger" title="Cancella record">
                <i class="bi bi-trash me-1" aria-hidden="true"></i> Cancella
            </button>
        </form>
        </div>
    </div>
</div>
<!-- mycrud:end page-header -->

<!-- mycrud:start form-partial -->
<?= view('{{VIEW_PATH}}/_form', [
    'formTitle'         => 'Edit record',
    'formIcon'          => 'bi-pencil-square',
    'formAction'        => $formAction,
    'row'               => $row ?? null,
    'errors'            => $errors ?? [],
    'options'           => $options ?? [],
    'context'           => [],
    'contextLabels'     => [],
    'navigationContext' => $navigationContext,
    'cascadeTrail'      => $cascadeTrail,
    'submissionToken'   => $submissionToken ?? '',
]) ?>
<!-- mycrud:end form-partial -->

<?= $this->endSection() ?>
