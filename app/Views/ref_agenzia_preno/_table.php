<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('ref_agenzia_preno/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'ref_agenzia_preno' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'ref_agenzia_preno',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="ref_agenzia_preno"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('RefAgenziaPreno.ref_agenzia_preno')) ?>
                                <?php if (($sort ?? '') === 'ref_agenzia_preno'): ?>
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
                                <?= esc(lang('RefAgenziaPreno.agenzia_id')) ?>
                                <?php if (($sort ?? '') === 'agenzia_id'): ?>
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
                                <?= esc(lang('RefAgenziaPreno.preno_id')) ?>
                                <?php if (($sort ?? '') === 'preno_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('RefAgenziaPreno.ref_a_p_datarecord')) ?></th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="5" class="text-center text-muted py-4">
                                Nessun record trovato.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td>
                                    <?php if ((string) ($row->ref_agenzia_preno ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'ref_agenzia_preno',
                                            'operator' => 'eq',
                                            'value' => (string) $row->ref_agenzia_preno,
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
                                        ><?= esc($row->ref_agenzia_preno) ?></a>
                                    <?php endif; ?>
                                </td>                                <td>
                                    <?php if ((string) ($row->agenzia_id ?? '') !== ''): ?><a href="<?= site_url('agenzie/view/' . rawurlencode((string) $row->agenzia_id)) ?>" class="text-decoration-none"><?= esc($row->agenzie__agenzia_id__label ?? $row->agenzia_id ?? '') ?></a><?php else: ?><?= esc($row->agenzie__agenzia_id__label ?? '') ?><?php endif; ?>
                                    <?php
                                    $quickFilters = array_values((array) ($filters ?? []));
                                    $quickFilters[] = [
                                        'field' => 'agenzia_id',
                                        'operator' => 'eq',
                                        'value' => (string) ($row->agenzia_id ?? ''),
                                        'logic' => 'and',
                                    ];
                                    $quickQuery = array_replace((array) ($query ?? []), [
                                        'filters' => $quickFilters,
                                        'page' => 1,
                                    ]);
                                    ?>
                                    <?php if ((string) ($row->agenzia_id ?? '') !== ''): ?>
                                        <a
                                            href="<?= current_url() . '?' . http_build_query($quickQuery) ?>"
                                            class="js-list-link ms-1 text-decoration-none"
                                            title="Filtra per questo valore"
                                            aria-label="Filtra per questo valore"
                                        ><i class="bi bi-funnel"></i></a>
                                    <?php endif; ?>                                </td>                                <td>
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
                                    <?php endif; ?>                                </td>                                <td><?= esc($row->ref_a_p_datarecord ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->ref_agenzia_preno ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('ref_agenzia_preno/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('ref_agenzia_preno/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('ref_agenzia_preno/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('ref_agenzia_preno/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
