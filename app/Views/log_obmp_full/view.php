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
                            <th class="w-25"><?= esc(lang('LogObmpFull.log_obmp_id_full')) ?></th>
                            <td><?= esc($row->log_obmp_id_full ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.preno_dal')) ?></th>
                            <td><?= esc($row->preno_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.preno_al')) ?></th>
                            <td><?= esc($row->preno_al ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.Q1')) ?></th>
                            <td><?= esc($row->Q1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.T1')) ?></th>
                            <td><?= esc($row->T1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.ref_site')) ?></th>
                            <td><?= esc($row->ref_site ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.ref_agency')) ?></th>
                            <td><?= esc($row->ref_agency ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.ref_event')) ?></th>
                            <td><?= esc($row->ref_event ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.ref_session')) ?></th>
                            <td><?= esc($row->ref_session ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.ref_cookie')) ?></th>
                            <td><?= esc($row->ref_cookie ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.mygooglekeyword')) ?></th>
                            <td><?= esc($row->mygooglekeyword ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.today')) ?></th>
                            <td><?= esc($row->today ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('LogObmpFull.log_obmp_daterecord')) ?></th>
                            <td><?= esc($row->log_obmp_daterecord ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('log_obmp_full') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
