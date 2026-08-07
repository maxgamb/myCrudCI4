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
                            <th class="w-25"><?= esc(lang('QuestionRew.question_rew_id')) ?></th>
                            <td><?= esc($row->question_rew_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('QuestionRew.question_id')) ?></th>
                            <td><?= esc($row->question_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('QuestionRew.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('QuestionRew.conto_id')) ?></th>
                            <td><?= esc($row->conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('QuestionRew.clienti_id')) ?></th>
                            <td><?= esc($row->clienti_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('QuestionRew.valore')) ?></th>
                            <td><?= esc($row->valore ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('QuestionRew.data')) ?></th>
                            <td><?= esc($row->data ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('question_rew') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
