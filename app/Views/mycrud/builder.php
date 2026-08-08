<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>


<?php
/*
 * Tabelle padre: relazioni belongsTo della tabella corrente.
 */
$parentTables = [];

foreach (
        $config['relations']['belongsTo'] ?? []
as $relation
) {
    $parentTable = trim(
            (string) ($relation['parentTable'] ?? '')
    );

    if ($parentTable !== '') {
        $parentTables[$parentTable] = $parentTable;
    }
}

/*
 * Tabelle figlie: relazioni hasMany della tabella corrente.
 */
$childTables = [];

foreach (
        $config['relations']['hasMany'] ?? []
as $relation
) {
    $childTable = trim(
            (string) ($relation['childTable'] ?? '')
    );

    if ($childTable !== '') {
        $childTables[$childTable] = $childTable;
    }
}

ksort($parentTables);
ksort($childTables);
?>

<div class="container-fluid px-3 px-lg-4">
    <div class="row g-4 align-items-start">
        <aside class="col-12 col-lg-2">
            <div class="card shadow-sm position-sticky" style="top: 1rem; max-height: calc(100vh - 2rem); overflow-y: auto;">
                <div class="card-header fw-semibold">
                    <i class="bi bi-diagram-2"></i>
                    Tabelle padre DB
                </div>

                <div class="list-group list-group-flush">
                    <?php if (($databaseParentTables ?? []) === []): ?>
                        <div class="list-group-item small text-muted">
                            Nessuna tabella padre
                        </div>
                    <?php else: ?>
                        <?php foreach (($databaseParentTables ?? []) as $databaseParentTable): ?>
                            <a
                                class="list-group-item list-group-item-action <?= $databaseParentTable === $table ? 'active' : '' ?>"
                                href="<?= site_url('mycrud/builder/configure/' . rawurlencode((string) $databaseParentTable)) ?>"
                            >
                                <?= esc($databaseParentTable) ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </aside>

        <main class="col-12 col-lg-10">
<div class="card shadow-sm mb-4 relation-navigation">
    <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
        <strong>
            <i class="bi bi-share"></i>
            Navigazione relazioni
        </strong>

        <span class="badge bg-primary">
            <?= count($parentTables) ?>
            padri
            ·
            <?= count($childTables) ?>
            figli
        </span>
    </div>

    <div class="card-body">
        <div class="row g-3 align-items-stretch">

            <!-- TABELLE PADRE -->
            <div class="col-12 col-lg-4">
                <div class="relation-group h-100">

                    <div class="small text-uppercase text-muted fw-semibold mb-2">
                        <i class="bi bi-arrow-left"></i>
                        Tabelle padre
                    </div>

                    <div class="d-flex flex-wrap gap-2">

                        <?php if ($parentTables === []): ?>

                            <span class="text-muted small">
                                Nessuna tabella padre
                            </span>

                        <?php else: ?>

                            <?php
                            foreach (
                                    $config['relations']['belongsTo'] ?? []
                            as $foreignKey => $relation
                            ):
                                ?>
                                <?php
                                $parentTable = (string) (
                                        $relation['parentTable'] ?? ''
                                );
                                ?>

                                <a
                                    href="<?=
                                    site_url(
                                            'mycrud/builder/configure/'
                                            . rawurlencode($parentTable)
                                    )
                                    ?>"
                                    class="btn btn-sm btn-outline-info"
                                    >
                                    <i class="bi bi-box-arrow-up-left"></i>

                                        <?= esc($parentTable) ?>

                                    <span class="badge text-bg-light ms-1">
                                <?= esc($foreignKey) ?>
                                    </span>
                                </a>
    <?php endforeach; ?>

<?php endif; ?>
                    </div>
                </div>
            </div>

            <!-- TABELLA CORRENTE -->
            <div class="col-12 col-lg-4">
                <div class="relation-current h-100 text-center">

                    <div class="small text-uppercase text-muted fw-semibold mb-2">
                        Tabella corrente
                    </div>

                    <div class="fs-5 fw-bold">
                        <i class="bi bi-table"></i>
                        <?= esc($table) ?>
                    </div>

                    <div class="small text-muted mt-1">
