<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('costi_var/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'costi_var_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'costi_var_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="costi_var_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('CostiVar.costi_var_id')) ?>
                                <?php if (($sort ?? '') === 'costi_var_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'costi_area_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'costi_area_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="costi_area_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('CostiVar.costi_area_id')) ?>
                                <?php if (($sort ?? '') === 'costi_area_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('CostiVar.costi_var_sub_1')) ?></th>
                        <th><?= esc(lang('CostiVar.costi_var_sub_2')) ?></th>
                        <th><?= esc(lang('CostiVar.hotel_id')) ?></th>
                        <th><?= esc(lang('CostiVar.costi_var_codice')) ?></th>
                        <th><?= esc(lang('CostiVar.costi_var_nome')) ?></th>
                        <th><?= esc(lang('CostiVar.mag_quantita')) ?></th>
                        <th><?= esc(lang('CostiVar.costi_var_prezzo_uso')) ?></th>
                        <th><?= esc(lang('CostiVar.mag_prezzo_lavaggio')) ?></th>
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
                                <td><?= esc($row->costi_var_id ?? '') ?></td>
                                <td><?= esc($row->costi_area_costi_area_nome ?? $row->costi_area_id ?? '') ?></td>
                                <td><?= esc($row->costi_var_sub_1 ?? '') ?></td>
                                <td><?= esc($row->costi_var_sub_2 ?? '') ?></td>
                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->costi_var_codice ?? '') ?></td>
                                <td><?= esc($row->costi_var_nome ?? '') ?></td>
                                <td><?= esc($row->mag_quantita ?? '') ?></td>
                                <td><?= esc($row->costi_var_prezzo_uso ?? '') ?></td>
                                <td><?= esc($row->mag_prezzo_lavaggio ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->costi_var_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('costi_var/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('costi_var/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('costi_var/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('costi_var/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
