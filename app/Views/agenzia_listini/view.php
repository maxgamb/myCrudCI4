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
                            <th class="w-25"><?= esc(lang('AgenziaListini.agenzia_listini_id')) ?></th>
                            <td><?= esc($row->agenzia_listini_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaListini.hotel_id')) ?></th>
                            <td><?= esc($row->hotel_id ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaListini.agenzia_listini_nome')) ?></th>
                            <td><?= esc($row->agenzia_listini_nome ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaListini.agenzia_listini_note')) ?></th>
                            <td><?= esc($row->agenzia_listini_note ?? '') ?></td>
                        </tr>                        <tr>
                            <th class="w-25"><?= esc(lang('AgenziaListini.agenzia_listini_datarecord')) ?></th>
                            <td><?= esc($row->agenzia_listini_datarecord ?? '') ?></td>
                        </tr>                    </tbody>
                </table>
            </div>
            <a href="<?= site_url('agenzia_listini') ?>" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Torna alla lista
            </a>
        </div>
    </div>

<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Agenzia Prezzi</strong>
            <span class="badge bg-secondary"><?= (int) ($children['agenzia_prezzi__agenzia_prezzi_id']['count'] ?? 0) ?><?= !empty($children['agenzia_prezzi__agenzia_prezzi_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['agenzia_prezzi__agenzia_prezzi_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Agenzia Prezzi Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Agenzia Listini Id') ?></th>
                                <th><?= esc('Agenzia Listini Dal') ?></th>
                                <th><?= esc('Agenzia Listini Al') ?></th>
                                <th><?= esc('Agenzia Prezzi 1pax') ?></th>
                                <th><?= esc('Agenzia Prezzi 2pax') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->agenzia_prezzi_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->agenzia_listini_id ?? '') ?></td>
                                <td><?= esc($child->agenzia_listini_dal ?? '') ?></td>
                                <td><?= esc($child->agenzia_listini_al ?? '') ?></td>
                                <td><?= esc($child->agenzia_prezzi_1pax ?? '') ?></td>
                                <td><?= esc($child->agenzia_prezzi_2pax ?? '') ?></td>
                                    <td><a href="<?= site_url('agenzia_prezzi/view/' . ($child->agenzia_prezzi_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['agenzia_prezzi__agenzia_prezzi_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
<div class="card shadow-sm mt-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <strong><i class="bi bi-diagram-3"></i> Ref Agenzia Listini</strong>
            <span class="badge bg-secondary"><?= (int) ($children['ref_agenzia_listini__agenzia_listini_id']['count'] ?? 0) ?><?= !empty($children['ref_agenzia_listini__agenzia_listini_id']['hasMore']) ? '+' : '' ?></span>
        </div>
        <div class="card-body">
            <?php $relatedRows = $children['ref_agenzia_listini__agenzia_listini_id']['rows'] ?? []; ?>
            <?php if (empty($relatedRows)): ?>
                <div class="alert alert-light border mb-0">Nessun record collegato.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-sm table-striped table-hover align-middle">
                        <thead><tr>
                                <th><?= esc('Ref Agenzia Listini Id') ?></th>
                                <th><?= esc('Agenzia Id') ?></th>
                                <th><?= esc('Hotel Id') ?></th>
                                <th><?= esc('Agenzia Limite Vendita') ?></th>
                                <th><?= esc('Agenzia Ab Limite Vendita') ?></th>
                                <th><?= esc('Agenzia Max Vendita') ?></th>
                            <th>Azioni</th>
                        </tr></thead>
                        <tbody>
                            <?php foreach ($relatedRows as $child): ?>
                                <tr>
                                <td><?= esc($child->ref_agenzia_listini_id ?? '') ?></td>
                                <td><?= esc($child->agenzia_id ?? '') ?></td>
                                <td><?= esc($child->hotel_id ?? '') ?></td>
                                <td><?= esc($child->agenzia_limite_vendita ?? '') ?></td>
                                <td><?= esc($child->agenzia_ab_limite_vendita ?? '') ?></td>
                                <td><?= esc($child->agenzia_max_vendita ?? '') ?></td>
                                    <td><a href="<?= site_url('ref_agenzia_listini/view/' . ($child->ref_agenzia_listini_id ?? '')) ?>" class="btn btn-sm btn-outline-info"><i class="bi bi-eye"></i></a></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php if (!empty($children['ref_agenzia_listini__agenzia_listini_id']['hasMore'])): ?>
                    <div class="small text-muted">Visualizzati i primi 20 record.</div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
