<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('obmp_clienti/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'obm_cliente_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'obm_cliente_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="obm_cliente_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('ObmpClienti.obm_cliente_id')) ?>
                                <?php if (($sort ?? '') === 'obm_cliente_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('ObmpClienti.obm_cliente_first_name')) ?></th>
                        <th><?= esc(lang('ObmpClienti.obm_cliente_last_name')) ?></th>
                        <?php
                        $nextDirection = ($sort ?? '') === 'obm_cliente_email' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'obm_cliente_email',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="obm_cliente_email"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('ObmpClienti.obm_cliente_email')) ?>
                                <?php if (($sort ?? '') === 'obm_cliente_email'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('ObmpClienti.obm_cliente_city')) ?></th>
                        <th><?= esc(lang('ObmpClienti.obm_cliente_country')) ?></th>
                        <th><?= esc(lang('ObmpClienti.lingua')) ?></th>
                        <th><?= esc(lang('ObmpClienti.obm_cliente_phone')) ?></th>
                        <th><?= esc(lang('ObmpClienti.obm_cliente_data_insert')) ?></th>
                        <th><?= esc(lang('ObmpClienti.obm_cliente_cc_type')) ?></th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="11" class="text-center text-muted py-4">
                                Nessun record trovato.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?= esc($row->obm_cliente_id ?? '') ?></td>
                                <td><?= esc($row->obm_cliente_first_name ?? '') ?></td>
                                <td><?= esc($row->obm_cliente_last_name ?? '') ?></td>
                                <td><?= esc($row->obm_cliente_email ?? '') ?></td>
                                <td><?= esc($row->obm_cliente_city ?? '') ?></td>
                                <td><?= esc($row->obm_cliente_country ?? '') ?></td>
                                <td><?= esc($row->lingua ?? '') ?></td>
                                <td><?= esc($row->obm_cliente_phone ?? '') ?></td>
                                <td><?= esc($row->obm_cliente_data_insert ?? '') ?></td>
                                <td><?= esc($row->obm_cliente_cc_type ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->obm_cliente_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('obmp_clienti/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('obmp_clienti/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('obmp_clienti/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('obmp_clienti/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
