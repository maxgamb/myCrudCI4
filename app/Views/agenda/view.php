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
                            <th class="w-25"><?= esc(lang('Agenda.preno_id')) ?></th>
                            <td><?= esc($row->preno_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_in_data')) ?></th>
                            <td><?= esc($row->preno_in_data ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_importo')) ?></th>
                            <td><?= esc($row->preno_importo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_impoto_mod')) ?></th>
                            <td><?= esc($row->preno_impoto_mod ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_dal')) ?></th>
                            <td><?= esc($row->preno_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_al')) ?></th>
                            <td><?= esc($row->preno_al ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_n_notti')) ?></th>
                            <td><?= esc($row->preno_n_notti ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_arr_ore')) ?></th>
                            <td><?= esc($row->preno_arr_ore ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_trattamento')) ?></th>
                            <td><?= esc($row->preno_trattamento ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.t1')) ?></th>
                            <td><?= esc($row->t1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.q1')) ?></th>
                            <td><?= esc($row->q1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.p1')) ?></th>
                            <td><?= esc($row->p1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.t2')) ?></th>
                            <td><?= esc($row->t2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.q2')) ?></th>
                            <td><?= esc($row->q2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.p2')) ?></th>
                            <td><?= esc($row->p2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.t3')) ?></th>
                            <td><?= esc($row->t3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.q3')) ?></th>
                            <td><?= esc($row->q3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.p3')) ?></th>
                            <td><?= esc($row->p3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.t4')) ?></th>
                            <td><?= esc($row->t4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.q4')) ?></th>
                            <td><?= esc($row->q4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.p4')) ?></th>
                            <td><?= esc($row->p4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.t5')) ?></th>
                            <td><?= esc($row->t5 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.q5')) ?></th>
                            <td><?= esc($row->q5 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.p5')) ?></th>
                            <td><?= esc($row->p5 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.t6')) ?></th>
                            <td><?= esc($row->t6 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.q6')) ?></th>
                            <td><?= esc($row->q6 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.p6')) ?></th>
                            <td><?= esc($row->p6 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_nome')) ?></th>
                            <td><?= esc($row->preno_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_cogno')) ?></th>
                            <td><?= esc($row->preno_cogno ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_agenzia')) ?></th>
                            <td><a href="<?= site_url('agenzie/view/' . rawurlencode((string) ($row->preno_agenzia ?? ''))) ?>" class="text-decoration-none"><?= esc($row->agenzie__preno_agenzia__label ?? $row->preno_agenzia ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.voucher_id')) ?></th>
                            <td><?= esc($row->voucher_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.ota_voucher')) ?></th>
                            <td><?= esc($row->ota_voucher ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.allotment_id')) ?></th>
                            <td><?= esc($row->allotment_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_cc_tip')) ?></th>
                            <td><?= esc($row->preno_cc_tip ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_cc_n')) ?></th>
                            <td><?= esc($row->preno_cc_n ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_cc_scad')) ?></th>
                            <td><?= esc($row->preno_cc_scad ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_tel')) ?></th>
                            <td><?= esc($row->preno_tel ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_fax')) ?></th>
                            <td><?= esc($row->preno_fax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_email')) ?></th>
                            <td><?= esc($row->preno_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_mercato')) ?></th>
                            <td><?= esc($row->preno_mercato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.nazione_iso2')) ?></th>
                            <td><?= esc($row->nazione_iso2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_note')) ?></th>
                            <td><?= esc($row->preno_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_doc_fax')) ?></th>
                            <td><?= esc($row->preno_doc_fax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_doc_email')) ?></th>
                            <td><?= esc($row->preno_doc_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_doc_form')) ?></th>
                            <td><?= esc($row->preno_doc_form ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_doc_mail')) ?></th>
                            <td><?= esc($row->preno_doc_mail ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_doc_vaglia')) ?></th>
                            <td><?= esc($row->preno_doc_vaglia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_doc_woucher')) ?></th>
                            <td><?= esc($row->preno_doc_woucher ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_pag_modalita')) ?></th>
                            <td><?= esc($row->preno_pag_modalita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_caparra')) ?></th>
                            <td><?= esc($row->preno_caparra ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.preno_stato')) ?></th>
                            <td><?= esc($row->preno_stato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.data_opzione')) ?></th>
                            <td><?= esc($row->data_opzione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.cancella_user')) ?></th>
                            <td><?= esc($row->cancella_user ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.cancella_pass')) ?></th>
                            <td><?= esc($row->cancella_pass ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Agenda.agenda_utente_id')) ?></th>
                            <td><?= esc($row->agenda_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('agenda') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Cassa</strong>
            <span class="badge bg-secondary"><?= (int) ($children['cassa__preno_id']['count'] ?? 0) ?><?= !empty($children['cassa__preno_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['cassa__preno_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Cassa Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Out Conto') ?></th>
                                <th><?= esc('Conto Id') ?></th>
                                <th><?= esc('Totale Importo') ?></th>
                                <th><?= esc('Totale Modificato') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->cassa_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->out_conto ?? '') ?></td>
                                <td><?= esc($child->conto_id ?? '') ?></td>
                                <td><?= esc($child->totale_importo ?? '') ?></td>
                                <td><?= esc($child->totale_modificato ?? '') ?></td>
                                    <td><a href="<?= site_url('cassa/view/' . ($child->cassa_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['cassa__preno_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Colori</strong>
            <span class="badge bg-secondary"><?= (int) ($children['colori__col_preno_id']['count'] ?? 0) ?><?= !empty($children['colori__col_preno_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['colori__col_preno_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Colore Nome') ?></th>
                                <th><?= esc('Colore Codice') ?></th>
                                <th><?= esc('Colore Data Record') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->colore_nome ?? '') ?></td>
                                <td><?= esc($child->colore_codice ?? '') ?></td>
                                <td><?= esc($child->colore_data_record ?? '') ?></td>
                                    <td><a href="<?= site_url('colori/view/' . ($child->colore_nome ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['colori__col_preno_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Foglio Giorno</strong>
            <span class="badge bg-secondary"><?= (int) ($children['foglio_giorno__preno_id']['count'] ?? 0) ?><?= !empty($children['foglio_giorno__preno_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['foglio_giorno__preno_id']['rows'] ?? []; ?>
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
                                <th><?= esc('Tipologia Id') ?></th>
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
                                <td><?= esc($child->tipologia_id ?? '') ?></td>
                                <td><?= esc($child->numero_camera ?? '') ?></td>
                                    <td><a href="<?= site_url('foglio_giorno/view/' . ($child->foglio_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['foglio_giorno__preno_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Modifica Agenda</strong>
            <span class="badge bg-secondary"><?= (int) ($children['modifica_agenda__mod_agenda_id']['count'] ?? 0) ?><?= !empty($children['modifica_agenda__mod_agenda_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['modifica_agenda__mod_agenda_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Mod Agenda Id') ?></th>
                                <th><?= esc('Mod Preno Id') ?></th>
                                <th><?= esc('Mod Agenda Valori') ?></th>
                                <th><?= esc('Mod Preno Data Records') ?></th>
                                <th><?= esc('Modifica Agenda Adebiti Utente Id') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->mod_agenda_id ?? '') ?></td>
                                <td><?= esc($child->mod_preno_id ?? '') ?></td>
                                <td><?= esc($child->mod_agenda_valori ?? '') ?></td>
                                <td><?= esc($child->mod_preno_data_records ?? '') ?></td>
                                <td><?= esc($child->modifica_agenda_adebiti_utente_id ?? '') ?></td>
                                    <td><a href="<?= site_url('modifica_agenda/view/' . ($child->mod_agenda_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['modifica_agenda__mod_agenda_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Agenda Clienti</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_agenda_clienti__preno_id']['count'] ?? 0) ?><?= !empty($children['ref_agenda_clienti__preno_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_agenda_clienti__preno_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Ref Agenda Cliente') ?></th>
                                <th><?= esc('Clienti Id') ?></th>
                                <th><?= esc('Tipologia Id') ?></th>
                                <th><?= esc('Ref A C Datarecord') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_agenda_cliente ?? '') ?></td>
                                <td><?= esc($child->clienti_id ?? '') ?></td>
                                <td><?= esc($child->tipologia_id ?? '') ?></td>
                                <td><?= esc($child->ref_a_c_datarecord ?? '') ?></td>
                                    <td><a href="<?= site_url('ref_agenda_clienti/view/' . ($child->ref_agenda_cliente ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['ref_agenda_clienti__preno_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Agenzia Preno</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_agenzia_preno__preno_id']['count'] ?? 0) ?><?= !empty($children['ref_agenzia_preno__preno_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_agenzia_preno__preno_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Ref Agenzia Preno') ?></th>
                                <th><?= esc('Agenzia Id') ?></th>
                                <th><?= esc('Ref A P Datarecord') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_agenzia_preno ?? '') ?></td>
                                <td><?= esc($child->agenzia_id ?? '') ?></td>
                                <td><?= esc($child->ref_a_p_datarecord ?? '') ?></td>
                                    <td><a href="<?= site_url('ref_agenzia_preno/view/' . ($child->ref_agenzia_preno ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['ref_agenzia_preno__preno_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Obmp Booking</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_obmp_booking__preno_id']['count'] ?? 0) ?><?= !empty($children['ref_obmp_booking__preno_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_obmp_booking__preno_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Ref Obm Data') ?></th>
                                <th><?= esc('Obm Cliente Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Ref Site') ?></th>
                                <th><?= esc('Ref Agency') ?></th>
                                <th><?= esc('Ref Event') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_obm_data ?? '') ?></td>
                                <td><?= esc($child->obm_cliente_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->ref_site ?? '') ?></td>
                                <td><?= esc($child->ref_agency ?? '') ?></td>
                                <td><?= esc($child->ref_event ?? '') ?></td>
                                    <td><a href="<?= site_url('ref_obmp_booking/view/' . ($child->ref_obm_data ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['ref_obmp_booking__preno_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
