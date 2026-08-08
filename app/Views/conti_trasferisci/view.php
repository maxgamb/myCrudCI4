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
                            <th class="w-25"><?= esc(lang('ContiTrasferisci.conti_trasferisci_id')) ?></th>
                            <td><?= esc($row->conti_trasferisci_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ContiTrasferisci.conto_id_ex')) ?></th>
                            <td><?= esc($row->conto_id_ex ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ContiTrasferisci.conto_id_new')) ?></th>
                            <td><?= esc($row->conto_id_new ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ContiTrasferisci.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ContiTrasferisci.adebito_id')) ?></th>
                            <td><a href="<?= site_url('adebiti/view/' . rawurlencode((string) ($row->adebito_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->adebiti__adebito_id__label ?? $row->adebito_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ContiTrasferisci.conti_tra_data')) ?></th>
                            <td><?= esc($row->conti_tra_data ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('conti_trasferisci') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
