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
                            <th class="w-25"><?= esc(lang('PraticheRif.pratica_rif_pratica_id')) ?></th>
                            <td><?= esc($row->pratica_rif_pratica_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PraticheRif.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PraticheRif.pratica_rif_conto_id')) ?></th>
                            <td><?= esc($row->pratica_rif_conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PraticheRif.pratica_rif_totale_modificato')) ?></th>
                            <td><?= esc($row->pratica_rif_totale_modificato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PraticheRif.pratica_rif_totale_importo')) ?></th>
                            <td><?= esc($row->pratica_rif_totale_importo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PraticheRif.pratica_rif_pagamento_importo_pag')) ?></th>
                            <td><?= esc($row->pratica_rif_pagamento_importo_pag ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PraticheRif.pratica_rif_note')) ?></th>
                            <td><?= esc($row->pratica_rif_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PraticheRif.pratica_rif_out_conto')) ?></th>
                            <td><?= esc($row->pratica_rif_out_conto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PraticheRif.pratiche_rif_id')) ?></th>
                            <td><?= esc($row->pratiche_rif_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('pratiche_rif') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
