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
                            <th class="w-25"><?= esc(lang('RegistroPs.registro_ps_id')) ?></th>
                            <td><?= esc($row->registro_ps_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RegistroPs.registro_ps_hotel_id')) ?></th>
                            <td><?= esc($row->registro_ps_hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RegistroPs.registro_ps_valore')) ?></th>
                            <td><?= esc($row->registro_ps_valore ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RegistroPs.registro_ps_utente_id')) ?></th>
                            <td><?= esc($row->registro_ps_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('registro_ps') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
