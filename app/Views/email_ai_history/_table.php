<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('email_ai_history/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('EmailAiHistory.id')) ?>
                                <?php if (($sort ?? '') === 'id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('EmailAiHistory.hotel_id')) ?></th>
                        <th><?= esc(lang('EmailAiHistory.category')) ?></th>
                        <th><?= esc(lang('EmailAiHistory.confidence')) ?></th>
                        <th><?= esc(lang('EmailAiHistory.referente_tipo')) ?></th>
                        <th><?= esc(lang('EmailAiHistory.prenotazione_tipo')) ?></th>
                        <th><?= esc(lang('EmailAiHistory.finalita')) ?></th>
                        <th><?= esc(lang('EmailAiHistory.segmento_commerciale')) ?></th>
                        <th><?= esc(lang('EmailAiHistory.agent_selected')) ?></th>
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
                                <td>
                                    <?php if ((string) ($row->id ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'id',
                                            'operator' => 'eq',
                                            'value' => (string) $row->id,
                                            'logic' => 'and',
                                        ];
                                        $quickQuery = array_replace((array) ($query ?? []), [
                                            'filters' => $quickFilters,
                                            'page' => 1,
                                        ]);
                                        ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link text-decoration-none"
                                            title="Filtra per questo valore"
                                        ><?= esc($row->id) ?></a>
                                    <?php endif; ?>
                                </td>                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->category ?? '') ?></td>
                                <td><?= esc($row->confidence ?? '') ?></td>
                                <td><?= esc($row->referente_tipo ?? '') ?></td>
                                <td><?= esc($row->prenotazione_tipo ?? '') ?></td>
                                <td><?= esc($row->finalita ?? '') ?></td>
                                <td><?= esc($row->segmento_commerciale ?? '') ?></td>
                                <td><?= esc($row->agent_selected ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('email_ai_history/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('email_ai_history/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('email_ai_history/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('email_ai_history/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
