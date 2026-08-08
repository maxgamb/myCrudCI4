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
                            <th class="w-25"><?= esc(lang('NoteUtente.note_utente_id')) ?></th>
                            <td><?= esc($row->note_utente_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.note_utente_rispondi_id')) ?></th>
                            <td><?= esc($row->note_utente_rispondi_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.Utente_id')) ?></th>
                            <td><a href="<?= site_url('utenti/view/' . rawurlencode((string) ($row->Utente_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->utenti__Utente_id__label ?? $row->Utente_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.reparto')) ?></th>
                            <td><?= esc($row->reparto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.titolo')) ?></th>
                            <td><?= esc($row->titolo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.note_utente_tex')) ?></th>
                            <td><?= esc($row->note_utente_tex ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.note_utente_per')) ?></th>
                            <td><?= esc($row->note_utente_per ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.note_utente_stato')) ?></th>
                            <td><?= esc($row->note_utente_stato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.note_utente_dal')) ?></th>
                            <td><?= esc($row->note_utente_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.note_utente_al')) ?></th>
                            <td><?= esc($row->note_utente_al ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NoteUtente.note_utente_data')) ?></th>
                            <td><?= esc($row->note_utente_data ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('note_utente') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
