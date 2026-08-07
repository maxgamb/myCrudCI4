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
                            <th class="w-25"><?= esc(lang('ObmpQuoteSub.obmp_quote_sub_id')) ?></th>
                            <td><?= esc($row->obmp_quote_sub_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuoteSub.obmp_quote_id')) ?></th>
                            <td><?= esc($row->obmp_quote_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuoteSub.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuoteSub.quote_sub_jeson')) ?></th>
                            <td><?= esc($row->quote_sub_jeson ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuoteSub.quote_sub_data')) ?></th>
                            <td><?= esc($row->quote_sub_data ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpQuoteSub.randomd_string')) ?></th>
                            <td><?= esc($row->randomd_string ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_quote_sub') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
