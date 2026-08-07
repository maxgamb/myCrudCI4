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
                            <th class="w-25"><?= esc(lang('EfTipologia.pax')) ?></th>
                            <td><?= esc($row->pax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfTipologia.4')) ?></th>
                            <td><?= esc($row->4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfTipologia.3')) ?></th>
                            <td><?= esc($row->3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfTipologia.2')) ?></th>
                            <td><?= esc($row->2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EfTipologia.1')) ?></th>
                            <td><?= esc($row->1 ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('ef_tipologia') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
