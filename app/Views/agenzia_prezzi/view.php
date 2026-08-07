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
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_id')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_listini_id')) ?></th>
                            <td><?= esc($row->agenzia_listini_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_listini_dal')) ?></th>
                            <td><?= esc($row->agenzia_listini_dal ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_listini_al')) ?></th>
                            <td><?= esc($row->agenzia_listini_al ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_1pax')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_1pax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_2pax')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_2pax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_3pax')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_3pax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_4pax')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_4pax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_free_pax')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_free_pax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_free')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_free ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_portage')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_portage ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_wdrink')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_wdrink ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_american_bb')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_american_bb ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_pranzo')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_pranzo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_cena')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_cena ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_nome')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_note')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_datarecord')) ?></th>
                            <td><?= esc($row->agenzia_prezzi_datarecord ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('agenzia_prezzi') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
