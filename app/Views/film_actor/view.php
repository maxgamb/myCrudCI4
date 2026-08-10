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
        break-inside: avoid;
    }
}
</style>

<div class="container py-4">
    <div class="d-flex justify-content-end mb-3 d-print-none">
        <button type="button" class="btn btn-outline-secondary" onclick="window.print()">
            <i class="bi bi-printer"></i> Stampa
        </button>
    </div>

    <div id="crud-print-area">
        <div class="card shadow-sm">
            <div class="card-header">
                <h1 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h1>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered table-striped align-middle">
                        <tbody>
                        <tr>
                            <th class="w-25"><?= esc(lang('FilmActor.actor_id')) ?></th>
                            <td><a href="<?= site_url('actor/view/' . rawurlencode((string) ($row->{'actor_id'} ?? ''))) ?>" class="text-decoration-none"><?= esc($row->{'actor__actor_id__label'} ?? $row->{'actor_id'} ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FilmActor.film_id')) ?></th>
                            <td><a href="<?= site_url('film/view/' . rawurlencode((string) ($row->{'film_id'} ?? ''))) ?>" class="text-decoration-none"><?= esc($row->{'film__film_id__label'} ?? $row->{'film_id'} ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FilmActor.last_update')) ?></th>
                            <td><?= esc($row->{'last_update'} ?? '') ?></td>
                        </tr>                        </tbody>
                    </table>
                </div>
                <a href="<?= site_url('film_actor') ?>" class="btn btn-secondary d-print-none">
                    <i class="bi bi-arrow-left"></i> Torna alla lista
                </a>
            </div>
        </div>

    </div>
</div>

<?= $this->endSection() ?>
