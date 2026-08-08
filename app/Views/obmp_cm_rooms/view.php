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
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_id')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_id')) ?></th>
                            <td><a href="<?= site_url('obmp_cm/view/' . rawurlencode((string) ($row->obmp_cm_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_cm__obmp_cm_id__label ?? $row->obmp_cm_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_room_id')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_room_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_attiva')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_attiva ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_tipologia_id')) ?></th>
                            <td><a href="<?= site_url('tipologia_camera/view/' . rawurlencode((string) ($row->obmp_cm_rooms_tipologia_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->tipologia_camera__obmp_cm_rooms_tipologia_id__label ?? $row->obmp_cm_rooms_tipologia_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_room_note')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_room_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_room_var_prezzo')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_room_var_prezzo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_room_min_prezzo')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_room_min_prezzo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_trattamento')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_trattamento ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_max_pax')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_max_pax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_max_room')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_max_room ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_nesting')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_nesting ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.citytax')) ?></th>
                            <td><?= esc($row->citytax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_foto')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_foto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_foto150')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_foto150 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_foto270')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_foto270 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_foto700')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_foto700 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmRooms.obmp_cm_rooms_utente_id')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_cm_rooms') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Images</strong>
            <span class="badge bg-secondary"><?= (int) ($children['images__obmp_cm_rooms_id']['count'] ?? 0) ?><?= !empty($children['images__obmp_cm_rooms_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['images__obmp_cm_rooms_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Images Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Camera Id') ?></th>
                                <th><?= esc('Tipologia Id') ?></th>
                                <th><?= esc('Img Small') ?></th>
                                <th><?= esc('Img Medium') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->images_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->camera_id ?? '') ?></td>
                                <td><?= esc($child->tipologia_id ?? '') ?></td>
                                <td><?= esc($child->img_small ?? '') ?></td>
                                <td><?= esc($child->img_medium ?? '') ?></td>
                                    <td><a href="<?= site_url('images/view/' . ($child->images_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['images__obmp_cm_rooms_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Listino Obmp</strong>
            <span class="badge bg-secondary"><?= (int) ($children['listino_obmp__tipologia_id']['count'] ?? 0) ?><?= !empty($children['listino_obmp__tipologia_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['listino_obmp__tipologia_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Listino Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Listino Nome Id') ?></th>
                                <th><?= esc('Listino Prezzo') ?></th>
                                <th><?= esc('Ref Site') ?></th>
                                <th><?= esc('Ref Agency') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->listino_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->listino_nome_id ?? '') ?></td>
                                <td><?= esc($child->listino_prezzo ?? '') ?></td>
                                <td><?= esc($child->ref_site ?? '') ?></td>
                                <td><?= esc($child->ref_agency ?? '') ?></td>
                                    <td><a href="<?= site_url('listino_obmp/view/' . ($child->listino_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['listino_obmp__tipologia_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Cm Lingue</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_cm_lingue__obmp_cm_rooms_id']['count'] ?? 0) ?><?= !empty($children['obmp_cm_lingue__obmp_cm_rooms_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_cm_lingue__obmp_cm_rooms_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Obmp Cm Lingue Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Obmp Cm Lingue Codice') ?></th>
                                <th><?= esc('Obmp Cm Lingue Nome') ?></th>
                                <th><?= esc('Obmp Cm Lingue Descrizione') ?></th>
                                <th><?= esc('Obmp Cm Lingue Html1') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->obmp_cm_lingue_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_lingue_codice ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_lingue_nome ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_lingue_descrizione ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_lingue_html1 ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_cm_lingue/view/' . ($child->obmp_cm_lingue_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['obmp_cm_lingue__obmp_cm_rooms_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Rates</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_rates__obmp_cm_rooms_id']['count'] ?? 0) ?><?= !empty($children['obmp_rates__obmp_cm_rooms_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_rates__obmp_cm_rooms_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Obmp Rate Id') ?></th>
                                <th><?= esc('Obmp Restriction Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Obmp Board Cod') ?></th>
                                <th><?= esc('Obmp Cancellation Cod') ?></th>
                                <th><?= esc('Obmp Payment Cod') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->obmp_rate_id ?? '') ?></td>
                                <td><?= esc($child->obmp_restriction_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->obmp_board_cod ?? '') ?></td>
                                <td><?= esc($child->obmp_cancellation_cod ?? '') ?></td>
                                <td><?= esc($child->obmp_payment_cod ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_rates/view/' . ($child->obmp_rate_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['obmp_rates__obmp_cm_rooms_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
