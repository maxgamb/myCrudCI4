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
                            <th class="w-25"><?= esc(lang('CostiVar.costi_var_id')) ?></th>
                            <td><?= esc($row->costi_var_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.costi_area_id')) ?></th>
                            <td><a href="<?= site_url('costi_area/view/' . rawurlencode((string) ($row->costi_area_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->costi_area__costi_area_id__label ?? $row->costi_area_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.costi_var_sub_1')) ?></th>
                            <td><?= esc($row->costi_var_sub_1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.costi_var_sub_2')) ?></th>
                            <td><?= esc($row->costi_var_sub_2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.costi_var_codice')) ?></th>
                            <td><?= esc($row->costi_var_codice ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.costi_var_nome')) ?></th>
                            <td><?= esc($row->costi_var_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.costi_var_deposito')) ?></th>
                            <td><?= esc($row->costi_var_deposito ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.mag_quantita')) ?></th>
                            <td><?= esc($row->mag_quantita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.costi_var_prezzo_uso')) ?></th>
                            <td><?= esc($row->costi_var_prezzo_uso ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.mag_prezzo_lavaggio')) ?></th>
                            <td><?= esc($row->mag_prezzo_lavaggio ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CostiVar.costi_var_addebbito')) ?></th>
                            <td><?= esc($row->costi_var_addebbito ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('costi_var') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Costi Tipologia</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_costi_tipologia__costi_var_id']['count'] ?? 0) ?><?= !empty($children['ref_costi_tipologia__costi_var_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_costi_tipologia__costi_var_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Ref Costi Tipologia Id') ?></th>
                                <th><?= esc('Tipologia Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Stay') ?></th>
                                <th><?= esc('Days') ?></th>
                                <th><?= esc('Check Out') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_costi_tipologia_id ?? '') ?></td>
                                <td><?= esc($child->tipologia_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->stay ?? '') ?></td>
                                <td><?= esc($child->days ?? '') ?></td>
                                <td><?= esc($child->check_out ?? '') ?></td>
                                    <td><a href="<?= site_url('ref_costi_tipologia/view/' . ($child->ref_costi_tipologia_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['ref_costi_tipologia__costi_var_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
