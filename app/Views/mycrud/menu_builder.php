<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<?php
/**
 * Menu Builder 3 - aggregazione guidata.
 *
 * Tutte le tabelle partono nell'area "Non assegnate". Le foreign key vengono
 * mostrate esclusivamente come suggerimenti informativi: nessuna relazione SQL
 * modifica automaticamente la struttura di navigazione scelta dallo sviluppatore.
 */
$items = array_values((array) ($items ?? []));
$related = (array) ($related ?? []);
$relationCount = (int) ($relationCount ?? 0);
$savedMenu = is_array($savedMenu ?? null) ? $savedMenu : null;
$menuConfigPath = (string) ($menuConfigPath ?? '');
$nextItemIndex = count($items);
$relatedJson = json_encode(
    $related,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
) ?: '{}';
$savedMenuJson = json_encode(
    $savedMenu,
    JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT
) ?: 'null';
?>

<div class="container-fluid py-4 menu-builder-page">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-3">
        <div>
            <h1 class="h3 mb-1">
                <i class="bi bi-layout-sidebar-inset"></i>
                Menu Builder
            </h1>
            <p class="text-body-secondary mb-0">
                Costruisci la navigazione per moduli funzionali, senza far dipendere il menu dalla struttura tecnica del database.
            </p>
        </div>

        <a class="btn btn-outline-secondary" href="<?= site_url('mycrud') ?>">
            <i class="bi bi-arrow-left"></i>
            Dashboard
        </a>
    </div>

    <?php if (session('message')): ?>
        <div class="alert alert-success py-2 mb-3">
            <i class="bi bi-check-circle me-1"></i><?= esc(session('message')) ?>
        </div>
    <?php endif ?>

    <?php if ($savedMenu !== null): ?>
        <div class="alert alert-light border py-2 mb-3 small">
            <i class="bi bi-save me-1"></i>
            Configurazione caricata da <code><?= esc($menuConfigPath) ?></code>
            <?php if (!empty($savedMenu['_meta']['savedAt'])): ?>
                · <?= esc((string) $savedMenu['_meta']['savedAt']) ?>
            <?php endif ?>
        </div>
    <?php endif ?>

    <div class="alert alert-info py-2 mb-3">
        <div class="d-flex gap-2 align-items-start">
            <i class="bi bi-info-circle mt-1"></i>
            <div>
                <strong>Nessuna aggregazione automatica.</strong>
                Le <?= count($items) ?> tabelle sono inizialmente non assegnate. Crea i gruppi che rappresentano davvero
                l'applicazione e usa le <?= $relationCount ?> relazioni SQL solo per individuare velocemente tabelle correlate.
            </div>
        </div>
    </div>

    <form method="post" action="<?= site_url('mycrud/tools/menu/generate') ?>" id="menuBuilderForm">
        <?= csrf_field() ?>

        <!-- =====================================================
             IMPOSTAZIONI GENERALI
             ===================================================== -->
        <div class="card shadow-sm mb-3">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-lg-3 col-md-6">
                        <label class="form-label" for="menuType">Layout predefinito</label>
                        <select class="form-select" id="menuType" name="menuType">
                            <option value="vertical" <?= (($savedMenu['type'] ?? 'vertical') === 'vertical') ? 'selected' : '' ?>>Verticale</option>
                            <option value="horizontal" <?= (($savedMenu['type'] ?? 'vertical') === 'horizontal') ? 'selected' : '' ?>>Orizzontale</option>
                        </select>
                        <div class="form-text">Entrambi i renderer vengono comunque generati.</div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <input type="hidden" name="enableSearch" value="0">
                        <div class="form-check form-switch mb-2">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                id="enableSearch"
                                name="enableSearch"
                                value="1"
                                <?= ($savedMenu === null || !array_key_exists('search', $savedMenu) || !empty($savedMenu['search'])) ? 'checked' : '' ?>
                            >
                            <label class="form-check-label" for="enableSearch">Ricerca nel menu finale</label>
                        </div>

                        <input type="hidden" name="showFavorites" value="0">
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                role="switch"
                                id="showFavorites"
                                name="showFavorites"
                                value="1"
                                <?= ($savedMenu === null || !array_key_exists('favorites', $savedMenu) || !empty($savedMenu['favorites'])) ? 'checked' : '' ?>
                            >
                            <label class="form-check-label" for="showFavorites">Sezione Preferiti</label>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6">
                        <div class="small text-body-secondary mb-1">Struttura supportata</div>
                        <div class="d-flex flex-wrap gap-1">
                            <span class="badge text-bg-light border">Gruppo</span>
                            <i class="bi bi-chevron-right text-body-secondary"></i>
                            <span class="badge text-bg-light border">Sottogruppo</span>
                            <i class="bi bi-chevron-right text-body-secondary"></i>
                            <span class="badge text-bg-light border">Voce</span>
                        </div>
                    </div>

                    <div class="col-lg-3 col-md-6 text-md-end">
                        <div class="form-check d-inline-block text-start">
                            <input class="form-check-input" type="checkbox" value="1" id="force" name="force">
                            <label class="form-check-label" for="force">Sovrascrivi staging</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- =====================================================
             BUILDER A TRE AREE
             ===================================================== -->
        <div class="row g-3 align-items-start">

            <!-- =================================================
                 SINISTRA: VOCI NON ASSEGNATE
                 ================================================= -->
            <div class="col-xxl-4 col-xl-4">
                <div class="card shadow-sm menu-sticky-panel">
                    <div class="card-header bg-body">
                        <div class="d-flex justify-content-between align-items-center gap-2">
                            <div>
                                <strong>Voci non assegnate</strong>
                                <span class="badge text-bg-secondary ms-1" id="unassignedCount">
                                    <?= count($items) ?>
                                </span>
                            </div>
                            <i class="bi bi-database text-body-secondary"></i>
                        </div>
                    </div>

                    <div class="card-body p-2 border-bottom">
                        <div class="input-group input-group-sm mb-2">
                            <span class="input-group-text"><i class="bi bi-search"></i></span>
                            <input
                                class="form-control"
                                type="search"
                                id="sourceSearch"
                                placeholder="Cerca tabella, label o relazione..."
                            >
                        </div>

                        <div class="d-flex flex-wrap gap-1 mb-2">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="selectVisible">
                                <i class="bi bi-check2-square"></i>
                                Seleziona visibili
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="clearSelection">
                                <i class="bi bi-square"></i>
                                Deseleziona
                            </button>
                        </div>

                        <div class="small text-body-secondary mb-2">
                            <span id="selectionCount">0 selezionate</span>
                        </div>

                        <div class="input-group input-group-sm mb-2">
                            <select class="form-select" id="bulkTarget" disabled>
                                <option value="">Prima crea un gruppo...</option>
                            </select>
                            <button class="btn btn-outline-primary" type="button" id="assignSelected" disabled>
                                Assegna
                            </button>
                        </div>

                        <button type="button" class="btn btn-sm btn-outline-primary w-100" id="createGroupFromSelection">
                            <i class="bi bi-folder-plus"></i>
                            Crea gruppo dalla selezione
                        </button>
                    </div>

                    <div
                        class="card-body p-2 menu-source-zone menu-dropzone"
                        id="unassignedZone"
                        data-dropzone
                        data-unassigned="1"
                    >
                        <?php foreach ($items as $index => $item): ?>
                            <?= view('mycrud/menu_builder_item', [
                                'index' => $index,
                                'item' => $item,
                                'assigned' => false,
                            ]) ?>
                        <?php endforeach ?>

                        <div class="menu-empty-source text-center text-body-secondary py-4 d-none" data-source-empty>
                            <i class="bi bi-check-circle fs-3 d-block mb-1"></i>
                            Tutte le voci sono state assegnate.
                        </div>
                    </div>
                </div>
            </div>

            <!-- =================================================
                 CENTRO: STRUTTURA SCELTA DALLO SVILUPPATORE
                 ================================================= -->
            <div class="col-xxl-5 col-xl-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-body d-flex flex-wrap justify-content-between align-items-center gap-2">
                        <div>
                            <strong>Struttura menu</strong>
                            <span class="badge text-bg-primary ms-1" id="assignedCount">0</span>
                        </div>

                        <div class="d-flex flex-wrap gap-1">
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="addGroup">
                                <i class="bi bi-folder-plus"></i>
                                Gruppo
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-secondary" id="addManualItem">
                                <i class="bi bi-plus-circle"></i>
                                Voce manuale
                            </button>
                        </div>
                    </div>

                    <div class="card-body p-2 menu-structure-zone" id="menuStructure">
                        <div class="menu-structure-empty text-center text-body-secondary py-5" id="structureEmpty">
                            <i class="bi bi-layout-sidebar fs-2 d-block mb-2"></i>
                            <strong>Nessun gruppo creato</strong>
                            <div class="small mt-1">
                                Seleziona alcune tabelle a sinistra e usa <em>Crea gruppo dalla selezione</em>,
                                oppure crea un gruppo vuoto.
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- =================================================
                 DESTRA: RELAZIONI E ANTEPRIMA
                 ================================================= -->
            <div class="col-xxl-3 col-xl-3">
                <div class="menu-sticky-panel">
                    <div class="card shadow-sm mb-3">
                        <div class="card-header bg-body d-flex justify-content-between align-items-center">
                            <strong>Relazioni SQL</strong>
                            <i class="bi bi-diagram-3 text-body-secondary"></i>
                        </div>
                        <div class="card-body" id="relationsPanel">
                            <div class="text-body-secondary small">
                                Clicca sull'icona <i class="bi bi-diagram-3"></i> di una tabella per vedere le tabelle correlate.
                                Le relazioni sono solo informazioni: non spostano mai le voci automaticamente.
                            </div>
                        </div>
                    </div>

                    <div class="card shadow-sm">
                        <div class="card-header bg-body d-flex flex-wrap justify-content-between align-items-center gap-2">
                            <strong>Anteprima</strong>
                            <div class="btn-group btn-group-sm" role="group" aria-label="Tipo anteprima">
                                <button type="button" class="btn btn-primary" data-preview-mode="vertical">
                                    <i class="bi bi-layout-sidebar"></i>
                                </button>
                                <button type="button" class="btn btn-outline-primary" data-preview-mode="horizontal">
                                    <i class="bi bi-layout-text-window"></i>
                                </button>
                            </div>
                        </div>
                        <div class="card-body p-2" id="menuPreview">
                            <div class="text-body-secondary small p-2">Il menu è ancora vuoto.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mt-3">
            <div class="small text-body-secondary">
                <i class="bi bi-shield-check me-1"></i>
                La generazione scrive esclusivamente in <code>app/Generated/</code>.
            </div>

            <div class="d-flex flex-wrap gap-2">
                <button
                    type="submit"
                    class="btn btn-outline-primary"
                    formaction="<?= site_url('mycrud/tools/menu/save') ?>"
                >
                    <i class="bi bi-save"></i>
                    Salva configurazione
                </button>
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-magic"></i>
                    Genera Menu
                </button>
            </div>
        </div>
    </form>
