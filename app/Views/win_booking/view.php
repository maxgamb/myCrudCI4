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
                            <th class="w-25"><?= esc(lang('WinBooking.win_id')) ?></th>
                            <td><?= esc($row->win_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WinBooking.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WinBooking.win_dal')) ?></th>
                            <td><?= esc($row->win_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WinBooking.win_al')) ?></th>
                            <td><?= esc($row->win_al ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WinBooking.mese')) ?></th>
                            <td><?= esc($row->mese ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WinBooking.win_hotel')) ?></th>
                            <td><?= esc($row->win_hotel ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WinBooking.win_comp')) ?></th>
                            <td><?= esc($row->win_comp ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WinBooking.win_hotel_cum')) ?></th>
                            <td><?= esc($row->win_hotel_cum ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WinBooking.win_comp_cum')) ?></th>
                            <td><?= esc($row->win_comp_cum ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('win_booking') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
