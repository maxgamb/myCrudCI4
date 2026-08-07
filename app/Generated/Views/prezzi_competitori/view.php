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
                            <th class="w-25"><?= esc(lang('PrezziCompetitori.prezzi_competitori_id')) ?></th>
                            <td><?= esc($row->prezzi_competitori_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PrezziCompetitori.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PrezziCompetitori.data_prezzo')) ?></th>
                            <td><?= esc($row->data_prezzo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PrezziCompetitori.percentile_10')) ?></th>
                            <td><?= esc($row->percentile_10 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PrezziCompetitori.percentile_25')) ?></th>
                            <td><?= esc($row->percentile_25 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PrezziCompetitori.percentile_50')) ?></th>
                            <td><?= esc($row->percentile_50 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PrezziCompetitori.percentile_75')) ?></th>
                            <td><?= esc($row->percentile_75 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PrezziCompetitori.percentile_90')) ?></th>
                            <td><?= esc($row->percentile_90 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PrezziCompetitori.indice_disponibilita')) ?></th>
                            <td><?= esc($row->indice_disponibilita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('PrezziCompetitori.data_acuisizione')) ?></th>
                            <td><?= esc($row->data_acuisizione ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('prezzi_competitori') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
