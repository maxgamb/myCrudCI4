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
                            <th class="w-25"><?= esc(lang('WrehSuppliers.supplier_id')) ?></th>
                            <td><?= esc($row->supplier_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehSuppliers.company')) ?></th>
                            <td><?= esc($row->company ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehSuppliers.contact_name')) ?></th>
                            <td><?= esc($row->contact_name ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehSuppliers.phone')) ?></th>
                            <td><?= esc($row->phone ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehSuppliers.email')) ?></th>
                            <td><?= esc($row->email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehSuppliers.address')) ?></th>
                            <td><?= esc($row->address ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('WrehSuppliers.utente_id')) ?></th>
                            <td><?= esc($row->utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('wreh_suppliers') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Wreh Products</strong>
            <span class="badge bg-secondary"><?= (int) ($children['wreh_products__supplier_id']['count'] ?? 0) ?><?= !empty($children['wreh_products__supplier_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['wreh_products__supplier_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Product Id') ?></th>
                                <th><?= esc('Costi Area Id') ?></th>
                                <th><?= esc('Name') ?></th>
                                <th><?= esc('Description') ?></th>
                                <th><?= esc('Price') ?></th>
                                <th><?= esc('Stock Quantity') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->product_id ?? '') ?></td>
                                <td><?= esc($child->costi_area_id ?? '') ?></td>
                                <td><?= esc($child->name ?? '') ?></td>
                                <td><?= esc($child->description ?? '') ?></td>
                                <td><?= esc($child->price ?? '') ?></td>
                                <td><?= esc($child->stock_quantity ?? '') ?></td>
                                    <td><a href="<?= site_url('wreh_products/view/' . ($child->product_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['wreh_products__supplier_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
