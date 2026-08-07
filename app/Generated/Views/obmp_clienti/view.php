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
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_id')) ?></th>
                            <td><?= esc($row->obm_cliente_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_first_name')) ?></th>
                            <td><?= esc($row->obm_cliente_first_name ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_last_name')) ?></th>
                            <td><?= esc($row->obm_cliente_last_name ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_email')) ?></th>
                            <td><?= esc($row->obm_cliente_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_city')) ?></th>
                            <td><?= esc($row->obm_cliente_city ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_country')) ?></th>
                            <td><?= esc($row->obm_cliente_country ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.lingua')) ?></th>
                            <td><?= esc($row->lingua ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_phone')) ?></th>
                            <td><?= esc($row->obm_cliente_phone ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_newsletter')) ?></th>
                            <td><?= esc($row->obm_cliente_newsletter ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_pass')) ?></th>
                            <td><?= esc($row->obm_cliente_pass ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_data_insert')) ?></th>
                            <td><?= esc($row->obm_cliente_data_insert ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_cc_type')) ?></th>
                            <td><?= esc($row->obm_cliente_cc_type ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_cc_number')) ?></th>
                            <td><?= esc($row->obm_cliente_cc_number ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_holder')) ?></th>
                            <td><?= esc($row->obm_cliente_holder ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_cc_expire')) ?></th>
                            <td><?= esc($row->obm_cliente_cc_expire ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpClienti.obm_cliente_cc_security')) ?></th>
                            <td><?= esc($row->obm_cliente_cc_security ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_clienti') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Obmp Booking</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_obmp_booking__obm_cliente_id']['count'] ?? 0) ?><?= !empty($children['ref_obmp_booking__obm_cliente_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_obmp_booking__obm_cliente_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Ref Obm Data') ?></th>
                                <th><?= esc('Preno Id') ?></th>
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
                                <td><?= esc($child->preno_id ?? '') ?></td>
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
                <?php if (!empty($children['ref_obmp_booking__obm_cliente_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
