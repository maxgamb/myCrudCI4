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
                            <th class="w-25"><?= esc(lang('Nazioni.Nazioni_Id_Codice')) ?></th>
                            <td><?= esc($row->Nazioni_Id_Codice ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Nazioni.Nazioni_Codice')) ?></th>
                            <td><?= esc($row->Nazioni_Codice ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Nazioni.Nazioni_Descrizione')) ?></th>
                            <td><?= esc($row->Nazioni_Descrizione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Nazioni.Nazioni_Targa')) ?></th>
                            <td><?= esc($row->Nazioni_Targa ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Nazioni.Nazioni_ColExcel')) ?></th>
                            <td><?= esc($row->Nazioni_ColExcel ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Nazioni.EN_Country')) ?></th>
                            <td><?= esc($row->EN_Country ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('nazioni') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
