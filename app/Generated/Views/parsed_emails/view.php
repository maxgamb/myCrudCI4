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
                            <th class="w-25"><?= esc(lang('ParsedEmails.id')) ?></th>
                            <td><?= esc($row->id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ParsedEmails.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ParsedEmails.category')) ?></th>
                            <td><?= esc($row->category ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ParsedEmails.referente_tipo')) ?></th>
                            <td><?= esc($row->referente_tipo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ParsedEmails.prenotazione_tipo')) ?></th>
                            <td><?= esc($row->prenotazione_tipo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ParsedEmails.finalita')) ?></th>
                            <td><?= esc($row->finalita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ParsedEmails.segmento_commerciale')) ?></th>
                            <td><?= esc($row->segmento_commerciale ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ParsedEmails.raw_email')) ?></th>
                            <td><?= esc($row->raw_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ParsedEmails.json_parsed')) ?></th>
                            <td><?= esc($row->json_parsed ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('parsed_emails') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
