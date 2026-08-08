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
                            <td><a href="<?= site_url('obmp_cm_rooms/view/' . rawurlencode((string) ($row->obmp_cm_rooms_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_cm_rooms__obmp_cm_rooms_id__label ?? $row->obmp_cm_rooms_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.obmp_restriction_id')) ?></th>
                            <td><a href="<?= site_url('obmp_restrictions/view/' . rawurlencode((string) ($row->obmp_restriction_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_restrictions__obmp_restriction_id__label ?? $row->obmp_restriction_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.obmp_board_cod')) ?></th>
                            <td><a href="<?= site_url('obmp_board/view/' . rawurlencode((string) ($row->obmp_board_cod ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_board__obmp_board_cod__label ?? $row->obmp_board_cod ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.obmp_cancellation_cod')) ?></th>
                            <td><a href="<?= site_url('obmp_cancellations/view/' . rawurlencode((string) ($row->obmp_cancellation_cod ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_cancellations__obmp_cancellation_cod__label ?? $row->obmp_cancellation_cod ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRates.obmp_payment_cod')) ?></th>
                            <td><a href="<?= site_url('obmp_payments/view/' . rawurlencode((string) ($row->obmp_payment_cod ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_payments__obmp_payment_cod__label ?? $row->obmp_payment_cod ?? '') ?></a></td>
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
