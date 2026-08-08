<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('obmp_affiliati/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'obmp_affiliati_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'obmp_affiliati_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="obmp_affiliati_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('ObmpAffiliati.obmp_affiliati_id')) ?>
                                <?php if (($sort ?? '') === 'obmp_affiliati_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('ObmpAffiliati.obmp_aff_societa')) ?></th>
                        <th><?= esc(lang('ObmpAffiliati.obmp_aff_sito')) ?></th>
                        <th><?= esc(lang('ObmpAffiliati.obmp_aff_email')) ?></th>
                        <th><?= esc(lang('ObmpAffiliati.obmp_aff_pasword')) ?></th>
                        <th><?= esc(lang('ObmpAffiliati.obmp_aff_cookies')) ?></th>
                        <th><?= esc(lang('ObmpAffiliati.obmp_aff_commisione')) ?></th>
                        <th><?= esc(lang('ObmpAffiliati.obmp_aff_mark_up')) ?></th>
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
                                    <?php if ((string) ($row->obmp_affiliati_id ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'obmp_affiliati_id',
                                            'operator' => 'eq',
                                            'value' => (string) $row->obmp_affiliati_id,
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
                                        ><?= esc($row->obmp_affiliati_id) ?></a>
                                    <?php endif; ?>
                                </td>                                <td><?= esc($row->obmp_aff_societa ?? '') ?></td>
                                <td><?= esc($row->obmp_aff_sito ?? '') ?></td>
                                <td><?= esc($row->obmp_aff_email ?? '') ?></td>
                                <td><?= esc($row->obmp_aff_pasword ?? '') ?></td>
                                <td><?= esc($row->obmp_aff_cookies ?? '') ?></td>
                                <td><?= esc($row->obmp_aff_commisione ?? '') ?></td>
                                <td><?= esc($row->obmp_aff_mark_up ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->obmp_affiliati_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('obmp_affiliati/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('obmp_affiliati/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('obmp_affiliati/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('obmp_affiliati/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
