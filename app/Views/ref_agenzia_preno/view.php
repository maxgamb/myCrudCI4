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
                            <th class="w-25"><?= esc(lang('RefAgenziaPreno.ref_agenzia_preno')) ?></th>
                            <td><?= esc($row->ref_agenzia_preno ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaPreno.agenzia_id')) ?></th>
                            <td><a href="<?= site_url('agenzie/view/' . rawurlencode((string) ($row->agenzia_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->agenzie__agenzia_id__label ?? $row->agenzia_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaPreno.preno_id')) ?></th>
                            <td><a href="<?= site_url('agenda/view/' . rawurlencode((string) ($row->preno_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->agenda__preno_id__label ?? $row->preno_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('RefAgenziaPreno.ref_a_p_datarecord')) ?></th>
                            <td><?= esc($row->ref_a_p_datarecord ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('ref_agenzia_preno') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
