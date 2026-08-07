<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('emails/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Emails.id')) ?>
                                <?php if (($sort ?? '') === 'id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <?php
                        $nextDirection = ($sort ?? '') === 'direction' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'direction',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="direction"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('Emails.direction')) ?>
                                <?php if (($sort ?? '') === 'direction'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('Emails.uid')) ?></th>
                        <th><?= esc(lang('Emails.message_id')) ?></th>
                        <th><?= esc(lang('Emails.in_reply_to')) ?></th>
                        <th><?= esc(lang('Emails.email_from')) ?></th>
                        <th><?= esc(lang('Emails.thread_id')) ?></th>
                        <th><?= esc(lang('Emails.thread_status')) ?></th>
                        <th><?= esc(lang('Emails.category')) ?></th>
                        <th><?= esc(lang('Emails.language')) ?></th>
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
                                <td><?= esc($row->id ?? '') ?></td>
                                <td><?= esc($row->direction ?? '') ?></td>
                                <td><?= esc($row->uid ?? '') ?></td>
                                <td><?= esc($row->message_id ?? '') ?></td>
                                <td><?= esc($row->in_reply_to ?? '') ?></td>
                                <td><?= esc($row->email_from ?? '') ?></td>
                                <td><?= esc($row->thread_id ?? '') ?></td>
                                <td><?= esc($row->thread_status ?? '') ?></td>
                                <td><?= esc($row->category ?? '') ?></td>
                                <td><?= esc($row->language ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('emails/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('emails/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('emails/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('emails/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