<?= esc($config['primaryKey'] ?? 'id') ?>
                    </div>
                </div>
            </div>

            <!-- TABELLE FIGLIE -->
            <div class="col-12 col-lg-4">
                <div class="relation-group h-100">

                    <div class="small text-uppercase text-muted fw-semibold mb-2">
                        Tabelle figlie
                        <i class="bi bi-arrow-right"></i>
                    </div>
                    <div class="d-flex flex-wrap gap-2">
                        <?php if ($childTables === []): ?>
                            <span class="text-muted small">
                                Nessuna tabella figlia
                            </span>
                        <?php else: ?>

                            <?php
                            foreach (
                                    $config['relations']['hasMany'] ?? []
                            as $relation
                            ):
                                ?>
                                <?php
                                $childTable = (string) (
                                        $relation['childTable'] ?? ''
                                );

                                $foreignKey = (string) (
                                        $relation['foreignKey'] ?? ''
                                );
                                ?>

                                <a
                                    href="<?=
                                site_url(
                                        'mycrud/builder/configure/'
                                        . rawurlencode($childTable)
                                )
                                ?>"
                                    class="btn btn-sm btn-outline-success"
                                    >
        <?= esc($childTable) ?>

                                    <span class="badge text-bg-light ms-1">
                                <?= esc($foreignKey) ?>
                                    </span>

                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
    <?php endforeach; ?>

<?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--CORPO-->


<div class="container py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-sliders"></i>
                Configura tabella: <?= esc($table) ?>
            </h1>
            <small class="text-muted">
                Trascina i campi per modificarne l'ordine.
            </small>
        </div>

        <div class="btn-group">
            <button type="button" class="btn btn-outline-secondary" id="expandAll">
                <i class="bi bi-arrows-expand"></i> Espandi
            </button>
            <button type="button" class="btn btn-outline-secondary" id="collapseAll">
                <i class="bi bi-arrows-collapse"></i> Comprimi
            </button>
            <button type="button" class="btn btn-primary" id="showPreview">
                <i class="bi bi-eye"></i> Anteprima
            </button>
        </div>
    </div>

    <?php if (session('message')): ?>
        <div class="alert alert-success"><?= esc(session('message')) ?></div>
<?php endif; ?>

        <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc(session('error')) ?></div>
<?php endif; ?>

    <form method="post" id="builderForm">
