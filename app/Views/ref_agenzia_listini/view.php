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
                            <th class="w-25"><?= esc(lang('RefAgenziaListini.ref_agenzia_listini_id')) ?></th>
                            <td><?= esc($row->ref_agenzia_listini_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaListini.agenzia_listini_id')) ?></th>
                            <td><?= esc($row->agenzia_listini_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaListini.agenzia_id')) ?></th>
                            <td><?= esc($row->agenzia_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaListini.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaListini.agenzia_limite_vendita')) ?></th>
                            <td><?= esc($row->agenzia_limite_vendita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaListini.agenzia_ab_limite_vendita')) ?></th>
                            <td><?= esc($row->agenzia_ab_limite_vendita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaListini.agenzia_max_vendita')) ?></th>
                            <td><?= esc($row->agenzia_max_vendita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaListini.agenzia_ab_max_vendita')) ?></th>
                            <td><?= esc($row->agenzia_ab_max_vendita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaListini.ref_agenzia_datarecord')) ?></th>
                            <td><?= esc($row->ref_agenzia_datarecord ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('ref_agenzia_listini') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
