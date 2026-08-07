<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('ref_agenzia_listini/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'ref_agenzia_listini_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'ref_agenzia_listini_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="ref_agenzia_listini_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('RefAgenziaListini.ref_agenzia_listini_id')) ?>
                                <?php if (($sort ?? '') === 'ref_agenzia_listini_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'agenzia_listini_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'agenzia_listini_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="agenzia_listini_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('RefAgenziaListini.agenzia_listini_id')) ?>
                                <?php if (($sort ?? '') === 'agenzia_listini_id'): ?>
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
                                <?= esc(lang('RefAgenziaListini.agenzia_id')) ?>
                                <?php if (($sort ?? '') === 'agenzia_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('RefAgenziaListini.hotel_id')) ?></th>
                        <th><?= esc(lang('RefAgenziaListini.agenzia_limite_vendita')) ?></th>
                        <th><?= esc(lang('RefAgenziaListini.agenzia_ab_limite_vendita')) ?></th>
                        <th><?= esc(lang('RefAgenziaListini.agenzia_max_vendita')) ?></th>
                        <th><?= esc(lang('RefAgenziaListini.agenzia_ab_max_vendita')) ?></th>
                        <th><?= esc(lang('RefAgenziaListini.ref_agenzia_datarecord')) ?></th>
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
                                <td><?= esc($row->ref_agenzia_listini_id ?? '') ?></td>
                                <td><?= esc($row->agenzia_listini_agenzia_listini_nome ?? $row->agenzia_listini_id ?? '') ?></td>
                                <td><?= esc($row->agenzie_agenzia_tipologia ?? $row->agenzia_id ?? '') ?></td>
                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->agenzia_limite_vendita ?? '') ?></td>
                                <td><?= esc($row->agenzia_ab_limite_vendita ?? '') ?></td>
                                <td><?= esc($row->agenzia_max_vendita ?? '') ?></td>
                                <td><?= esc($row->agenzia_ab_max_vendita ?? '') ?></td>
                                <td><?= esc($row->ref_agenzia_datarecord ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->ref_agenzia_listini_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('ref_agenzia_listini/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('ref_agenzia_listini/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('ref_agenzia_listini/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('ref_agenzia_listini/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
