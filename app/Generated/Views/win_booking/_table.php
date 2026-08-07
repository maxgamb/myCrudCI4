<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('win_booking/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'win_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'win_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="win_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('WinBooking.win_id')) ?>
                                <?php if (($sort ?? '') === 'win_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('WinBooking.hotel_id')) ?></th>
                        <th><?= esc(lang('WinBooking.win_dal')) ?></th>
                        <th><?= esc(lang('WinBooking.win_al')) ?></th>
                        <th><?= esc(lang('WinBooking.mese')) ?></th>
                        <th><?= esc(lang('WinBooking.win_hotel')) ?></th>
                        <th><?= esc(lang('WinBooking.win_comp')) ?></th>
                        <th><?= esc(lang('WinBooking.win_hotel_cum')) ?></th>
                        <th><?= esc(lang('WinBooking.win_comp_cum')) ?></th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="10" class="text-center text-muted py-4">
                                Nessun record trovato.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?= esc($row->win_id ?? '') ?></td>
                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->win_dal ?? '') ?></td>
                                <td><?= esc($row->win_al ?? '') ?></td>
                                <td><?= esc($row->mese ?? '') ?></td>
                                <td><?= esc($row->win_hotel ?? '') ?></td>
                                <td><?= esc($row->win_comp ?? '') ?></td>
                                <td><?= esc($row->win_hotel_cum ?? '') ?></td>
                                <td><?= esc($row->win_comp_cum ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->win_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('win_booking/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('win_booking/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('win_booking/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('win_booking/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
