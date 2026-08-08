<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('tipologia_camera/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'tipologia_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'tipologia_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="tipologia_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('TipologiaCamera.tipologia_id')) ?>
                                <?php if (($sort ?? '') === 'tipologia_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('TipologiaCamera.nome_tipologia')) ?></th>
                        <th><?= esc(lang('TipologiaCamera.nome_tipologia_en')) ?></th>
                        <th><?= esc(lang('TipologiaCamera.nome_tipologia_fr')) ?></th>
                        <th><?= esc(lang('TipologiaCamera.nome_tipologia_de')) ?></th>
                        <th><?= esc(lang('TipologiaCamera.nome_tipologia_sp')) ?></th>
                        <th><?= esc(lang('TipologiaCamera.nome_tipologia_jp')) ?></th>
                        <th><?= esc(lang('TipologiaCamera.tipologia_sigla')) ?></th>
                        <th><?= esc(lang('TipologiaCamera.numero_pax')) ?></th>
                        <th><?= esc(lang('TipologiaCamera.perc_prezzo')) ?></th>
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
                                    <?php if ((string) ($row->tipologia_id ?? '') !== ''): ?>
                                        <?php
                                        $quickFilters = array_values((array) ($filters ?? []));
                                        $quickFilters[] = [
                                            'field' => 'tipologia_id',
                                            'operator' => 'eq',
                                            'value' => (string) $row->tipologia_id,
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
                                        ><?= esc($row->tipologia_id) ?></a>
                                    <?php endif; ?>
                                </td>                                <td><?= esc($row->nome_tipologia ?? '') ?></td>
                                <td><?= esc($row->nome_tipologia_en ?? '') ?></td>
                                <td><?= esc($row->nome_tipologia_fr ?? '') ?></td>
                                <td><?= esc($row->nome_tipologia_de ?? '') ?></td>
                                <td><?= esc($row->nome_tipologia_sp ?? '') ?></td>
                                <td><?= esc($row->nome_tipologia_jp ?? '') ?></td>
                                <td><?= esc($row->tipologia_sigla ?? '') ?></td>
                                <td><?= esc($row->numero_pax ?? '') ?></td>
                                <td><?= esc($row->perc_prezzo ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->tipologia_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('tipologia_camera/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('tipologia_camera/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('tipologia_camera/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('tipologia_camera/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
