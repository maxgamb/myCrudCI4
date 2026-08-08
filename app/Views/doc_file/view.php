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
                            <th class="w-25"><?= esc(lang('DocFile.doc_files_id')) ?></th>
                            <td><?= esc($row->doc_files_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('DocFile.hotel_id')) ?></th>
                            <td><a href="<?= site_url('hotels/view/' . rawurlencode((string) ($row->hotel_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->hotels__hotel_id__label ?? $row->hotel_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('DocFile.doc_dipar_id')) ?></th>
                            <td><?= esc($row->doc_dipar_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('DocFile.doc_protocollo')) ?></th>
                            <td><?= esc($row->doc_protocollo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('DocFile.doc_url_file')) ?></th>
                            <td><?= esc($row->doc_url_file ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('DocFile.doc_note')) ?></th>
                            <td><?= esc($row->doc_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('DocFile.doc_utente_id')) ?></th>
                            <td><?= esc($row->doc_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('doc_file') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
