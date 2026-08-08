<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('obmp_quote/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'quote_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'quote_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="quote_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('ObmpQuote.quote_id')) ?>
                                <?php if (($sort ?? '') === 'quote_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('ObmpQuote.hotel_id')) ?></th>
                        <th><?= esc(lang('ObmpQuote.quote_lg')) ?></th>
                        <th><?= esc(lang('ObmpQuote.quote_dal')) ?></th>
                        <th><?= esc(lang('ObmpQuote.quote_titolo')) ?></th>
                        <th><?= esc(lang('ObmpQuote.quote_nome')) ?></th>
                        <th><?= esc(lang('ObmpQuote.quote_email')) ?></th>
                        <th><?= esc(lang('ObmpQuote.quote_tel_rich')) ?></th>
                        <th><?= esc(lang('ObmpQuote.quote_data_time')) ?></th>
                        <th><?= esc(lang('ObmpQuote.quote_stato')) ?></th>
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
                                <td>
                                    <?php if ((string) ($row->quote_id ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'quote_id',
                                            'operator' => 'eq',
                                            'value' => (string) $row->quote_id,
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
                                        ><?= esc($row->quote_id) ?></a>
                                    <?php endif; ?>
                                </td>                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->quote_lg ?? '') ?></td>
                                <td><?= esc($row->quote_dal ?? '') ?></td>
                                <td><?= esc($row->quote_titolo ?? '') ?></td>
                                <td><?= esc($row->quote_nome ?? '') ?></td>
                                <td><?= esc($row->quote_email ?? '') ?></td>
                                <td><?= esc($row->quote_tel_rich ?? '') ?></td>
                                <td><?= esc($row->quote_data_time ?? '') ?></td>
                                <td><?= esc($row->quote_stato ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->quote_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('obmp_quote/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('obmp_quote/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('obmp_quote/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('obmp_quote/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
