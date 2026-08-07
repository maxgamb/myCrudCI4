<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('woucher/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'woucher_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'woucher_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="woucher_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Woucher.woucher_id')) ?>
                                <?php if (($sort ?? '') === 'woucher_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Woucher.woucher_agenzia_id')) ?></th>
                        <th><?= esc(lang('Woucher.woucher_preno_id')) ?></th>
                        <th><?= esc(lang('Woucher.woucher_hotel_id')) ?></th>
                        <th><?= esc(lang('Woucher.woucher_in')) ?></th>
                        <th><?= esc(lang('Woucher.woucher_notti')) ?></th>
                        <th><?= esc(lang('Woucher.woucher_out')) ?></th>
                        <th><?= esc(lang('Woucher.woucher_numero')) ?></th>
                        <th><?= esc(lang('Woucher.woucher_serie')) ?></th>
                        <th><?= esc(lang('Woucher.woucher_singole')) ?></th>
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
                                <td><?= esc($row->woucher_id ?? '') ?></td>
                                <td><?= esc($row->woucher_agenzia_id ?? '') ?></td>
                                <td><?= esc($row->woucher_preno_id ?? '') ?></td>
                                <td><?= esc($row->woucher_hotel_id ?? '') ?></td>
                                <td><?= esc($row->woucher_in ?? '') ?></td>
                                <td><?= esc($row->woucher_notti ?? '') ?></td>
                                <td><?= esc($row->woucher_out ?? '') ?></td>
                                <td><?= esc($row->woucher_numero ?? '') ?></td>
                                <td><?= esc($row->woucher_serie ?? '') ?></td>
                                <td><?= esc($row->woucher_singole ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->woucher_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('woucher/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('woucher/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('woucher/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('woucher/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
