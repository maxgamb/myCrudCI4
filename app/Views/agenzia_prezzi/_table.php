<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('agenzia_prezzi/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'agenzia_prezzi_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'agenzia_prezzi_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="agenzia_prezzi_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('AgenziaPrezzi.agenzia_prezzi_id')) ?>
                                <?php if (($sort ?? '') === 'agenzia_prezzi_id'): ?>
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
                                <?= esc(lang('AgenziaPrezzi.hotel_id')) ?>
                                <?php if (($sort ?? '') === 'hotel_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('AgenziaPrezzi.agenzia_listini_id')) ?></th>
                        <th><?= esc(lang('AgenziaPrezzi.agenzia_listini_dal')) ?></th>
                        <th><?= esc(lang('AgenziaPrezzi.agenzia_listini_al')) ?></th>
                        <th><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_1pax')) ?></th>
                        <th><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_2pax')) ?></th>
                        <th><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_3pax')) ?></th>
                        <th><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_4pax')) ?></th>
                        <th><?= esc(lang('AgenziaPrezzi.agenzia_prezzi_nome')) ?></th>
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
                                <td><?= esc($row->agenzia_listini_agenzia_listini_nome ?? $row->agenzia_prezzi_id ?? '') ?></td>
                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->agenzia_listini_id ?? '') ?></td>
                                <td><?= esc($row->agenzia_listini_dal ?? '') ?></td>
                                <td><?= esc($row->agenzia_listini_al ?? '') ?></td>
                                <td><?= esc($row->agenzia_prezzi_1pax ?? '') ?></td>
                                <td><?= esc($row->agenzia_prezzi_2pax ?? '') ?></td>
                                <td><?= esc($row->agenzia_prezzi_3pax ?? '') ?></td>
                                <td><?= esc($row->agenzia_prezzi_4pax ?? '') ?></td>
                                <td><?= esc($row->agenzia_prezzi_nome ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->agenzia_prezzi_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('agenzia_prezzi/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('agenzia_prezzi/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('agenzia_prezzi/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('agenzia_prezzi/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
