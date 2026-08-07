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
                            <th class="w-25"><?= esc(lang('CiSessions.id')) ?></th>
                            <td><?= esc($row->id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CiSessions.ip_address')) ?></th>
                            <td><?= esc($row->ip_address ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CiSessions.timestamp')) ?></th>
                            <td><?= esc($row->timestamp ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('CiSessions.data')) ?></th>
                            <td><?= esc($row->data ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('ci_sessions') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
