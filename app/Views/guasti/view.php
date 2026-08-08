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
                            <th class="w-25"><?= esc(lang('Guasti.guasto_id')) ?></th>
                            <td><?= esc($row->guasto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Guasti.hotel_id')) ?></th>
                            <td><a href="<?= site_url('hotels/view/' . rawurlencode((string) ($row->hotel_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->hotels__hotel_id__label ?? $row->hotel_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Guasti.camera_id')) ?></th>
                            <td><a href="<?= site_url('camere/view/' . rawurlencode((string) ($row->camera_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->camere__camera_id__label ?? $row->camera_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Guasti.guasto_priorita')) ?></th>
                            <td><?= esc($row->guasto_priorita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Guasti.guasto_area')) ?></th>
                            <td><?= esc($row->guasto_area ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Guasti.guasto_piano')) ?></th>
                            <td><?= esc($row->guasto_piano ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Guasti.guasto_note')) ?></th>
                            <td><?= esc($row->guasto_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Guasti.guasto_stato')) ?></th>
                            <td><?= esc($row->guasto_stato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Guasti.guasto_data')) ?></th>
                            <td><?= esc($row->guasto_data ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Guasti.guasto_utente_id')) ?></th>
                            <td><?= esc($row->guasto_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('guasti') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
