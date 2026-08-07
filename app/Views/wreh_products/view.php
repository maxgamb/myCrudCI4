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
                            <th class="w-25"><?= esc(lang('WrehProducts.product_id')) ?></th>
                            <td><?= esc($row->product_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehProducts.costi_area_id')) ?></th>
                            <td><?= esc($row->costi_area_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehProducts.name')) ?></th>
                            <td><?= esc($row->name ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehProducts.description')) ?></th>
                            <td><?= esc($row->description ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehProducts.price')) ?></th>
                            <td><?= esc($row->price ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehProducts.stock_quantity')) ?></th>
                            <td><?= esc($row->stock_quantity ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehProducts.supplier_id')) ?></th>
                            <td><?= esc($row->supplier_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('wreh_products') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Wreh Order Details</strong>
            <span class="badge bg-secondary"><?= (int) ($children['wreh_order_details__product_id']['count'] ?? 0) ?><?= !empty($children['wreh_order_details__product_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['wreh_order_details__product_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Order Detail Id') ?></th>
                                <th><?= esc('Order Id') ?></th>
                                <th><?= esc('Quantity') ?></th>
                                <th><?= esc('Price') ?></th>
                                <th><?= esc('Utente Id') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->order_detail_id ?? '') ?></td>
                                <td><?= esc($child->order_id ?? '') ?></td>
                                <td><?= esc($child->quantity ?? '') ?></td>
                                <td><?= esc($child->price ?? '') ?></td>
                                <td><?= esc($child->utente_id ?? '') ?></td>
                                    <td><a href="<?= site_url('wreh_order_details/view/' . ($child->order_detail_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['wreh_order_details__product_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
