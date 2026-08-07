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
                            <th class="w-25"><?= esc(lang('ObmpRefSite.ref_site_id')) ?></th>
                            <td><?= esc($row->ref_site_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefSite.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefSite.obmp_affiliati_id')) ?></th>
                            <td><?= esc($row->obmp_affiliati_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefSite.ref_site_nome')) ?></th>
                            <td><?= esc($row->ref_site_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefSite.ref_site_date_record')) ?></th>
                            <td><?= esc($row->ref_site_date_record ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_ref_site') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Ref Event</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_ref_event__ref_site_id']['count'] ?? 0) ?><?= !empty($children['obmp_ref_event__ref_site_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_ref_event__ref_site_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Ref Event Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Listino Nome Id') ?></th>
                                <th><?= esc('Agenzia Id') ?></th>
                                <th><?= esc('Ref Event Nome') ?></th>
                                <th><?= esc('Event Dal') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_event_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->listino_nome_id ?? '') ?></td>
                                <td><?= esc($child->agenzia_id ?? '') ?></td>
                                <td><?= esc($child->ref_event_nome ?? '') ?></td>
                                <td><?= esc($child->event_dal ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_ref_event/view/' . ($child->ref_event_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['obmp_ref_event__ref_site_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Obmp Booking</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_obmp_booking__ref_site']['count'] ?? 0) ?><?= !empty($children['ref_obmp_booking__ref_site']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_obmp_booking__ref_site']['rows'] ?? []; ?>
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
                                <th><?= esc('Ref Agency') ?></th>
                                <th><?= esc('Ref Event') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_obm_data ?? '') ?></td>
                                <td><?= esc($child->preno_id ?? '') ?></td>
                                <td><?= esc($child->obm_cliente_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->ref_agency ?? '') ?></td>
                                <td><?= esc($child->ref_event ?? '') ?></td>
                                    <td><a href="<?= site_url('ref_obmp_booking/view/' . ($child->ref_obm_data ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['ref_obmp_booking__ref_site']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
