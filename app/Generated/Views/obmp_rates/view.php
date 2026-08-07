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
                            <th class="w-25"><?= esc(lang('ObmpRates.obmp_rate_id')) ?></th>
                            <td><?= esc($row->obmp_rate_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.obmp_cm_rooms_id')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.obmp_restriction_id')) ?></th>
                            <td><?= esc($row->obmp_restriction_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.obmp_board_cod')) ?></th>
                            <td><?= esc($row->obmp_board_cod ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.obmp_cancellation_cod')) ?></th>
                            <td><?= esc($row->obmp_cancellation_cod ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.obmp_payment_cod')) ?></th>
                            <td><?= esc($row->obmp_payment_cod ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.rate_sum')) ?></th>
                            <td><?= esc($row->rate_sum ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.rate_mol')) ?></th>
                            <td><?= esc($row->rate_mol ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.rate_stato')) ?></th>
                            <td><?= esc($row->rate_stato ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_rates') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
