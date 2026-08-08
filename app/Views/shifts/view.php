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
                            <th class="w-25"><?= esc(lang('Shifts.id')) ?></th>
                            <td><?= esc($row->id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Shifts.staff_id')) ?></th>
                            <td><a href="<?= site_url('staff/view/' . rawurlencode((string) ($row->staff_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->staff__staff_id__label ?? $row->staff_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Shifts.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Shifts.shift_date')) ?></th>
                            <td><?= esc($row->shift_date ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Shifts.position')) ?></th>
                            <td><?= esc($row->position ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Shifts.shift_time')) ?></th>
                            <td><?= esc($row->shift_time ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('shifts') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