</div>

<!-- =========================================================
     TEMPLATE SOTTOGRUPPO
     ========================================================= -->
<template id="subgroupTemplate">
    <div class="border rounded mb-2 menu-subgroup" data-subgroup-card>
        <div class="d-flex align-items-center gap-2 px-2 py-2 bg-body-tertiary border-bottom">
            <i class="bi bi-diagram-2 text-body-secondary"></i>
            <input
                class="form-control form-control-sm fw-semibold"
                style="max-width: 250px"
                value="Nuovo sottogruppo"
                data-subgroup-label
                aria-label="Nome sottogruppo"
            >
            <button
                type="button"
                class="btn btn-sm btn-outline-danger ms-auto"
                data-remove-subgroup
                title="Rimuovi sottogruppo"
            >
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="menu-dropzone rounded p-1" data-dropzone data-subgroup="">
            <div class="menu-empty-hint small text-body-secondary px-2 py-2">
                Trascina qui le voci del sottogruppo.
            </div>
        </div>
    </div>
</template>

<style>
.menu-builder-page .min-w-0 { min-width: 0; }
.menu-sticky-panel { position: sticky; top: .75rem; }
.menu-source-zone,
.menu-structure-zone { max-height: calc(100vh - 330px); overflow-y: auto; min-height: 260px; }
.menu-builder-item { transition: border-color .15s ease, box-shadow .15s ease, opacity .15s ease; }
.menu-builder-item:hover { border-color: var(--bs-primary-border-subtle) !important; }
.menu-builder-item.dragging { opacity: .45; }
.menu-builder-item.menu-filter-hidden { display: none !important; }
.menu-drag-handle { cursor: grab; }
.menu-drag-handle:active { cursor: grabbing; }
.menu-dropzone { min-height: 54px; border: 1px dashed var(--bs-border-color); transition: background-color .15s ease, border-color .15s ease; }
.menu-dropzone.drag-over { background: var(--bs-primary-bg-subtle); border-color: var(--bs-primary); }
.menu-group-card { border-left: 4px solid var(--bs-primary-border-subtle); }
.menu-group-label { min-width: 150px; }
.menu-subgroup { border-left: 3px solid var(--bs-secondary-border-subtle) !important; }
.menu-empty-hint { pointer-events: none; }
.preview-sidebar { border: 1px solid var(--bs-border-color); border-radius: var(--bs-border-radius); overflow: hidden; background: var(--bs-body-bg); max-height: 520px; overflow-y: auto; }
.preview-link { font-size: .86rem; border-top: 1px solid transparent; }
.preview-link:hover { background: var(--bs-tertiary-bg); }
.preview-subgroup-title { font-size: .72rem; text-transform: uppercase; letter-spacing: .02em; }
.relation-table-button { text-align: left; }
@media (max-width: 1199.98px) {
    .menu-sticky-panel { position: static; }
    .menu-source-zone,
    .menu-structure-zone { max-height: 520px; }
}
</style>

