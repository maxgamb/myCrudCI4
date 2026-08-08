<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('banca_hotel/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'banca_hotel_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'banca_hotel_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="banca_hotel_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('BancaHotel.banca_hotel_id')) ?>
                                <?php if (($sort ?? '') === 'banca_hotel_id'): ?>
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
                                <?= esc(lang('BancaHotel.hotel_id')) ?>
                                <?php if (($sort ?? '') === 'hotel_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('BancaHotel.Banca_Nome_Societa')) ?></th>
                        <th><?= esc(lang('BancaHotel.Banca_Nome')) ?></th>
                        <th><?= esc(lang('BancaHotel.Banca_via')) ?></th>
                        <th><?= esc(lang('BancaHotel.Banca_citta')) ?></th>
                        <th><?= esc(lang('BancaHotel.Intestazione')) ?></th>
                        <th><?= esc(lang('BancaHotel.BBAN')) ?></th>
                        <th><?= esc(lang('BancaHotel.CIN')) ?></th>
                        <th><?= esc(lang('BancaHotel.ABI')) ?></th>
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
                                    <?php if ((string) ($row->banca_hotel_id ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'banca_hotel_id',
                                            'operator' => 'eq',
                                            'value' => (string) $row->banca_hotel_id,
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
                                        ><?= esc($row->banca_hotel_id) ?></a>
                                    <?php endif; ?>
                                </td>                                <td>
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
                                </td>                                <td><?= esc($row->Banca_Nome_Societa ?? '') ?></td>
                                <td><?= esc($row->Banca_Nome ?? '') ?></td>
                                <td><?= esc($row->Banca_via ?? '') ?></td>
                                <td><?= esc($row->Banca_citta ?? '') ?></td>
                                <td><?= esc($row->Intestazione ?? '') ?></td>
                                <td><?= esc($row->BBAN ?? '') ?></td>
                                <td><?= esc($row->CIN ?? '') ?></td>
                                <td><?= esc($row->ABI ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->banca_hotel_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('banca_hotel/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('banca_hotel/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('banca_hotel/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('banca_hotel/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
