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
                            <th class="w-25"><?= esc(lang('Adebiti.adebito_id')) ?></th>
                            <td><?= esc($row->adebito_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Adebiti.conto_id')) ?></th>
                            <td><?= esc($row->conto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Adebiti.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Adebiti.prodotto_id')) ?></th>
                            <td><a href="<?= site_url('prodotti/view/' . rawurlencode((string) ($row->prodotto_id ?? ''))) ?>" class="text-decoration-none"><?= esc($row->prodotti__prodotto_id__label ?? $row->prodotto_id ?? '') ?></a></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Adebiti.descrizione')) ?></th>
                            <td><?= esc($row->descrizione ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Adebiti.prezzo')) ?></th>
                            <td><?= esc($row->prezzo ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Adebiti.quantita')) ?></th>
                            <td><?= esc($row->quantita ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Adebiti.adebiti_utente_id')) ?></th>
                            <td><?= esc($row->adebiti_utente_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Adebiti.preno_id')) ?></th>
                            <td><?= esc($row->preno_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('adebiti') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Conti Trasferisci</strong>
            <span class="badge bg-secondary"><?= (int) ($children['conti_trasferisci__adebito_id']['count'] ?? 0) ?><?= !empty($children['conti_trasferisci__adebito_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['conti_trasferisci__adebito_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Conti Trasferisci Id') ?></th>
                                <th><?= esc('Conto Id Ex') ?></th>
                                <th><?= esc('Conto Id New') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Conti Tra Data') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->conti_trasferisci_id ?? '') ?></td>
                                <td><?= esc($child->conto_id_ex ?? '') ?></td>
                                <td><?= esc($child->conto_id_new ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->conti_tra_data ?? '') ?></td>
                                    <td><a href="<?= site_url('conti_trasferisci/view/' . ($child->conti_trasferisci_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['conti_trasferisci__adebito_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
