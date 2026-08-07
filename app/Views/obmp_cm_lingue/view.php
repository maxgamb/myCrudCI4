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
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_id')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_rooms_id')) ?></th>
                            <td><?= esc($row->obmp_cm_rooms_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_codice')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_codice ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_nome')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_descrizione')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_descrizione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_html1')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_html1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_html2')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_html2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_html3')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_html3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_note')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_politiche')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_politiche ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_condizioni')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_condizioni ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpCmLingue.obmp_cm_lingue_utente_id')) ?></th>
                            <td><?= esc($row->obmp_cm_lingue_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_cm_lingue') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
