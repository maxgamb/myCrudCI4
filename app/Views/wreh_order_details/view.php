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
                            <th class="w-25"><?= esc(lang('WrehOrderDetails.order_detail_id')) ?></th>
                            <td><?= esc($row->order_detail_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehOrderDetails.order_id')) ?></th>
                            <td><a href="<?= site_url('wreh_orders/view/' . rawurlencode((string) ($row->order_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->wreh_orders__order_id__label ?? $row->order_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehOrderDetails.product_id')) ?></th>
                            <td><a href="<?= site_url('wreh_products/view/' . rawurlencode((string) ($row->product_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->wreh_products__product_id__label ?? $row->product_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehOrderDetails.quantity')) ?></th>
                            <td><?= esc($row->quantity ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehOrderDetails.price')) ?></th>
                            <td><?= esc($row->price ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehOrderDetails.utente_id')) ?></th>
                            <td><?= esc($row->utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('wreh_order_details') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
