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
                            <th class="w-25"><?= esc(lang('Conti.conto_id')) ?></th>
                            <td><?= esc($row->conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.foglio_id')) ?></th>
                            <td><?= esc($row->foglio_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.clienti_id')) ?></th>
                            <td><?= esc($row->clienti_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.in_conto')) ?></th>
                            <td><?= esc($row->in_conto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.in_conto_time')) ?></th>
                            <td><?= esc($row->in_conto_time ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.out_preno')) ?></th>
                            <td><?= esc($row->out_preno ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.out_conto')) ?></th>
                            <td><?= esc($row->out_conto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.preno_id')) ?></th>
                            <td><?= esc($row->preno_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.camera_id')) ?></th>
                            <td><?= esc($row->camera_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.numero_camera')) ?></th>
                            <td><?= esc($row->numero_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.trattamento_sog')) ?></th>
                            <td><?= esc($row->trattamento_sog ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.tipo_camera')) ?></th>
                            <td><?= esc($row->tipo_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.tipologia_id')) ?></th>
                            <td><?= esc($row->tipologia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.prezzo')) ?></th>
                            <td><?= esc($row->prezzo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.nome_cliente')) ?></th>
                            <td><?= esc($row->nome_cliente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.cognome_cliente')) ?></th>
                            <td><?= esc($row->cognome_cliente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.preno_agenzia')) ?></th>
                            <td><?= esc($row->preno_agenzia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.mercato')) ?></th>
                            <td><?= esc($row->mercato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.conti_stato_camere')) ?></th>
                            <td><?= esc($row->conti_stato_camere ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.acconto')) ?></th>
                            <td><?= esc($row->acconto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.conto_pag_modalita')) ?></th>
                            <td><?= esc($row->conto_pag_modalita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Conti.conti_utente_id')) ?></th>
                            <td><?= esc($row->conti_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('conti') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Conti Note</strong>
            <span class="badge bg-secondary"><?= (int) ($children['conti_note__conto_id']['count'] ?? 0) ?><?= !empty($children['conti_note__conto_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['conti_note__conto_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Conto Nota Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Conto Nota Testo') ?></th>
                                <th><?= esc('Conto Nota Data Record') ?></th>
                                <th><?= esc('Note Conto Utente Id') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->conto_nota_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->conto_nota_testo ?? '') ?></td>
                                <td><?= esc($child->conto_nota_data_record ?? '') ?></td>
                                <td><?= esc($child->note_conto_utente_id ?? '') ?></td>
                                    <td><a href="<?= site_url('conti_note/view/' . ($child->conto_nota_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['conti_note__conto_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Modifica Conti</strong>
            <span class="badge bg-secondary"><?= (int) ($children['modifica_conti__mod_conto_id']['count'] ?? 0) ?><?= !empty($children['modifica_conti__mod_conto_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['modifica_conti__mod_conto_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Id Mod Conto') ?></th>
                                <th><?= esc('Mod Hotel Id') ?></th>
                                <th><?= esc('Mod Foglio Id') ?></th>
                                <th><?= esc('Mod Clienti Id') ?></th>
                                <th><?= esc('Mod In Conto') ?></th>
                                <th><?= esc('Mod Out Preno') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->id_mod_conto ?? '') ?></td>
                                <td><?= esc($child->mod_hotel_id ?? '') ?></td>
                                <td><?= esc($child->mod_foglio_id ?? '') ?></td>
                                <td><?= esc($child->mod_clienti_id ?? '') ?></td>
                                <td><?= esc($child->mod_in_conto ?? '') ?></td>
                                <td><?= esc($child->mod_out_preno ?? '') ?></td>
                                    <td><a href="<?= site_url('modifica_conti/view/' . ($child->id_mod_conto ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['modifica_conti__mod_conto_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Review</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_review__conto_id']['count'] ?? 0) ?><?= !empty($children['obmp_review__conto_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_review__conto_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Review Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Preno Id') ?></th>
                                <th><?= esc('Postazione Id') ?></th>
                                <th><?= esc('Camera Numero') ?></th>
                                <th><?= esc('Nome') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->review_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->preno_id ?? '') ?></td>
                                <td><?= esc($child->postazione_id ?? '') ?></td>
                                <td><?= esc($child->camera_numero ?? '') ?></td>
                                <td><?= esc($child->nome ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_review/view/' . ($child->review_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['obmp_review__conto_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Pulizia</strong>
            <span class="badge bg-secondary"><?= (int) ($children['pulizia__conto_id']['count'] ?? 0) ?><?= !empty($children['pulizia__conto_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['pulizia__conto_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Pulizia Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Camera Id') ?></th>
                                <th><?= esc('Cambio Biancheria') ?></th>
                                <th><?= esc('Pulizia Stato') ?></th>
                                <th><?= esc('Pulizia Data') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->pulizia_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->camera_id ?? '') ?></td>
                                <td><?= esc($child->cambio_biancheria ?? '') ?></td>
                                <td><?= esc($child->pulizia_stato ?? '') ?></td>
                                <td><?= esc($child->pulizia_data ?? '') ?></td>
                                    <td><a href="<?= site_url('pulizia/view/' . ($child->pulizia_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['pulizia__conto_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Punti Spesi</strong>
            <span class="badge bg-secondary"><?= (int) ($children['punti_spesi__conto_id']['count'] ?? 0) ?><?= !empty($children['punti_spesi__conto_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['punti_spesi__conto_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Punti Spesi Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Cliente Id') ?></th>
                                <th><?= esc('Punti') ?></th>
                                <th><?= esc('Data') ?></th>
                                <th><?= esc('Data Record') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->punti_spesi_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->cliente_id ?? '') ?></td>
                                <td><?= esc($child->punti ?? '') ?></td>
                                <td><?= esc($child->data ?? '') ?></td>
                                <td><?= esc($child->data_record ?? '') ?></td>
                                    <td><a href="<?= site_url('punti_spesi/view/' . ($child->punti_spesi_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['punti_spesi__conto_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Refer Clienti</strong>
            <span class="badge bg-secondary"><?= (int) ($children['refer_clienti__conto_id']['count'] ?? 0) ?><?= !empty($children['refer_clienti__conto_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['refer_clienti__conto_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Conto Id') ?></th>
                                <th><?= esc('Clienti Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Ps Valore') ?></th>
                                <th><?= esc('Ref Clinti Data Record') ?></th>
                                <th><?= esc('Refer Clienti Utente Id') ?></th>
                                <th><?= esc('Refer Clienti Conto Id') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->conto_id ?? '') ?></td>
                                <td><?= esc($child->clienti_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->ps_valore ?? '') ?></td>
                                <td><?= esc($child->ref_clinti_data_record ?? '') ?></td>
                                <td><?= esc($child->refer_clienti_utente_id ?? '') ?></td>
                                <td><?= esc($child->refer_clienti_conto_id ?? '') ?></td>
                                    <td><a href="<?= site_url('refer_clienti/view/' . ($child->conto_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['refer_clienti__conto_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Sidae</strong>
            <span class="badge bg-secondary"><?= (int) ($children['sidae__conto_id']['count'] ?? 0) ?><?= !empty($children['sidae__conto_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['sidae__conto_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Sidae Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Foglio Id') ?></th>
                                <th><?= esc('Nome Cliente') ?></th>
                                <th><?= esc('Pag Room') ?></th>
                                <th><?= esc('Aliquota') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->sidae_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->foglio_id ?? '') ?></td>
                                <td><?= esc($child->nome_cliente ?? '') ?></td>
                                <td><?= esc($child->pag_room ?? '') ?></td>
                                <td><?= esc($child->aliquota ?? '') ?></td>
                                    <td><a href="<?= site_url('sidae/view/' . ($child->sidae_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['sidae__conto_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Tax Pagamento</strong>
            <span class="badge bg-secondary"><?= (int) ($children['tax_pagamento__conto_id']['count'] ?? 0) ?><?= !empty($children['tax_pagamento__conto_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['tax_pagamento__conto_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Tax Pagamento Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Pratica Id') ?></th>
                                <th><?= esc('Importo') ?></th>
                                <th><?= esc('Pagamento Forma') ?></th>
                                <th><?= esc('Tassa Stato') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->tax_pagamento_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->pratica_id ?? '') ?></td>
                                <td><?= esc($child->importo ?? '') ?></td>
                                <td><?= esc($child->pagamento_forma ?? '') ?></td>
                                <td><?= esc($child->tassa_stato ?? '') ?></td>
                                    <td><a href="<?= site_url('tax_pagamento/view/' . ($child->tax_pagamento_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['tax_pagamento__conto_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
