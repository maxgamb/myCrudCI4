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
                            <th class="w-25"><?= esc(lang('FoglioGiorno.foglio_id')) ?></th>
                            <td><?= esc($row->foglio_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.conto_id')) ?></th>
                            <td><?= esc($row->conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.camera_id')) ?></th>
                            <td><a href="<?= site_url('camere/view/' . rawurlencode((string) ($row->camera_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->camere__camera_id__label ?? $row->camera_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.preno_id')) ?></th>
                            <td><a href="<?= site_url('agenda/view/' . rawurlencode((string) ($row->preno_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->agenda__preno_id__label ?? $row->preno_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.tipologia_id')) ?></th>
                            <td><a href="<?= site_url('tipologia_camera/view/' . rawurlencode((string) ($row->tipologia_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->tipologia_camera__tipologia_id__label ?? $row->tipologia_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.numero_camera')) ?></th>
                            <td><?= esc($row->numero_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.foglio_prezzo_camera')) ?></th>
                            <td><?= esc($row->foglio_prezzo_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.date_foglio')) ?></th>
                            <td><?= esc($row->date_foglio ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.nome_cliente')) ?></th>
                            <td><?= esc($row->nome_cliente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.cognome_cliente')) ?></th>
                            <td><?= esc($row->cognome_cliente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.in_conto')) ?></th>
                            <td><?= esc($row->in_conto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.out_preno')) ?></th>
                            <td><?= esc($row->out_preno ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.stato_camera')) ?></th>
                            <td><?= esc($row->stato_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.preno_agenzia')) ?></th>
                            <td><a href="<?= site_url('agenzie/view/' . rawurlencode((string) ($row->preno_agenzia ?? ''))) ?>" class="text-decoration-none"><?= esc($row->agenzie__preno_agenzia__label ?? $row->preno_agenzia ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('FoglioGiorno.foglio_utente_id')) ?></th>
                            <td><?= esc($row->foglio_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('foglio_giorno') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Conti</strong>
            <span class="badge bg-secondary"><?= (int) ($children['conti__foglio_id']['count'] ?? 0) ?><?= !empty($children['conti__foglio_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['conti__foglio_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Conto Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Clienti Id') ?></th>
                                <th><?= esc('In Conto') ?></th>
                                <th><?= esc('In Conto Time') ?></th>
                                <th><?= esc('Out Preno') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->conto_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->clienti_id ?? '') ?></td>
                                <td><?= esc($child->in_conto ?? '') ?></td>
                                <td><?= esc($child->in_conto_time ?? '') ?></td>
                                <td><?= esc($child->out_preno ?? '') ?></td>
                                    <td><a href="<?= site_url('conti/view/' . ($child->conto_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['conti__foglio_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
