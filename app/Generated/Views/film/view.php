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
                <li class="breadcrumb-item"><a href="<?= site_url('film') . $navigationQuery ?>">film</a></li>
                <li class="breadcrumb-item active" aria-current="page">Details</li>
            </ol>
        </nav>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
            <div>
                <h1 class="h3 mb-0">film</h1>
                <small class="text-muted">Record details</small>
            </div>
            <div class="d-flex flex-wrap justify-content-end gap-2">
        <a href="<?= site_url('film/create') . ($navigationQuery ?? '') ?>" class="btn btn-primary" title="New record">
            <i class="bi bi-plus-circle me-1" aria-hidden="true"></i> New
        </a>        <a href="<?= site_url('film') . ($navigationQuery ?? '') ?>" class="btn btn-outline-secondary" title="Back to list">
            <i class="bi bi-list-ul me-1" aria-hidden="true"></i> List
        </a>
        <a href="<?= site_url('film/edit/' . rawurlencode((string) ($row->{'film_id'} ?? ''))) . ($navigationQuery ?? '') ?>" class="btn btn-outline-warning" title="Edit record">
            <i class="bi bi-pencil-square me-1" aria-hidden="true"></i> Edit
        </a>
        <form method="post" action="<?= site_url('film/delete/' . rawurlencode((string) ($row->{'film_id'} ?? ''))) . ($navigationQuery ?? '') ?>" class="d-inline" onsubmit="return confirm('Delete this record?')">
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
                            <th class="w-25"><?= esc(lang('Film.film_id')) ?></th>
                            <td><?= esc($row->{'film_id'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.title')) ?></th>
                            <td><?= esc($row->{'title'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.description')) ?></th>
                            <td><?= esc($row->{'description'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.release_year')) ?></th>
                            <td><?= esc($row->{'release_year'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.language_id')) ?></th>
                            <td><?= esc($row->{'language_id__label'} ?? $row->{'language_id'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.original_language_id')) ?></th>
                            <td><?= esc($row->{'original_language_id__label'} ?? $row->{'original_language_id'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.rental_duration')) ?></th>
                            <td><?= esc($row->{'rental_duration'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.rental_rate')) ?></th>
                            <td><?= esc($row->{'rental_rate'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.length')) ?></th>
                            <td><?= esc($row->{'length'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.replacement_cost')) ?></th>
                            <td><?= esc($row->{'replacement_cost'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.rating')) ?></th>
                            <td><?= esc($row->{'rating'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.special_features')) ?></th>
                            <td><?= esc($row->{'special_features'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.last_update')) ?></th>
                            <td><?= esc($row->{'last_update'} ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Film.uploads')) ?></th>
                            <td><?= esc($row->{'uploads'} ?? '') ?></td>
                        </tr>                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- mycrud:start relation-panels -->
<?= view('film/_children_inventory__film_id', ['row' => $row, 'children' => $children, 'cascadeTrail' => $cascadeTrail ?? []]) ?>
<?= view('film/_many_many__film_actor__film_id', ['row' => $row, 'children' => $children, 'cascadeTrail' => $cascadeTrail ?? []]) ?>
<?= view('film/_many_many__film_category__film_id', ['row' => $row, 'children' => $children, 'cascadeTrail' => $cascadeTrail ?? []]) ?>
        <!-- mycrud:end relation-panels -->
    </div>
    <!-- mycrud:end record-detail -->
</div>

<?= $this->endSection() ?>
