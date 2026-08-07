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
                            <th class="w-25"><?= esc(lang('PagamentiSospesi.pagamento_id')) ?></th>
                            <td><?= esc($row->pagamento_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PagamentiSospesi.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PagamentiSospesi.sospeso_id')) ?></th>
                            <td><?= esc($row->sospeso_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PagamentiSospesi.paga_sosp_importo')) ?></th>
                            <td><?= esc($row->paga_sosp_importo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PagamentiSospesi.data_pagamento')) ?></th>
                            <td><?= esc($row->data_pagamento ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PagamentiSospesi.paga_modalita')) ?></th>
                            <td><?= esc($row->paga_modalita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PagamentiSospesi.data_rec_paga_sosp')) ?></th>
                            <td><?= esc($row->data_rec_paga_sosp ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PagamentiSospesi.pagamenti_sospesi_utente_id')) ?></th>
                            <td><?= esc($row->pagamenti_sospesi_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('pagamenti_sospesi') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
