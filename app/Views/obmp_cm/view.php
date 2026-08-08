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
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_id')) ?></th>
                            <td><?= esc($row->obmp_cm_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.agenzia_id')) ?></th>
                            <td><a href="<?= site_url('agenzie/view/' . rawurlencode((string) ($row->agenzia_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->agenzie__agenzia_id__label ?? $row->agenzia_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_id_hotel_agenzia')) ?></th>
                            <td><?= esc($row->obmp_cm_id_hotel_agenzia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_attiva')) ?></th>
                            <td><?= esc($row->obmp_cm_attiva ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_agenzia_url')) ?></th>
                            <td><?= esc($row->obmp_cm_agenzia_url ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_agenzia_user')) ?></th>
                            <td><?= esc($row->obmp_cm_agenzia_user ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_agenzia_password')) ?></th>
                            <td><?= esc($row->obmp_cm_agenzia_password ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_ws_agenzia_url')) ?></th>
                            <td><?= esc($row->obmp_cm_ws_agenzia_url ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_ws_agenzia_user')) ?></th>
                            <td><?= esc($row->obmp_cm_ws_agenzia_user ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_ws_agenzia_password')) ?></th>
                            <td><?= esc($row->obmp_cm_ws_agenzia_password ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_tipologia_id1')) ?></th>
                            <td><?= esc($row->obmp_cm_tipologia_id1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_room_id1')) ?></th>
                            <td><?= esc($row->obmp_cm_room_id1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_tipologia_id2')) ?></th>
                            <td><?= esc($row->obmp_cm_tipologia_id2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_room_id2')) ?></th>
                            <td><?= esc($row->obmp_cm_room_id2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_tipologia_id3')) ?></th>
                            <td><?= esc($row->obmp_cm_tipologia_id3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_room_id3')) ?></th>
                            <td><?= esc($row->obmp_cm_room_id3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_tipologia_id4')) ?></th>
                            <td><?= esc($row->obmp_cm_tipologia_id4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_room_id4')) ?></th>
                            <td><?= esc($row->obmp_cm_room_id4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_tipologia_id5')) ?></th>
                            <td><?= esc($row->obmp_cm_tipologia_id5 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_room_id5')) ?></th>
                            <td><?= esc($row->obmp_cm_room_id5 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_tipologia_id6')) ?></th>
                            <td><?= esc($row->obmp_cm_tipologia_id6 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_room_id6')) ?></th>
                            <td><?= esc($row->obmp_cm_room_id6 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_tipologia_id7')) ?></th>
                            <td><?= esc($row->obmp_cm_tipologia_id7 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_room_id7')) ?></th>
                            <td><?= esc($row->obmp_cm_room_id7 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_tipologia_id8')) ?></th>
                            <td><?= esc($row->obmp_cm_tipologia_id8 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_room_id8')) ?></th>
                            <td><?= esc($row->obmp_cm_room_id8 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_tipologia_id9')) ?></th>
                            <td><?= esc($row->obmp_cm_tipologia_id9 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_room_id9')) ?></th>
                            <td><?= esc($row->obmp_cm_room_id9 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_tipologia_id10')) ?></th>
                            <td><?= esc($row->obmp_cm_tipologia_id10 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_room_id10')) ?></th>
                            <td><?= esc($row->obmp_cm_room_id10 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_moltiplicatore')) ?></th>
                            <td><?= esc($row->obmp_cm_moltiplicatore ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_max_camere')) ?></th>
                            <td><?= esc($row->obmp_cm_max_camere ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_min_camare')) ?></th>
                            <td><?= esc($row->obmp_cm_min_camare ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCm.obmp_cm_utente_id')) ?></th>
                            <td><?= esc($row->obmp_cm_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_cm') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Cm Rooms</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_cm_rooms__obmp_cm_id']['count'] ?? 0) ?><?= !empty($children['obmp_cm_rooms__obmp_cm_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_cm_rooms__obmp_cm_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Obmp Cm Rooms Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Obmp Cm Rooms Room Id') ?></th>
                                <th><?= esc('Obmp Cm Rooms Attiva') ?></th>
                                <th><?= esc('Obmp Cm Rooms Tipologia Id') ?></th>
                                <th><?= esc('Obmp Cm Rooms Room Note') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->obmp_cm_rooms_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_rooms_room_id ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_rooms_attiva ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_rooms_tipologia_id ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_rooms_room_note ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_cm_rooms/view/' . ($child->obmp_cm_rooms_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['obmp_cm_rooms__obmp_cm_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
