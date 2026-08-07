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
                            <th class="w-25"><?= esc(lang('TexLingue.tex_lingue_id')) ?></th>
                            <td><?= esc($row->tex_lingue_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TexLingue.etichetta_lg')) ?></th>
                            <td><?= esc($row->etichetta_lg ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TexLingue.en')) ?></th>
                            <td><?= esc($row->en ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TexLingue.it')) ?></th>
                            <td><?= esc($row->it ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TexLingue.es')) ?></th>
                            <td><?= esc($row->es ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TexLingue.fr')) ?></th>
                            <td><?= esc($row->fr ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TexLingue.de')) ?></th>
                            <td><?= esc($row->de ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('TexLingue.reparto_id')) ?></th>
                            <td><?= esc($row->reparto_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('tex_lingue') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
