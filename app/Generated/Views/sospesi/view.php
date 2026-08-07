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
                            <th class="w-25"><?= esc(lang('Sospesi.sospeso_id')) ?></th>
                            <td><?= esc($row->sospeso_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.pagamento_id')) ?></th>
                            <td><?= esc($row->pagamento_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.cassa_id')) ?></th>
                            <td><?= esc($row->cassa_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sospeso_data')) ?></th>
                            <td><?= esc($row->sospeso_data ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sospeso_conto_id')) ?></th>
                            <td><?= esc($row->sospeso_conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sospeso_pratica_id')) ?></th>
                            <td><?= esc($row->sospeso_pratica_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sospeso_preno_id')) ?></th>
                            <td><?= esc($row->sospeso_preno_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sospeso_fatt_numero')) ?></th>
                            <td><?= esc($row->sospeso_fatt_numero ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sopeso_importo')) ?></th>
                            <td><?= esc($row->sopeso_importo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sospeso_imp_conto')) ?></th>
                            <td><?= esc($row->sospeso_imp_conto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sopeso_societa')) ?></th>
                            <td><?= esc($row->sopeso_societa ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sospeso_note')) ?></th>
                            <td><?= esc($row->sospeso_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sospeso_stato')) ?></th>
                            <td><?= esc($row->sospeso_stato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Sospesi.sospesi_utente_id')) ?></th>
                            <td><?= esc($row->sospesi_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('sospesi') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Pagamenti Sospesi</strong>
            <span class="badge bg-secondary"><?= (int) ($children['pagamenti_sospesi__sospeso_id']['count'] ?? 0) ?><?= !empty($children['pagamenti_sospesi__sospeso_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['pagamenti_sospesi__sospeso_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Pagamento Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Paga Sosp Importo') ?></th>
                                <th><?= esc('Data Pagamento') ?></th>
                                <th><?= esc('Paga Modalita') ?></th>
                                <th><?= esc('Data Rec Paga Sosp') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->pagamento_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->paga_sosp_importo ?? '') ?></td>
                                <td><?= esc($child->data_pagamento ?? '') ?></td>
                                <td><?= esc($child->paga_modalita ?? '') ?></td>
                                <td><?= esc($child->data_rec_paga_sosp ?? '') ?></td>
                                    <td><a href="<?= site_url('pagamenti_sospesi/view/' . ($child->pagamento_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['pagamenti_sospesi__sospeso_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
