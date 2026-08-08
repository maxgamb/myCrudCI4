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
                            <th class="w-25"><?= esc(lang('ModificaConti.id_mod_conto')) ?></th>
                            <td><?= esc($row->id_mod_conto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_conto_id')) ?></th>
                            <td><a href="<?= site_url('conti/view/' . rawurlencode((string) ($row->mod_conto_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->conti__mod_conto_id__label ?? $row->mod_conto_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_hotel_id')) ?></th>
                            <td><?= esc($row->mod_hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_foglio_id')) ?></th>
                            <td><?= esc($row->mod_foglio_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_clienti_id')) ?></th>
                            <td><?= esc($row->mod_clienti_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_in_conto')) ?></th>
                            <td><?= esc($row->mod_in_conto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_out_preno')) ?></th>
                            <td><?= esc($row->mod_out_preno ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_out_conto')) ?></th>
                            <td><?= esc($row->mod_out_conto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_preno_id')) ?></th>
                            <td><?= esc($row->mod_preno_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_camera_id')) ?></th>
                            <td><?= esc($row->mod_camera_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_numero_camera')) ?></th>
                            <td><?= esc($row->mod_numero_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_trattamento_sog')) ?></th>
                            <td><?= esc($row->mod_trattamento_sog ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_tipo_camera')) ?></th>
                            <td><?= esc($row->mod_tipo_camera ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_prezzo')) ?></th>
                            <td><?= esc($row->mod_prezzo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_nome_cliente')) ?></th>
                            <td><?= esc($row->mod_nome_cliente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_cognome_cliente')) ?></th>
                            <td><?= esc($row->mod_cognome_cliente ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_preno_agenzia')) ?></th>
                            <td><?= esc($row->mod_preno_agenzia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_mercato')) ?></th>
                            <td><?= esc($row->mod_mercato ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_conti_stato_camere')) ?></th>
                            <td><?= esc($row->mod_conti_stato_camere ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.mod_acconto')) ?></th>
                            <td><?= esc($row->mod_acconto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ModificaConti.modifica_conti_adebiti_utente_id')) ?></th>
                            <td><?= esc($row->modifica_conti_adebiti_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('modifica_conti') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

</div>

<?= $this->endSection() ?>
