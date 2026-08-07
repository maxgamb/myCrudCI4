<?php
/*
 * Filtro dinamico del sito.
 * Ogni riga rappresenta una condizione: campo, operatore, valore e AND/OR.
 * La whitelist reale viene ricontrollata dal Model: i valori del browser non
 * vengono mai usati direttamente come nomi colonna o operatori SQL.
 */
$filterDefinitions = [
    'conto_nota_id' => [
        'label' => lang('ContiNote.conto_nota_id'),
        'input' => 'number',
        'operators' => array (
  0 => 'eq',
  1 => 'neq',
  2 => 'gt',
  3 => 'gte',
  4 => 'lt',
  5 => 'lte',
  6 => 'between',
  7 => 'is_null',
  8 => 'not_null',
),
        'relation' => NULL,
    ],
    'conto_id' => [
        'label' => lang('ContiNote.conto_id'),
        'input' => 'select',
        'operators' => array (
  0 => 'eq',
  1 => 'neq',
),
        'relation' => 'conto_id',
    ],
];
$activeFilters = array_values(array_filter(
    (array) ($filters ?? []),
    static fn ($filter): bool => is_array($filter) && trim((string) ($filter['field'] ?? '')) !== ''
));
?>

<form id="crudFiltersForm" method="get" action="<?= site_url('conti_note') ?>">
    <input type="hidden" name="sort" value="<?= esc($sort ?? 'conto_nota_id') ?>">
    <input type="hidden" name="direction" value="<?= esc($direction ?? 'desc') ?>">

    <div id="crudFilterRows"></div>

    <?php if ($filterDefinitions === []): ?>
        <div class="alert alert-light border mb-3">
            Nessun campo filtrabile disponibile nella configurazione corrente.
        </div>
    <?php endif; ?>

    <div class="row g-2 align-items-end">
        <div class="col-6 col-md-2">
            <label for="crudPerPage" class="form-label">Righe</label>
            <select id="crudPerPage" name="perPage" class="form-select">
                <?php foreach ([25, 50, 100] as $size): ?>
                    <option value="<?= $size ?>" <?= (int) ($perPage ?? 25) === $size ? 'selected' : '' ?>>
                        <?= $size ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="col-12 col-md-auto">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-search"></i> Cerca
            </button>
            <button type="button" id="crudAddFilter" class="btn btn-outline-primary" <?= $filterDefinitions === [] ? 'disabled' : '' ?>>
                <i class="bi bi-plus-circle"></i> Aggiungi filtro
            </button>
            <a href="<?= site_url('conti_note') ?>" class="btn btn-outline-secondary js-reset-filters">
                Azzera
            </a>
        </div>
    </div>
</form>

