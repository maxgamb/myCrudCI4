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
                            <th class="w-25"><?= esc(lang('NazioniBandiera.nazione_iso2')) ?></th>
                            <td><?= esc($row->nazione_iso2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NazioniBandiera.Nazioni_Codice')) ?></th>
                            <td><?= esc($row->Nazioni_Codice ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NazioniBandiera.emoji')) ?></th>
                            <td><?= esc($row->emoji ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('NazioniBandiera.cod_emoji')) ?></th>
                            <td><?= esc($row->cod_emoji ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('nazioni_bandiera') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
