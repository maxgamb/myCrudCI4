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
                            <th class="w-25"><?= esc(lang('Manutenzioni.manutenzione_id')) ?></th>
                            <td><?= esc($row->manutenzione_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Manutenzioni.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Manutenzioni.manut_priorita')) ?></th>
                            <td><?= esc($row->manut_priorita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Manutenzioni.manut_area_guasto')) ?></th>
                            <td><?= esc($row->manut_area_guasto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Manutenzioni.manut_piano')) ?></th>
                            <td><?= esc($row->manut_piano ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Manutenzioni.manut_camera')) ?></th>
                            <td><?= esc($row->manut_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Manutenzioni.manut_descrizione')) ?></th>
                            <td><?= esc($row->manut_descrizione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Manutenzioni.manut_data_segnalazione')) ?></th>
                            <td><?= esc($row->manut_data_segnalazione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Manutenzioni.manut_stato')) ?></th>
                            <td><?= esc($row->manut_stato ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('manutenzioni') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
