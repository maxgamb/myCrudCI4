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
                            <th class="w-25"><?= esc(lang('Tipoallogiati.Tip_all_Cod')) ?></th>
                            <td><?= esc($row->Tip_all_Cod ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Tipoallogiati.Tip_all_Descrizione')) ?></th>
                            <td><?= esc($row->Tip_all_Descrizione ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('tipoallogiati') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
