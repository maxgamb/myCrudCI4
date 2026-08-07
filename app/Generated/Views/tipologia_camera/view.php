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
                            <th class="w-25"><?= esc(lang('TipologiaCamera.tipologia_id')) ?></th>
                            <td><?= esc($row->tipologia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TipologiaCamera.nome_tipologia')) ?></th>
                            <td><?= esc($row->nome_tipologia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TipologiaCamera.nome_tipologia_en')) ?></th>
                            <td><?= esc($row->nome_tipologia_en ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TipologiaCamera.nome_tipologia_fr')) ?></th>
                            <td><?= esc($row->nome_tipologia_fr ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TipologiaCamera.nome_tipologia_de')) ?></th>
                            <td><?= esc($row->nome_tipologia_de ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TipologiaCamera.nome_tipologia_sp')) ?></th>
                            <td><?= esc($row->nome_tipologia_sp ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TipologiaCamera.nome_tipologia_jp')) ?></th>
                            <td><?= esc($row->nome_tipologia_jp ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TipologiaCamera.tipologia_sigla')) ?></th>
                            <td><?= esc($row->tipologia_sigla ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TipologiaCamera.numero_pax')) ?></th>
                            <td><?= esc($row->numero_pax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TipologiaCamera.tipologia_camera_utente_id')) ?></th>
                            <td><?= esc($row->tipologia_camera_utente_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TipologiaCamera.perc_prezzo')) ?></th>
                            <td><?= esc($row->perc_prezzo ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('tipologia_camera') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Camere</strong>
            <span class="badge bg-secondary"><?= (int) ($children['camere__tipologia_id']['count'] ?? 0) ?><?= !empty($children['camere__tipologia_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['camere__tipologia_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Camera Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Numero Camera') ?></th>
                                <th><?= esc('Tipologia Camera') ?></th>
                                <th><?= esc('Camere Max Pax') ?></th>
                                <th><?= esc('Camere Metri Quadri') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->camera_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->numero_camera ?? '') ?></td>
                                <td><?= esc($child->tipologia_camera ?? '') ?></td>
                                <td><?= esc($child->camere_max_pax ?? '') ?></td>
                                <td><?= esc($child->camere_metri_quadri ?? '') ?></td>
                                    <td><a href="<?= site_url('camere/view/' . ($child->camera_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['camere__tipologia_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Foglio Giorno</strong>
            <span class="badge bg-secondary"><?= (int) ($children['foglio_giorno__tipologia_id']['count'] ?? 0) ?><?= !empty($children['foglio_giorno__tipologia_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['foglio_giorno__tipologia_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Foglio Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Conto Id') ?></th>
                                <th><?= esc('Camera Id') ?></th>
                                <th><?= esc('Preno Id') ?></th>
                                <th><?= esc('Numero Camera') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->foglio_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->conto_id ?? '') ?></td>
                                <td><?= esc($child->camera_id ?? '') ?></td>
                                <td><?= esc($child->preno_id ?? '') ?></td>
                                <td><?= esc($child->numero_camera ?? '') ?></td>
                                    <td><a href="<?= site_url('foglio_giorno/view/' . ($child->foglio_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['foglio_giorno__tipologia_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Cm Rooms</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_cm_rooms__obmp_cm_rooms_tipologia_id']['count'] ?? 0) ?><?= !empty($children['obmp_cm_rooms__obmp_cm_rooms_tipologia_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_cm_rooms__obmp_cm_rooms_tipologia_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Obmp Cm Rooms Id') ?></th>
                                <th><?= esc('Obmp Cm Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Obmp Cm Rooms Room Id') ?></th>
                                <th><?= esc('Obmp Cm Rooms Attiva') ?></th>
                                <th><?= esc('Obmp Cm Rooms Room Note') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->obmp_cm_rooms_id ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_rooms_room_id ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_rooms_attiva ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_rooms_room_note ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_cm_rooms/view/' . ($child->obmp_cm_rooms_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['obmp_cm_rooms__obmp_cm_rooms_tipologia_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Costi Tipologia</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_costi_tipologia__tipologia_id']['count'] ?? 0) ?><?= !empty($children['ref_costi_tipologia__tipologia_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_costi_tipologia__tipologia_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Ref Costi Tipologia Id') ?></th>
                                <th><?= esc('Costi Var Id') ?></th>
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
                                <td><?= esc($child->costi_var_id ?? '') ?></td>
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
                <?php if (!empty($children['ref_costi_tipologia__tipologia_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
