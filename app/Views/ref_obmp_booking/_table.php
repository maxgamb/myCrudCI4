<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('ref_obmp_booking/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'ref_obm_data' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'ref_obm_data',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="ref_obm_data"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('RefObmpBooking.ref_obm_data')) ?>
                                <?php if (($sort ?? '') === 'ref_obm_data'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'preno_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'preno_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="preno_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('RefObmpBooking.preno_id')) ?>
                                <?php if (($sort ?? '') === 'preno_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'obm_cliente_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'obm_cliente_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="obm_cliente_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('RefObmpBooking.obm_cliente_id')) ?>
                                <?php if (($sort ?? '') === 'obm_cliente_id'): ?>
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
                                <?= esc(lang('RefObmpBooking.hotel_id')) ?>
                                <?php if (($sort ?? '') === 'hotel_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'ref_site' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'ref_site',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="ref_site"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('RefObmpBooking.ref_site')) ?>
                                <?php if (($sort ?? '') === 'ref_site'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('RefObmpBooking.ref_agency')) ?></th>
                        <th><?= esc(lang('RefObmpBooking.ref_event')) ?></th>
                        <th><?= esc(lang('RefObmpBooking.ref_session')) ?></th>
                        <th><?= esc(lang('RefObmpBooking.ref_cookie')) ?></th>
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
                                <?= esc(lang('RefObmpBooking.quote_id')) ?>
                                <?php if (($sort ?? '') === 'quote_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th class="text-end">Azioni</th>
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
                                    <?php if ((string) ($row->ref_obm_data ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'ref_obm_data',
                                            'operator' => 'eq',
                                            'value' => (string) $row->ref_obm_data,
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
                                        ><?= esc($row->ref_obm_data) ?></a>
                                    <?php endif; ?>
                                </td>                                <td>
                                    <?php if ((string) ($row->preno_id ?? '') !== ''): ?><a href="<?= site_url('agenda/view/' . rawurlencode((string) $row->preno_id)) ?>" class="text-decoration-none"><?= esc($row->agenda__preno_id__label ?? $row->preno_id ?? '') ?></a><?php else: ?><?= esc($row->agenda__preno_id__label ?? '') ?><?php endif; ?>
                                    <?php
                                    $quickFilters = array_values((array) ($filters ?? []));
                                    $quickFilters[] = [
                                        'field' => 'preno_id',
                                        'operator' => 'eq',
                                        'value' => (string) ($row->preno_id ?? ''),
                                        'logic' => 'and',
                                    ];
                                    $quickQuery = array_replace((array) ($query ?? []), [
                                        'filters' => $quickFilters,
                                        'page' => 1,
                                    ]);
                                    ?>
                                    <?php if ((string) ($row->preno_id ?? '') !== ''): ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link ms-1 text-decoration-none"
                                            title="Filtra per questo valore"
                                            aria-label="Filtra per questo valore"
                                        ><i class="bi bi-funnel"></i></a>
                                    <?php endif; ?>                                </td>                                <td>
                                    <?php if ((string) ($row->obm_cliente_id ?? '') !== ''): ?><a href="<?= site_url('obmp_clienti/view/' . rawurlencode((string) $row->obm_cliente_id)) ?>" class="text-decoration-none"><?= esc($row->obmp_clienti__obm_cliente_id__label ?? $row->obm_cliente_id ?? '') ?></a><?php else: ?><?= esc($row->obmp_clienti__obm_cliente_id__label ?? '') ?><?php endif; ?>
                                    <?php
                                    $quickFilters = array_values((array) ($filters ?? []));
                                    $quickFilters[] = [
                                        'field' => 'obm_cliente_id',
                                        'operator' => 'eq',
                                        'value' => (string) ($row->obm_cliente_id ?? ''),
                                        'logic' => 'and',
                                    ];
                                    $quickQuery = array_replace((array) ($query ?? []), [
                                        'filters' => $quickFilters,
                                        'page' => 1,
                                    ]);
                                    ?>
                                    <?php if ((string) ($row->obm_cliente_id ?? '') !== ''): ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link ms-1 text-decoration-none"
                                            title="Filtra per questo valore"
                                            aria-label="Filtra per questo valore"
                                        ><i class="bi bi-funnel"></i></a>
                                    <?php endif; ?>                                </td>                                <td>
                                    <?php if ((string) ($row->hotel_id ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'hotel_id',
                                            'operator' => 'eq',
                                            'value' => (string) $row->hotel_id,
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
                                        ><?= esc($row->hotel_id) ?></a>
                                    <?php endif; ?>
                                </td>                                <td>
                                    <?php if ((string) ($row->ref_site ?? '') !== ''): ?><a href="<?= site_url('obmp_ref_site/view/' . rawurlencode((string) $row->ref_site)) ?>" class="text-decoration-none"><?= esc($row->obmp_ref_site__ref_site__label ?? $row->ref_site ?? '') ?></a><?php else: ?><?= esc($row->obmp_ref_site__ref_site__label ?? '') ?><?php endif; ?>
                                    <?php
                                    $quickFilters = array_values((array) ($filters ?? []));
                                    $quickFilters[] = [
                                        'field' => 'ref_site',
                                        'operator' => 'eq',
                                        'value' => (string) ($row->ref_site ?? ''),
                                        'logic' => 'and',
                                    ];
                                    $quickQuery = array_replace((array) ($query ?? []), [
                                        'filters' => $quickFilters,
                                        'page' => 1,
                                    ]);
                                    ?>
                                    <?php if ((string) ($row->ref_site ?? '') !== ''): ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link ms-1 text-decoration-none"
                                            title="Filtra per questo valore"
                                            aria-label="Filtra per questo valore"
                                        ><i class="bi bi-funnel"></i></a>
                                    <?php endif; ?>                                </td>                                <td><?= esc($row->ref_agency ?? '') ?></td>
                                <td><?= esc($row->ref_event ?? '') ?></td>
                                <td><?= esc($row->ref_session ?? '') ?></td>
                                <td><?= esc($row->ref_cookie ?? '') ?></td>
                                <td>
                                    <?php if ((string) ($row->quote_id ?? '') !== ''): ?><a href="<?= site_url('obmp_quote/view/' . rawurlencode((string) $row->quote_id)) ?>" class="text-decoration-none"><?= esc($row->obmp_quote__quote_id__label ?? $row->quote_id ?? '') ?></a><?php else: ?><?= esc($row->obmp_quote__quote_id__label ?? '') ?><?php endif; ?>
                                    <?php
                                    $quickFilters = array_values((array) ($filters ?? []));
                                    $quickFilters[] = [
                                        'field' => 'quote_id',
                                        'operator' => 'eq',
                                        'value' => (string) ($row->quote_id ?? ''),
                                        'logic' => 'and',
                                    ];
                                    $quickQuery = array_replace((array) ($query ?? []), [
                                        'filters' => $quickFilters,
                                        'page' => 1,
                                    ]);
                                    ?>
                                    <?php if ((string) ($row->quote_id ?? '') !== ''): ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link ms-1 text-decoration-none"
                                            title="Filtra per questo valore"
                                            aria-label="Filtra per questo valore"
                                        ><i class="bi bi-funnel"></i></a>
                                    <?php endif; ?>                                </td>                                <td class="text-end text-nowrap">
                                    <?php $id = $row->ref_obm_data ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('ref_obmp_booking/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('ref_obmp_booking/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('ref_obmp_booking/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('ref_obmp_booking/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
