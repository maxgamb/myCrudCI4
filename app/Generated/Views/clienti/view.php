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
                            <th class="w-25"><?= esc(lang('Clienti.clienti_id')) ?></th>
                            <td><?= esc($row->clienti_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.preno_id')) ?></th>
                            <td><?= esc($row->preno_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.camera_id')) ?></th>
                            <td><?= esc($row->camera_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.camera_numero')) ?></th>
                            <td><?= esc($row->camera_numero ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.camara_tipologia')) ?></th>
                            <td><?= esc($row->camara_tipologia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_nome')) ?></th>
                            <td><?= esc($row->clienti_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_cogno')) ?></th>
                            <td><?= esc($row->clienti_cogno ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nato_a')) ?></th>
                            <td><?= esc($row->cliente_nato_a ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nato_il')) ?></th>
                            <td><?= esc($row->cliente_nato_il ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nazione')) ?></th>
                            <td><?= esc($row->cliente_nazione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_provincia')) ?></th>
                            <td><?= esc($row->cliente_provincia ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_residenza')) ?></th>
                            <td><?= esc($row->cliente_residenza ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_cocumento_tipo')) ?></th>
                            <td><?= esc($row->cliente_cocumento_tipo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_cocumento_numero')) ?></th>
                            <td><?= esc($row->cliente_cocumento_numero ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_cocumento_rilasciato_il')) ?></th>
                            <td><?= esc($row->cliente_cocumento_rilasciato_il ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_sesso')) ?></th>
                            <td><?= esc($row->cliente_sesso ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_nome1')) ?></th>
                            <td><?= esc($row->clienti_nome1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_nome2')) ?></th>
                            <td><?= esc($row->clienti_nome2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_nome3')) ?></th>
                            <td><?= esc($row->clienti_nome3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_nome4')) ?></th>
                            <td><?= esc($row->clienti_nome4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_cogno1')) ?></th>
                            <td><?= esc($row->clienti_cogno1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_cogno2')) ?></th>
                            <td><?= esc($row->clienti_cogno2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_cogno3')) ?></th>
                            <td><?= esc($row->clienti_cogno3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_cogno4')) ?></th>
                            <td><?= esc($row->clienti_cogno4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nato_a1')) ?></th>
                            <td><?= esc($row->cliente_nato_a1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nato_a2')) ?></th>
                            <td><?= esc($row->cliente_nato_a2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nato_a3')) ?></th>
                            <td><?= esc($row->cliente_nato_a3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nato_a4')) ?></th>
                            <td><?= esc($row->cliente_nato_a4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nato_il1')) ?></th>
                            <td><?= esc($row->cliente_nato_il1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nato_il2')) ?></th>
                            <td><?= esc($row->cliente_nato_il2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nato_il3')) ?></th>
                            <td><?= esc($row->cliente_nato_il3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nato_il4')) ?></th>
                            <td><?= esc($row->cliente_nato_il4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_sesso1')) ?></th>
                            <td><?= esc($row->cliente_sesso1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_sesso2')) ?></th>
                            <td><?= esc($row->cliente_sesso2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_sesso3')) ?></th>
                            <td><?= esc($row->cliente_sesso3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_sesso4')) ?></th>
                            <td><?= esc($row->cliente_sesso4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nazione1')) ?></th>
                            <td><?= esc($row->cliente_nazione1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nazione2')) ?></th>
                            <td><?= esc($row->cliente_nazione2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nazione3')) ?></th>
                            <td><?= esc($row->cliente_nazione3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_nazione4')) ?></th>
                            <td><?= esc($row->cliente_nazione4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_provincia1')) ?></th>
                            <td><?= esc($row->cliente_provincia1 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_provincia2')) ?></th>
                            <td><?= esc($row->cliente_provincia2 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_provincia3')) ?></th>
                            <td><?= esc($row->cliente_provincia3 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.cliente_provincia4')) ?></th>
                            <td><?= esc($row->cliente_provincia4 ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_cc_tip')) ?></th>
                            <td><?= esc($row->clienti_cc_tip ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_cc_n')) ?></th>
                            <td><?= esc($row->clienti_cc_n ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_cc_scad')) ?></th>
                            <td><?= esc($row->clienti_cc_scad ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_tel')) ?></th>
                            <td><?= esc($row->clienti_tel ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_fax')) ?></th>
                            <td><?= esc($row->clienti_fax ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_email')) ?></th>
                            <td><?= esc($row->clienti_email ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_note')) ?></th>
                            <td><?= esc($row->clienti_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.privacy')) ?></th>
                            <td><?= esc($row->privacy ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.marketing')) ?></th>
                            <td><?= esc($row->marketing ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.lingua')) ?></th>
                            <td><?= esc($row->lingua ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.password')) ?></th>
                            <td><?= esc($row->password ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Clienti.clienti_utente_id')) ?></th>
                            <td><?= esc($row->clienti_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('clienti') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Punti Spesi</strong>
            <span class="badge bg-secondary"><?= (int) ($children['punti_spesi__cliente_id']['count'] ?? 0) ?><?= !empty($children['punti_spesi__cliente_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['punti_spesi__cliente_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Punti Spesi Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Conto Id') ?></th>
                                <th><?= esc('Punti') ?></th>
                                <th><?= esc('Data') ?></th>
                                <th><?= esc('Data Record') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->punti_spesi_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->conto_id ?? '') ?></td>
                                <td><?= esc($child->punti ?? '') ?></td>
                                <td><?= esc($child->data ?? '') ?></td>
                                <td><?= esc($child->data_record ?? '') ?></td>
                                    <td><a href="<?= site_url('punti_spesi/view/' . ($child->punti_spesi_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['punti_spesi__cliente_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
