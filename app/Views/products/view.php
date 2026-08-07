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
                            <th class="w-25"><?= esc(lang('Products.product_id')) ?></th>
                            <td><?= esc($row->product_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Products.name')) ?></th>
                            <td><?= esc($row->name ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Products.description')) ?></th>
                            <td><?= esc($row->description ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Products.price')) ?></th>
                            <td><?= esc($row->price ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Products.stock_quantity')) ?></th>
                            <td><?= esc($row->stock_quantity ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Products.supplier_id')) ?></th>
                            <td><?= esc($row->supplier_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('products') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
