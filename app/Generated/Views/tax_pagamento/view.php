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
                            <th class="w-25"><?= esc(lang('TaxPagamento.tax_pagamento_id')) ?></th>
                            <td><?= esc($row->tax_pagamento_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TaxPagamento.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TaxPagamento.conto_id')) ?></th>
                            <td><?= esc($row->conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TaxPagamento.pratica_id')) ?></th>
                            <td><?= esc($row->pratica_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TaxPagamento.importo')) ?></th>
                            <td><?= esc($row->importo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TaxPagamento.pagamento_forma')) ?></th>
                            <td><?= esc($row->pagamento_forma ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TaxPagamento.tassa_stato')) ?></th>
                            <td><?= esc($row->tassa_stato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TaxPagamento.data_pagamento')) ?></th>
                            <td><?= esc($row->data_pagamento ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TaxPagamento.tax_pagamento_utente_id')) ?></th>
                            <td><?= esc($row->tax_pagamento_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('tax_pagamento') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
