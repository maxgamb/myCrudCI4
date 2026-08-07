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
                            <th class="w-25"><?= esc(lang('Woucher.woucher_id')) ?></th>
                            <td><?= esc($row->woucher_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_agenzia_id')) ?></th>
                            <td><?= esc($row->woucher_agenzia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_preno_id')) ?></th>
                            <td><?= esc($row->woucher_preno_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_hotel_id')) ?></th>
                            <td><?= esc($row->woucher_hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_in')) ?></th>
                            <td><?= esc($row->woucher_in ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_notti')) ?></th>
                            <td><?= esc($row->woucher_notti ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_out')) ?></th>
                            <td><?= esc($row->woucher_out ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_numero')) ?></th>
                            <td><?= esc($row->woucher_numero ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_serie')) ?></th>
                            <td><?= esc($row->woucher_serie ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_singole')) ?></th>
                            <td><?= esc($row->woucher_singole ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_singole_staff')) ?></th>
                            <td><?= esc($row->woucher_singole_staff ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_doppia')) ?></th>
                            <td><?= esc($row->woucher_doppia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_tripla')) ?></th>
                            <td><?= esc($row->woucher_tripla ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_quadrupla')) ?></th>
                            <td><?= esc($row->woucher_quadrupla ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_cildren_n')) ?></th>
                            <td><?= esc($row->woucher_cildren_n ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_doppia_studenti')) ?></th>
                            <td><?= esc($row->woucher_doppia_studenti ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_tripla_studenti')) ?></th>
                            <td><?= esc($row->woucher_tripla_studenti ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_quadrupla_studenti')) ?></th>
                            <td><?= esc($row->woucher_quadrupla_studenti ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_quintupla_studenti')) ?></th>
                            <td><?= esc($row->woucher_quintupla_studenti ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_tot_pax')) ?></th>
                            <td><?= esc($row->woucher_tot_pax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_tot_adulti')) ?></th>
                            <td><?= esc($row->woucher_tot_adulti ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_tot_studenti')) ?></th>
                            <td><?= esc($row->woucher_tot_studenti ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Woucher.woucher_note')) ?></th>
                            <td><?= esc($row->woucher_note ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('woucher') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
