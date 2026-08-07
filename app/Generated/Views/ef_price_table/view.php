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
                            <th class="w-25"><?= esc(lang('EfPriceTable.price_ef_is')) ?></th>
                            <td><?= esc($row->price_ef_is ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfPriceTable.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfPriceTable.from')) ?></th>
                            <td><?= esc($row->from ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfPriceTable.to')) ?></th>
                            <td><?= esc($row->to ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfPriceTable.single')) ?></th>
                            <td><?= esc($row->single ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfPriceTable.single_plus')) ?></th>
                            <td><?= esc($row->single_plus ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfPriceTable.tw_db')) ?></th>
                            <td><?= esc($row->tw_db ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfPriceTable.student')) ?></th>
                            <td><?= esc($row->student ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfPriceTable.fam_tr')) ?></th>
                            <td><?= esc($row->fam_tr ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('ef_price_table') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