<?= csrf_field() ?>
        <input type="hidden" name="table" value="<?= esc($table) ?>">

        <div class="card shadow-sm mb-4">
            <div class="card-header">
                <strong>Architettura</strong>
            </div>

            <div class="card-body">
                <?php $selectedArchitecture = (string) ($config['architecture'] ?? 'basic'); ?>
                <div class="row g-3">
                    <?php foreach ([
                        'basic' => [
                            'title' => 'Basic',
                            'icon' => 'bi-box',
                            'description' => 'CRUD, validazione, Bootstrap AJAX, Pager CI4, filtri indicizzati, CSV e Word HTML.',
                        ],
                        'standard' => [
                            'title' => 'Standard',
                            'icon' => 'bi-layers',
                            'description' => 'Tutto Basic, con Entity e Service.',
                        ],
                        'full' => [
                            'title' => 'Full',
                            'icon' => 'bi-rocket-takeoff',
                            'description' => 'Tutto Standard, con API REST v1, Resource, validazione API e OpenAPI.',
                        ],
                    ] as $value => $architecture): ?>
                        <div class="col-12 col-lg-4">
                            <label class="card h-100 border architecture-card <?= $selectedArchitecture === $value ? 'border-primary' : '' ?>">
                                <div class="card-body">
                                    <div class="form-check">
                                        <input
                                            class="form-check-input architecture-radio"
                                            type="radio"
                                            name="architecture"
                                            id="architecture_<?= esc($value) ?>"
                                            value="<?= esc($value) ?>"
                                            <?= $selectedArchitecture === $value ? 'checked' : '' ?>
                                        >
                                        <span class="form-check-label fw-bold">
                                            <i class="bi <?= esc($architecture['icon']) ?>"></i>
                                            <?= esc($architecture['title']) ?>
                                        </span>
                                    </div>
                                    <p class="small text-muted mt-2 mb-0">
                                        <?= esc($architecture['description']) ?>
                                    </p>
                                </div>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>

                <hr>

                <div class="row g-3">
                    <?php
                    $featureLabels = [
                        'relations' => 'Relazioni FK',
                        'timestamps' => 'Timestamp',
                        'softDeletes' => 'Soft delete',
                    ];
                    ?>

                    <?php foreach ($featureLabels as $feature => $label): ?>
                        <div class="col-md-3 col-sm-6">
                            <div class="form-check form-switch">
                                <input
                                    class="form-check-input feature-check"
                                    type="checkbox"
                                    name="features[<?= esc($feature) ?>]"
                                    value="1"
                                    id="feature_<?= esc($feature) ?>"
                                    <?= !empty($config['features'][$feature]) ? 'checked' : '' ?>
                                    <?= $feature === 'softDeletes' && empty($config['softDelete']['available']) ? 'disabled' : '' ?>
                                >
                                <label class="form-check-label" for="feature_<?= esc($feature) ?>">
                                    <?= esc($label) ?>
                                </label>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="alert alert-info mt-3">
                    <i class="bi bi-info-circle"></i>
                    Il motore elenco è comune: Bootstrap AJAX, Pager CI4, filtri server-side indicizzati,
                    CSV e Word HTML. Le differenze riguardano i livelli Entity, Service e API.
                </div>

                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <label for="filtersSummary" class="form-label">Titolo sezione filtri</label>
                        <input
                            type="text"
                            class="form-control"
                            id="filtersSummary"
                            name="list[filtersSummary]"
                            value="<?= esc($config['list']['filtersSummary'] ?? 'Filtri di ricerca') ?>"
                            maxlength="120"
                        >
                    </div>
                </div>
            </div>
        </div>


