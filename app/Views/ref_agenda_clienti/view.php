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
                            <th class="w-25"><?= esc(lang('RefAgendaClienti.ref_agenda_cliente')) ?></th>
                            <td><?= esc($row->ref_agenda_cliente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgendaClienti.preno_id')) ?></th>
                            <td><?= esc($row->preno_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgendaClienti.clienti_id')) ?></th>
                            <td><?= esc($row->clienti_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgendaClienti.tipologia_id')) ?></th>
                            <td><?= esc($row->tipologia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgendaClienti.ref_a_c_datarecord')) ?></th>
                            <td><?= esc($row->ref_a_c_datarecord ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('ref_agenda_clienti') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
