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
                            <th class="w-25"><?= esc(lang('ReferClienti.conto_id')) ?></th>
                            <td><?= esc($row->conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ReferClienti.clienti_id')) ?></th>
                            <td><?= esc($row->clienti_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ReferClienti.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ReferClienti.ps_valore')) ?></th>
                            <td><?= esc($row->ps_valore ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ReferClienti.refer_clienti_utente_id')) ?></th>
                            <td><?= esc($row->refer_clienti_utente_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ReferClienti.refer_clienti_conto_id')) ?></th>
                            <td><?= esc($row->refer_clienti_conto_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('refer_clienti') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Clienti</strong>
            <span class="badge bg-secondary"><?= (int) ($children['clienti__clienti_id']['count'] ?? 0) ?><?= !empty($children['clienti__clienti_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['clienti__clienti_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Clienti Id') ?></th>
                                <th><?= esc('Preno Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Camera Id') ?></th>
                                <th><?= esc('Camera Numero') ?></th>
                                <th><?= esc('Camara Tipologia') ?></th>
                                <th><?= esc('Clienti Nome') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->clienti_id ?? '') ?></td>
                                <td><?= esc($child->preno_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->camera_id ?? '') ?></td>
                                <td><?= esc($child->camera_numero ?? '') ?></td>
                                <td><?= esc($child->camara_tipologia ?? '') ?></td>
                                <td><?= esc($child->clienti_nome ?? '') ?></td>
                                    <td><a href="<?= site_url('clienti/view/' . ($child->clienti_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['clienti__clienti_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
