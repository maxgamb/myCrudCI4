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
                            <th class="w-25"><?= esc(lang('Regioni.regione_id')) ?></th>
                            <td><?= esc($row->regione_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Regioni.cod_provincia')) ?></th>
                            <td><?= esc($row->cod_provincia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Regioni.provincia')) ?></th>
                            <td><?= esc($row->provincia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Regioni.regione')) ?></th>
                            <td><?= esc($row->regione ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('regioni') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
