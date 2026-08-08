<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('nazioni_linque/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'isoKey' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'isoKey',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="isoKey"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('NazioniLinque.isoKey')) ?>
                                <?php if (($sort ?? '') === 'isoKey'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('NazioniLinque.iso3')) ?></th>
                        <th><?= esc(lang('NazioniLinque.nazioni_EN')) ?></th>
                        <th><?= esc(lang('NazioniLinque.nazioni_ES')) ?></th>
                        <th><?= esc(lang('NazioniLinque.nazioni_FR')) ?></th>
                        <th><?= esc(lang('NazioniLinque.nazioni_DE')) ?></th>
                        <th><?= esc(lang('NazioniLinque.nazioni_IT')) ?></th>
                        <th><?= esc(lang('NazioniLinque.lg')) ?></th>
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
                                <td>
                                    <?php if ((string) ($row->isoKey ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'isoKey',
                                            'operator' => 'eq',
                                            'value' => (string) $row->isoKey,
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
                                        ><?= esc($row->isoKey) ?></a>
                                    <?php endif; ?>
                                </td>                                <td><?= esc($row->iso3 ?? '') ?></td>
                                <td><?= esc($row->nazioni_EN ?? '') ?></td>
                                <td><?= esc($row->nazioni_ES ?? '') ?></td>
                                <td><?= esc($row->nazioni_FR ?? '') ?></td>
                                <td><?= esc($row->nazioni_DE ?? '') ?></td>
                                <td><?= esc($row->nazioni_IT ?? '') ?></td>
                                <td><?= esc($row->lg ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->isoKey ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('nazioni_linque/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('nazioni_linque/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('nazioni_linque/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('nazioni_linque/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
