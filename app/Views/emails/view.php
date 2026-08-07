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
                            <th class="w-25"><?= esc(lang('Emails.id')) ?></th>
                            <td><?= esc($row->id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.direction')) ?></th>
                            <td><?= esc($row->direction ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.uid')) ?></th>
                            <td><?= esc($row->uid ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.message_id')) ?></th>
                            <td><?= esc($row->message_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.in_reply_to')) ?></th>
                            <td><?= esc($row->in_reply_to ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.refs')) ?></th>
                            <td><?= esc($row->refs ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.email_from')) ?></th>
                            <td><?= esc($row->email_from ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.thread_id')) ?></th>
                            <td><?= esc($row->thread_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.thread_status')) ?></th>
                            <td><?= esc($row->thread_status ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.subject')) ?></th>
                            <td><?= esc($row->subject ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.body')) ?></th>
                            <td><?= esc($row->body ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.category')) ?></th>
                            <td><?= esc($row->category ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.language')) ?></th>
                            <td><?= esc($row->language ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.reply')) ?></th>
                            <td><?= esc($row->reply ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.attachments')) ?></th>
                            <td><?= esc($row->attachments ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Emails.replied')) ?></th>
                            <td><?= esc($row->replied ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('emails') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
