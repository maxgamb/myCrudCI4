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
                            <th class="w-25"><?= esc(lang('ObmpRefEvent.ref_event_id')) ?></th>
                            <td><?= esc($row->ref_event_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefEvent.ref_site_id')) ?></th>
                            <td><a href="<?= site_url('obmp_ref_site/view/' . rawurlencode((string) ($row->ref_site_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_ref_site__ref_site_id__label ?? $row->ref_site_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefEvent.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefEvent.listino_nome_id')) ?></th>
                            <td><a href="<?= site_url('listino_nome_obmp/view/' . rawurlencode((string) ($row->listino_nome_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->listino_nome_obmp__listino_nome_id__label ?? $row->listino_nome_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefEvent.agenzia_id')) ?></th>
                            <td><a href="<?= site_url('agenzie/view/' . rawurlencode((string) ($row->agenzia_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->agenzie__agenzia_id__label ?? $row->agenzia_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefEvent.ref_event_nome')) ?></th>
                            <td><?= esc($row->ref_event_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefEvent.event_dal')) ?></th>
                            <td><?= esc($row->event_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefEvent.event_al')) ?></th>
                            <td><?= esc($row->event_al ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpRefEvent.ref_event_note')) ?></th>
                            <td><?= esc($row->ref_event_note ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_ref_event') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
