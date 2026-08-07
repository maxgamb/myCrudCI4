<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('prezzi/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'prezzo_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'prezzo_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="prezzo_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Prezzi.prezzo_id')) ?>
                                <?php if (($sort ?? '') === 'prezzo_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Prezzi.hotel_id')) ?></th>
                        <th><?= esc(lang('Prezzi.conto_id')) ?></th>
                        <th><?= esc(lang('Prezzi.prezzo_dal')) ?></th>
                        <th><?= esc(lang('Prezzi.prezzo_al')) ?></th>
                        <th><?= esc(lang('Prezzi.prezzo_valore')) ?></th>
                        <th><?= esc(lang('Prezzi.libero')) ?></th>
                        <th><?= esc(lang('Prezzi.prezzi_utente_id')) ?></th>
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
                                <td><?= esc($row->prezzo_id ?? '') ?></td>
                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->conto_id ?? '') ?></td>
                                <td><?= esc($row->prezzo_dal ?? '') ?></td>
                                <td><?= esc($row->prezzo_al ?? '') ?></td>
                                <td><?= esc($row->prezzo_valore ?? '') ?></td>
                                <td><?= esc($row->libero ?? '') ?></td>
                                <td><?= esc($row->prezzi_utente_id ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->prezzo_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('prezzi/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('prezzi/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('prezzi/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('prezzi/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
