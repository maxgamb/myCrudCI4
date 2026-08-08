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
                            <th class="w-25"><?= esc(lang('ListinoPeriodiObmp.listino_periodi_id')) ?></th>
                            <td><?= esc($row->listino_periodi_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoPeriodiObmp.listino_nome_id')) ?></th>
                            <td><a href="<?= site_url('listino_nome_obmp/view/' . rawurlencode((string) ($row->listino_nome_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->listino_nome_obmp__listino_nome_id__label ?? $row->listino_nome_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoPeriodiObmp.listino_periodi_flex')) ?></th>
                            <td><?= esc($row->listino_periodi_flex ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoPeriodiObmp.listino_dal')) ?></th>
                            <td><?= esc($row->listino_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoPeriodiObmp.listino_al')) ?></th>
                            <td><?= esc($row->listino_al ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoPeriodiObmp.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoPeriodiObmp.listino_periodi')) ?></th>
                            <td><?= esc($row->listino_periodi ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('listino_periodi_obmp') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
