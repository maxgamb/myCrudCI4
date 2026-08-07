<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('manutenzioni/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'manutenzione_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'manutenzione_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="manutenzione_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Manutenzioni.manutenzione_id')) ?>
                                <?php if (($sort ?? '') === 'manutenzione_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Manutenzioni.hotel_id')) ?></th>
                        <th><?= esc(lang('Manutenzioni.manut_priorita')) ?></th>
                        <th><?= esc(lang('Manutenzioni.manut_area_guasto')) ?></th>
                        <th><?= esc(lang('Manutenzioni.manut_piano')) ?></th>
                        <th><?= esc(lang('Manutenzioni.manut_camera')) ?></th>
                        <th><?= esc(lang('Manutenzioni.manut_data_segnalazione')) ?></th>
                        <th><?= esc(lang('Manutenzioni.manut_stato')) ?></th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="9" class="text-center text-muted py-4">
                                Nessun record trovato.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?= esc($row->manutenzione_id ?? '') ?></td>
                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->manut_priorita ?? '') ?></td>
                                <td><?= esc($row->manut_area_guasto ?? '') ?></td>
                                <td><?= esc($row->manut_piano ?? '') ?></td>
                                <td><?= esc($row->manut_camera ?? '') ?></td>
                                <td><?= esc($row->manut_data_segnalazione ?? '') ?></td>
                                <td><?= esc($row->manut_stato ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->manutenzione_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('manutenzioni/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('manutenzioni/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('manutenzioni/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('manutenzioni/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
