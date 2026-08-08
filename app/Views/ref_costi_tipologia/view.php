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
                            <th class="w-25"><?= esc(lang('RefCostiTipologia.ref_costi_tipologia_id')) ?></th>
                            <td><?= esc($row->ref_costi_tipologia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefCostiTipologia.costi_var_id')) ?></th>
                            <td><a href="<?= site_url('costi_var/view/' . rawurlencode((string) ($row->costi_var_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->costi_var__costi_var_id__label ?? $row->costi_var_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefCostiTipologia.tipologia_id')) ?></th>
                            <td><a href="<?= site_url('tipologia_camera/view/' . rawurlencode((string) ($row->tipologia_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->tipologia_camera__tipologia_id__label ?? $row->tipologia_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefCostiTipologia.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefCostiTipologia.stay')) ?></th>
                            <td><?= esc($row->stay ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefCostiTipologia.days')) ?></th>
                            <td><?= esc($row->days ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefCostiTipologia.check_out')) ?></th>
                            <td><?= esc($row->check_out ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefCostiTipologia.utente_id')) ?></th>
                            <td><?= esc($row->utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('ref_costi_tipologia') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
