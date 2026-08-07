<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('agenda/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
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
                                <?= esc(lang('Agenda.preno_id')) ?>
                                <?php if (($sort ?? '') === 'preno_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'preno_in_data' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'preno_in_data',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="preno_in_data"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Agenda.preno_in_data')) ?>
                                <?php if (($sort ?? '') === 'preno_in_data'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Agenda.preno_importo')) ?></th>
                        <th><?= esc(lang('Agenda.preno_nome')) ?></th>
                        <?php
                        $nextDirection = ($sort ?? '') === 'preno_agenzia' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'preno_agenzia',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="preno_agenzia"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Agenda.preno_agenzia')) ?>
                                <?php if (($sort ?? '') === 'preno_agenzia'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Agenda.preno_tel')) ?></th>
                        <th><?= esc(lang('Agenda.preno_email')) ?></th>
                        <th><?= esc(lang('Agenda.preno_doc_email')) ?></th>
                        <?php
                        $nextDirection = ($sort ?? '') === 'preno_stato' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'preno_stato',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="preno_stato"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Agenda.preno_stato')) ?>
                                <?php if (($sort ?? '') === 'preno_stato'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Agenda.data_opzione')) ?></th>
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
                                <td><?= esc($row->preno_id ?? '') ?></td>
                                <td><?= esc($row->preno_in_data ?? '') ?></td>
                                <td><?= esc($row->preno_importo ?? '') ?></td>
                                <td><?= esc($row->preno_nome ?? '') ?></td>
                                <td><?= esc($row->agenzie_agenzia_tipologia ?? $row->preno_agenzia ?? '') ?></td>
                                <td><?= esc($row->preno_tel ?? '') ?></td>
                                <td><?= esc($row->preno_email ?? '') ?></td>
                                <td><?= esc($row->preno_doc_email ?? '') ?></td>
                                <td><?= esc($row->preno_stato ?? '') ?></td>
                                <td><?= esc($row->data_opzione ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->preno_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('agenda/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('agenda/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('agenda/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('agenda/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
