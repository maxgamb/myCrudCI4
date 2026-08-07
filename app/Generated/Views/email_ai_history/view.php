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
                            <th class="w-25"><?= esc(lang('EmailAiHistory.id')) ?></th>
                            <td><?= esc($row->id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.raw_email')) ?></th>
                            <td><?= esc($row->raw_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.json_classifier')) ?></th>
                            <td><?= esc($row->json_classifier ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.category')) ?></th>
                            <td><?= esc($row->category ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.confidence')) ?></th>
                            <td><?= esc($row->confidence ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.referente_tipo')) ?></th>
                            <td><?= esc($row->referente_tipo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.prenotazione_tipo')) ?></th>
                            <td><?= esc($row->prenotazione_tipo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.finalita')) ?></th>
                            <td><?= esc($row->finalita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.segmento_commerciale')) ?></th>
                            <td><?= esc($row->segmento_commerciale ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.agent_selected')) ?></th>
                            <td><?= esc($row->agent_selected ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.reply_prompt')) ?></th>
                            <td><?= esc($row->reply_prompt ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.gpt_reply_raw')) ?></th>
                            <td><?= esc($row->gpt_reply_raw ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.gpt_reply_clean')) ?></th>
                            <td><?= esc($row->gpt_reply_clean ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('EmailAiHistory.pms_output')) ?></th>
                            <td><?= esc($row->pms_output ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('email_ai_history') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
