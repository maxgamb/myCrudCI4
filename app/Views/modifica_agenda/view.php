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
                            <th class="w-25"><?= esc(lang('ModificaAgenda.mod_agenda_id')) ?></th>
                            <td><?= esc($row->mod_agenda_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaAgenda.mod_preno_id')) ?></th>
                            <td><?= esc($row->mod_preno_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaAgenda.mod_agenda_valori')) ?></th>
                            <td><?= esc($row->mod_agenda_valori ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaAgenda.mod_preno_data_records')) ?></th>
                            <td><?= esc($row->mod_preno_data_records ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaAgenda.modifica_agenda_adebiti_utente_id')) ?></th>
                            <td><?= esc($row->modifica_agenda_adebiti_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('modifica_agenda') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
