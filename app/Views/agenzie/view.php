<?= $this->extend('layouts/default_app') ?>
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
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_id')) ?></th>
                            <td><?= esc($row->agenzia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_tipologia')) ?></th>
                            <td><?= esc($row->agenzia_tipologia ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_nome')) ?></th>
                            <td><?= esc($row->agenzia_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_via')) ?></th>
                            <td><?= esc($row->agenzia_via ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_citta')) ?></th>
                            <td><?= esc($row->agenzia_citta ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_state')) ?></th>
                            <td><?= esc($row->agenzia_state ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_country')) ?></th>
                            <td><?= esc($row->agenzia_country ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_cap')) ?></th>
                            <td><?= esc($row->agenzia_cap ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_tel')) ?></th>
                            <td><?= esc($row->agenzia_tel ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_fax')) ?></th>
                            <td><?= esc($row->agenzia_fax ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_email')) ?></th>
                            <td><?= esc($row->agenzia_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_web')) ?></th>
                            <td><?= esc($row->agenzia_web ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_par_iva')) ?></th>
                            <td><?= esc($row->agenzia_par_iva ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_par_cf')) ?></th>
                            <td><?= esc($row->agenzia_par_cf ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_pec')) ?></th>
                            <td><?= esc($row->agenzia_pec ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_sid')) ?></th>
                            <td><?= esc($row->agenzia_sid ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_referente')) ?></th>
                            <td><?= esc($row->agenzia_referente ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_banca_nome')) ?></th>
                            <td><?= esc($row->agenzia_banca_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_banca_iban')) ?></th>
                            <td><?= esc($row->agenzia_banca_iban ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_banca_swift')) ?></th>
                            <td><?= esc($row->agenzia_banca_swift ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_banca_iata')) ?></th>
                            <td><?= esc($row->agenzia_banca_iata ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_cc_tipo')) ?></th>
                            <td><?= esc($row->agenzia_cc_tipo ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_cc_nome')) ?></th>
                            <td><?= esc($row->agenzia_cc_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_cc_numero')) ?></th>
                            <td><?= esc($row->agenzia_cc_numero ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_cc_scadenza')) ?></th>
                            <td><?= esc($row->agenzia_cc_scadenza ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_cc_cod_sicurezza')) ?></th>
                            <td><?= esc($row->agenzia_cc_cod_sicurezza ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_login')) ?></th>
                            <td><?= esc($row->agenzia_login ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_ab_web')) ?></th>
                            <td><?= esc($row->agenzia_ab_web ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_ab_affiliati')) ?></th>
                            <td><?= esc($row->agenzia_ab_affiliati ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_ad_vis')) ?></th>
                            <td><?= esc($row->agenzia_ad_vis ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_ab_sospeso')) ?></th>
                            <td><?= esc($row->agenzia_ab_sospeso ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzia_data_record')) ?></th>
                            <td><?= esc($row->agenzia_data_record ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.agenzie_utente_id')) ?></th>
                            <td><?= esc($row->agenzie_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('agenzie') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Agenda</strong>
            <span class="badge bg-secondary"><?= (int) ($children['agenda__preno_agenzia']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['agenda__preno_agenzia']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.preno_id')) ?></th>
                                <th><?= esc(lang('Fields.hotel_id')) ?></th>
                                <th><?= esc(lang('Fields.preno_in_data')) ?></th>
                                <th><?= esc(lang('Fields.preno_importo')) ?></th>
                                <th><?= esc(lang('Fields.preno_impoto_mod')) ?></th>
                                <th><?= esc(lang('Fields.preno_dal')) ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->preno_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->preno_in_data ?? '') ?></td>
                                <td><?= esc($child->preno_importo ?? '') ?></td>
                                <td><?= esc($child->preno_impoto_mod ?? '') ?></td>
                                <td><?= esc($child->preno_dal ?? '') ?></td>
                                    <td><a href="<?= site_url('agenda/view/' . ($child->preno_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((int) ($children['agenda__preno_agenzia']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Foglio Giorno</strong>
            <span class="badge bg-secondary"><?= (int) ($children['foglio_giorno__preno_agenzia']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['foglio_giorno__preno_agenzia']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.foglio_id')) ?></th>
                                <th><?= esc(lang('Fields.hotel_id')) ?></th>
                                <th><?= esc(lang('Fields.conto_id')) ?></th>
                                <th><?= esc(lang('Fields.camera_id')) ?></th>
                                <th><?= esc(lang('Fields.preno_id')) ?></th>
                                <th><?= esc(lang('Fields.tipologia_id')) ?></th>
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
                                <td><?= esc($child->tipologia_id ?? '') ?></td>
                                    <td><a href="<?= site_url('foglio_giorno/view/' . ($child->foglio_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((int) ($children['foglio_giorno__preno_agenzia']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Cm</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_cm__agenzia_id']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_cm__agenzia_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.obmp_cm_id')) ?></th>
                                <th><?= esc(lang('Fields.hotel_id')) ?></th>
                                <th><?= esc(lang('Fields.obmp_cm_id_hotel_agenzia')) ?></th>
                                <th><?= esc(lang('Fields.obmp_cm_attiva')) ?></th>
                                <th><?= esc(lang('Fields.obmp_cm_agenzia_url')) ?></th>
                                <th><?= esc(lang('Fields.obmp_cm_agenzia_user')) ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->obmp_cm_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_id_hotel_agenzia ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_attiva ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_agenzia_url ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_agenzia_user ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_cm/view/' . ($child->obmp_cm_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((int) ($children['obmp_cm__agenzia_id']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Ref Event</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_ref_event__agenzia_id']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_ref_event__agenzia_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.ref_event_id')) ?></th>
                                <th><?= esc(lang('Fields.ref_site_id')) ?></th>
                                <th><?= esc(lang('Fields.hotel_id')) ?></th>
                                <th><?= esc(lang('Fields.listino_nome_id')) ?></th>
                                <th><?= esc(lang('Fields.ref_event_nome')) ?></th>
                                <th><?= esc(lang('Fields.event_dal')) ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_event_id ?? '') ?></td>
                                <td><?= esc($child->ref_site_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->listino_nome_id ?? '') ?></td>
                                <td><?= esc($child->ref_event_nome ?? '') ?></td>
                                <td><?= esc($child->event_dal ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_ref_event/view/' . ($child->ref_event_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((int) ($children['obmp_ref_event__agenzia_id']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Pratiche</strong>
            <span class="badge bg-secondary"><?= (int) ($children['pratiche__pratica_agenzia_id']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['pratiche__pratica_agenzia_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.pratica_id')) ?></th>
                                <th><?= esc(lang('Fields.hotel_id')) ?></th>
                                <th><?= esc(lang('Fields.pratica_nome')) ?></th>
                                <th><?= esc(lang('Fields.pratica_1')) ?></th>
                                <th><?= esc(lang('Fields.pratica_2')) ?></th>
                                <th><?= esc(lang('Fields.pratica_note')) ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->pratica_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->pratica_nome ?? '') ?></td>
                                <td><?= esc($child->pratica_1 ?? '') ?></td>
                                <td><?= esc($child->pratica_2 ?? '') ?></td>
                                <td><?= esc($child->pratica_note ?? '') ?></td>
                                    <td><a href="<?= site_url('pratiche/view/' . ($child->pratica_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((int) ($children['pratiche__pratica_agenzia_id']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Agenzia Listini</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_agenzia_listini__agenzia_id']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_agenzia_listini__agenzia_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.ref_agenzia_listini_id')) ?></th>
                                <th><?= esc(lang('Fields.agenzia_listini_id')) ?></th>
                                <th><?= esc(lang('Fields.hotel_id')) ?></th>
                                <th><?= esc(lang('Fields.agenzia_limite_vendita')) ?></th>
                                <th><?= esc(lang('Fields.agenzia_ab_limite_vendita')) ?></th>
                                <th><?= esc(lang('Fields.agenzia_max_vendita')) ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_agenzia_listini_id ?? '') ?></td>
                                <td><?= esc($child->agenzia_listini_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->agenzia_limite_vendita ?? '') ?></td>
                                <td><?= esc($child->agenzia_ab_limite_vendita ?? '') ?></td>
                                <td><?= esc($child->agenzia_max_vendita ?? '') ?></td>
                                    <td><a href="<?= site_url('ref_agenzia_listini/view/' . ($child->ref_agenzia_listini_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((int) ($children['ref_agenzia_listini__agenzia_id']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Agenzia Preno</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_agenzia_preno__agenzia_id']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_agenzia_preno__agenzia_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.ref_agenzia_preno')) ?></th>
                                <th><?= esc(lang('Fields.preno_id')) ?></th>
                                <th><?= esc(lang('Fields.ref_a_p_datarecord')) ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_agenzia_preno ?? '') ?></td>
                                <td><?= esc($child->preno_id ?? '') ?></td>
                                <td><?= esc($child->ref_a_p_datarecord ?? '') ?></td>
                                    <td><a href="<?= site_url('ref_agenzia_preno/view/' . ($child->ref_agenzia_preno ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((int) ($children['ref_agenzia_preno__agenzia_id']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Sospesi</strong>
            <span class="badge bg-secondary"><?= (int) ($children['sospesi__sopeso_societa']['count'] ?? 0) ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['sospesi__sopeso_societa']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc(lang('Fields.sospeso_id')) ?></th>
                                <th><?= esc(lang('Fields.hotel_id')) ?></th>
                                <th><?= esc(lang('Fields.pagamento_id')) ?></th>
                                <th><?= esc(lang('Fields.cassa_id')) ?></th>
                                <th><?= esc(lang('Fields.sospeso_data')) ?></th>
                                <th><?= esc(lang('Fields.sospeso_conto_id')) ?></th>
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
                <?php if ((int) ($children['sospesi__sopeso_societa']['count'] ?? 0) > 20): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
