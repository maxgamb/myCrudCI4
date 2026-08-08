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
                            <th class="w-25"><?= esc(lang('ListinoObmp.listino_id')) ?></th>
                            <td><?= esc($row->listino_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoObmp.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoObmp.listino_nome_id')) ?></th>
                            <td><a href="<?= site_url('listino_nome_obmp/view/' . rawurlencode((string) ($row->listino_nome_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->listino_nome_obmp__listino_nome_id__label ?? $row->listino_nome_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoObmp.tipologia_id')) ?></th>
                            <td><a href="<?= site_url('obmp_cm_rooms/view/' . rawurlencode((string) ($row->tipologia_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->obmp_cm_rooms__tipologia_id__label ?? $row->tipologia_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoObmp.listino_prezzo')) ?></th>
                            <td><?= esc($row->listino_prezzo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoObmp.ref_site')) ?></th>
                            <td><?= esc($row->ref_site ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoObmp.ref_agency')) ?></th>
                            <td><?= esc($row->ref_agency ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoObmp.ref_event')) ?></th>
                            <td><?= esc($row->ref_event ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoObmp.ref_session')) ?></th>
                            <td><?= esc($row->ref_session ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoObmp.ref_cookie')) ?></th>
                            <td><?= esc($row->ref_cookie ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ListinoObmp.listino_obmp_datarecord')) ?></th>
                            <td><?= esc($row->listino_obmp_datarecord ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('listino_obmp') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
