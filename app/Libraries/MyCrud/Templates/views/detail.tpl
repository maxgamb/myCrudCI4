<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<style>
@media print {
    body * {
        visibility: hidden !important;
    }

    #crud-print-area,
    #crud-print-area * {
        visibility: visible !important;
    }

    #crud-print-area {
        position: absolute;
        inset: 0 auto auto 0;
        width: 100%;
    }

    #crud-print-area .d-print-none {
        display: none !important;
    }

    #crud-print-area .card {
        box-shadow: none !important;
        break-inside: auto;
    }

    /* The initial detail section remains compact; hasMany panels may instead
       start in the available space and continue on the next page. */
    #crud-print-area > .card:first-child {
        break-inside: avoid;
    }
}
</style>

<?php
$navigationContext = (array) ($navigationContext ?? []);
$cascadeTrail = (array) ($cascadeTrail ?? []);
$navigationParams = $navigationContext;
$encodedTrail = \App\Libraries\Crud\CrudNavigationTrail::encode($cascadeTrail);
if ($encodedTrail !== '') $navigationParams['_trail'] = $encodedTrail;
$navigationQuery = $navigationParams === [] ? '' : '?' . http_build_query($navigationParams);
?>

<div class="container py-4">
    <div class="d-print-none">
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
                <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <div>
                <h1 class="h3 mb-0">{{TABLE}}</h1>
                <small class="text-muted">Record details</small>
            </div>
            <div class="d-flex flex-wrap justify-content-end gap-2">
{{TOOLBAR_ACTIONS}}            </div>
        </div>
    </div>

    <!-- mycrud:start record-detail -->
    <div id="crud-print-area">
        <div class="card shadow-sm">
            <div class="card-header">
                <h2 class="h4 mb-0"><i class="bi bi-eye"></i> Record details</h2>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped align-middle">
                        <tbody>
{{ROWS}}                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- mycrud:start relation-panels -->
{{PANELS}}        <!-- mycrud:end relation-panels -->
    </div>
    <!-- mycrud:end record-detail -->
</div>

<?= $this->endSection() ?>
