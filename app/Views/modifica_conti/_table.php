<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('modifica_conti/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'id_mod_conto' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'id_mod_conto',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="id_mod_conto"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('ModificaConti.id_mod_conto')) ?>
                                <?php if (($sort ?? '') === 'id_mod_conto'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'mod_conto_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'mod_conto_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="mod_conto_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('ModificaConti.mod_conto_id')) ?>
                                <?php if (($sort ?? '') === 'mod_conto_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('ModificaConti.mod_hotel_id')) ?></th>
                        <th><?= esc(lang('ModificaConti.mod_foglio_id')) ?></th>
                        <th><?= esc(lang('ModificaConti.mod_clienti_id')) ?></th>
                        <th><?= esc(lang('ModificaConti.mod_in_conto')) ?></th>
                        <th><?= esc(lang('ModificaConti.mod_tipo_camera')) ?></th>
                        <th><?= esc(lang('ModificaConti.mod_prezzo')) ?></th>
                        <th><?= esc(lang('ModificaConti.mod_nome_cliente')) ?></th>
                        <th><?= esc(lang('ModificaConti.mod_conti_stato_camere')) ?></th>
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
                                    <?php if ((string) ($row->id_mod_conto ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'id_mod_conto',
                                            'operator' => 'eq',
                                            'value' => (string) $row->id_mod_conto,
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
                                        ><?= esc($row->id_mod_conto) ?></a>
                                    <?php endif; ?>
                                </td>                                <td>
                                    <?php if ((string) ($row->mod_conto_id ?? '') !== ''): ?><a href="<?= site_url('conti/view/' . rawurlencode((string) $row->mod_conto_id)) ?>" class="text-decoration-none"><?= esc($row->conti__mod_conto_id__label ?? $row->mod_conto_id ?? '') ?></a><?php else: ?><?= esc($row->conti__mod_conto_id__label ?? '') ?><?php endif; ?>
                                    <?php
                                    $quickFilters = array_values((array) ($filters ?? []));
                                    $quickFilters[] = [
                                        'field' => 'mod_conto_id',
                                        'operator' => 'eq',
                                        'value' => (string) ($row->mod_conto_id ?? ''),
                                        'logic' => 'and',
                                    ];
                                    $quickQuery = array_replace((array) ($query ?? []), [
                                        'filters' => $quickFilters,
                                        'page' => 1,
                                    ]);
                                    ?>
                                    <?php if ((string) ($row->mod_conto_id ?? '') !== ''): ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link ms-1 text-decoration-none"
                                            title="Filtra per questo valore"
                                            aria-label="Filtra per questo valore"
                                        ><i class="bi bi-funnel"></i></a>
                                    <?php endif; ?>                                </td>                                <td><?= esc($row->mod_hotel_id ?? '') ?></td>
                                <td><?= esc($row->mod_foglio_id ?? '') ?></td>
                                <td><?= esc($row->mod_clienti_id ?? '') ?></td>
                                <td><?= esc($row->mod_in_conto ?? '') ?></td>
                                <td><?= esc($row->mod_tipo_camera ?? '') ?></td>
                                <td><?= esc($row->mod_prezzo ?? '') ?></td>
                                <td><?= esc($row->mod_nome_cliente ?? '') ?></td>
                                <td><?= esc($row->mod_conti_stato_camere ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->id_mod_conto ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('modifica_conti/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('modifica_conti/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('modifica_conti/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('modifica_conti/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