<script>
document.addEventListener('DOMContentLoaded', () => {
    /*
     * Runtime lato sito del filtro dinamico. Costruiamo solo controlli HTML;
     * l'interpretazione sicura di campo/operatore avviene sempre nel Model.
     */
    const definitions = <?= json_encode($filterDefinitions, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    const relationOptions = <?= json_encode((array) ($options ?? []), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    const relationBaseUrl = <?= json_encode(site_url('conti_note/relation-options'), JSON_UNESCAPED_SLASHES) ?>;
    const initialFilters = <?= json_encode($activeFilters, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    const rowsContainer = document.getElementById('crudFilterRows');
    const addButton = document.getElementById('crudAddFilter');

    if (!rowsContainer || !addButton) {
        return;
    }

    const operatorLabels = {
        eq: '=',
        neq: '≠',
        gt: '>',
        gte: '≥',
        lt: '<',
        lte: '≤',
        between: 'Tra',
        starts_with: 'Inizia con',
        contains: 'Contiene',
        ends_with: 'Finisce con',
        is_null: 'Vuoto / NULL',
        not_null: 'Non vuoto / NOT NULL'
    };

    const escapeHtml = value => String(value ?? '')
        .replaceAll('&', '&amp;')
        .replaceAll('<', '&lt;')
        .replaceAll('>', '&gt;')
        .replaceAll('"', '&quot;')
        .replaceAll("'", '&#039;');

    const renumberRows = () => {
        [...rowsContainer.querySelectorAll('.js-filter-row')].forEach((row, index) => {
            row.dataset.index = String(index);
            row.querySelectorAll('[data-filter-part]').forEach(input => {
                input.name = `filters[${index}][${input.dataset.filterPart}]`;
            });

            const logic = row.querySelector('[data-filter-part="logic"]');
            if (logic) {
                const isLast = index === rowsContainer.querySelectorAll('.js-filter-row').length - 1;
                logic.disabled = isLast;
                if (isLast) {
                    logic.value = 'and';
                }
            }
        });
    };

    const valueMarkup = (field, filter) => {
        const definition = definitions[field] || {};
        const input = definition.input || 'text';
        const operator = filter.operator || (definition.operators || ['eq'])[0] || 'eq';
        const value = escapeHtml(filter.value ?? '');
        const valueTo = escapeHtml(filter.value_to ?? '');

        if (operator === 'is_null' || operator === 'not_null') {
            return '<div class="form-control bg-body-secondary text-muted">Nessun valore richiesto</div>';
        }

        if (input === 'relation_ajax') {
            return `<div class="js-filter-relation" data-field="${escapeHtml(field)}">
                <input type="hidden" data-filter-part="value" value="${value}">
                <input type="search" class="form-control js-filter-relation-search" value="${value}" placeholder="Cerca…" autocomplete="off">
                <select class="form-select mt-2 d-none js-filter-relation-results" size="5"></select>
            </div>`;
        }

        if (input === 'select') {
            const options = relationOptions[field] || {};
            const optionHtml = Object.entries(options).map(([optionValue, optionLabel]) =>
                `<option value="${escapeHtml(optionValue)}" ${String(filter.value ?? '') === String(optionValue) ? 'selected' : ''}>${escapeHtml(optionLabel)}</option>`
            ).join('');
            return `<select class="form-select" data-filter-part="value"><option value="">Seleziona…</option>${optionHtml}</select>`;
        }

        if (input === 'boolean') {
            return `<select class="form-select" data-filter-part="value">
                <option value="">Seleziona…</option>
                <option value="1" ${String(filter.value ?? '') === '1' ? 'selected' : ''}>Sì</option>
                <option value="0" ${String(filter.value ?? '') === '0' ? 'selected' : ''}>No</option>
            </select>`;
        }

        const htmlType = ['number', 'date', 'datetime-local', 'time'].includes(input) ? input : 'text';
        const step = htmlType === 'number' ? ' step="any"' : '';
        const first = `<input type="${htmlType}"${step} class="form-control" data-filter-part="value" value="${value}">`;

        if (operator === 'between') {
            return `<div class="input-group">${first}<span class="input-group-text">e</span><input type="${htmlType}"${step} class="form-control" data-filter-part="value_to" value="${valueTo}"></div>`;
        }

        return first;
    };

    const refreshRow = row => {
        const fieldSelect = row.querySelector('[data-filter-part="field"]');
        const operatorSelect = row.querySelector('[data-filter-part="operator"]');
        const valueContainer = row.querySelector('.js-filter-value');
        if (!fieldSelect || !operatorSelect || !valueContainer) {
            return;
        }

        const field = fieldSelect.value;
        const definition = definitions[field] || { operators: ['eq'] };
        const previousOperator = operatorSelect.value;
        operatorSelect.innerHTML = (definition.operators || ['eq'])
            .map(operator => `<option value="${escapeHtml(operator)}">${escapeHtml(operatorLabels[operator] || operator)}</option>`)
            .join('');
        operatorSelect.value = (definition.operators || []).includes(previousOperator)
            ? previousOperator
            : ((definition.operators || ['eq'])[0] || 'eq');

        const currentValue = valueContainer.querySelector('[data-filter-part="value"]')?.value ?? '';
        const currentValueTo = valueContainer.querySelector('[data-filter-part="value_to"]')?.value ?? '';
        valueContainer.innerHTML = valueMarkup(field, {
            operator: operatorSelect.value,
            value: currentValue,
            value_to: currentValueTo
        });
        renumberRows();
    };

    const addRow = (filter = {}, afterRow = null) => {
        const fields = Object.keys(definitions);
        if (fields.length === 0) {
            return;
        }

        const selectedField = definitions[filter.field] ? filter.field : fields[0];
        const definition = definitions[selectedField];
        const selectedOperator = (definition.operators || []).includes(filter.operator)
            ? filter.operator
            : ((definition.operators || ['eq'])[0] || 'eq');

        const row = document.createElement('div');
        row.className = 'row g-2 align-items-end mb-2 js-filter-row';
        row.innerHTML = `
            <div class="col-12 col-md-3">
                <label class="form-label">Campo</label>
                <select class="form-select" data-filter-part="field">
                    ${fields.map(field => `<option value="${escapeHtml(field)}" ${field === selectedField ? 'selected' : ''}>${escapeHtml(definitions[field].label || field)}</option>`).join('')}
                </select>
            </div>
            <div class="col-6 col-md-2">
                <label class="form-label">Criterio</label>
                <select class="form-select" data-filter-part="operator">
                    ${(definition.operators || ['eq']).map(operator => `<option value="${escapeHtml(operator)}" ${operator === selectedOperator ? 'selected' : ''}>${escapeHtml(operatorLabels[operator] || operator)}</option>`).join('')}
                </select>
            </div>
            <div class="col-12 col-md-4 js-filter-value">
                <label class="form-label">Valore</label>
                ${valueMarkup(selectedField, {...filter, operator: selectedOperator})}
            </div>
            <div class="col-6 col-md-1">
                <label class="form-label">Logica</label>
                <select class="form-select" data-filter-part="logic">
                    <option value="and" ${(filter.logic || 'and') === 'and' ? 'selected' : ''}>AND</option>
                    <option value="or" ${filter.logic === 'or' ? 'selected' : ''}>OR</option>
                </select>
            </div>
            <div class="col-6 col-md-2">
                <button type="button" class="btn btn-outline-primary js-add-filter" title="Aggiungi riga"><i class="bi bi-plus"></i></button>
                <button type="button" class="btn btn-outline-danger js-remove-filter" title="Rimuovi riga"><i class="bi bi-dash"></i></button>
            </div>
        `;

        if (afterRow instanceof HTMLElement && afterRow.parentElement === rowsContainer) {
            afterRow.insertAdjacentElement('afterend', row);
        } else {
            rowsContainer.appendChild(row);
        }
        renumberRows();
    };

    const relationTimers = new WeakMap();
    const relationControllers = new WeakMap();

    rowsContainer.addEventListener('input', event => {
        const input = event.target.closest('.js-filter-relation-search');
        if (!input) return;

        const wrapper = input.closest('.js-filter-relation');
        const hidden = wrapper?.querySelector('[data-filter-part="value"]');
        const results = wrapper?.querySelector('.js-filter-relation-results');
        const field = wrapper?.dataset.field || '';
        if (!wrapper || !hidden || !results || !field) return;

        hidden.value = '';
        results.innerHTML = '';
        results.classList.add('d-none');

        const oldTimer = relationTimers.get(input);
        if (oldTimer) window.clearTimeout(oldTimer);

        const query = input.value.trim();
        if (query.length < 2) return;

        const timer = window.setTimeout(async () => {
            relationControllers.get(input)?.abort();
            const controller = new AbortController();
            relationControllers.set(input, controller);

            try {
                const response = await fetch(`${relationBaseUrl}/${encodeURIComponent(field)}?q=${encodeURIComponent(query)}`, {
                    headers: {'X-Requested-With': 'XMLHttpRequest'},
                    signal: controller.signal
                });
                if (!response.ok) throw new Error('Errore ricerca relazione');
                const payload = await response.json();
                const rows = Array.isArray(payload.results) ? payload.results : [];
                rows.forEach(row => {
                    const option = document.createElement('option');
                    option.value = String(row.id ?? '');
                    option.textContent = String(row.text ?? '');
                    results.appendChild(option);
                });
                results.classList.toggle('d-none', rows.length === 0);
            } catch (error) {
                if (error.name !== 'AbortError') console.error(error);
            }
        }, 350);
        relationTimers.set(input, timer);
    });

    rowsContainer.addEventListener('change', event => {
        const relationResults = event.target.closest('.js-filter-relation-results');
        if (relationResults) {
            const wrapper = relationResults.closest('.js-filter-relation');
            const hidden = wrapper?.querySelector('[data-filter-part="value"]');
            const search = wrapper?.querySelector('.js-filter-relation-search');
            const selected = relationResults.options[relationResults.selectedIndex];
            if (hidden && search && selected) {
                hidden.value = selected.value;
                search.value = selected.textContent || '';
                relationResults.classList.add('d-none');
            }
            return;
        }
        const row = event.target.closest('.js-filter-row');
        if (!row) {
            return;
        }
        if (event.target.matches('[data-filter-part="field"], [data-filter-part="operator"]')) {
            refreshRow(row);
        }
    });

    rowsContainer.addEventListener('click', event => {
        const add = event.target.closest('.js-add-filter');
        const remove = event.target.closest('.js-remove-filter');
        if (add) {
            addRow({}, add.closest('.js-filter-row'));
        }
        if (remove) {
            const row = remove.closest('.js-filter-row');
            row?.remove();
            if (rowsContainer.querySelectorAll('.js-filter-row').length === 0) {
                addRow();
            }
            renumberRows();
        }
    });

    addButton.addEventListener('click', () => addRow());

    if (initialFilters.length > 0) {
        initialFilters.forEach(filter => addRow(filter));
    } else if (Object.keys(definitions).length > 0) {
        addRow();
    }
});
</script>
