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
                            <th class="w-25"><?= esc(lang('Lettere.lettere_id')) ?></th>
                            <td><?= esc($row->lettere_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.etichetta')) ?></th>
                            <td><?= esc($row->etichetta ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.titolo')) ?></th>
                            <td><?= esc($row->titolo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.reparto')) ?></th>
                            <td><?= esc($row->reparto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.contoller')) ?></th>
                            <td><?= esc($row->contoller ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.en')) ?></th>
                            <td><?= esc($row->en ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.it')) ?></th>
                            <td><?= esc($row->it ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.es')) ?></th>
                            <td><?= esc($row->es ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.fr')) ?></th>
                            <td><?= esc($row->fr ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.de')) ?></th>
                            <td><?= esc($row->de ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Lettere.data_stamp')) ?></th>
                            <td><?= esc($row->data_stamp ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('lettere') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