<?php if (!empty($config['relationsConfig']['hasMany'])): ?>

            <div class="card shadow-sm mb-4">
                <div class="card-header">
                    <strong>
                        <i class="bi bi-diagram-3"></i>
                        Related Panels (hasMany readonly)
                    </strong>
                </div>

                <div class="card-body">

                    <div class="row g-3">

    <?php
    foreach (
            $config['relationsConfig']['hasMany']
    as $relationKey => $relation
    ):
        ?>

                            <div class="col-12 col-lg-6 col-xxl-4">

                                <div class="card h-100 border shadow-sm">

                                    <div class="card-header d-flex justify-content-between align-items-center">

                                        <div>
                                            <strong>
        <?= esc($relation['title']) ?>
                                            </strong>

                                            <div class="small text-muted">
        <?= esc($relation['childTable']) ?>.
        <?= esc($relation['foreignKey']) ?>
                                            </div>
                                        </div>

                                        <div class="form-check form-switch mb-0">

                                            <input
                                                class="form-check-input"
                                                type="checkbox"
                                                name="relationsConfig[hasMany][<?= esc($relationKey) ?>][enabled]"
                                                value="1"
                                                id="relation_enabled_<?= esc(md5($relationKey)) ?>"
        <?=
        !empty($relation['enabled']) ? 'checked' : ''
        ?>
                                                >

                                            <label
                                                class="form-check-label"
                                                for="relation_enabled_<?= esc(md5($relationKey)) ?>"
                                                >
                                                Attivo
                                            </label>
                                        </div>
                                    </div>

                                    <div class="card-body">

                                        <div class="row g-3">

                                            <div class="col-12">

                                                <label class="form-label">
                                                    Titolo
                                                </label>

                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    name="relationsConfig[hasMany][<?= esc($relationKey) ?>][title]"
                                                    value="<?= esc($relation['title']) ?>"
                                                    >
                                            </div>

                                            <div class="col-md-8">

                                                <label class="form-label">
                                                    Icona
                                                </label>

                                                <div class="input-group">

                                                    <span class="input-group-text">
                                                        <i class="bi <?=
        esc(
                $relation['icon'] ?? 'bi-diagram-3'
        )
        ?>"></i>
                                                    </span>

                                                    <input
                                                        type="text"
                                                        class="form-control relation-icon-input"
                                                        name="relationsConfig[hasMany][<?= esc($relationKey) ?>][icon]"
                                                        value="<?=
        esc(
                $relation['icon'] ?? 'bi-diagram-3'
        )
        ?>"
                                                        >
                                                </div>
                                            </div>

                                            <div class="col-md-4">

                                                <label class="form-label">
                                                    Limite
                                                </label>

                                                <input
                                                    type="number"
                                                    min="1"
                                                    max="200"
                                                    class="form-control"
                                                    name="relationsConfig[hasMany][<?= esc($relationKey) ?>][limit]"
                                                    value="<?=
        (int) (
        $relation['limit'] ?? 20
        )
        ?>"
                                                    >
                                            </div>

                                            <div class="col-12">

                                                <div class="form-check">

                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="relationsConfig[hasMany][<?= esc($relationKey) ?>][showCount]"
                                                        value="1"
                                                        id="relation_count_<?= esc(md5($relationKey)) ?>"
        <?=
        !empty($relation['showCount']) ? 'checked' : ''
        ?>
                                                        >

                                                    <label
                                                        class="form-check-label"
                                                        for="relation_count_<?= esc(md5($relationKey)) ?>"
                                                        >
                                                        Mostra conteggio
                                                    </label>
                                                </div>

                                                <div class="form-check">

                                                    <input
                                                        class="form-check-input"
                                                        type="checkbox"
                                                        name="relationsConfig[hasMany][<?= esc($relationKey) ?>][showViewButton]"
                                                        value="1"
                                                        id="relation_view_<?= esc(md5($relationKey)) ?>"
        <?=
        !empty($relation['showViewButton']) ? 'checked' : ''
        ?>
                                                        >

                                                    <label
                                                        class="form-check-label"
                                                        for="relation_view_<?= esc(md5($relationKey)) ?>"
                                                        >
                                                        Pulsante dettaglio
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="col-12">

                                                <label class="form-label d-block">
                                                    Colonne
                                                </label>

                                                <div class="border rounded p-2 related-columns">

        <?php
        foreach (
                $relation['columns'] ?? []
        as $column
        ):
            ?>

                                                        <div class="form-check">

                                                            <input
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                name="relationsConfig[hasMany][<?= esc($relationKey) ?>][columns][]"
                                                                value="<?= esc($column) ?>"
                                                                id="relation_column_<?=
                                                                esc(
                                                                        md5(
                                                                                $relationKey
                                                                                . '_'
                                                                                . $column
                                                                        )
                                                                )
                                                                ?>"
                                                                checked
                                                                >

                                                            <label
                                                                class="form-check-label"
                                                                for="relation_column_<?=
                                                                esc(
                                                                        md5(
                                                                                $relationKey
                                                                                . '_'
                                                                                . $column
                                                                        )
                                                                )
                                                                ?>"
                                                                >
            <?= esc($column) ?>
                                                            </label>
                                                        </div>

        <?php endforeach; ?>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                <?php endforeach; ?>

                    </div>
                </div>
            </div>

<?php endif; ?>

        <?php $tableStats = (array) ($config['tableStats'] ?? []); ?>
        <div class="alert alert-light border d-flex flex-wrap gap-3 align-items-center">
            <strong>Schema:</strong>
            <span>Righe stimate: <?= number_format((int) ($tableStats['rowEstimate'] ?? 0), 0, ',', '.') ?></span>
            <span>Campi: <?= count($config['fields'] ?? []) ?></span>
            <span class="text-muted">Gli indici sono mostrati su ogni campo; mycrud:doctor fornisce l'analisi completa.</span>
        </div>

        <div id="sortableFields">
