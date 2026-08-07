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
                            <th class="w-25"><?= esc(lang('LogRichieste.log_ric_id')) ?></th>
                            <td><?= esc($row->log_ric_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogRichieste.log_ric_hotel_id')) ?></th>
                            <td><?= esc($row->log_ric_hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogRichieste.log_ric_dal')) ?></th>
                            <td><?= esc($row->log_ric_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogRichieste.log_ric_al')) ?></th>
                            <td><?= esc($row->log_ric_al ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogRichieste.log_ric_data')) ?></th>
                            <td><?= esc($row->log_ric_data ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogRichieste.log_ric_notti')) ?></th>
                            <td><?= esc($row->log_ric_notti ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogRichieste.log_ric_wind')) ?></th>
                            <td><?= esc($row->log_ric_wind ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogRichieste.log_ric_utente_id')) ?></th>
                            <td><?= esc($row->log_ric_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('log_richieste') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
