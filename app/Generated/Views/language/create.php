<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php
$navigationContext = (array) ($navigationContext ?? []);
$parentContext = (array) ($parentContext ?? []);
$cascadeTrail = (array) ($cascadeTrail ?? []);
$navigationParams = $navigationContext;
$encodedTrail = \App\Libraries\Crud\CrudNavigationTrail::encode($cascadeTrail);
if ($encodedTrail !== '') $navigationParams['_trail'] = $encodedTrail;
$navigationQuery = $navigationParams === [] ? '' : '?' . http_build_query($navigationParams);
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
            <li class="breadcrumb-item"><a href="<?= site_url('language') . $navigationQuery ?>">language</a></li>
            <li class="breadcrumb-item active" aria-current="page">New</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">language</h1>
            <small class="text-muted">New record</small>
        </div>
        <div class="d-flex flex-wrap justify-content-end gap-2">
        <?php if (!empty($parentContext['url'])): ?>
            <a href="<?= esc((string) $parentContext['url']) ?>" class="btn btn-outline-secondary" title="Back to parent record">
                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>
                <?= esc((string) ($parentContext['label'] ?? 'Parent')) ?>
            </a>
        <?php else: ?>
            <a href="<?= site_url('language') . $navigationQuery ?>" class="btn btn-outline-secondary" title="Back to list">
                <i class="bi bi-list-ul me-1" aria-hidden="true"></i> List
            </a>
        <?php endif; ?>
        </div>
    </div>
</div>
<!-- mycrud:end page-header -->

<!-- mycrud:start form-partial -->
<?= view('language/_form', [
    'formTitle'         => 'New record',
    'formIcon'          => 'bi-plus-circle',
    'formAction'        => site_url('language/store') . $navigationQuery,
    'row'               => $row ?? null,
    'errors'            => $errors ?? [],
    'options'           => $options ?? [],
    'context'           => $context ?? [],
    'contextLabels'     => $contextLabels ?? [],
    'navigationContext' => $navigationContext,
    'parentContext'     => $parentContext,
    'cascadeTrail'      => $cascadeTrail,
    'submissionToken'   => $submissionToken ?? '',
]) ?>
<!-- mycrud:end form-partial -->

<?= $this->endSection() ?>