<?php foreach ($config['order'] as $fieldName): ?>
    <?php
    $field = $config['fields'][$fieldName];
    $fk = $field['foreignKey'];
    $allowedTypes = [
        'text', 'number', 'email', 'password', 'date',
        'datetime-local', 'time', 'textarea', 'select',
        'checkbox', 'radio', 'url', 'tel', 'file',
        'hidden', 'range', 'color', 'search'
    ];
    ?>
                <div class="card shadow-sm mb-3 field-block"
                     data-field="<?= esc($fieldName) ?>">

                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center gap-2">
                            <span class="drag-handle fs-4" title="Trascina">☰</span>
                            <strong><?= esc($fieldName) ?></strong>

    <?php if ($field['primary']): ?>
                                <span class="badge bg-secondary">PK</span>
    <?php endif; ?>

    <?php if ($fk): ?>
                                <span class="badge bg-warning text-dark">
                                    FK → <?= esc($fk['parentTable']) ?>
                                </span>
                                <?php if ((int) ($field['relationRowEstimate'] ?? 0) > 0): ?>
                                    <span class="badge text-bg-light">
                                        ~<?= number_format((int) $field['relationRowEstimate'], 0, ',', '.') ?> righe
                                    </span>
                                <?php endif; ?>
    <?php endif; ?>

    <?php $indexInfo = (array) ($field['index'] ?? []); ?>
    <?php if (!empty($indexInfo['primary'])): ?>
                                <span class="badge text-bg-dark">PRIMARY</span>
    <?php elseif (!empty($indexInfo['unique'])): ?>
                                <span class="badge text-bg-success">UNIQUE</span>
    <?php elseif (!empty($indexInfo['leading'])): ?>
                                <span class="badge text-bg-primary">INDEX</span>
    <?php elseif (!empty($indexInfo['indexed'])): ?>
                                <span class="badge text-bg-secondary">INDEX non-leading</span>
    <?php else: ?>
                                <span class="badge text-bg-light">No index</span>
    <?php endif; ?>
                        </div>

                        <button type="button"
                                class="btn btn-sm btn-outline-secondary toggle-field">
                            <i class="bi bi-chevron-up"></i>
                        </button>
                    </div>

                    <div class="card-body field-body">
                        <div class="row g-3">
                            <div class="col-lg-4">
                                <label class="form-label">Tipo input</label>
                                <select
                                    name="inputType[<?= esc($fieldName) ?>]"
                                    class="form-select input-type"
                                    >
                                    <?php
                                    $icons = [
                                        'text' => '📝', 'number' => '🔢', 'email' => '✉️',
                                        'password' => '🔐', 'date' => '📅', 'datetime-local' => '⏰',
                                        'time' => '🕒', 'textarea' => '✍️', 'select' => '📂',
                                        'checkbox' => '☑️', 'radio' => '🔘', 'url' => '🌐',
                                        'tel' => '📞', 'file' => '📁', 'hidden' => '🙈',
                                        'range' => '🎚️', 'color' => '🎨', 'search' => '🔍',
                                    ];
                                    ?>
    <?php foreach ($allowedTypes as $type): ?>
                                        <option
                                            value="<?= esc($type) ?>"
        <?= $field['inputType'] === $type ? 'selected' : '' ?>
                                            >
        <?= esc(($icons[$type] ?? '') . ' ' . $type) ?>
                                        </option>
    <?php endforeach; ?>
                                </select>
                            </div>

                            <?php if ($fk): ?>
                                <div class="col-lg-4">
                                    <label class="form-label">Caricamento relazione</label>
                                    <select name="relationMode[<?= esc($fieldName) ?>]" class="form-select">
                                        <option value="select" <?= ($field['relationMode'] ?? 'select') === 'select' ? 'selected' : '' ?>>Select completa</option>
                                        <option value="ajax" <?= ($field['relationMode'] ?? '') === 'ajax' ? 'selected' : '' ?>>Select AJAX</option>
                                    </select>
                                    <div class="form-text">
                                        <?php if (($field['relationMode'] ?? '') === 'ajax'): ?>
                                            Suggerita AJAX per la dimensione della tabella collegata.
                                        <?php else: ?>
                                            AJAX evita di caricare tutte le opzioni quando la tabella collegata è grande.
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php if ($fk): ?>
                                <?php
                                $displayFields = array_values((array) ($fk['availableDisplayFields'] ?? []));
                                $selectedDisplayField = (string) ($field['relationDisplayField'] ?? $fk['displayField'] ?? $fk['parentKey'] ?? '');
                                $navigation = (array) ($field['relationNavigation'] ?? []);
                                ?>

                                <div class="col-lg-4">
                                    <label class="form-label">Valore descrittivo</label>
                                    <select
                                        name="relationDisplayField[<?= esc($fieldName) ?>]"
                                        class="form-select"
                                    >
                                        <?php foreach ($displayFields as $displayField): ?>
                                            <option
                                                value="<?= esc($displayField) ?>"
                                                <?= $selectedDisplayField === $displayField ? 'selected' : '' ?>
                                            >
                                                <?= esc($displayField) ?>
                                            </option>
                                        <?php endforeach; ?>
                                    </select>
                                    <div class="form-text">
                                        È il testo mostrato al posto della chiave FK, per esempio 5 → “Hotel Ateneo”.
                                    </div>
                                </div>

                                <div class="col-lg-8">
                                    <label class="form-label">Template descrittivo <span class="text-muted">(opzionale)</span></label>
                                    <input
                                        type="text"
                                        name="relationDisplayTemplate[<?= esc($fieldName) ?>]"
                                        value="<?= esc($field['relationDisplayTemplate'] ?? '') ?>"
                                        class="form-control"
                                        placeholder="Esempio: {cognome} {nome}"
                                    >
                                    <div class="form-text">
                                        Se compilato, prevale sul campo singolo. Campi disponibili:
                                        <?= esc(implode(', ', $displayFields)) ?>.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label d-block">Navigazione relazione</label>
                                    <input type="hidden" name="relationNavigation[<?= esc($fieldName) ?>][]" value="">

                                    <?php
                                    $navigationFlags = [
                                        'quickFilter' => 'Filtro rapido nella tabella',
                                        'parentLink' => 'Link al record padre',
                                        'acceptContext' => 'Accetta la FK dalla URL nel Create',
                                        'createParentLink' => 'Link “Nuovo padre” nel form',
                                    ];
                                    ?>

                                    <?php foreach ($navigationFlags as $navFlag => $navLabel): ?>
                                        <div class="form-check form-check-inline">
                                            <input
                                                type="checkbox"
                                                class="form-check-input"
                                                name="relationNavigation[<?= esc($fieldName) ?>][]"
                                                value="<?= esc($navFlag) ?>"
                                                id="<?= esc($fieldName . '_nav_' . $navFlag) ?>"
                                                <?= !empty($navigation[$navFlag]) ? 'checked' : '' ?>
                                            >
                                            <label
                                                class="form-check-label"
                                                for="<?= esc($fieldName . '_nav_' . $navFlag) ?>"
                                            >
                                                <?= esc($navLabel) ?>
                                            </label>
                                        </div>
                                    <?php endforeach; ?>

                                    <div class="form-text">
                                        La FK ricevuta via URL viene validata sulla tabella padre prima di precompilare hidden, select, select AJAX o input normale.
                                    </div>
                                </div>
                            <?php endif; ?>

                            <div class="col-lg-4">
                                <label class="form-label">Label</label>
                                <input
                                    type="text"
                                    name="label[<?= esc($fieldName) ?>]"
                                    value="<?= esc($field['label'] ?? '') ?>"
                                    placeholder="<?= esc($field['defaultLabel'] ?? $fieldName) ?>"
                                    class="form-control field-label"
                                    >
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label">Larghezza Bootstrap</label>
                                <select
                                    name="width[<?= esc($fieldName) ?>]"
                                    class="form-select width-select"
                                    >
    <?php for ($width = 12; $width >= 1; $width--): ?>
                                        <option
                                            value="<?= $width ?>"
        <?= (int) $field['width'] === $width ? 'selected' : '' ?>
                                            >
                                            col-md-<?= $width ?>
                                        </option>
                                        <?php endfor; ?>
                                </select>
                            </div>

                            <div class="col-lg-4">
                                <label class="form-label d-block">Attributi booleani</label>

                                        <?php foreach (['required' => '⭐', 'readonly' => '🔒', 'disabled' => '🚫'] as $attribute => $icon): ?>
                                    <div class="form-check form-check-inline">
                                        <input
                                            type="checkbox"
                                            class="form-check-input attribute-boolean"
                                            name="attrBool[<?= esc($fieldName) ?>][]"
                                            value="<?= esc($attribute) ?>"
                                            id="<?= esc($fieldName . '_' . $attribute) ?>"
                                                <?php
                                                $checked = in_array($attribute, $field['attributes']['boolean'] ?? [], true);
                                                if ($attribute === 'required' && (($field['nullable'] ?? true) === false) && empty($field['autoIncrement']) && !in_array('disabled', $field['attributes']['boolean'] ?? [], true)
                                                ) {
                                                    $checked = true;
                                                }
                                                ?>
        <?= $checked ? 'checked' : '' ?>
                                            >
                                        <label
                                            class="form-check-label"
                                            for="<?= esc($fieldName . '_' . $attribute) ?>"
                                            >
        <?= $icon ?> <?= esc($attribute) ?>
                                        </label>
                                    </div>
    <?php endforeach; ?>
                            </div>

                            <div class="col-12">
                                <label class="form-label d-block">Comportamento CRUD e API</label>
                                <input type="hidden" name="ui[<?= esc($fieldName) ?>][]" value="">
                                <?php
                                $uiFlags = [
                                    'searchable' => '🔍 Ricercabile',
                                    'sortable' => '↕️ Ordinabile',
                                    'visibleIndex' => '📋 Visibile elenco',
                                    'visibleForm' => '🧾 Visibile form',
                                    'visibleView' => '👁️ Visibile dettaglio',
                                    'sensitive' => '🔐 Sensibile',
                                    'exportable' => '📄 Esportabile CSV/Word',
                                    'apiVisible' => '🔌 Visibile API',
                                ];
                                ?>
                                <?php foreach ($uiFlags as $flag => $flagLabel): ?>
                                    <div class="form-check form-check-inline">
                                        <input
                                            type="checkbox"
                                            class="form-check-input"
                                            name="ui[<?= esc($fieldName) ?>][]"
                                            value="<?= esc($flag) ?>"
                                            id="<?= esc($fieldName . '_ui_' . $flag) ?>"
                                            <?= !empty($field['ui'][$flag]) ? 'checked' : '' ?>
                                        >
                                        <label class="form-check-label" for="<?= esc($fieldName . '_ui_' . $flag) ?>">
                                            <?= esc($flagLabel) ?>
                                        </label>
                                    </div>
                                <?php endforeach; ?>
                                <div class="form-text">
                                    “Ricercabile” rende il campo disponibile nel filtro dinamico Campo/Criterio/Valore quando l'indice lo consente.
                                    Le opzioni di visibilità ed export vengono rispettate dal codice generato lato sito.
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <label class="form-label">Attributi con valore</label>
                                <div class="row g-2">
    <?php foreach (['maxlength', 'minlength', 'min', 'max', 'step', 'pattern', 'placeholder'] as $attribute): ?>
                                        <div class="col-md-4">
                                            <div class="input-group input-group-sm">
                                                <span class="input-group-text"><?= esc($attribute) ?></span>
                                                <input
                                                    type="text"
                                                    name="attrVal[<?= esc($fieldName) ?>][<?= esc($attribute) ?>]"
                                                    value="<?= esc($field['attributes']['values'][$attribute] ?? '') ?>"
                                                    class="form-control"
                                                    >
                                            </div>
                                        </div>
    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
