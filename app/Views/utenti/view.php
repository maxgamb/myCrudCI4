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
                            <th class="w-25"><?= esc(lang('Utenti.Utente_id')) ?></th>
                            <td><?= esc($row->Utente_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Utenti.staff_id')) ?></th>
                            <td><?= esc($row->staff_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Utenti.Nome_Utente')) ?></th>
                            <td><?= esc($row->Nome_Utente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Utenti.Pass_Utente')) ?></th>
                            <td><?= esc($row->Pass_Utente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Utenti.Email_Utente')) ?></th>
                            <td><?= esc($row->Email_Utente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Utenti.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Utenti.utenti_livello')) ?></th>
                            <td><?= esc($row->utenti_livello ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Utenti.utenti_Utente_id')) ?></th>
                            <td><?= esc($row->utenti_Utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('utenti') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Note Utente</strong>
            <span class="badge bg-secondary"><?= (int) ($children['note_utente__Utente_id']['count'] ?? 0) ?><?= !empty($children['note_utente__Utente_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['note_utente__Utente_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Note Utente Id') ?></th>
                                <th><?= esc('Note Utente Rispondi Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Reparto') ?></th>
                                <th><?= esc('Titolo') ?></th>
                                <th><?= esc('Note Utente Tex') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->note_utente_id ?? '') ?></td>
                                <td><?= esc($child->note_utente_rispondi_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->reparto ?? '') ?></td>
                                <td><?= esc($child->titolo ?? '') ?></td>
                                <td><?= esc($child->note_utente_tex ?? '') ?></td>
                                    <td><a href="<?= site_url('note_utente/view/' . ($child->note_utente_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['note_utente__Utente_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
