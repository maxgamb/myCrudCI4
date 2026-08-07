<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped align-middle">
                    <tbody>
                        <tr>
                            <th class="w-25"><?= esc(lang('CamereNesting.nesting_id')) ?></th>
                            <td><?= esc($row->nesting_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CamereNesting.camara_id')) ?></th>
                            <td><?= esc($row->camara_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CamereNesting.tipologia_id')) ?></th>
                            <td><?= esc($row->tipologia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CamereNesting.voto')) ?></th>
                            <td><?= esc($row->voto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CamereNesting.nesting_utente_id')) ?></th>
                            <td><?= esc($row->nesting_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('camere_nesting') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
