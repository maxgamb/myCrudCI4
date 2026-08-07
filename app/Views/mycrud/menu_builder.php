<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h3 mb-1"><i class="bi bi-list"></i> Generatore Menu</h1>
            <p class="text-body-secondary mb-0">
                Costruisci una navigazione indipendente da myCrudGpt partendo dalle tabelle e dalle relazioni SQL.
            </p>
        </div>
    </div>

    <div class="alert alert-info">
        Le relazioni SQL sono usate solo per suggerire i gruppi. Etichette, route, icone e raggruppamenti restano una decisione dello sviluppatore.
    </div>

    <form method="post" action="<?= site_url('mycrud/tools/menu/generate') ?>" id="menuBuilderForm">
        <?= csrf_field() ?>

        <div class="card shadow-sm mb-3">
            <div class="card-body row g-3 align-items-end">
                <div class="col-md-4">
                    <label class="form-label" for="menuType">Tipo menu predefinito</label>
                    <select class="form-select" id="menuType" name="menuType">
                        <option value="vertical">Verticale</option>
                        <option value="horizontal">Orizzontale</option>
                    </select>
                    <div class="form-text">Entrambi i renderer vengono comunque generati.</div>
                </div>

                <div class="col-md-4">
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="force" name="force">
                        <label class="form-check-label" for="force">Sovrascrivi i file menu già presenti nello staging</label>
                    </div>
                </div>

                <div class="col-md-4 text-md-end">
                    <button type="button" class="btn btn-outline-secondary" id="addManualItem">
                        <i class="bi bi-plus-circle"></i> Voce manuale
                    </button>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <strong>Voci</strong>
                <span class="badge text-bg-secondary"><?= count($items) ?> tabelle rilevate</span>
            </div>

            <div class="table-responsive">
                <table class="table table-sm table-striped align-middle mb-0">
                    <thead>
                        <tr>
                            <th>Usa</th>
                            <th>Origine</th>
                            <th>Relazione suggerita</th>
                            <th>Etichetta</th>
                            <th>Route</th>
                            <th>Icona</th>
                            <th>Gruppo</th>
                            <th>Ordine gruppo</th>
                            <th>Ordine voce</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody id="menuItemsBody">
                        <?php foreach ($items as $index => $item): ?>
                            <tr data-menu-row>
                                <td>
                                    <input type="hidden" name="items[<?= $index ?>][table]" value="<?= esc($item['table']) ?>">
                                    <input class="form-check-input" type="checkbox" name="items[<?= $index ?>][enabled]" value="1" checked>
                                </td>
                                <td><code><?= esc($item['table']) ?></code></td>
                                <td>
                                    <?php if ($item['relationHint'] !== ''): ?>
                                        <span class="badge text-bg-light border"><?= esc($item['relationHint']) ?></span>
                                    <?php else: ?>
                                        <span class="text-body-secondary">—</span>
                                    <?php endif ?>
                                </td>
                                <td><input class="form-control form-control-sm" name="items[<?= $index ?>][label]" value="<?= esc($item['label']) ?>"></td>
                                <td><input class="form-control form-control-sm" name="items[<?= $index ?>][route]" value="<?= esc($item['route']) ?>"></td>
                                <td><input class="form-control form-control-sm" name="items[<?= $index ?>][icon]" value="<?= esc($item['icon']) ?>"></td>
                                <td><input class="form-control form-control-sm" name="items[<?= $index ?>][group]" value="<?= esc($item['group']) ?>"></td>
                                <td><input class="form-control form-control-sm" type="number" name="items[<?= $index ?>][groupOrder]" value="<?= esc((string) $item['groupOrder']) ?>" min="0" step="10"></td>
                                <td><input class="form-control form-control-sm" type="number" name="items[<?= $index ?>][order]" value="<?= esc((string) $item['order']) ?>" min="0" step="10"></td>
                                <td></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="d-flex gap-2">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-gear"></i> Genera menu
            </button>
            <a class="btn btn-outline-secondary" href="<?= site_url('mycrud') ?>">Annulla</a>
        </div>
    </form>
</div>

<template id="manualItemTemplate">
    <tr data-menu-row>
        <td>
            <input type="hidden" data-name="table" value="">
            <input class="form-check-input" type="checkbox" data-name="enabled" value="1" checked>
        </td>
        <td><span class="badge text-bg-secondary">Manuale</span></td>
        <td><span class="text-body-secondary">—</span></td>
        <td><input class="form-control form-control-sm" data-name="label" value="Nuova voce"></td>
        <td><input class="form-control form-control-sm" data-name="route" value=""></td>
        <td><input class="form-control form-control-sm" data-name="icon" value="bi-link-45deg"></td>
        <td><input class="form-control form-control-sm" data-name="group" value="Principale"></td>
        <td><input class="form-control form-control-sm" type="number" data-name="groupOrder" value="10" min="0" step="10"></td>
        <td><input class="form-control form-control-sm" type="number" data-name="order" value="10" min="0" step="10"></td>
        <td>
            <button type="button" class="btn btn-sm btn-outline-danger" data-remove-menu-row aria-label="Rimuovi">
                <i class="bi bi-trash"></i>
            </button>
        </td>
    </tr>
</template>

<?= $this->endSection() ?>
<?= $this->section('scripts') ?>
<script>
(() => {
    const body = document.getElementById('menuItemsBody');
    const template = document.getElementById('manualItemTemplate');
    const addButton = document.getElementById('addManualItem');

    let manualIndex = <?= count($items) ?>;

    function nextIndex() {
        const index = manualIndex;
        manualIndex += 1;
        return index;
    }

    function assignNames(row, index) {
        row.querySelectorAll('[data-name]').forEach((control) => {
            control.name = `items[${index}][${control.dataset.name}]`;
            control.removeAttribute('data-name');
        });
    }

    addButton?.addEventListener('click', () => {
        const fragment = template.content.cloneNode(true);
        const row = fragment.querySelector('[data-menu-row]');
        assignNames(row, nextIndex());
        body.appendChild(fragment);
    });

    body?.addEventListener('click', (event) => {
        const button = event.target.closest('[data-remove-menu-row]');
        if (!button) return;
        button.closest('[data-menu-row]')?.remove();
    });
})();
</script>
<?= $this->endSection() ?>