<script>
(() => {
    'use strict';

    const form = document.getElementById('menuBuilderForm');
    const sourceZone = document.getElementById('unassignedZone');
    const structure = document.getElementById('menuStructure');
    const structureEmpty = document.getElementById('structureEmpty');
    const sourceSearch = document.getElementById('sourceSearch');
    const bulkTarget = document.getElementById('bulkTarget');
    const assignSelected = document.getElementById('assignSelected');
    const selectionCount = document.getElementById('selectionCount');
    const unassignedCount = document.getElementById('unassignedCount');
    const assignedCount = document.getElementById('assignedCount');
    const relationsPanel = document.getElementById('relationsPanel');
    const preview = document.getElementById('menuPreview');
    const subgroupTemplate = document.getElementById('subgroupTemplate');
    const relatedData = <?= $relatedJson ?>;
    const savedMenu = <?= $savedMenuJson ?>;

    let nextItemIndex = <?= (int) $nextItemIndex ?>;
    let nextZoneId = 1;
    let draggedItem = null;
    let previewMode = 'vertical';
    let currentRelationTable = '';

    const escHtml = (value) => String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

    const normalize = (value) => String(value ?? '').toLocaleLowerCase().trim();

    function groupCards() {
        return [...structure.querySelectorAll(':scope > [data-menu-group-card]')];
    }

    function itemTable(item) {
        return item?.dataset?.table || item?.querySelector('[data-item-table]')?.value || '';
    }

    function itemLabel(item) {
        return item?.querySelector('[data-item-label]')?.value.trim() || itemTable(item) || 'Voce';
    }

    function setItemAssigned(item, assigned) {
        const enabled = item.querySelector('[data-item-enabled]');
        if (enabled) enabled.checked = assigned;

        if (!assigned) {
            item.querySelector('[data-item-group]').value = '';
            item.querySelector('[data-item-group-icon]').value = 'bi-folder2-open';
            item.querySelector('[data-item-subgroup]').value = '';
            item.querySelector('[data-item-group-order]').value = '0';
            item.querySelector('[data-item-subgroup-order]').value = '0';
        }
    }

    function selectedUnassignedItems() {
        return [...sourceZone.querySelectorAll(':scope > [data-menu-item]')]
            .filter((item) => item.querySelector('[data-item-select]')?.checked);
    }

    function updateSelectionCount() {
        const count = selectedUnassignedItems().length;
        selectionCount.textContent = `${count} ${count === 1 ? 'selezionata' : 'selezionate'}`;
    }

    function updateCounters() {
        const unassigned = sourceZone.querySelectorAll(':scope > [data-menu-item]').length;
        const assigned = structure.querySelectorAll('[data-menu-item]').length;

        unassignedCount.textContent = String(unassigned);
        assignedCount.textContent = String(assigned);

        sourceZone.querySelector('[data-source-empty]')?.classList.toggle('d-none', unassigned !== 0);
        structureEmpty?.classList.toggle('d-none', groupCards().length !== 0);
    }

    function makeZoneKey(zone) {
        if (!zone.dataset.zoneKey) {
            zone.dataset.zoneKey = `menu-zone-${nextZoneId++}`;
        }
        return zone.dataset.zoneKey;
    }

    function refreshBulkTargets() {
        const current = bulkTarget.value;
        bulkTarget.innerHTML = '<option value="">Assegna a...</option>';

        groupCards().forEach((groupCard) => {
            const groupLabel = groupCard.querySelector('[data-group-label]')?.value.trim() || 'Gruppo';
            const direct = groupCard.querySelector(':scope > .card-body > [data-dropzone]');

            if (direct) {
                const option = document.createElement('option');
                option.value = makeZoneKey(direct);
                option.textContent = groupLabel;
                bulkTarget.appendChild(option);
            }

            groupCard.querySelectorAll('[data-subgroup-card]').forEach((subgroupCard) => {
                const subgroupLabel = subgroupCard.querySelector('[data-subgroup-label]')?.value.trim() || 'Sottogruppo';
                const zone = subgroupCard.querySelector('[data-dropzone]');
                if (!zone) return;

                const option = document.createElement('option');
                option.value = makeZoneKey(zone);
                option.textContent = `${groupLabel} / ${subgroupLabel}`;
                bulkTarget.appendChild(option);
            });
        });

        if ([...bulkTarget.options].some((option) => option.value === current)) {
            bulkTarget.value = current;
        }

        const hasTargets = bulkTarget.options.length > 1;
        bulkTarget.disabled = !hasTargets;
        assignSelected.disabled = !hasTargets;
    }

    function syncStructure() {
        groupCards().forEach((groupCard, groupIndex) => {
            const groupLabel = groupCard.querySelector('[data-group-label]')?.value.trim() || 'Principale';
            const groupIcon = groupCard.querySelector('[data-group-icon]')?.value.trim() || 'bi-folder2-open';
            const directZone = groupCard.querySelector(':scope > .card-body > [data-dropzone]');

            directZone?.querySelectorAll(':scope > [data-menu-item]').forEach((item, itemIndex) => {
                setItemAssigned(item, true);
                item.querySelector('[data-item-group]').value = groupLabel;
                item.querySelector('[data-item-group-icon]').value = groupIcon;
                item.querySelector('[data-item-subgroup]').value = '';
                item.querySelector('[data-item-group-order]').value = String((groupIndex + 1) * 10);
                item.querySelector('[data-item-subgroup-order]').value = '0';
                item.querySelector('[data-item-order]').value = String((itemIndex + 1) * 10);
            });

            groupCard.querySelectorAll('[data-subgroup-card]').forEach((subgroupCard, subgroupIndex) => {
                const subgroupLabel = subgroupCard.querySelector('[data-subgroup-label]')?.value.trim() || 'Sottogruppo';
                const zone = subgroupCard.querySelector('[data-dropzone]');
                if (!zone) return;

                zone.dataset.subgroup = subgroupLabel;

                zone.querySelectorAll(':scope > [data-menu-item]').forEach((item, itemIndex) => {
                    setItemAssigned(item, true);
                    item.querySelector('[data-item-group]').value = groupLabel;
                    item.querySelector('[data-item-group-icon]').value = groupIcon;
                    item.querySelector('[data-item-subgroup]').value = subgroupLabel;
                    item.querySelector('[data-item-group-order]').value = String((groupIndex + 1) * 10);
                    item.querySelector('[data-item-subgroup-order]').value = String((subgroupIndex + 1) * 10);
                    item.querySelector('[data-item-order]').value = String((itemIndex + 1) * 10);
                });
            });
        });

        sourceZone.querySelectorAll(':scope > [data-menu-item]').forEach((item, index) => {
            setItemAssigned(item, false);
            item.querySelector('[data-item-order]').value = String((index + 1) * 10);
        });

        refreshBulkTargets();
        updateCounters();
        updateSelectionCount();
        renderPreview();
    }

    function addGroup(label = 'Nuovo gruppo', icon = 'bi-folder2-open') {
        const card = document.createElement('section');
        card.className = 'card shadow-sm mb-3 menu-group-card';
        card.dataset.menuGroupCard = '';
        card.innerHTML = `
            <div class="card-header bg-body d-flex flex-wrap align-items-center gap-2">
                <i class="bi bi-folder2-open text-body-secondary"></i>
                <input
                    class="form-control form-control-sm fw-semibold menu-group-label"
                    style="max-width:220px"
                    value="${escHtml(label)}"
                    data-group-label
                    aria-label="Nome gruppo"
                >
                <input
                    class="form-control form-control-sm"
                    style="max-width:160px"
                    value="${escHtml(icon)}"
                    data-group-icon
                    aria-label="Icona gruppo"
                >
                <div class="ms-auto d-flex gap-1">
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-add-subgroup title="Aggiungi sottogruppo">
                        <i class="bi bi-node-plus"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-group-up title="Sposta gruppo su">
                        <i class="bi bi-arrow-up"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-secondary" data-group-down title="Sposta gruppo giù">
                        <i class="bi bi-arrow-down"></i>
                    </button>
                    <button type="button" class="btn btn-sm btn-outline-danger" data-remove-group title="Rimuovi gruppo">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-2">
                <div class="menu-dropzone rounded p-1 mb-2" data-dropzone data-subgroup="">
                    <div class="menu-empty-hint small text-body-secondary px-2 py-2">
                        Trascina qui le voci del gruppo.
                    </div>
                </div>
                <div data-subgroups-container></div>
            </div>
        `;

        structure.appendChild(card);
        bindGroup(card);
        bindDropzones(card);
        syncStructure();
        return card;
    }

    function addSubgroup(groupCard, label = 'Nuovo sottogruppo') {
        const fragment = subgroupTemplate.content.cloneNode(true);
        const subgroup = fragment.querySelector('[data-subgroup-card]');
        subgroup.querySelector('[data-subgroup-label]').value = label;
        groupCard.querySelector('[data-subgroups-container]').appendChild(fragment);
        bindSubgroup(subgroup);
        bindDropzones(subgroup);
        syncStructure();
        return subgroup;
    }

    function createManualItem() {
        const index = nextItemIndex++;
        const item = document.createElement('div');
        item.className = 'menu-builder-item border rounded bg-body p-2 mb-2';
        item.draggable = true;
        item.dataset.menuItem = '';
        item.dataset.table = '';
        item.dataset.search = 'nuova voce route manuale';

        item.innerHTML = `
            <input type="hidden" name="items[${index}][table]" value="" data-item-table>
            <input type="hidden" name="items[${index}][group]" value="" data-item-group>
            <input type="hidden" name="items[${index}][groupIcon]" value="bi-folder2-open" data-item-group-icon>
            <input type="hidden" name="items[${index}][subgroup]" value="" data-item-subgroup>
            <input type="hidden" name="items[${index}][groupOrder]" value="0" data-item-group-order>
            <input type="hidden" name="items[${index}][subgroupOrder]" value="0" data-item-subgroup-order>
            <input type="hidden" name="items[${index}][order]" value="10" data-item-order>
            <input class="d-none" type="checkbox" name="items[${index}][enabled]" value="1" data-item-enabled checked>

            <div class="d-flex align-items-start gap-2">
                <span class="menu-drag-handle text-body-secondary pt-1"><i class="bi bi-grip-vertical"></i></span>
                <input class="form-check-input mt-1" type="checkbox" data-item-select aria-label="Seleziona voce manuale">
                <div class="flex-grow-1 min-w-0">
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <span class="badge text-bg-primary">Route manuale</span>
                        <label class="btn btn-sm btn-outline-warning py-0 px-2 mb-0 ms-auto" title="Preferito">
                            <input class="visually-hidden" type="checkbox" name="items[${index}][favorite]" value="1" data-item-favorite>
                            <i class="bi bi-star"></i>
                        </label>
                        <button type="button" class="btn btn-sm btn-outline-secondary py-0 px-2" data-toggle-item-details title="Proprietà voce">
                            <i class="bi bi-sliders"></i>
                        </button>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" name="items[${index}][label]" value="Nuova voce" data-item-label placeholder="Etichetta">
                        </div>
                        <div class="col-md-6">
                            <input class="form-control form-control-sm" name="items[${index}][route]" value="" data-item-route placeholder="route/interna">
                        </div>
                    </div>
                    <div class="row g-2 mt-1 d-none" data-item-details>
                        <div class="col-md-6">
                            <label class="form-label small mb-1">Bootstrap Icon</label>
                            <input class="form-control form-control-sm" name="items[${index}][icon]" value="bi-link-45deg" data-item-icon>
                        </div>
                        <div class="col-md-6 small text-body-secondary pt-4">Voce indipendente da una tabella DB.</div>
                    </div>
                </div>
            </div>
        `;

        bindItem(item);
        return item;
    }

    function bindGroup(groupCard) {
        groupCard.querySelector('[data-group-label]')?.addEventListener('input', syncStructure);
        groupCard.querySelector('[data-group-icon]')?.addEventListener('input', syncStructure);

        groupCard.querySelector('[data-add-subgroup]')?.addEventListener('click', () => {
            const name = window.prompt('Nome del sottogruppo:', 'Nuovo sottogruppo');
            if (name === null || !name.trim()) return;
            addSubgroup(groupCard, name.trim());
        });

        groupCard.querySelector('[data-group-up]')?.addEventListener('click', () => {
            const previous = groupCard.previousElementSibling;
            if (previous?.matches?.('[data-menu-group-card]')) {
                structure.insertBefore(groupCard, previous);
                syncStructure();
            }
        });

        groupCard.querySelector('[data-group-down]')?.addEventListener('click', () => {
            const next = groupCard.nextElementSibling;
            if (next?.matches?.('[data-menu-group-card]')) {
                structure.insertBefore(next, groupCard);
                syncStructure();
            }
        });

        groupCard.querySelector('[data-remove-group]')?.addEventListener('click', () => {
            const groupName = groupCard.querySelector('[data-group-label]')?.value.trim() || 'questo gruppo';
            if (!window.confirm(`Rimuovere "${groupName}"? Le voci torneranno tra quelle non assegnate.`)) return;

            groupCard.querySelectorAll('[data-menu-item]').forEach((item) => {
                item.querySelector('[data-item-select]').checked = false;
                sourceZone.appendChild(item);
            });

            if (currentRelationTable && !document.querySelector(`[data-menu-item][data-table="${CSS.escape(currentRelationTable)}"]`)) {
                currentRelationTable = '';
            }

            groupCard.remove();
            syncStructure();
            applySourceSearch();
        });
    }

    function bindSubgroup(subgroupCard) {
        subgroupCard.querySelector('[data-subgroup-label]')?.addEventListener('input', syncStructure);

        subgroupCard.querySelector('[data-remove-subgroup]')?.addEventListener('click', () => {
            const groupCard = subgroupCard.closest('[data-menu-group-card]');
            const directZone = groupCard?.querySelector(':scope > .card-body > [data-dropzone]');
            if (!directZone) return;

            subgroupCard.querySelectorAll('[data-menu-item]').forEach((item) => directZone.appendChild(item));
            subgroupCard.remove();
            syncStructure();
        });
    }

    function bindItem(item) {
        if (item.dataset.boundItem) return;
        item.dataset.boundItem = '1';

        item.addEventListener('dragstart', (event) => {
            draggedItem = item;
            item.classList.add('dragging');
            event.dataTransfer.effectAllowed = 'move';
        });

        item.addEventListener('dragend', () => {
            item.classList.remove('dragging');
            draggedItem = null;
            document.querySelectorAll('.drag-over').forEach((element) => element.classList.remove('drag-over'));
            syncStructure();
            applySourceSearch();
        });

        item.querySelector('[data-item-select]')?.addEventListener('change', updateSelectionCount);

        item.querySelector('[data-toggle-item-details]')?.addEventListener('click', () => {
            item.querySelector('[data-item-details]')?.classList.toggle('d-none');
        });

        item.querySelector('[data-item-favorite]')?.addEventListener('change', (event) => {
            const icon = event.currentTarget.closest('label')?.querySelector('i');
            icon?.classList.toggle('bi-star-fill', event.currentTarget.checked);
            icon?.classList.toggle('bi-star', !event.currentTarget.checked);
            renderPreview();
        });

        item.querySelector('[data-item-label]')?.addEventListener('input', () => {
            renderPreview();
            applySourceSearch();
        });
        item.querySelector('[data-item-route]')?.addEventListener('input', renderPreview);
        item.querySelector('[data-item-icon]')?.addEventListener('input', renderPreview);

        item.querySelector('[data-show-relations]')?.addEventListener('click', () => showRelations(itemTable(item)));
    }

    function bindDropzones(root = document) {
        root.querySelectorAll('[data-dropzone]').forEach((zone) => {
            if (zone.dataset.boundDropzone) return;
            zone.dataset.boundDropzone = '1';
            makeZoneKey(zone);

            zone.addEventListener('dragover', (event) => {
                if (!draggedItem) return;
                event.preventDefault();
                zone.classList.add('drag-over');

                const candidates = [...zone.querySelectorAll(':scope > [data-menu-item]:not(.dragging)')];
                const after = candidates.find((candidate) => {
                    const box = candidate.getBoundingClientRect();
                    return event.clientY < box.top + box.height / 2;
                });

                const emptyHint = zone.querySelector(':scope > .menu-empty-hint, :scope > [data-source-empty]');
                zone.insertBefore(draggedItem, after || emptyHint || null);
            });

            zone.addEventListener('dragleave', () => zone.classList.remove('drag-over'));

            zone.addEventListener('drop', (event) => {
                event.preventDefault();
                zone.classList.remove('drag-over');
                if (!draggedItem) return;

                const isUnassigned = zone.dataset.unassigned === '1';
                setItemAssigned(draggedItem, !isUnassigned);
                draggedItem.querySelector('[data-item-select]').checked = false;
                syncStructure();
                applySourceSearch();
            });
        });
    }

    function applySourceSearch() {
        const term = normalize(sourceSearch.value);
        let visible = 0;

        sourceZone.querySelectorAll(':scope > [data-menu-item]').forEach((item) => {
            const label = item.querySelector('[data-item-label]')?.value || '';
            const haystack = normalize(`${item.dataset.search || ''} ${label}`);
            const show = term === '' || haystack.includes(term);
            item.classList.toggle('menu-filter-hidden', !show);
            if (show) visible++;
        });

        const empty = sourceZone.querySelector('[data-source-empty]');
        if (empty) {
            const trulyEmpty = sourceZone.querySelectorAll(':scope > [data-menu-item]').length === 0;
            empty.classList.toggle('d-none', !(trulyEmpty || (term !== '' && visible === 0)));
            empty.innerHTML = trulyEmpty
                ? '<i class="bi bi-check-circle fs-3 d-block mb-1"></i>Tutte le voci sono state assegnate.'
                : '<i class="bi bi-search fs-3 d-block mb-1"></i>Nessuna voce corrisponde alla ricerca.';
        }
    }

    function moveSelectedTo(zone) {
        const selected = selectedUnassignedItems();
        if (!selected.length) {
            window.alert('Seleziona almeno una voce non assegnata.');
            return false;
        }

        selected.forEach((item) => {
            item.querySelector('[data-item-select]').checked = false;
            setItemAssigned(item, true);
            const hint = zone.querySelector(':scope > .menu-empty-hint');
            zone.insertBefore(item, hint || null);
        });

        syncStructure();
        applySourceSearch();
        return true;
    }

    function showRelations(table) {
        currentRelationTable = table;
        if (!table) {
            relationsPanel.innerHTML = '<div class="text-body-secondary small">Le voci manuali non hanno relazioni DB.</div>';
            return;
        }

        const rows = Array.isArray(relatedData[table]) ? relatedData[table] : [];
        if (!rows.length) {
            relationsPanel.innerHTML = `
                <div class="fw-semibold mb-2"><code>${escHtml(table)}</code></div>
                <div class="text-body-secondary small">Nessuna foreign key diretta rilevata.</div>
            `;
            return;
        }

        const html = rows.map((row) => {
            const direction = row.direction === 'parent' ? 'Padre' : 'Figlia';
            const icon = row.direction === 'parent' ? 'bi-arrow-up-right' : 'bi-arrow-down-right';
            return `
                <button
                    type="button"
                    class="btn btn-sm btn-outline-secondary w-100 mb-2 relation-table-button"
                    data-related-table="${escHtml(row.table)}"
                    title="Seleziona ${escHtml(row.table)} tra le voci non assegnate"
                >
                    <div class="d-flex justify-content-between gap-2">
                        <span><i class="bi ${icon} me-1"></i><strong>${escHtml(row.table)}</strong></span>
                        <span class="badge text-bg-light border">${direction}</span>
                    </div>
                    <div class="small text-body-secondary text-truncate mt-1">${escHtml(row.hint || '')}</div>
                </button>
            `;
        }).join('');

        relationsPanel.innerHTML = `
            <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
                <div>
                    <div class="small text-body-secondary">Tabella selezionata</div>
                    <code>${escHtml(table)}</code>
                </div>
                <button type="button" class="btn btn-sm btn-outline-primary" id="selectRelatedTables">
                    <i class="bi bi-check2-square"></i>
                    Seleziona correlate
                </button>
            </div>
            ${html}
            <div class="small text-body-secondary mt-1">
                La selezione non assegna alcun gruppo: serve solo a velocizzare il lavoro manuale.
            </div>
        `;

        relationsPanel.querySelectorAll('[data-related-table]').forEach((button) => {
            button.addEventListener('click', () => {
                const targetTable = button.dataset.relatedTable;
                const item = sourceZone.querySelector(`[data-menu-item][data-table="${CSS.escape(targetTable)}"]`);
                if (!item) return;
                item.querySelector('[data-item-select]').checked = true;
                item.scrollIntoView({behavior: 'smooth', block: 'center'});
                updateSelectionCount();
            });
        });

        document.getElementById('selectRelatedTables')?.addEventListener('click', () => {
            rows.forEach((row) => {
                const item = sourceZone.querySelector(`[data-menu-item][data-table="${CSS.escape(row.table)}"]`);
                if (item) item.querySelector('[data-item-select]').checked = true;
            });
            updateSelectionCount();
        });
    }

    function itemSnapshot(item) {
        return {
            label: itemLabel(item),
            route: item.querySelector('[data-item-route]')?.value.trim() || '#',
            icon: item.querySelector('[data-item-icon]')?.value.trim() || 'bi-link-45deg',
            favorite: item.querySelector('[data-item-favorite]')?.checked === true,
        };
    }

    function groupSnapshot() {
        syncPositionOnly();

        return groupCards().map((groupCard) => {
            const group = {
                label: groupCard.querySelector('[data-group-label]')?.value.trim() || 'Principale',
                icon: groupCard.querySelector('[data-group-icon]')?.value.trim() || 'bi-folder2-open',
                items: [],
                subgroups: [],
            };

            const direct = groupCard.querySelector(':scope > .card-body > [data-dropzone]');
            direct?.querySelectorAll(':scope > [data-menu-item]').forEach((item) => group.items.push(itemSnapshot(item)));

            groupCard.querySelectorAll('[data-subgroup-card]').forEach((subgroupCard) => {
                const subgroup = {
                    label: subgroupCard.querySelector('[data-subgroup-label]')?.value.trim() || 'Sottogruppo',
                    items: [],
                };
                subgroupCard.querySelector('[data-dropzone]')?.querySelectorAll(':scope > [data-menu-item]')
                    .forEach((item) => subgroup.items.push(itemSnapshot(item)));
                group.subgroups.push(subgroup);
            });

            return group;
        });
    }

    // Variante senza renderPreview(), usata dal rendering stesso per evitare ricorsione.
    function syncPositionOnly() {
        groupCards().forEach((groupCard, groupIndex) => {
            const groupLabel = groupCard.querySelector('[data-group-label]')?.value.trim() || 'Principale';
            const groupIcon = groupCard.querySelector('[data-group-icon]')?.value.trim() || 'bi-folder2-open';
            const direct = groupCard.querySelector(':scope > .card-body > [data-dropzone]');

            direct?.querySelectorAll(':scope > [data-menu-item]').forEach((item, itemIndex) => {
                setItemAssigned(item, true);
                item.querySelector('[data-item-group]').value = groupLabel;
                item.querySelector('[data-item-group-icon]').value = groupIcon;
                item.querySelector('[data-item-subgroup]').value = '';
                item.querySelector('[data-item-group-order]').value = String((groupIndex + 1) * 10);
                item.querySelector('[data-item-subgroup-order]').value = '0';
                item.querySelector('[data-item-order]').value = String((itemIndex + 1) * 10);
            });

            groupCard.querySelectorAll('[data-subgroup-card]').forEach((subgroupCard, subgroupIndex) => {
                const subgroupLabel = subgroupCard.querySelector('[data-subgroup-label]')?.value.trim() || 'Sottogruppo';
                subgroupCard.querySelector('[data-dropzone]')?.querySelectorAll(':scope > [data-menu-item]')
                    .forEach((item, itemIndex) => {
                        setItemAssigned(item, true);
                        item.querySelector('[data-item-group]').value = groupLabel;
                        item.querySelector('[data-item-group-icon]').value = groupIcon;
                        item.querySelector('[data-item-subgroup]').value = subgroupLabel;
                        item.querySelector('[data-item-group-order]').value = String((groupIndex + 1) * 10);
                        item.querySelector('[data-item-subgroup-order]').value = String((subgroupIndex + 1) * 10);
                        item.querySelector('[data-item-order]').value = String((itemIndex + 1) * 10);
                    });
            });
        });
    }

    function previewItem(item, indent = 'ps-3') {
        return `
            <div class="preview-link py-1 ${indent}">
                <i class="bi ${escHtml(item.icon)} me-2"></i>${escHtml(item.label)}
            </div>
        `;
    }

    function renderPreview() {
        const groups = groupSnapshot();

        if (!groups.length || !structure.querySelector('[data-menu-item]')) {
            preview.innerHTML = '<div class="text-body-secondary small p-2">Il menu è ancora vuoto.</div>';
            return;
        }

        if (previewMode === 'horizontal') {
            const buttons = groups.map((group) => {
                const count = group.items.length + group.subgroups.reduce((total, subgroup) => total + subgroup.items.length, 0);
                if (!count) return '';
                return `
                    <button type="button" class="btn btn-sm btn-outline-secondary me-1 mb-1">
                        <i class="bi ${escHtml(group.icon)} me-1"></i>
                        ${escHtml(group.label)}
                        <i class="bi bi-chevron-down ms-1"></i>
                    </button>
                `;
            }).join('');

            preview.innerHTML = `<div class="bg-body border rounded p-2">${buttons}</div>`;
            return;
        }

        const favorites = [];
        groups.forEach((group) => {
            [...group.items, ...group.subgroups.flatMap((subgroup) => subgroup.items)]
                .forEach((item) => { if (item.favorite) favorites.push(item); });
        });

        let html = '<div class="preview-sidebar">';

        if (document.getElementById('enableSearch')?.checked) {
            html += `
                <div class="p-2 border-bottom">
                    <div class="form-control form-control-sm text-body-secondary">
                        <i class="bi bi-search me-1"></i>Cerca nel menu...
                    </div>
                </div>
            `;
        }

        if (document.getElementById('showFavorites')?.checked && favorites.length) {
            html += '<div class="p-2 border-bottom">';
            html += '<div class="preview-subgroup-title text-body-secondary fw-semibold mb-1"><i class="bi bi-star-fill me-1"></i>Preferiti</div>';
            favorites.slice(0, 6).forEach((item) => { html += previewItem(item); });
            html += '</div>';
        }

        groups.forEach((group) => {
            const count = group.items.length + group.subgroups.reduce((total, subgroup) => total + subgroup.items.length, 0);
            if (!count) return;

            html += `
                <div class="border-bottom">
                    <div class="px-3 py-2 fw-semibold">
                        <i class="bi ${escHtml(group.icon)} me-2"></i>${escHtml(group.label)}
                    </div>
            `;

            group.items.forEach((item) => { html += previewItem(item, 'ps-4'); });
            group.subgroups.forEach((subgroup) => {
                if (!subgroup.items.length) return;
                html += `<div class="px-4 pt-2 pb-1 preview-subgroup-title text-body-secondary fw-semibold">${escHtml(subgroup.label)}</div>`;
                subgroup.items.forEach((item) => { html += previewItem(item, 'ps-5'); });
            });

            html += '</div>';
        });

        html += '</div>';
        preview.innerHTML = html;
    }

    function applySavedItem(item, saved) {
        if (!item || !saved) return;
        const label = item.querySelector('[data-item-label]');
        const route = item.querySelector('[data-item-route]');
        const icon = item.querySelector('[data-item-icon]');
        const favorite = item.querySelector('[data-item-favorite]');

        if (label) label.value = String(saved.label ?? label.value ?? '');
        if (route) route.value = String(saved.route ?? route.value ?? '');
        if (icon) icon.value = String(saved.icon ?? icon.value ?? 'bi-link-45deg');
        if (favorite) {
            favorite.checked = saved.favorite === true;
            const star = favorite.closest('label')?.querySelector('i');
            star?.classList.toggle('bi-star-fill', favorite.checked);
            star?.classList.toggle('bi-star', !favorite.checked);
        }
    }

    function savedItemNode(saved) {
        const table = String(saved?.table ?? '');
        let item = null;

        if (table !== '') {
            item = document.querySelector(`[data-menu-item][data-table="${CSS.escape(table)}"]`);
        } else {
            item = createManualItem();
        }

        if (!item) return null;
        applySavedItem(item, saved);
        return item;
    }

    function appendSavedItem(zone, saved) {
        const item = savedItemNode(saved);
        if (!item || !zone) return;
        const hint = zone.querySelector(':scope > .menu-empty-hint');
        zone.insertBefore(item, hint || null);
    }

    function hydrateSavedMenu() {
        if (!savedMenu || !Array.isArray(savedMenu.groups)) return;

        const menuType = document.getElementById('menuType');
        if (menuType && ['vertical', 'horizontal'].includes(savedMenu.type)) {
            menuType.value = savedMenu.type;
        }

        const search = document.getElementById('enableSearch');
        if (search && Object.prototype.hasOwnProperty.call(savedMenu, 'search')) {
            search.checked = savedMenu.search === true;
        }

        const favorites = document.getElementById('showFavorites');
        if (favorites && Object.prototype.hasOwnProperty.call(savedMenu, 'favorites')) {
            favorites.checked = savedMenu.favorites === true;
        }

        savedMenu.groups.forEach((savedGroup) => {
            const group = addGroup(
                String(savedGroup?.label ?? 'Principale'),
                String(savedGroup?.icon ?? 'bi-folder2-open')
            );
            const direct = group.querySelector(':scope > .card-body > [data-dropzone]');

            (Array.isArray(savedGroup?.items) ? savedGroup.items : [])
                .forEach((savedItem) => appendSavedItem(direct, savedItem));

            (Array.isArray(savedGroup?.subgroups) ? savedGroup.subgroups : [])
                .forEach((savedSubgroup) => {
                    const subgroup = addSubgroup(group, String(savedSubgroup?.label ?? 'Sottogruppo'));
                    const zone = subgroup.querySelector('[data-dropzone]');
                    (Array.isArray(savedSubgroup?.items) ? savedSubgroup.items : [])
                        .forEach((savedItem) => appendSavedItem(zone, savedItem));
                });
        });
    }

    // ---------------------------------------------------------
    // Eventi pagina
    // ---------------------------------------------------------
    document.querySelectorAll('[data-menu-item]').forEach(bindItem);
    bindDropzones(document);

    document.getElementById('addGroup')?.addEventListener('click', () => {
        const name = window.prompt('Nome del nuovo gruppo:', 'Nuovo gruppo');
        if (name === null || !name.trim()) return;
        addGroup(name.trim());
    });

    document.getElementById('createGroupFromSelection')?.addEventListener('click', () => {
        const selected = selectedUnassignedItems();
        if (!selected.length) {
            window.alert('Seleziona prima una o più tabelle.');
            return;
        }

        const name = window.prompt('Nome del gruppo:', 'Nuovo gruppo');
        if (name === null || !name.trim()) return;

        const group = addGroup(name.trim());
        const zone = group.querySelector(':scope > .card-body > [data-dropzone]');
        moveSelectedTo(zone);
    });

    document.getElementById('addManualItem')?.addEventListener('click', () => {
        let group = groupCards()[0];
        if (!group) group = addGroup('Principale');

        const zone = group.querySelector(':scope > .card-body > [data-dropzone]');
        const item = createManualItem();
        const hint = zone.querySelector(':scope > .menu-empty-hint');
        zone.insertBefore(item, hint || null);
        syncStructure();
    });

    document.getElementById('selectVisible')?.addEventListener('click', () => {
        sourceZone.querySelectorAll(':scope > [data-menu-item]:not(.menu-filter-hidden) [data-item-select]')
            .forEach((checkbox) => { checkbox.checked = true; });
        updateSelectionCount();
    });

    document.getElementById('clearSelection')?.addEventListener('click', () => {
        document.querySelectorAll('[data-item-select]').forEach((checkbox) => { checkbox.checked = false; });
        updateSelectionCount();
    });

    assignSelected?.addEventListener('click', () => {
        const key = bulkTarget.value;
        if (!key) return;
        const zone = document.querySelector(`[data-dropzone][data-zone-key="${CSS.escape(key)}"]`);
        if (zone) moveSelectedTo(zone);
    });

    sourceSearch?.addEventListener('input', applySourceSearch);

    bulkTarget?.addEventListener('change', () => {
        assignSelected.disabled = bulkTarget.disabled || bulkTarget.value === '';
    });

    document.querySelectorAll('[data-preview-mode]').forEach((button) => {
        button.addEventListener('click', () => {
            previewMode = button.dataset.previewMode || 'vertical';
            document.querySelectorAll('[data-preview-mode]').forEach((candidate) => {
                const active = candidate === button;
                candidate.classList.toggle('btn-primary', active);
                candidate.classList.toggle('btn-outline-primary', !active);
            });
            renderPreview();
        });
    });

    document.getElementById('enableSearch')?.addEventListener('change', renderPreview);
    document.getElementById('showFavorites')?.addEventListener('change', renderPreview);

    form?.addEventListener('submit', (event) => {
        syncPositionOnly();
        const assigned = structure.querySelectorAll('[data-menu-item]').length;
        if (!assigned) {
            event.preventDefault();
            window.alert('Il menu è vuoto. Assegna almeno una voce a un gruppo.');
        }
    });

    hydrateSavedMenu();
    syncStructure();
    applySourceSearch();
})();
</script>

<?= $this->endSection() ?>
