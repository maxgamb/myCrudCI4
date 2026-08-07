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
                            <th class="w-25"><?= esc(lang('Hotels.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.nome_hotel')) ?></th>
                            <td><?= esc($row->nome_hotel ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_tipologia')) ?></th>
                            <td><?= esc($row->hotel_tipologia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_categoria')) ?></th>
                            <td><?= esc($row->hotel_categoria ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_citta')) ?></th>
                            <td><?= esc($row->hotel_citta ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_via')) ?></th>
                            <td><?= esc($row->hotel_via ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_tel')) ?></th>
                            <td><?= esc($row->hotel_tel ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_fax')) ?></th>
                            <td><?= esc($row->hotel_fax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_email')) ?></th>
                            <td><?= esc($row->hotel_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_stato')) ?></th>
                            <td><?= esc($row->hotel_stato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_cap')) ?></th>
                            <td><?= esc($row->hotel_cap ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_piva')) ?></th>
                            <td><?= esc($row->hotel_piva ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_numero_camere')) ?></th>
                            <td><?= esc($row->hotel_numero_camere ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotels_utente_id')) ?></th>
                            <td><?= esc($row->hotels_utente_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_web')) ?></th>
                            <td><?= esc($row->hotel_web ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_logo')) ?></th>
                            <td><?= esc($row->hotel_logo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_mappa')) ?></th>
                            <td><?= esc($row->hotel_mappa ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_reach_by_car')) ?></th>
                            <td><?= esc($row->hotel_reach_by_car ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_reach_by_treno')) ?></th>
                            <td><?= esc($row->hotel_reach_by_treno ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_reach_aereo')) ?></th>
                            <td><?= esc($row->hotel_reach_aereo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_reach_nave')) ?></th>
                            <td><?= esc($row->hotel_reach_nave ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_foto_piccola')) ?></th>
                            <td><?= esc($row->hotel_foto_piccola ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_foto_grande')) ?></th>
                            <td><?= esc($row->hotel_foto_grande ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_testo_en')) ?></th>
                            <td><?= esc($row->hotel_testo_en ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_testo_it')) ?></th>
                            <td><?= esc($row->hotel_testo_it ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_disp_modo')) ?></th>
                            <td><?= esc($row->hotel_disp_modo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_limite_vendite_web')) ?></th>
                            <td><?= esc($row->hotel_limite_vendite_web ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_limite_vendite_xml')) ?></th>
                            <td><?= esc($row->hotel_limite_vendite_xml ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_incremento_prezzo_xml')) ?></th>
                            <td><?= esc($row->hotel_incremento_prezzo_xml ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_booking_attivazione')) ?></th>
                            <td><?= esc($row->hotel_booking_attivazione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_booking_url')) ?></th>
                            <td><?= esc($row->hotel_booking_url ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_booking_agenzia')) ?></th>
                            <td><?= esc($row->hotel_booking_agenzia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_tarif_cambia_gg')) ?></th>
                            <td><?= esc($row->hotel_tarif_cambia_gg ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_tarif_listino_nome_id')) ?></th>
                            <td><?= esc($row->hotel_tarif_listino_nome_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_agenzia_attivazione')) ?></th>
                            <td><?= esc($row->hotel_agenzia_attivazione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_type_booking')) ?></th>
                            <td><?= esc($row->hotel_type_booking ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_check_in')) ?></th>
                            <td><?= esc($row->hotel_check_in ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_check_out')) ?></th>
                            <td><?= esc($row->hotel_check_out ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_serv_inclusi')) ?></th>
                            <td><?= esc($row->hotel_serv_inclusi ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.hotel_cancel_pol')) ?></th>
                            <td><?= esc($row->hotel_cancel_pol ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.facebook')) ?></th>
                            <td><?= esc($row->facebook ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.google')) ?></th>
                            <td><?= esc($row->google ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.instagram')) ?></th>
                            <td><?= esc($row->instagram ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.twitter')) ?></th>
                            <td><?= esc($row->twitter ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.linkedin')) ?></th>
                            <td><?= esc($row->linkedin ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.analytics')) ?></th>
                            <td><?= esc($row->analytics ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.email_desk')) ?></th>
                            <td><?= esc($row->email_desk ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.tripadvisor')) ?></th>
                            <td><?= esc($row->tripadvisor ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.trip_rec_url')) ?></th>
                            <td><?= esc($row->trip_rec_url ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.pec')) ?></th>
                            <td><?= esc($row->pec ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.sdi')) ?></th>
                            <td><?= esc($row->sdi ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.ae_user')) ?></th>
                            <td><?= esc($row->ae_user ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.ae_password')) ?></th>
                            <td><?= esc($row->ae_password ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.ae_pin')) ?></th>
                            <td><?= esc($row->ae_pin ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.ae_codice_fiscale')) ?></th>
                            <td><?= esc($row->ae_codice_fiscale ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.sa_nome')) ?></th>
                            <td><?= esc($row->sa_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.sa_chiave')) ?></th>
                            <td><?= esc($row->sa_chiave ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.ae_test')) ?></th>
                            <td><?= esc($row->ae_test ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.citytax')) ?></th>
                            <td><?= esc($row->citytax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.wifi_network')) ?></th>
                            <td><?= esc($row->wifi_network ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.wifi_password')) ?></th>
                            <td><?= esc($row->wifi_password ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.chek_email')) ?></th>
                            <td><?= esc($row->chek_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.chek_tel')) ?></th>
                            <td><?= esc($row->chek_tel ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.nexi_alias')) ?></th>
                            <td><?= esc($row->nexi_alias ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.nexi_key')) ?></th>
                            <td><?= esc($row->nexi_key ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.nexi_url')) ?></th>
                            <td><?= esc($row->nexi_url ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.cir_bdsr')) ?></th>
                            <td><?= esc($row->cir_bdsr ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.cin_bdsr')) ?></th>
                            <td><?= esc($row->cin_bdsr ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Hotels.catastale_id')) ?></th>
                            <td><?= esc($row->catastale_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('hotels') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Doc File</strong>
            <span class="badge bg-secondary"><?= (int) ($children['doc_file__hotel_id']['count'] ?? 0) ?><?= !empty($children['doc_file__hotel_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['doc_file__hotel_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Doc Files Id') ?></th>
                                <th><?= esc('Doc Dipar Id') ?></th>
                                <th><?= esc('Doc Protocollo') ?></th>
                                <th><?= esc('Doc Url File') ?></th>
                                <th><?= esc('Doc Note') ?></th>
                                <th><?= esc('Doc Utente Id') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->doc_files_id ?? '') ?></td>
                                <td><?= esc($child->doc_dipar_id ?? '') ?></td>
                                <td><?= esc($child->doc_protocollo ?? '') ?></td>
                                <td><?= esc($child->doc_url_file ?? '') ?></td>
                                <td><?= esc($child->doc_note ?? '') ?></td>
                                <td><?= esc($child->doc_utente_id ?? '') ?></td>
                                    <td><a href="<?= site_url('doc_file/view/' . ($child->doc_files_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['doc_file__hotel_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Guasti</strong>
            <span class="badge bg-secondary"><?= (int) ($children['guasti__hotel_id']['count'] ?? 0) ?><?= !empty($children['guasti__hotel_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['guasti__hotel_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Guasto Id') ?></th>
                                <th><?= esc('Camera Id') ?></th>
                                <th><?= esc('Guasto Priorita') ?></th>
                                <th><?= esc('Guasto Area') ?></th>
                                <th><?= esc('Guasto Piano') ?></th>
                                <th><?= esc('Guasto Note') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->guasto_id ?? '') ?></td>
                                <td><?= esc($child->camera_id ?? '') ?></td>
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
                <?php if (!empty($children['guasti__hotel_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
