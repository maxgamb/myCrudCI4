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
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_id')) ?></th>
                            <td><?= esc($row->quote_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_lg')) ?></th>
                            <td><?= esc($row->quote_lg ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_dal')) ?></th>
                            <td><?= esc($row->quote_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_al')) ?></th>
                            <td><?= esc($row->quote_al ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_titolo')) ?></th>
                            <td><?= esc($row->quote_titolo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_cognome')) ?></th>
                            <td><?= esc($row->quote_cognome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_nome')) ?></th>
                            <td><?= esc($row->quote_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_email')) ?></th>
                            <td><?= esc($row->quote_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.trattamento_id')) ?></th>
                            <td><?= esc($row->trattamento_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.trariffa_id')) ?></th>
                            <td><?= esc($row->trariffa_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.cax_policy_id')) ?></th>
                            <td><?= esc($row->cax_policy_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_tel_rich')) ?></th>
                            <td><?= esc($row->quote_tel_rich ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_cc_rich')) ?></th>
                            <td><?= esc($row->quote_cc_rich ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_del')) ?></th>
                            <td><?= esc($row->quote_del ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_data_time')) ?></th>
                            <td><?= esc($row->quote_data_time ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.utente_id')) ?></th>
                            <td><?= esc($row->utente_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuote.quote_stato')) ?></th>
                            <td><?= esc($row->quote_stato ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_quote') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Quote Sub</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_quote_sub__obmp_quote_id']['count'] ?? 0) ?><?= !empty($children['obmp_quote_sub__obmp_quote_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_quote_sub__obmp_quote_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Obmp Quote Sub Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Quote Sub Jeson') ?></th>
                                <th><?= esc('Quote Sub Data') ?></th>
                                <th><?= esc('Randomd String') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->obmp_quote_sub_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->quote_sub_jeson ?? '') ?></td>
                                <td><?= esc($child->quote_sub_data ?? '') ?></td>
                                <td><?= esc($child->randomd_string ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_quote_sub/view/' . ($child->obmp_quote_sub_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['obmp_quote_sub__obmp_quote_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Obmp Booking</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_obmp_booking__quote_id']['count'] ?? 0) ?><?= !empty($children['ref_obmp_booking__quote_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_obmp_booking__quote_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Ref Obm Data') ?></th>
                                <th><?= esc('Preno Id') ?></th>
                                <th><?= esc('Obm Cliente Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Ref Site') ?></th>
                                <th><?= esc('Ref Agency') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_obm_data ?? '') ?></td>
                                <td><?= esc($child->preno_id ?? '') ?></td>
                                <td><?= esc($child->obm_cliente_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->ref_site ?? '') ?></td>
                                <td><?= esc($child->ref_agency ?? '') ?></td>
                                    <td><a href="<?= site_url('ref_obmp_booking/view/' . ($child->ref_obm_data ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['ref_obmp_booking__quote_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
