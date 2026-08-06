<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <tbody>
                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.Comuni_Codice')) ?></th>
                            <td><?= esc($row->Comuni_Codice ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.Comuni_Nome')) ?></th>
                            <td><?= esc($row->Comuni_Nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.Comuni_Prov')) ?></th>
                            <td><?= esc($row->Comuni_Prov ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.Comuni_CAP')) ?></th>
                            <td><?= esc($row->Comuni_CAP ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.Comuni_Prefisso')) ?></th>
                            <td><?= esc($row->Comuni_Prefisso ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.Comuni_ColExcel')) ?></th>
                            <td><?= esc($row->Comuni_ColExcel ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.Comuni_Nazione')) ?></th>
                            <td><?= esc($row->Comuni_Nazione ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.Comuni_Lingua')) ?></th>
                            <td><?= esc($row->Comuni_Lingua ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.nazione_iso2')) ?></th>
                            <td><?= esc($row->nazione_iso2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th style="width: 30%"><?= esc(lang('Fields.nazione_iso3')) ?></th>
                            <td><?= esc($row->nazione_iso3 ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('comuni') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
