<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <tbody>
                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.camera_id')) ?></th>
                            <td><?= esc($row->camera_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.numero_camera')) ?></th>
                            <td><?= esc($row->numero_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.tipologia_camera')) ?></th>
                            <td><?= esc($row->tipologia_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.tipologia_id')) ?></th>
                            <td><?= esc($row->tipologia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.camere_max_pax')) ?></th>
                            <td><?= esc($row->camere_max_pax ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.camere_metri_quadri')) ?></th>
                            <td><?= esc($row->camere_metri_quadri ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.camere_vista')) ?></th>
                            <td><?= esc($row->camere_vista ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.camere_piano')) ?></th>
                            <td><?= esc($row->camere_piano ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.camere_bagno')) ?></th>
                            <td><?= esc($row->camere_bagno ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.camere_edificio')) ?></th>
                            <td><?= esc($row->camere_edificio ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.review_tot')) ?></th>
                            <td><?= esc($row->review_tot ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.camere_data_record')) ?></th>
                            <td><?= esc($row->camere_data_record ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.camere_utente_id')) ?></th>
                            <td><?= esc($row->camere_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('camere') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Conti</strong>
            <span class="badge bg-secondary"><?= (int) ($children['conti__camera_id']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['conti__camera_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.conto_id')) ?></th>
                                <th><?= esc(lang('Fields.hotel_id')) ?></th>
                                <th><?= esc(lang('Fields.foglio_id')) ?></th>
                                <th><?= esc(lang('Fields.clienti_id')) ?></th>
                                <th><?= esc(lang('Fields.in_conto')) ?></th>
                                <th><?= esc(lang('Fields.in_conto_time')) ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->conto_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->foglio_id ?? '') ?></td>
                                <td><?= esc($child->clienti_id ?? '') ?></td>
                                <td><?= esc($child->in_conto ?? '') ?></td>
                                <td><?= esc($child->in_conto_time ?? '') ?></td>
                                    <td><a href="<?= site_url('conti/view/' . ($child->conto_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((int) ($children['conti__camera_id']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Foglio Giorno</strong>
            <span class="badge bg-secondary"><?= (int) ($children['foglio_giorno__camera_id']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['foglio_giorno__camera_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.foglio_id')) ?></th>
                                <th><?= esc(lang('Fields.hotel_id')) ?></th>
                                <th><?= esc(lang('Fields.conto_id')) ?></th>
                                <th><?= esc(lang('Fields.preno_id')) ?></th>
                                <th><?= esc(lang('Fields.tipologia_id')) ?></th>
                                <th><?= esc(lang('Fields.numero_camera')) ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->foglio_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->conto_id ?? '') ?></td>
                                <td><?= esc($child->preno_id ?? '') ?></td>
                                <td><?= esc($child->tipologia_id ?? '') ?></td>
                                <td><?= esc($child->numero_camera ?? '') ?></td>
                                    <td><a href="<?= site_url('foglio_giorno/view/' . ($child->foglio_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((int) ($children['foglio_giorno__camera_id']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Guasti</strong>
            <span class="badge bg-secondary"><?= (int) ($children['guasti__camera_id']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['guasti__camera_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.guasto_id')) ?></th>
                                <th><?= esc(lang('Fields.hotel_id')) ?></th>
                                <th><?= esc(lang('Fields.guasto_priorita')) ?></th>
                                <th><?= esc(lang('Fields.guasto_area')) ?></th>
                                <th><?= esc(lang('Fields.guasto_piano')) ?></th>
                                <th><?= esc(lang('Fields.guasto_note')) ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->guasto_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->guasto_priorita ?? '') ?></td>
                                <td><?= esc($child->guasto_area ?? '') ?></td>
                                <td><?= esc($child->guasto_piano ?? '') ?></td>
                                <td><?= esc($child->guasto_note ?? '') ?></td>
                                    <td><a href="<?= site_url('guasti/view/' . ($child->guasto_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((int) ($children['guasti__camera_id']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
