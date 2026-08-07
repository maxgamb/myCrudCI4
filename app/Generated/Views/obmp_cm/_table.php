<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('obmp_cm/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'obmp_cm_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'obmp_cm_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="obmp_cm_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('ObmpCm.obmp_cm_id')) ?>
                                <?php if (($sort ?? '') === 'obmp_cm_id'): ?>
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
                                <?= esc(lang('ObmpCm.hotel_id')) ?>
                                <?php if (($sort ?? '') === 'hotel_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
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
                                <?= esc(lang('ObmpCm.agenzia_id')) ?>
                                <?php if (($sort ?? '') === 'agenzia_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('ObmpCm.obmp_cm_id_hotel_agenzia')) ?></th>
                        <?php
                        $nextDirection = ($sort ?? '') === 'obmp_cm_attiva' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'obmp_cm_attiva',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="obmp_cm_attiva"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('ObmpCm.obmp_cm_attiva')) ?>
                                <?php if (($sort ?? '') === 'obmp_cm_attiva'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('ObmpCm.obmp_cm_agenzia_url')) ?></th>
                        <th><?= esc(lang('ObmpCm.obmp_cm_agenzia_user')) ?></th>
                        <th><?= esc(lang('ObmpCm.obmp_cm_agenzia_password')) ?></th>
                        <th><?= esc(lang('ObmpCm.obmp_cm_ws_agenzia_url')) ?></th>
                        <th><?= esc(lang('ObmpCm.obmp_cm_ws_agenzia_user')) ?></th>
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
                                <td><?= esc($row->obmp_cm_id ?? '') ?></td>
                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->agenzie_agenzia_tipologia ?? $row->agenzia_id ?? '') ?></td>
                                <td><?= esc($row->obmp_cm_id_hotel_agenzia ?? '') ?></td>
                                <td><?= esc($row->obmp_cm_attiva ?? '') ?></td>
                                <td><?= esc($row->obmp_cm_agenzia_url ?? '') ?></td>
                                <td><?= esc($row->obmp_cm_agenzia_user ?? '') ?></td>
                                <td><?= esc($row->obmp_cm_agenzia_password ?? '') ?></td>
                                <td><?= esc($row->obmp_cm_ws_agenzia_url ?? '') ?></td>
                                <td><?= esc($row->obmp_cm_ws_agenzia_user ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->obmp_cm_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('obmp_cm/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('obmp_cm/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('obmp_cm/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('obmp_cm/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
