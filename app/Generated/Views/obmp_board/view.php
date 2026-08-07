<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header">
            <h1 class="h4 mb-0"><i class="bi bi-eye"></i> Dettaglio record</h1>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-sm table-bordered table-striped align-middle">
                    <tbody>
                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpBoard.obmp_board_id')) ?></th>
                            <td><?= esc($row->obmp_board_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpBoard.obmp_board_title')) ?></th>
                            <td><?= esc($row->obmp_board_title ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpBoard.obmp_board')) ?></th>
                            <td><?= esc($row->obmp_board ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpBoard.obmp_board_cod')) ?></th>
                            <td><?= esc($row->obmp_board_cod ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('ObmpBoard.board_lg')) ?></th>
                            <td><?= esc($row->board_lg ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('obmp_board') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Obmp Rates</strong>
            <span class="badge bg-secondary"><?= (int) ($children['obmp_rates__obmp_board_cod']['count'] ?? 0) ?><?= !empty($children['obmp_rates__obmp_board_cod']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['obmp_rates__obmp_board_cod']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Obmp Rate Id') ?></th>
                                <th><?= esc('Obmp Cm Rooms Id') ?></th>
                                <th><?= esc('Obmp Restriction Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Obmp Cancellation Cod') ?></th>
                                <th><?= esc('Obmp Payment Cod') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->obmp_rate_id ?? '') ?></td>
                                <td><?= esc($child->obmp_cm_rooms_id ?? '') ?></td>
                                <td><?= esc($child->obmp_restriction_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->obmp_cancellation_cod ?? '') ?></td>
                                <td><?= esc($child->obmp_payment_cod ?? '') ?></td>
                                    <td><a href="<?= site_url('obmp_rates/view/' . ($child->obmp_rate_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['obmp_rates__obmp_board_cod']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
