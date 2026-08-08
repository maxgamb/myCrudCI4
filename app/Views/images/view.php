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
                            <th class="w-25"><?= esc(lang('Images.images_id')) ?></th>
                            <td><?= esc($row->images_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Images.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Images.camera_id')) ?></th>
                            <td><?= esc($row->camera_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Images.obmp_cm_rooms_id')) ?></th>
                            <td><a href="<?= site_url('obmp_cm_rooms/view/' . rawurlencode((string) ($row->obmp_cm_rooms_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_cm_rooms__obmp_cm_rooms_id__label ?? $row->obmp_cm_rooms_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Images.tipologia_id')) ?></th>
                            <td><?= esc($row->tipologia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Images.img_small')) ?></th>
                            <td><?= esc($row->img_small ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Images.img_medium')) ?></th>
                            <td><?= esc($row->img_medium ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Images.img_large')) ?></th>
                            <td><?= esc($row->img_large ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Images.titolo')) ?></th>
                            <td><?= esc($row->titolo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Images.utente_id')) ?></th>
                            <td><?= esc($row->utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('images') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
