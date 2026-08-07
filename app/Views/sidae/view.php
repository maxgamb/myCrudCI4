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
                            <th class="w-25"><?= esc(lang('Sidae.sidae_id')) ?></th>
                            <td><?= esc($row->sidae_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.conto_id')) ?></th>
                            <td><?= esc($row->conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.foglio_id')) ?></th>
                            <td><?= esc($row->foglio_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.nome_cliente')) ?></th>
                            <td><?= esc($row->nome_cliente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.pag_room')) ?></th>
                            <td><?= esc($row->pag_room ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.aliquota')) ?></th>
                            <td><?= esc($row->aliquota ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.quan_room')) ?></th>
                            <td><?= esc($row->quan_room ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.pag_extra')) ?></th>
                            <td><?= esc($row->pag_extra ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.extra_aliquota')) ?></th>
                            <td><?= esc($row->extra_aliquota ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.pag_citytax')) ?></th>
                            <td><?= esc($row->pag_citytax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.pagamentoTipo')) ?></th>
                            <td><?= esc($row->pagamentoTipo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.pagamentoCityTax')) ?></th>
                            <td><?= esc($row->pagamentoCityTax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.codiceLotteria')) ?></th>
                            <td><?= esc($row->codiceLotteria ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.stringaLotteria')) ?></th>
                            <td><?= esc($row->stringaLotteria ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.se_idTrx')) ?></th>
                            <td><?= esc($row->se_idTrx ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.command')) ?></th>
                            <td><?= esc($row->command ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.errore')) ?></th>
                            <td><?= esc($row->errore ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.ae_idTrx')) ?></th>
                            <td><?= esc($row->ae_idTrx ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.numeroDocumento')) ?></th>
                            <td><?= esc($row->numeroDocumento ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.numeroRiferimento')) ?></th>
                            <td><?= esc($row->numeroRiferimento ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.totaleScontrino')) ?></th>
                            <td><?= esc($row->totaleScontrino ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.totaleIva')) ?></th>
                            <td><?= esc($row->totaleIva ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.totaleSconto')) ?></th>
                            <td><?= esc($row->totaleSconto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.importoDetraibile')) ?></th>
                            <td><?= esc($row->importoDetraibile ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.data')) ?></th>
                            <td><?= esc($row->data ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.idElemento')) ?></th>
                            <td><?= esc($row->idElemento ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sidae.utente_id')) ?></th>
                            <td><?= esc($row->utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('sidae') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
