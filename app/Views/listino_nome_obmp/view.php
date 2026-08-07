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
                            <th class="w-25"><?= esc(lang('ListinoNomeObmp.listino_nome_id')) ?></th>
                            <td><?= esc($row->listino_nome_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoNomeObmp.listino_nome')) ?></th>
                            <td><?= esc($row->listino_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoNomeObmp.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoNomeObmp.yield')) ?></th>
                            <td><?= esc($row->yield ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoNomeObmp.listino_nome_datarecord')) ?></th>
                            <td><?= esc($row->listino_nome_datarecord ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('listino_nome_obmp') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Listino Obmp</strong>
            <span class="badge bg-secondary"><?= (int) ($children['listino_obmp__listino_nome_id']['count'] ?? 0) ?><?= !empty($children['listino_obmp__listino_nome_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['listino_obmp__listino_nome_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Listino Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Tipologia Id') ?></th>
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
                                <td><?= esc($child->tipologia_id ?? '') ?></td>
                                <td><?= esc($child->listino_prezzo ?? '') ?></td>
                                <td><?= esc($child->ref_site ?? '') ?></td>
                                <td><?= esc($child->ref_agency ?? '') ?></td>
                                    <td><a href="<?= site_url('listino_obmp/view/' . ($child->listino_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['listino_obmp__listino_nome_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Listino Periodi Obmp</strong>
            <span class="badge bg-secondary"><?= (int) ($children['listino_periodi_obmp__listino_nome_id']['count'] ?? 0) ?><?= !empty($children['listino_periodi_obmp__listino_nome_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['listino_periodi_obmp__listino_nome_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Listino Periodi Id') ?></th>
                                <th><?= esc('Listino Periodi Flex') ?></th>
                                <th><?= esc('Listino Dal') ?></th>
                                <th><?= esc('Listino Al') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Listino Periodi') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->listino_periodi_id ?? '') ?></td>
                                <td><?= esc($child->listino_periodi_flex ?? '') ?></td>
                                <td><?= esc($child->listino_dal ?? '') ?></td>
                                <td><?= esc($child->listino_al ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->listino_periodi ?? '') ?></td>
                                    <td><a href="<?= site_url('listino_periodi_obmp/view/' . ($child->listino_periodi_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['listino_periodi_obmp__listino_nome_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Ref Event</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_ref_event__listino_nome_id']['count'] ?? 0) ?><?= !empty($children['obmp_ref_event__listino_nome_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_ref_event__listino_nome_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Ref Event Id') ?></th>
                                <th><?= esc('Ref Site Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Agenzia Id') ?></th>
                                <th><?= esc('Ref Event Nome') ?></th>
                                <th><?= esc('Event Dal') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_event_id ?? '') ?></td>
                                <td><?= esc($child->ref_site_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->agenzia_id ?? '') ?></td>
                                <td><?= esc($child->ref_event_nome ?? '') ?></td>
                                <td><?= esc($child->event_dal ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_ref_event/view/' . ($child->ref_event_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['obmp_ref_event__listino_nome_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
