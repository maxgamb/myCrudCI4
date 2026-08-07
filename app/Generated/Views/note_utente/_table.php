<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('note_utente/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <?php
                        $nextDirection = ($sort ?? '') === 'note_utente_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'note_utente_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="note_utente_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('NoteUtente.note_utente_id')) ?>
                                <?php if (($sort ?? '') === 'note_utente_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('NoteUtente.note_utente_rispondi_id')) ?></th>
                        <?php
                        $nextDirection = ($sort ?? '') === 'Utente_id' && ($direction ?? 'desc') === 'asc' ? 'desc' : 'asc';
                        $sortQuery = array_replace((array) ($query ?? []), [
                            'sort' => 'Utente_id',
                            'direction' => $nextDirection,
                            'page' => 1,
                        ]);
                        ?>
                        <th>
                            <a
                                href="<?= current_url() . '?' . http_build_query($sortQuery) ?>"
                                class="js-list-link text-decoration-none"
                                data-sort="Utente_id"
                                data-direction="<?= esc($nextDirection) ?>"
                            >
                                <?= esc(lang('NoteUtente.Utente_id')) ?>
                                <?php if (($sort ?? '') === 'Utente_id'): ?>
                                    <i class="bi bi-sort-<?= ($direction ?? 'desc') === 'asc' ? 'up' : 'down' ?>"></i>
                                <?php endif; ?>
                            </a>
                        </th>                        <th><?= esc(lang('NoteUtente.hotel_id')) ?></th>
                        <th><?= esc(lang('NoteUtente.reparto')) ?></th>
                        <th><?= esc(lang('NoteUtente.titolo')) ?></th>
                        <th><?= esc(lang('NoteUtente.note_utente_per')) ?></th>
                        <th><?= esc(lang('NoteUtente.note_utente_stato')) ?></th>
                        <th><?= esc(lang('NoteUtente.note_utente_dal')) ?></th>
                        <th><?= esc(lang('NoteUtente.note_utente_data')) ?></th>
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
                                <td><?= esc($row->note_utente_id ?? '') ?></td>
                                <td><?= esc($row->note_utente_rispondi_id ?? '') ?></td>
                                <td><?= esc($row->utenti_Nome_Utente ?? $row->Utente_id ?? '') ?></td>
                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->reparto ?? '') ?></td>
                                <td><?= esc($row->titolo ?? '') ?></td>
                                <td><?= esc($row->note_utente_per ?? '') ?></td>
                                <td><?= esc($row->note_utente_stato ?? '') ?></td>
                                <td><?= esc($row->note_utente_dal ?? '') ?></td>
                                <td><?= esc($row->note_utente_data ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->note_utente_id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('note_utente/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('note_utente/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('note_utente/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('note_utente/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
