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
                            <th class="w-25"><?= esc(lang('Pratiche.pratica_id')) ?></th>
                            <td><?= esc($row->pratica_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Pratiche.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Pratiche.pratica_nome')) ?></th>
                            <td><?= esc($row->pratica_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Pratiche.pratica_agenzia_id')) ?></th>
                            <td><?= esc($row->pratica_agenzia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Pratiche.pratica_1')) ?></th>
                            <td><?= esc($row->pratica_1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Pratiche.pratica_2')) ?></th>
                            <td><?= esc($row->pratica_2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Pratiche.pratica_note')) ?></th>
                            <td><?= esc($row->pratica_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Pratiche.pratica_stato')) ?></th>
                            <td><?= esc($row->pratica_stato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Pratiche.pratiche_utente_id')) ?></th>
                            <td><?= esc($row->pratiche_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('pratiche') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Pratiche Rif</strong>
            <span class="badge bg-secondary"><?= (int) ($children['pratiche_rif__pratiche_rif_id']['count'] ?? 0) ?><?= !empty($children['pratiche_rif__pratiche_rif_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['pratiche_rif__pratiche_rif_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Pratica Rif Pratica Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Pratica Rif Conto Id') ?></th>
                                <th><?= esc('Pratica Rif Totale Modificato') ?></th>
                                <th><?= esc('Pratica Rif Totale Importo') ?></th>
                                <th><?= esc('Pratica Rif Pagamento Importo Pag') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->pratica_rif_pratica_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->pratica_rif_conto_id ?? '') ?></td>
                                <td><?= esc($child->pratica_rif_totale_modificato ?? '') ?></td>
                                <td><?= esc($child->pratica_rif_totale_importo ?? '') ?></td>
                                <td><?= esc($child->pratica_rif_pagamento_importo_pag ?? '') ?></td>
                                    <td><a href="<?= site_url('pratiche_rif/view/' . ($child->pratica_rif_pratica_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['pratiche_rif__pratiche_rif_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Sospesi</strong>
            <span class="badge bg-secondary"><?= (int) ($children['sospesi__sospeso_pratica_id']['count'] ?? 0) ?><?= !empty($children['sospesi__sospeso_pratica_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['sospesi__sospeso_pratica_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Sospeso Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Pagamento Id') ?></th>
                                <th><?= esc('Cassa Id') ?></th>
                                <th><?= esc('Sospeso Data') ?></th>
                                <th><?= esc('Sospeso Conto Id') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->sospeso_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->pagamento_id ?? '') ?></td>
                                <td><?= esc($child->cassa_id ?? '') ?></td>
                                <td><?= esc($child->sospeso_data ?? '') ?></td>
                                <td><?= esc($child->sospeso_conto_id ?? '') ?></td>
                                    <td><a href="<?= site_url('sospesi/view/' . ($child->sospeso_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['sospesi__sospeso_pratica_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
