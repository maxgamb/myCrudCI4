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
                            <th class="w-25"><?= esc(lang('ChecklistPreno.checklist_id')) ?></th>
                            <td><?= esc($row->checklist_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.preno_id')) ?></th>
                            <td><?= esc($row->preno_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.preno_dal')) ?></th>
                            <td><?= esc($row->preno_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.email')) ?></th>
                            <td><?= esc($row->email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.email_pms')) ?></th>
                            <td><?= esc($row->email_pms ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.lista')) ?></th>
                            <td><?= esc($row->lista ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.lista_pms')) ?></th>
                            <td><?= esc($row->lista_pms ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.pagamento')) ?></th>
                            <td><?= esc($row->pagamento ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.tassa')) ?></th>
                            <td><?= esc($row->tassa ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.proforma')) ?></th>
                            <td><?= esc($row->proforma ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.proforma_pms')) ?></th>
                            <td><?= esc($row->proforma_pms ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.bonifico')) ?></th>
                            <td><?= esc($row->bonifico ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.importo')) ?></th>
                            <td><?= esc($row->importo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.note')) ?></th>
                            <td><?= esc($row->note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.data_check')) ?></th>
                            <td><?= esc($row->data_check ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ChecklistPreno.utente_id')) ?></th>
                            <td><?= esc($row->utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('checklist_preno') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
