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
                <li class="breadcrumb-item"><a href="<?= site_url('inventory') . $navigationQuery ?>">inventory</a></li>
                <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <div>
                <h1 class="h3 mb-0">inventory</h1>
                <small class="text-muted">Record details</small>
            </div>
            <div class="d-flex flex-wrap justify-content-end gap-2">
        <a href="<?= site_url('inventory/create') . ($navigationQuery ?? '') ?>" class="btn btn-primary" title="New record">
            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> New
        </a>        <a href="<?= site_url('inventory') . ($navigationQuery ?? '') ?>" class="btn btn-outline-secondary" title="Back to list">
            <i class="bi bi-list-ul me-1" aria-hidden="true"></i> List
        </a>
        <a href="<?= site_url('inventory/edit/' . rawurlencode((string) ($row->{'inventory_id'} ?? ''))) . ($navigationQuery ?? '') ?>" class="btn btn-outline-warning" title="Edit record">
            <i class="bi bi-pencil-square me-1" aria-hidden="true"></i> Edit
        </a>
        <form method="post" action="<?= site_url('inventory/delete/' . rawurlencode((string) ($row->{'inventory_id'} ?? ''))) . ($navigationQuery ?? '') ?>" class="d-inline" onsubmit="return confirm('Delete this record?')">
            <?= csrf_field() ?>
            <?php foreach ((array) ($navigationContext ?? []) as $contextField => $contextValue): ?>
                <input type="hidden" name="_context[<?= esc((string) $contextField) ?>]" value="<?= esc((string) $contextValue) ?>">
            <?php endforeach; ?>
            <button type="submit" class="btn btn-outline-danger" title="Delete record">
                <i class="bi bi-trash me-1" aria-hidden="true"></i> Cancella
            </button>
        </form>        <button type="button" class="btn btn-outline-secondary" onclick="window.print()" title="Print details">
            <i class="bi bi-printer me-1" aria-hidden="true"></i> Stampa
        </button>            </div>
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
                        <tr>
                            <th class="w-25"><?= esc(lang('Inventory.inventory_id')) ?></th>
                            <td><?= esc($row->{'inventory_id'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Inventory.film_id')) ?></th>
                            <td><?php
$parentTargetId = (string) ($row->{'film_id'} ?? '');
$parentTrail = \App\Libraries\Crud\CrudNavigationTrail::ancestorsForParent((array) ($cascadeTrail ?? []), 'film', $parentTargetId);
if ($parentTrail === (array) ($cascadeTrail ?? [])) {
    $parentTrail = \App\Libraries\Crud\CrudNavigationTrail::append($parentTrail, "inventory", (string) ($row->{'inventory_id'} ?? ''), 'Inventory' . ' #' . (string) ($row->{'inventory_id'} ?? ''));
}
$parentTrailEncoded = \App\Libraries\Crud\CrudNavigationTrail::encode($parentTrail);
$parentUrl = site_url('film' . '/view/' . rawurlencode($parentTargetId));
if ($parentTrailEncoded !== '') $parentUrl .= '?_trail=' . rawurlencode($parentTrailEncoded);
?>
<a href="<?= esc($parentUrl) ?>" class="text-decoration-none"><?= esc($row->{'film_id__label'} ?? $row->{'film_id'} ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Inventory.store_id')) ?></th>
                            <td><?php
$parentTargetId = (string) ($row->{'store_id'} ?? '');
$parentTrail = \App\Libraries\Crud\CrudNavigationTrail::ancestorsForParent((array) ($cascadeTrail ?? []), 'store', $parentTargetId);
if ($parentTrail === (array) ($cascadeTrail ?? [])) {
    $parentTrail = \App\Libraries\Crud\CrudNavigationTrail::append($parentTrail, "inventory", (string) ($row->{'inventory_id'} ?? ''), 'Inventory' . ' #' . (string) ($row->{'inventory_id'} ?? ''));
}
$parentTrailEncoded = \App\Libraries\Crud\CrudNavigationTrail::encode($parentTrail);
$parentUrl = site_url('store' . '/view/' . rawurlencode($parentTargetId));
if ($parentTrailEncoded !== '') $parentUrl .= '?_trail=' . rawurlencode($parentTrailEncoded);
?>
<a href="<?= esc($parentUrl) ?>" class="text-decoration-none"><?= esc($row->{'store_id__label'} ?? $row->{'store_id'} ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Inventory.last_update')) ?></th>
                            <td><?= esc($row->{'last_update'} ?? '') ?></td>
                        </tr>                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- mycrud:start relation-panels -->
<?= view('inventory/_children_rental__inventory_id', ['row' => $row, 'children' => $children, 'cascadeTrail' => $cascadeTrail ?? []]) ?>
        <!-- mycrud:end relation-panels -->
    </div>
    <!-- mycrud:end record-detail -->
</div>

<?= $this->endSection() ?>
