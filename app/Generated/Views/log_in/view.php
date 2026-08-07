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
                            <th class="w-25"><?= esc(lang('LogIn.log_in_id')) ?></th>
                            <td><?= esc($row->log_in_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogIn.log_nome')) ?></th>
                            <td><?= esc($row->log_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogIn.log_pass')) ?></th>
                            <td><?= esc($row->log_pass ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogIn.log_ip')) ?></th>
                            <td><?= esc($row->log_ip ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogIn.log_out')) ?></th>
                            <td><?= esc($row->log_out ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogIn.log_time')) ?></th>
                            <td><?= esc($row->log_time ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('log_in') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
