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
                            <th class="w-25"><?= esc(lang('Cassa.cassa_id')) ?></th>
                            <td><?= esc($row->cassa_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.preno_id')) ?></th>
                            <td><a href="<?= site_url('agenda/view/' . rawurlencode((string) ($row->preno_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->agenda__preno_id__label ?? $row->preno_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.out_conto')) ?></th>
                            <td><?= esc($row->out_conto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.conto_id')) ?></th>
                            <td><?= esc($row->conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.totale_importo')) ?></th>
                            <td><?= esc($row->totale_importo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.totale_modificato')) ?></th>
                            <td><?= esc($row->totale_modificato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.pagamento_importo_pag')) ?></th>
                            <td><?= esc($row->pagamento_importo_pag ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.pagamento_forma')) ?></th>
                            <td><?= esc($row->pagamento_forma ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.cassa_stato_camera')) ?></th>
                            <td><?= esc($row->cassa_stato_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.sospeso')) ?></th>
                            <td><?= esc($row->sospeso ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.fattura_numero')) ?></th>
                            <td><?= esc($row->fattura_numero ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.nome_pagante')) ?></th>
                            <td><?= esc($row->nome_pagante ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.cassa_utente_id')) ?></th>
                            <td><?= esc($row->cassa_utente_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.divisa')) ?></th>
                            <td><?= esc($row->divisa ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.nexi_cod_aut')) ?></th>
                            <td><?= esc($row->nexi_cod_aut ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.nexi_codTrans')) ?></th>
                            <td><?= esc($row->nexi_codTrans ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Cassa.nexi_pan')) ?></th>
                            <td><?= esc($row->nexi_pan ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('cassa') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
