<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('comuni/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'Comuni_Codice' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'Comuni_Codice',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="Comuni_Codice"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Comuni.Comuni_Codice')) ?>
                                <?php if (($sort ?? '') === 'Comuni_Codice'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'Comuni_Nome' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'Comuni_Nome',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="Comuni_Nome"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Comuni.Comuni_Nome')) ?>
                                <?php if (($sort ?? '') === 'Comuni_Nome'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Comuni.Comuni_Prov')) ?></th>
                        <th><?= esc(lang('Comuni.Comuni_CAP')) ?></th>
                        <th><?= esc(lang('Comuni.Comuni_Prefisso')) ?></th>
                        <th><?= esc(lang('Comuni.Comuni_ColExcel')) ?></th>
                        <th><?= esc(lang('Comuni.Comuni_Nazione')) ?></th>
                        <th><?= esc(lang('Comuni.Comuni_Lingua')) ?></th>
                        <th><?= esc(lang('Comuni.nazione_iso2')) ?></th>
                        <th><?= esc(lang('Comuni.nazione_iso3')) ?></th>
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
                                    <?php if ((string) ($row->Comuni_Codice ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'Comuni_Codice',
                                            'operator' => 'eq',
                                            'value' => (string) $row->Comuni_Codice,
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
                                        ><?= esc($row->Comuni_Codice) ?></a>
                                    <?php endif; ?>
                                </td>                                <td>
                                    <?php if ((string) ($row->Comuni_Nome ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'Comuni_Nome',
                                            'operator' => 'eq',
                                            'value' => (string) $row->Comuni_Nome,
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
                                        ><?= esc($row->Comuni_Nome) ?></a>
                                    <?php endif; ?>
                                </td>                                <td><?= esc($row->Comuni_Prov ?? '') ?></td>
                                <td><?= esc($row->Comuni_CAP ?? '') ?></td>
                                <td><?= esc($row->Comuni_Prefisso ?? '') ?></td>
                                <td><?= esc($row->Comuni_ColExcel ?? '') ?></td>
                                <td><?= esc($row->Comuni_Nazione ?? '') ?></td>
                                <td><?= esc($row->Comuni_Lingua ?? '') ?></td>
                                <td><?= esc($row->nazione_iso2 ?? '') ?></td>
                                <td><?= esc($row->nazione_iso3 ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->Comuni_Codice ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('comuni/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('comuni/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('comuni/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('comuni/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
