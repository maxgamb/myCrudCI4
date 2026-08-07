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
                            <th class="w-25"><?= esc(lang('ObmpAffiliati.obmp_affiliati_id')) ?></th>
                            <td><?= esc($row->obmp_affiliati_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpAffiliati.obmp_aff_societa')) ?></th>
                            <td><?= esc($row->obmp_aff_societa ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpAffiliati.obmp_aff_sito')) ?></th>
                            <td><?= esc($row->obmp_aff_sito ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpAffiliati.obmp_aff_email')) ?></th>
                            <td><?= esc($row->obmp_aff_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpAffiliati.obmp_aff_pasword')) ?></th>
                            <td><?= esc($row->obmp_aff_pasword ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpAffiliati.obmp_aff_cookies')) ?></th>
                            <td><?= esc($row->obmp_aff_cookies ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpAffiliati.obmp_aff_commisione')) ?></th>
                            <td><?= esc($row->obmp_aff_commisione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpAffiliati.obmp_aff_mark_up')) ?></th>
                            <td><?= esc($row->obmp_aff_mark_up ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_affiliati') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
