<?php /* Frammento sostituito via AJAX: doppio Pager e tabella Bootstrap compatta. */ ?>
<div class="card shadow-sm">
    <div class="card-body">
        <?= view('parsed_emails/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>

        <div class="table-responsive">
            <table class="table table-sm table-striped table-hover align-middle text-nowrap mb-0 crud-table">
                <thead class="table-light">
                    <tr>
                        <th><?= esc(lang('ParsedEmails.id')) ?></th>
                        <th><?= esc(lang('ParsedEmails.hotel_id')) ?></th>
                        <th><?= esc(lang('ParsedEmails.category')) ?></th>
                        <th><?= esc(lang('ParsedEmails.referente_tipo')) ?></th>
                        <th><?= esc(lang('ParsedEmails.prenotazione_tipo')) ?></th>
                        <th><?= esc(lang('ParsedEmails.finalita')) ?></th>
                        <th><?= esc(lang('ParsedEmails.segmento_commerciale')) ?></th>
                        <th class="text-end">Azioni</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($rows)): ?>
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Nessun record trovato.
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($rows as $row): ?>
                            <tr>
                                <td><?= esc($row->id ?? '') ?></td>
                                <td><?= esc($row->hotel_id ?? '') ?></td>
                                <td><?= esc($row->category ?? '') ?></td>
                                <td><?= esc($row->referente_tipo ?? '') ?></td>
                                <td><?= esc($row->prenotazione_tipo ?? '') ?></td>
                                <td><?= esc($row->finalita ?? '') ?></td>
                                <td><?= esc($row->segmento_commerciale ?? '') ?></td>
                                <td class="text-end text-nowrap">
                                    <?php $id = $row->id ?? ''; ?>
                                    <div class="btn-group btn-group-sm" role="group" aria-label="Azioni record">
                                        <a href="<?= site_url('parsed_emails/view/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-info" title="Visualizza">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="<?= site_url('parsed_emails/edit/' . rawurlencode((string) $id)) ?>" class="btn btn-outline-warning" title="Modifica">
                                            <i class="bi bi-pencil-square"></i>
                                        </a>
                                        <form method="post" action="<?= site_url('parsed_emails/delete/' . rawurlencode((string) $id)) ?>" class="d-inline" onsubmit="return confirm('Eliminare questo record?')">
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

        <?= view('parsed_emails/_pager', [
            'pagerLinks' => $pagerLinks ?? '',
            'total' => $total ?? 0,
            'page' => $page ?? 1,
        ]) ?>
    </div>
</div>
