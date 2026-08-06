<?= $this->extend('layouts/default') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-magic"></i> Generazione automatica avanzata</h1>
            <p class="text-muted mb-0">Architettura e feature configurabili; campi e validazione derivano dal database.</p>
        </div>
    </div>

    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
    <?php endif; ?>

    <?php if ($config === null): ?>
        <div class="card shadow-sm">
            <div class="card-header"><strong>Seleziona la tabella</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <?php foreach ($tables as $tableName): ?>
                        <div class="col-12 col-md-6 col-xl-4">
                            <a class="btn btn-outline-primary w-100 text-start" href="<?= site_url('mycrud/auto/configure/' . rawurlencode($tableName)) ?>">
                                <i class="bi bi-table me-2"></i><?= esc($tableName) ?>
                            </a>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <?= form_open('mycrud/auto/generate', ['id' => 'autoWizard']) ?>
        <input type="hidden" name="table" value="<?= esc($config['table']) ?>">

        <div class="row g-4">
            <div class="col-12 col-xl-4">
                <div class="card shadow-sm h-100">
                    <div class="card-header"><strong>Configurazione</strong></div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Tabella</label>
                            <input class="form-control" value="<?= esc($config['table']) ?>" readonly>
                        </div>
                        <label class="form-label d-block">Architettura</label>
                        <?php foreach (['basic' => 'Basic', 'standard' => 'Standard', 'full' => 'Full'] as $value => $label): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="architecture" id="arch_<?= esc($value) ?>" value="<?= esc($value) ?>" <?= $value === ($config['architecture'] ?? 'standard') ? 'checked' : '' ?>>
                                <label class="form-check-label" for="arch_<?= esc($value) ?>"><?= esc($label) ?></label>
                            </div>
                        <?php endforeach; ?>

                        <hr>
                        <label class="form-label d-block">Feature</label>
                        <?php foreach (['datatable' => 'DataTable', 'relations' => 'Relazioni', 'timestamps' => 'Timestamp', 'exportButtons' => 'Export', 'softDeletes' => 'Soft delete'] as $name => $label): ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="features[<?= esc($name) ?>]" value="1" id="feature_<?= esc($name) ?>" <?= !empty($config['features'][$name]) ? 'checked' : '' ?> <?= $name === 'softDeletes' && empty($config['softDelete']['available']) ? 'disabled' : '' ?>>
                                <label class="form-check-label" for="feature_<?= esc($name) ?>"><?= esc($label) ?></label>
                            </div>
                        <?php endforeach; ?>

                        <hr>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="codeComments" value="1" id="codeComments" checked>
                            <label class="form-check-label" for="codeComments">Commenti essenziali nel codice</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="force" value="1" id="force">
                            <label class="form-check-label" for="force">Sovrascrivi file esistenti</label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-xl-8">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <strong>Validazione derivata dal database</strong>
                        <span class="badge text-bg-primary"><?= count($validationSummary) ?> campi</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive" style="max-height: 620px;">
                            <table class="table table-sm table-hover mb-0 align-middle">
                                <thead class="table-light sticky-top"><tr><th>Campo</th><th>Tipo DB</th><th>Regole CI4</th></tr></thead>
                                <tbody>
                                <?php foreach ($config['fields'] as $field): ?>
                                    <tr>
                                        <td><code><?= esc($field['name']) ?></code></td>
                                        <td><?= esc($field['columnType'] ?? $field['type']) ?></td>
                                        <td><small><?= esc($validationSummary[$field['name']] ?? '—') ?></small></td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-end gap-2 mt-4">
            <a class="btn btn-secondary" href="<?= site_url('mycrud/auto') ?>">Cambia tabella</a>
            <button class="btn btn-success" type="submit"><i class="bi bi-gear"></i> Genera</button>
        </div>
        <?= form_close() ?>
    <?php endif; ?>
</div>

<?= $this->endSection() ?>
