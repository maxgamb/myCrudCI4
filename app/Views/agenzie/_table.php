<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center gap-3 mb-3">
            <span class="text-muted">
                Record trovati: <strong><?= number_format((int) ($total ?? 0), 0, ',', '.') ?></strong>
            </span>
            <span class="text-muted small">
                Pagina <?= (int) ($page ?? 1) ?>
            </span>
        </div>

        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle mb-0">
                <thead>
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'agenzia_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'agenzia_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="agenzia_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Fields.agenzia_id')) ?>
                                <?php if (($sort ?? '') === 'agenzia_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'hotel_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'hotel_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="hotel_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Fields.hotel_id')) ?>
                                <?php if (($sort ?? '') === 'hotel_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Fields.agenzia_tipologia')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_nome')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_via')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_citta')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_state')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_country')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_cap')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_tel')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_fax')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_email')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_web')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_par_iva')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_par_cf')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_pec')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_sid')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_referente')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_banca_nome')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_banca_iban')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_banca_swift')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_banca_iata')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_cc_tipo')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_cc_nome')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_cc_numero')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_cc_scadenza')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_cc_cod_sicurezza')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_login')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_ab_web')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_ab_affiliati')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_ad_vis')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_ab_sospeso')) ?></th>
                        <th><?= esc(lang('Fields.agenzia_data_record')) ?></th>
                        <th><?= esc(lang('Fields.agenzie_utente_id')) ?></th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="35" class="text-center text-muted py-5">
                                Nessun record trovato.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?= esc($row->agenzia_id ?? '') ?></td>
                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->agenzia_tipologia ?? '') ?></td>
                                <td><?= esc($row->agenzia_nome ?? '') ?></td>
                                <td><?= esc($row->agenzia_via ?? '') ?></td>
                                <td><?= esc($row->agenzia_citta ?? '') ?></td>
                                <td><?= esc($row->agenzia_state ?? '') ?></td>
                                <td><?= esc($row->agenzia_country ?? '') ?></td>
                                <td><?= esc($row->agenzia_cap ?? '') ?></td>
                                <td><?= esc($row->agenzia_tel ?? '') ?></td>
                                <td><?= esc($row->agenzia_fax ?? '') ?></td>
                                <td><?= esc($row->agenzia_email ?? '') ?></td>
                                <td><?= esc($row->agenzia_web ?? '') ?></td>
                                <td><?= esc($row->agenzia_par_iva ?? '') ?></td>
                                <td><?= esc($row->agenzia_par_cf ?? '') ?></td>
                                <td><?= esc($row->agenzia_pec ?? '') ?></td>
                                <td><?= esc($row->agenzia_sid ?? '') ?></td>
                                <td><?= esc($row->agenzia_referente ?? '') ?></td>
                                <td><?= esc($row->agenzia_banca_nome ?? '') ?></td>
                                <td><?= esc($row->agenzia_banca_iban ?? '') ?></td>
                                <td><?= esc($row->agenzia_banca_swift ?? '') ?></td>
                                <td><?= esc($row->agenzia_banca_iata ?? '') ?></td>
                                <td><?= esc($row->agenzia_cc_tipo ?? '') ?></td>
                                <td><?= esc($row->agenzia_cc_nome ?? '') ?></td>
                                <td><?= esc($row->agenzia_cc_numero ?? '') ?></td>
                                <td><?= esc($row->agenzia_cc_scadenza ?? '') ?></td>
                                <td><?= esc($row->agenzia_cc_cod_sicurezza ?? '') ?></td>
                                <td><?= esc($row->agenzia_login ?? '') ?></td>
                                <td><?= esc($row->agenzia_ab_web ?? '') ?></td>
                                <td><?= esc($row->agenzia_ab_affiliati ?? '') ?></td>
                                <td><?= esc($row->agenzia_ad_vis ?? '') ?></td>
                                <td><?= esc($row->agenzia_ab_sospeso ?? '') ?></td>
                                <td><?= esc($row->agenzia_data_record ?? '') ?></td>
                                <td><?= esc($row->agenzie_utente_id ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->agenzia_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="<?= site_url('agenzie/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('agenzie/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('agenzie/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
                                            <?= csrf_field() ?>
                                            <button type="submit" class="btn btn-outline-danger" title="Elimina">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (($pagerLinks ?? '') !== ''): ?>
            <nav class="mt-3" aria-label="Paginazione">
                <?= $pagerLinks ?>
            </nav>
        <?php endif; ?>
    </div>
</div>
