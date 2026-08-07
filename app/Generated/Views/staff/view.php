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
                            <th class="w-25"><?= esc(lang('Staff.staff_id')) ?></th>
                            <td><?= esc($row->staff_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.cognome')) ?></th>
                            <td><?= esc($row->cognome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.nome')) ?></th>
                            <td><?= esc($row->nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.citta')) ?></th>
                            <td><?= esc($row->citta ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.provincia')) ?></th>
                            <td><?= esc($row->provincia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.staff_nazione')) ?></th>
                            <td><?= esc($row->staff_nazione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.indirizzo')) ?></th>
                            <td><?= esc($row->indirizzo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.telefono')) ?></th>
                            <td><?= esc($row->telefono ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.cellulare')) ?></th>
                            <td><?= esc($row->cellulare ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.email')) ?></th>
                            <td><?= esc($row->email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.genere')) ?></th>
                            <td><?= esc($row->genere ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.reparto_id')) ?></th>
                            <td><?= esc($row->reparto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.staff_stato')) ?></th>
                            <td><?= esc($row->staff_stato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.staff_datarecod')) ?></th>
                            <td><?= esc($row->staff_datarecod ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Staff.utente_id')) ?></th>
                            <td><?= esc($row->utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('staff') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Shifts</strong>
            <span class="badge bg-secondary"><?= (int) ($children['shifts__staff_id']['count'] ?? 0) ?><?= !empty($children['shifts__staff_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['shifts__staff_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Shift Date') ?></th>
                                <th><?= esc('Position') ?></th>
                                <th><?= esc('Shift Time') ?></th>
                                <th><?= esc('Data Record') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->shift_date ?? '') ?></td>
                                <td><?= esc($child->position ?? '') ?></td>
                                <td><?= esc($child->shift_time ?? '') ?></td>
                                <td><?= esc($child->data_record ?? '') ?></td>
                                    <td><a href="<?= site_url('shifts/view/' . ($child->id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['shifts__staff_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Utenti</strong>
            <span class="badge bg-secondary"><?= (int) ($children['utenti__staff_id']['count'] ?? 0) ?><?= !empty($children['utenti__staff_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['utenti__staff_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Utente Id') ?></th>
                                <th><?= esc('Nome Utente') ?></th>
                                <th><?= esc('Pass Utente') ?></th>
                                <th><?= esc('Email Utente') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Utenti Livello') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->Utente_id ?? '') ?></td>
                                <td><?= esc($child->Nome_Utente ?? '') ?></td>
                                <td><?= esc($child->Pass_Utente ?? '') ?></td>
                                <td><?= esc($child->Email_Utente ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->utenti_livello ?? '') ?></td>
                                    <td><a href="<?= site_url('utenti/view/' . ($child->Utente_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['utenti__staff_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
