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
                            <th class="w-25"><?= esc(lang('Prodotti.prodotto_id')) ?></th>
                            <td><?= esc($row->prodotto_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prodotti.prodotti_lista_id')) ?></th>
                            <td><?= esc($row->prodotti_lista_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prodotti.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prodotti.nome_prodotto')) ?></th>
                            <td><?= esc($row->nome_prodotto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prodotti.prezzo_prodotto')) ?></th>
                            <td><?= esc($row->prezzo_prodotto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prodotti.tipologia_prodotto')) ?></th>
                            <td><?= esc($row->tipologia_prodotto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prodotti.reparto_prodotto')) ?></th>
                            <td><?= esc($row->reparto_prodotto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prodotti.cent_costo_prodotto')) ?></th>
                            <td><?= esc($row->cent_costo_prodotto ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('Prodotti.prodotti_utente_id')) ?></th>
                            <td><?= esc($row->prodotti_utente_id ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('prodotti') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Adebiti</strong>
            <span class="badge bg-secondary"><?= (int) ($children['adebiti__prodotto_id']['count'] ?? 0) ?><?= !empty($children['adebiti__prodotto_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['adebiti__prodotto_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Adebito Id') ?></th>
                                <th><?= esc('Conto Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Descrizione') ?></th>
                                <th><?= esc('Prezzo') ?></th>
                                <th><?= esc('Quantita') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->adebito_id ?? '') ?></td>
                                <td><?= esc($child->conto_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->descrizione ?? '') ?></td>
                                <td><?= esc($child->prezzo ?? '') ?></td>
                                <td><?= esc($child->quantita ?? '') ?></td>
                                    <td><a href="<?= site_url('adebiti/view/' . ($child->adebito_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['adebiti__prodotto_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Prodotti Lista</strong>
            <span class="badge bg-secondary"><?= (int) ($children['prodotti_lista__prodotti_lista_id']['count'] ?? 0) ?><?= !empty($children['prodotti_lista__prodotti_lista_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['prodotti_lista__prodotti_lista_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Prodotti Lista Id') ?></th>
                                <th><?= esc('Prod Lista Mone') ?></th>
                                <th><?= esc('Prod Lista Descrixione') ?></th>
                                <th><?= esc('Prod Lista Allergenici') ?></th>
                                <th><?= esc('Prod Lista Costo Unitario') ?></th>
                                <th><?= esc('Prod Lista Img') ?></th>
                                <th><?= esc('Prod Lista Data') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->prodotti_lista_id ?? '') ?></td>
                                <td><?= esc($child->prod_lista_mone ?? '') ?></td>
                                <td><?= esc($child->prod_lista_descrixione ?? '') ?></td>
                                <td><?= esc($child->prod_lista_allergenici ?? '') ?></td>
                                <td><?= esc($child->prod_lista_costo_unitario ?? '') ?></td>
                                <td><?= esc($child->prod_lista_img ?? '') ?></td>
                                <td><?= esc($child->prod_lista_data ?? '') ?></td>
                                    <td><a href="<?= site_url('prodotti_lista/view/' . ($child->prodotti_lista_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['prodotti_lista__prodotti_lista_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
