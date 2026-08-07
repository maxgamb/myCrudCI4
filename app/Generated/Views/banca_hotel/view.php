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
                            <th class="w-25"><?= esc(lang('BancaHotel.banca_hotel_id')) ?></th>
                            <td><?= esc($row->banca_hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.Banca_Nome_Societa')) ?></th>
                            <td><?= esc($row->Banca_Nome_Societa ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.Banca_Nome')) ?></th>
                            <td><?= esc($row->Banca_Nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.Banca_via')) ?></th>
                            <td><?= esc($row->Banca_via ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.Banca_citta')) ?></th>
                            <td><?= esc($row->Banca_citta ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.Intestazione')) ?></th>
                            <td><?= esc($row->Intestazione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.BBAN')) ?></th>
                            <td><?= esc($row->BBAN ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.CIN')) ?></th>
                            <td><?= esc($row->CIN ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.ABI')) ?></th>
                            <td><?= esc($row->ABI ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.CAB')) ?></th>
                            <td><?= esc($row->CAB ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.Rapporto')) ?></th>
                            <td><?= esc($row->Rapporto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.IBAN')) ?></th>
                            <td><?= esc($row->IBAN ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.Filiale')) ?></th>
                            <td><?= esc($row->Filiale ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.SWIFT')) ?></th>
                            <td><?= esc($row->SWIFT ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.SWIFT_SEDE')) ?></th>
                            <td><?= esc($row->SWIFT_SEDE ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('BancaHotel.banca_utente_id')) ?></th>
                            <td><?= esc($row->banca_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('banca_hotel') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