<?php endforeach; ?>
        </div>

        <div id="orderContainer"></div>

        <div class="sticky-bottom bg-light border-top py-3 mt-4">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">
                <a href="<?= site_url('mycrud') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Tabelle
                </a>

                <div class="d-flex flex-wrap gap-2">
                    <div class="form-check form-switch align-self-center me-2">
                        <input class="form-check-input" type="checkbox" name="force" value="1" id="force">
                        <label class="form-check-label" for="force">
                            Sovrascrivi file esistenti
                        </label>
                    </div>

                    <button
                        type="submit"
                        formaction="<?= site_url('mycrud/builder/save') ?>"
                        class="btn btn-outline-success"
                        >
                        <i class="bi bi-floppy"></i> Salva configurazione
                    </button>

                    <button
                        type="submit"
                        formaction="<?= site_url('mycrud/builder/generate') ?>"
                        class="btn btn-warning"
                        >
                        <i class="bi bi-gear"></i> Genera CRUD
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
        </main>
    </div>
</div>

<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-xl modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">
                    <i class="bi bi-eye"></i> Anteprima form
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="previewContent"></div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const sortableElement = document.getElementById('sortableFields');
        const orderContainer = document.getElementById('orderContainer');

        function updateOrder() {
            orderContainer.innerHTML = '';

            document.querySelectorAll('.field-block').forEach(function (block) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'order[]';
                input.value = block.dataset.field;
                orderContainer.appendChild(input);
            });
        }

        new Sortable(sortableElement, {
            animation: 150,
            handle: '.drag-handle',
            ghostClass: 'border-warning',
            onSort: updateOrder
        });

        updateOrder();

        document.querySelectorAll('.toggle-field').forEach(function (button) {
            button.addEventListener('click', function () {
                const body = button.closest('.card').querySelector('.field-body');
                const icon = button.querySelector('i');

                body.classList.toggle('d-none');
                icon.className = body.classList.contains('d-none')
                        ? 'bi bi-chevron-down'
                        : 'bi bi-chevron-up';
            });
        });

        document.getElementById('expandAll').addEventListener('click', function () {
            document.querySelectorAll('.field-body').forEach(body => body.classList.remove('d-none'));
            document.querySelectorAll('.toggle-field i').forEach(icon => icon.className = 'bi bi-chevron-up');
        });

        document.getElementById('collapseAll').addEventListener('click', function () {
            document.querySelectorAll('.field-body').forEach(body => body.classList.add('d-none'));
            document.querySelectorAll('.toggle-field i').forEach(icon => icon.className = 'bi bi-chevron-down');
        });

        function previewControl(type) {
            switch (type) {
                case 'textarea':
                    return '<textarea class="form-control"></textarea>';
                case 'select':
                    return '<select class="form-select"><option>Seleziona...</option></select>';
                case 'checkbox':
                    return '<div class="form-check"><input type="checkbox" class="form-check-input"></div>';
                case 'radio':
                    return '<div class="form-check"><input type="radio" class="form-check-input"></div>';
                case 'hidden':
                    return '<div class="form-text">Campo nascosto</div>';
                default:
                    return '<input type="' + type + '" class="form-control">';
            }
        }

        // Le architetture Basic, Standard e Full condividono lo stesso Builder dei campi.

        document.querySelectorAll('.field-block').forEach(function (block) {
            const disabled = block.querySelector('input[value="disabled"]');
            const required = block.querySelector('input[value="required"]');
            if (!disabled || !required)
                return;
            const sync = () => {
                required.checked = disabled.checked ? false : required.checked;
                required.disabled = disabled.checked;
            };
            disabled.addEventListener('change', sync);
            sync();
        });

        document.getElementById('showPreview').addEventListener('click', function () {
            let html = '<form class="row g-3">';

            document.querySelectorAll('.field-block').forEach(function (block) {
                const type = block.querySelector('.input-type').value;
                const labelInput = block.querySelector('.field-label');
                const label = labelInput.value.trim() || labelInput.placeholder || block.dataset.field;
                const width = block.querySelector('.width-select').value;

                html += `
                <div class="col-md-${width}">
                    <label class="form-label">${label}</label>
                    ${previewControl(type)}
                </div>
            `;
            });

            html += '</form>';

            document.getElementById('previewContent').innerHTML = html;
            bootstrap.Modal.getOrCreateInstance(
                    document.getElementById('previewModal')
                    ).show();
        });
    });
</script>
<?= $this->endSection() ?>
