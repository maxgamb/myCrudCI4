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
                            <th class="w-25"><?= esc(lang('NazioniLinque.isoKey')) ?></th>
                            <td><?= esc($row->isoKey ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NazioniLinque.iso3')) ?></th>
                            <td><?= esc($row->iso3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NazioniLinque.nazioni_EN')) ?></th>
                            <td><?= esc($row->nazioni_EN ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NazioniLinque.nazioni_ES')) ?></th>
                            <td><?= esc($row->nazioni_ES ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NazioniLinque.nazioni_FR')) ?></th>
                            <td><?= esc($row->nazioni_FR ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NazioniLinque.nazioni_DE')) ?></th>
                            <td><?= esc($row->nazioni_DE ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NazioniLinque.nazioni_IT')) ?></th>
                            <td><?= esc($row->nazioni_IT ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NazioniLinque.lg')) ?></th>
                            <td><?= esc($row->lg ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('nazioni_linque') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
