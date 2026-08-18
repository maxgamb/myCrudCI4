<?= $this->extend('layouts/default_crud') ?>
<?= $this->section('content') ?>

<?php
$globalFilterSlots = array_values((array) ($dashboard['globalFilters'] ?? []));
for ($i = count($globalFilterSlots); $i < 3; $i++) {
    $globalFilterSlots[] = [
        'enabled' => false,
        'id' => 'filter' . ($i + 1),
        'label' => '',
        'operator' => 'eq',
        'inputType' => 'text',
    ];
}
$globalFilterSlots = array_slice($globalFilterSlots, 0, 3);
?>

<div class="container-fluid py-4">
    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="text-primary small fw-semibold text-uppercase">Application Dashboard</div>
            <h1 class="h3 mb-1">Dashboard Builder</h1>
            <p class="text-muted mb-0">
                Reuse generated CRUD Models/Entities for record data and add Dashboard-specific DTO/query code only for aggregates.
            </p>
        </div>
        <span class="badge text-bg-secondary">Analytics</span>
    </div>

    <?php if (session('message')): ?>
        <div class="alert alert-success"><?= esc((string) session('message')) ?></div>
    <?php endif ?>
    <?php if (session('error')): ?>
        <div class="alert alert-danger"><?= esc((string) session('error')) ?></div>
    <?php endif ?>

    <form method="post" id="dashboardBuilderForm">
        <?= csrf_field() ?>

        <div class="card shadow-sm mb-4">
            <div class="card-header"><strong>General</strong></div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-12 col-lg-6">
                        <label class="form-label">Title</label>
                        <input
                            class="form-control"
                            name="title"
                            value="<?= esc(old('title', $dashboard['title'] ?? 'Application Dashboard')) ?>"
                            required
                        >
                    </div>
                    <div class="col-12 col-lg-6">
                        <label class="form-label">Application route</label>
                        <div class="input-group">
                            <span class="input-group-text">/</span>
                            <input
                                class="form-control"
                                name="route"
                                value="<?= esc(old('route', $dashboard['route'] ?? 'dashboard')) ?>"
                                pattern="[A-Za-z0-9/_-]+"
                                required
                            >
                        </div>
                    </div>
                </div>

                <div class="border rounded p-3 mt-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2">
                        <div>
                            <div class="fw-semibold"><i class="bi bi-calendar-range me-1"></i>Global date filter</div>
                            <div class="small text-muted">
                                Adds one From/To period control to the generated Dashboard.
                                Each widget can map it to a different DATE/DATETIME/TIMESTAMP field.
                            </div>
                        </div>
                        <div class="form-check form-switch">
                            <input
                                class="form-check-input"
                                type="checkbox"
                                name="globalDateEnabled"
                                value="1"
                                id="dashboard_global_date_enabled"
                                <?= !empty($dashboard['globalDateFilter']['enabled']) ? 'checked' : '' ?>
                            >
                            <label class="form-check-label" for="dashboard_global_date_enabled">Enabled</label>
                        </div>
                    </div>

                    <div class="row g-2">
                        <div class="col-12 col-lg-6">
                            <label class="form-label">Filter label</label>
                            <input
                                class="form-control"
                                name="globalDateLabel"
                                value="<?= esc((string) ($dashboard['globalDateFilter']['label'] ?? 'Period')) ?>"
                                maxlength="80"
                                placeholder="Period"
                            >
                        </div>
                    </div>
                </div>

                <div class="border rounded p-3 mt-3">
                    <div class="d-flex flex-wrap justify-content-between align-items-start gap-2 mb-2">
                        <div>
                            <div class="fw-semibold">
                                <i class="bi bi-funnel me-1"></i>Global filters
                            </div>
                            <div class="small text-muted">
                                Configure up to three Dashboard-wide filters. Each widget can map a global filter
                                to one of its own CRUD fields.
                            </div>
                        </div>
                        <span class="badge text-bg-light border">Max 3</span>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-sm align-middle mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 7rem;">Enabled</th>
                                    <th>Key</th>
                                    <th>Label</th>
                                    <th>Operator</th>
                                    <th>Input</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($globalFilterSlots as $filterIndex => $globalFilter): ?>
                                    <tr>
                                        <td>
                                            <div class="form-check form-switch mb-0">
                                                <input
                                                    class="form-check-input"
                                                    type="checkbox"
                                                    name="globalFilters[<?= $filterIndex ?>][enabled]"
                                                    value="1"
                                                    <?= !empty($globalFilter['enabled']) ? 'checked' : '' ?>
                                                >
                                            </div>
                                        </td>
                                        <td>
                                            <input
                                                class="form-control form-control-sm"
                                                name="globalFilters[<?= $filterIndex ?>][id]"
                                                data-global-definition-key="<?= $filterIndex ?>"
                                                value="<?= esc((string) ($globalFilter['id'] ?? ('filter' . ($filterIndex + 1)))) ?>"
                                                pattern="[A-Za-z][A-Za-z0-9_]*"
                                                maxlength="40"
                                                placeholder="store"
                                            >
                                        </td>
                                        <td>
                                            <input
                                                class="form-control form-control-sm"
                                                name="globalFilters[<?= $filterIndex ?>][label]"
                                                data-global-definition-label="<?= $filterIndex ?>"
                                                value="<?= esc((string) ($globalFilter['label'] ?? '')) ?>"
                                                maxlength="80"
                                                placeholder="Store"
                                            >
                                        </td>
                                        <td>
                                            <select
                                                class="form-select form-select-sm"
                                                name="globalFilters[<?= $filterIndex ?>][operator]"
                                            >
                                                <?php foreach ([
                                                    'eq' => '=',
                                                    'neq' => '!=',
                                                    'gt' => '>',
                                                    'gte' => '>=',
                                                    'lt' => '<',
                                                    'lte' => '<=',
                                                    'contains' => 'contains',
                                                    'starts_with' => 'starts with',
                                                ] as $operatorKey => $operatorLabel): ?>
                                                    <option
                                                        value="<?= esc($operatorKey) ?>"
                                                        <?= ($globalFilter['operator'] ?? 'eq') === $operatorKey ? 'selected' : '' ?>
                                                    >
                                                        <?= esc($operatorLabel) ?>
                                                    </option>
                                                <?php endforeach ?>
                                            </select>
                                        </td>
                                        <td>
                                            <select
                                                class="form-select form-select-sm"
                                                name="globalFilters[<?= $filterIndex ?>][inputType]"
                                            >
                                                <option value="text" <?= ($globalFilter['inputType'] ?? 'text') === 'text' ? 'selected' : '' ?>>
                                                    Text
                                                </option>
                                                <option value="number" <?= ($globalFilter['inputType'] ?? 'text') === 'number' ? 'selected' : '' ?>>
                                                    Number
                                                </option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="form-text mt-2">
                        Example: key <code>store</code>, label <code>Store</code>, operator <code>=</code>.
                        Widget mappings decide which field receives the runtime value.
                    </div>
                </div>

                <div class="alert alert-light border mt-3 mb-0 small">
                    <strong>Architecture:</strong>
                    recent-record widgets reuse existing generated Models and therefore receive configured Entities when the CRUD uses them.
                    KPI/aggregate widgets return small Dashboard DTOs. Dashboard-only SQL stays in <code>DashboardQuery</code>.
                </div>
            </div>
        </div>

        <div class="card shadow-sm mb-4">
            <div class="card-header d-flex flex-wrap justify-content-between align-items-center gap-2">
                <strong>Widgets</strong>
                <div class="btn-group btn-group-sm">
                    <button type="button" class="btn btn-outline-primary" data-add-widget="kpi_count">
                        <i class="bi bi-speedometer2 me-1"></i>KPI Count
                    </button>
                    <button type="button" class="btn btn-outline-primary" data-add-widget="kpi_aggregate">
                        <i class="bi bi-calculator me-1"></i>KPI Aggregate
                    </button>
                    <button type="button" class="btn btn-outline-primary" data-add-widget="grouped_chart">
                        <i class="bi bi-bar-chart me-1"></i>Grouped chart
                    </button>
                    <button type="button" class="btn btn-outline-primary" data-add-widget="recent">
                        <i class="bi bi-clock-history me-1"></i>Recent records
                    </button>
                    <button type="button" class="btn btn-outline-primary" data-add-widget="quick_link">
                        <i class="bi bi-link-45deg me-1"></i>Quick link
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="alert alert-info small py-2">
                    <strong>Compact workflow:</strong>
                    configure the widget's core behavior first. Presentation, global-period mapping,
                    Dashboard-wide filter mappings, and local filtering are grouped as advanced options.
                </div>

                <div id="dashboardWidgets" class="row g-3 align-items-start">
                    <?php foreach ((array) ($dashboard['widgets'] ?? []) as $index => $widget): ?>
                        <?php $id = (string) ($widget['id'] ?? ('widget_' . $index)); ?>
                        <?= view('mycrud/dashboard_widget', [
                            'id' => $id,
                            'widget' => $widget,
                            'tables' => $tables,
                            'tableMeta' => $tableMeta,
                            'globalFilters' => $globalFilterSlots,
                        ]) ?>
                    <?php endforeach ?>
                </div>

                <div id="noDashboardWidgets" class="text-muted text-center py-4 <?= ($dashboard['widgets'] ?? []) !== [] ? 'd-none' : '' ?>">
                    No widgets configured. Add a KPI, recent-record panel, or quick link.
                </div>
            </div>
        </div>

        <div class="sticky-bottom bg-light border-top py-3">
            <div class="d-flex flex-wrap justify-content-between gap-2">
                <a href="<?= site_url('mycrud') ?>" class="btn btn-secondary">Back</a>
                <div class="d-flex flex-wrap gap-2 align-items-center">
                    <div class="form-check form-switch me-2">
                        <input class="form-check-input" type="checkbox" name="force" value="1" id="dashboard_force">
                        <label class="form-check-label small" for="dashboard_force">Overwrite Dashboard files on publish</label>
                    </div>
                    <button formaction="<?= site_url('mycrud/dashboard/save') ?>" class="btn btn-outline-success">
                        <i class="bi bi-floppy me-1"></i>Save configuration
                    </button>
                    <button formaction="<?= site_url('mycrud/dashboard/generate') ?>" class="btn btn-warning">
                        <i class="bi bi-gear me-1"></i>Generate to staging
                    </button>
                    <button
                        formaction="<?= site_url('mycrud/dashboard/publish') ?>"
                        class="btn btn-primary"
                        onclick="return confirm('Publish generated Dashboard files to app/?')"
                    >
                        <i class="bi bi-box-arrow-up me-1"></i>Publish
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>

<template id="dashboardWidgetTemplate">
    <?= view('mycrud/dashboard_widget', [
        'id' => '__ID__',
        'widget' => [
            'type' => '__TYPE__',
            'title' => '',
            'table' => '',
            'limit' => 5,
            'width' => 4,
            'decimals' => 0,
            'prefix' => '',
            'suffix' => '',
            'filterField' => '',
            'filterOperator' => 'eq',
            'filterValue' => '',
            'globalDateField' => '',
            'globalFilterFields' => [],
            'dateGroup' => 'raw',
            'recentFields' => [],
        ],
        'tables' => $tables,
        'tableMeta' => $tableMeta,
        'globalFilters' => $globalFilterSlots,
    ]) ?>
</template>


<style>
.dashboard-widget-slot {
    display: flex;
}
.dashboard-widget {
    border-color: var(--bs-border-color);
    width: 100%;
}
.dashboard-widget-slot.sortable-ghost {
    opacity: .35;
}
.dashboard-widget-slot.sortable-chosen .dashboard-widget {
    box-shadow: var(--bs-box-shadow) !important;
}
.dashboard-widget-header {
    background: var(--bs-tertiary-bg);
}
.dashboard-widget-drag {
    cursor: grab;
}
.dashboard-widget-drag:active {
    cursor: grabbing;
}
.dashboard-widget .form-label {
    color: var(--bs-secondary-color);
}
.dashboard-widget-primary-options:empty {
    display: none;
}
.dashboard-option-panel {
    border: 1px solid var(--bs-border-color);
    border-radius: .5rem;
    background: var(--bs-body-bg);
}
.dashboard-option-panel > summary {
    list-style: none;
    cursor: pointer;
    padding: .55rem .7rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: .5rem;
    font-size: .875rem;
    font-weight: 600;
}
.dashboard-option-panel > summary::-webkit-details-marker {
    display: none;
}
.dashboard-option-panel > summary::after {
    content: "›";
    transform: rotate(90deg);
    transition: transform .15s ease;
    color: var(--bs-secondary-color);
}
.dashboard-option-panel[open] > summary::after {
    transform: rotate(-90deg);
}
.dashboard-option-panel-body {
    border-top: 1px solid var(--bs-border-color);
    padding: .7rem;
}
.dashboard-widget-summary-title {
    max-width: 15rem;
}
.dashboard-widget-preview {
    min-height: 4.25rem;
}
.dashboard-preview-kpi {
    border-left: .25rem solid var(--bs-primary);
    padding-left: .65rem;
}
.dashboard-preview-kpi-value {
    font-size: 1.35rem;
    font-weight: 600;
    line-height: 1.1;
}
.dashboard-preview-bars {
    height: 3.25rem;
    display: flex;
    align-items: end;
    gap: .3rem;
}
.dashboard-preview-bar {
    flex: 1 1 0;
    min-width: .35rem;
    background: var(--bs-primary);
    opacity: .55;
    border-radius: .2rem .2rem 0 0;
}
.dashboard-preview-table {
    font-size: .72rem;
}
.dashboard-preview-table th,
.dashboard-preview-table td {
    padding: .15rem .25rem;
    white-space: nowrap;
}
.dashboard-widget-header {
    min-height: 4.25rem;
}
.dashboard-widget .dashboard-widget-advanced .row > [class*="col-"] {
    min-width: 0;
}
.min-w-0 {
    min-width: 0;
}
@media (max-width: 1199.98px) {
    .dashboard-widget-summary-title {
        max-width: 14rem;
    }
}
@media (max-width: 767.98px) {
    .dashboard-widget-summary-title {
        max-width: 12rem;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Sortable/1.15.2/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    const tableMeta = <?= json_encode($tableMeta ?? [], JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) ?>;
    const list = document.getElementById('dashboardWidgets');
    const template = document.getElementById('dashboardWidgetTemplate');
    const empty = document.getElementById('noDashboardWidgets');
    const globalDefinitionKeys = Array.from(document.querySelectorAll('[data-global-definition-key]'));
    const globalDefinitionLabels = Array.from(document.querySelectorAll('[data-global-definition-label]'));

    const syncGlobalDefinitionMappings = (scope = document) => {
        globalDefinitionKeys.forEach((keyInput) => {
            const slot = keyInput.dataset.globalDefinitionKey || '';
            const key = (keyInput.value || '').trim() || `filter${Number(slot) + 1}`;
            const labelInput = globalDefinitionLabels.find(
                (input) => input.dataset.globalDefinitionLabel === slot
            );
            const label = (labelInput?.value || '').trim() || key;

            scope.querySelectorAll(`[data-global-filter-slot="${slot}"]`).forEach((select) => {
                select.dataset.globalFilterId = key;
                select.name = select.name.replace(
                    /\[globalFilterFields\]\[[^\]]*\]$/,
                    `[globalFilterFields][${key}]`
                );

                const labelTarget = select
                    .closest('[data-global-filter-mapping-row]')
                    ?.querySelector('[data-global-filter-map-label]');
                if (labelTarget) labelTarget.textContent = label;
            });
        });
    };

    globalDefinitionKeys.forEach((input) => {
        input.addEventListener('input', () => syncGlobalDefinitionMappings(document));
    });
    globalDefinitionLabels.forEach((input) => {
        input.addEventListener('input', () => syncGlobalDefinitionMappings(document));
    });

    const refresh = () => {
        empty?.classList.toggle('d-none', list.children.length > 0);
        Array.from(list.querySelectorAll('.dashboard-widget-slot')).forEach((item) => {
            const order = item.querySelector('[data-widget-order]');
            if (order) order.value = item.dataset.widgetId || '';
        });
    };

    document.querySelectorAll('[data-add-widget]').forEach((button) => {
        button.addEventListener('click', () => {
            const type = button.dataset.addWidget || 'kpi_count';
            const id = 'widget_' + Date.now().toString(36) + '_' + Math.random().toString(36).slice(2, 7);
            const html = template.innerHTML
                .replaceAll('__ID__', id)
                .replaceAll('__TYPE__', type);
            const wrapper = document.createElement('div');
            wrapper.innerHTML = html.trim();
            const item = wrapper.firstElementChild;
            if (!item) return;
            list.appendChild(item);
            bind(item);
            refresh();
        });
    });

    function bind(item) {
        item.querySelector('[data-remove-widget]')?.addEventListener('click', () => {
            item.remove();
            refresh();
        });

        const type = item.querySelector('[data-widget-type]');
        const table = item.querySelector('[data-dashboard-table]');
        const title = item.querySelector('[data-widget-title]');
        const operation = item.querySelector('[data-dashboard-operation]');
        const limit = item.querySelector('[data-widget-limit]');
        const limitWrap = item.querySelector('[data-limit-wrap]');
        const operationWrap = item.querySelector('[data-operation-wrap]');
        const valueWrap = item.querySelector('[data-value-field-wrap]');
        const groupWrap = item.querySelector('[data-group-field-wrap]');
        const chartWrap = item.querySelector('[data-chart-type-wrap]');
        const dateGroupWrap = item.querySelector('[data-date-group-wrap]');
        const dateGroup = item.querySelector('[data-date-group]');
        const kpiFormatWrap = item.querySelector('[data-kpi-format-wrap]');
        const advancedWrap = item.querySelector('[data-advanced-wrap]');
        const filterWrap = item.querySelector('[data-filter-wrap]');
        const valueSelect = item.querySelector('[data-value-field]');
        const groupSelect = item.querySelector('[data-group-field]');
        const filterSelect = item.querySelector('[data-filter-field]');
        const filterOperator = item.querySelector('[data-filter-operator]');
        const filterValue = item.querySelector('[data-filter-value]');
        const globalDateSelect = item.querySelector('[data-global-date-field]');
        const globalFilterSelects = Array.from(item.querySelectorAll('[data-global-filter-field]'));
        const globalFilterStatus = item.querySelector('[data-global-filter-status]');
        const recentFieldsWrap = item.querySelector('[data-recent-fields-wrap]');
        const recentFieldsSelect = item.querySelector('[data-recent-fields]');
        const recentFieldsStatus = item.querySelector('[data-recent-fields-status]');
        const recentUp = item.querySelector('[data-recent-up]');
        const recentDown = item.querySelector('[data-recent-down]');
        const widthSelect = item.querySelector('[data-widget-width]');
        const widthGuidance = item.querySelector('[data-width-guidance]');
        const chartGuidance = item.querySelector('[data-chart-guidance]');
        const preview = item.querySelector('[data-widget-preview]');

        const summaryTitle = item.querySelector('[data-widget-summary-title]');
        const summaryType = item.querySelector('[data-widget-summary-type]');
        const summarySource = item.querySelector('[data-widget-summary-source]');
        const summaryDetail = item.querySelector('[data-widget-summary-detail]');
        const filterStatus = item.querySelector('[data-filter-status]');
        const periodStatus = item.querySelector('[data-period-status]');
        const presentationStatus = item.querySelector('[data-presentation-status]');

        const typeLabels = {
            kpi_count: 'KPI Count',
            kpi_aggregate: 'KPI Aggregate',
            grouped_chart: 'Grouped chart',
            recent: 'Recent records',
            quick_link: 'Quick link'
        };

        const populate = (select, values, placeholder, labels = {}) => {
            if (!select) return;
            const selected = select.dataset.selected || select.value || '';
            select.innerHTML = '';

            const emptyOption = document.createElement('option');
            emptyOption.value = '';
            emptyOption.textContent = placeholder;
            select.appendChild(emptyOption);

            values.forEach((value) => {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = labels?.[value] || value;
                if (value === selected) option.selected = true;
                select.appendChild(option);
            });
        };

        const currentMeta = () => tableMeta[table?.value || ''] || {
            fields: [],
            numericFields: [],
            labels: {},
            recentFields: [],
            dateFields: [],
            relationFields: {},
            primaryKey: 'id'
        };

        const rebuildRecentFields = (meta, selected = null) => {
            if (!recentFieldsSelect) return;

            const selectedValues = Array.isArray(selected)
                ? selected
                : Array.from(recentFieldsSelect.selectedOptions).map((option) => option.value);

            recentFieldsSelect.innerHTML = '';

            const ordered = [
                ...selectedValues.filter((value) => (meta.fields || []).includes(value)),
                ...(meta.fields || []).filter((value) => !selectedValues.includes(value))
            ];

            ordered.forEach((value) => {
                const option = document.createElement('option');
                option.value = value;
                option.textContent = meta.labels?.[value] || value;
                option.selected = selectedValues.includes(value);
                recentFieldsSelect.appendChild(option);
            });
        };

        const selectedRecentFields = () => recentFieldsSelect
            ? Array.from(recentFieldsSelect.options)
                .filter((option) => option.selected)
                .map((option) => option.value)
            : [];

        const recommendedRecentWidth = () => {
            const count = selectedRecentFields().length;
            if (count >= 6) return 12;
            if (count >= 4) return 8;
            if (count >= 3) return 6;
            return 4;
        };

        const syncWidthGuidance = () => {
            if (!widthGuidance) return;
            const widgetType = type?.value || 'kpi_count';
            if (widgetType !== 'recent') {
                widthGuidance.classList.add('d-none');
                widthGuidance.textContent = '';
                return;
            }

            const selectedCount = selectedRecentFields().length;
            const recommended = recommendedRecentWidth();
            const currentWidth = Number(widthSelect?.value || 4);
            if (selectedCount >= 3 && currentWidth < recommended) {
                widthGuidance.textContent = `${selectedCount} columns: recommended width ${recommended}.`;
                widthGuidance.classList.remove('d-none');
                widthGuidance.classList.add('text-warning-emphasis');
            } else {
                widthGuidance.textContent = selectedCount > 0 ? `Recommended width: ${recommended}.` : '';
                widthGuidance.classList.toggle('d-none', selectedCount === 0);
                widthGuidance.classList.remove('text-warning-emphasis');
            }
        };

        const humanize = (value) => String(value || '')
            .replaceAll('_', ' ')
            .replaceAll('-', ' ')
            .replace(/\b\w/g, (letter) => letter.toUpperCase());

        const fieldLabel = (field) => currentMeta().labels?.[field] || humanize(field);

        const automaticTitle = () => {
            const widgetType = type?.value || 'kpi_count';
            const tableLabel = humanize(table?.value || '');
            const op = operation?.value || 'COUNT';
            const opLabel = {SUM: 'Total', AVG: 'Average', MIN: 'Minimum', MAX: 'Maximum', COUNT: 'Count'}[op] || op;
            const valueLabel = fieldLabel(valueSelect?.value || '');
            const groupLabel = fieldLabel(groupSelect?.value || '');

            if (widgetType === 'kpi_count') return `${tableLabel} Count`.trim();
            if (widgetType === 'kpi_aggregate') return `${opLabel} ${valueLabel}`.trim();
            if (widgetType === 'grouped_chart') {
                return op === 'COUNT'
                    ? `${tableLabel} Count by ${groupLabel}`.trim()
                    : `${opLabel} ${valueLabel} by ${groupLabel}`.trim();
            }
            if (widgetType === 'recent') return `Recent ${tableLabel} records`.trim();
            if (widgetType === 'quick_link') return tableLabel || 'Quick link';
            return tableLabel || 'Widget';
        };

        const syncChartGuidance = () => {
            if (!chartGuidance) return;
            const widgetType = type?.value || 'kpi_count';
            if (widgetType !== 'grouped_chart') {
                chartGuidance.classList.add('d-none');
                chartGuidance.textContent = '';
                return;
            }

            const meta = currentMeta();
            const group = groupSelect?.value || '';
            const messages = [];
            if (!group) {
                messages.push('Select a grouping field to make the chart meaningful.');
            } else {
                if (group === (meta.primaryKey || '')) {
                    messages.push(`${fieldLabel(group)} is the primary key: grouping by it usually creates one category per record.`);
                }
                if (meta.relationFields?.[group]) {
                    messages.push(`${fieldLabel(group)} is a relation field and may create many categories; the chart will show only the configured top results.`);
                }
                if ((meta.dateFields || []).includes(group) && (dateGroup?.value || 'raw') === 'raw') {
                    messages.push(`${fieldLabel(group)} is a date field: grouping by exact values can fragment the chart. Consider day, month, or year.`);
                }
                if ((filterSelect?.value || '') === group && (filterValue?.value || '').trim() !== '') {
                    const filterOp = filterOperator?.value || 'eq';
                    if (filterOp === 'eq') {
                        messages.push(`The local filter fixes ${fieldLabel(group)} to one value, so the chart will normally contain a single category.`);
                    } else {
                        messages.push(`The local filter also targets ${fieldLabel(group)} and can significantly reduce the number of categories.`);
                    }
                }
            }

            chartGuidance.textContent = messages.join(' ');
            chartGuidance.classList.toggle('d-none', messages.length === 0);
        };

        const renderPreview = () => {
            if (!preview) return;

            const widgetType = type?.value || 'kpi_count';
            const meta = currentMeta();
            const widgetTitle = title?.value?.trim() || automaticTitle();
            const escapeHtml = (value) => String(value ?? '')
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');

            if (widgetType === 'kpi_count' || widgetType === 'kpi_aggregate') {
                const prefix = item.querySelector('input[name$="[prefix]"]')?.value || '';
                const suffix = item.querySelector('input[name$="[suffix]"]')?.value || '';
                preview.innerHTML = `
                    <div class="dashboard-preview-kpi">
                        <div class="small text-muted">${escapeHtml(widgetTitle)}</div>
                        <div class="dashboard-preview-kpi-value">${escapeHtml(prefix)}—${escapeHtml(suffix)}</div>
                    </div>
                `;
                return;
            }

            if (widgetType === 'grouped_chart') {
                const heights = [42, 78, 56, 92, 66];
                preview.innerHTML = `
                    <div class="small text-muted mb-1">${escapeHtml(widgetTitle)}</div>
                    <div class="dashboard-preview-bars">
                        ${heights.map((height) => `<span class="dashboard-preview-bar" style="height:${height}%"></span>`).join('')}
                    </div>
                `;
                return;
            }

            if (widgetType === 'recent') {
                const fields = selectedRecentFields().slice(0, 4);
                const headers = fields.length > 0
                    ? fields.map((field) => `<th>${escapeHtml(meta.labels?.[field] || field)}</th>`).join('')
                    : '<th>Select columns</th>';
                const cells = fields.length > 0
                    ? fields.map(() => '<td class="text-muted">…</td>').join('')
                    : '<td class="text-muted">…</td>';

                preview.innerHTML = `
                    <div class="small text-muted mb-1">${escapeHtml(widgetTitle)}</div>
                    <div class="table-responsive">
                        <table class="table table-sm mb-0 dashboard-preview-table">
                            <thead><tr>${headers}</tr></thead>
                            <tbody><tr>${cells}</tr><tr>${cells}</tr></tbody>
                        </table>
                    </div>
                `;
                return;
            }

            preview.innerHTML = `
                <div class="d-flex align-items-center justify-content-between border rounded px-2 py-2">
                    <strong class="small">${escapeHtml(widgetTitle)}</strong>
                    <i class="bi bi-arrow-right"></i>
                </div>
            `;
        };

        const syncFields = () => {
            const meta = currentMeta();

            if (valueSelect) {
                valueSelect.dataset.selected = valueSelect.value || valueSelect.dataset.selected || '';
                populate(valueSelect, meta.numericFields || [], 'Select numeric field...', meta.labels || {});
            }
            if (groupSelect) {
                groupSelect.dataset.selected = groupSelect.value || groupSelect.dataset.selected || '';
                populate(groupSelect, meta.fields || [], 'Select group field...', meta.labels || {});
            }
            if (filterSelect) {
                filterSelect.dataset.selected = filterSelect.value || filterSelect.dataset.selected || '';
                populate(filterSelect, meta.fields || [], 'No filter', meta.labels || {});
            }
            if (globalDateSelect) {
                globalDateSelect.dataset.selected = globalDateSelect.value || globalDateSelect.dataset.selected || '';
                populate(globalDateSelect, meta.dateFields || [], 'Do not use global period', meta.labels || {});
            }

            globalFilterSelects.forEach((select) => {
                select.dataset.selected = select.value || select.dataset.selected || '';
                populate(select, meta.fields || [], 'Do not apply', meta.labels || {});
            });
        };

        const syncSummary = () => {
            const widgetType = type?.value || 'kpi_count';
            const typeLabel = typeLabels[widgetType] || 'Widget';
            const widgetTitle = title?.value?.trim() || automaticTitle();
            if (title) title.placeholder = `Automatic: ${automaticTitle()}`;
            const source = table?.value || '';

            if (summaryTitle) summaryTitle.textContent = widgetTitle;
            if (summaryType) summaryType.textContent = typeLabel;

            if (summarySource) {
                summarySource.textContent = source;
                summarySource.classList.toggle('d-none', source === '');
            }

            if (summaryDetail) {
                if (widgetType === 'kpi_aggregate') {
                    summaryDetail.textContent = `${operation?.value || 'SUM'} ${fieldLabel(valueSelect?.value || '') || '—'}`;
                } else if (widgetType === 'grouped_chart') {
                    summaryDetail.textContent = `${operation?.value || 'COUNT'} by ${fieldLabel(groupSelect?.value || '') || '—'}`;
                } else if (widgetType === 'recent') {
                    summaryDetail.textContent = `Last ${limit?.value || '5'} records`;
                } else if (widgetType === 'quick_link') {
                    summaryDetail.textContent = 'CRUD navigation';
                } else {
                    summaryDetail.textContent = 'Record count';
                }
            }

            if (filterStatus) {
                filterStatus.textContent = filterSelect?.value && filterValue?.value ? 'Configured' : 'None';
            }
            if (periodStatus) {
                periodStatus.textContent = globalDateSelect?.value || 'Not mapped';
            }

            if (globalFilterStatus) {
                const mapped = globalFilterSelects.filter((select) => (select.value || '').trim() !== '').length;
                globalFilterStatus.textContent = `${mapped} mapped`;
            }

            if (presentationStatus) {
                const decimalSelect = item.querySelector('select[name$="[decimals]"]');
                const prefixInput = item.querySelector('input[name$="[prefix]"]');
                const suffixInput = item.querySelector('input[name$="[suffix]"]');
                const configured = (decimalSelect?.value || '0') !== '0'
                    || (prefixInput?.value || '').trim() !== ''
                    || (suffixInput?.value || '').trim() !== '';
                presentationStatus.textContent = configured ? 'Configured' : 'Default';
            }

            if (recentFieldsStatus) {
                recentFieldsStatus.textContent = `${selectedRecentFields().length} selected`;
            }

            syncWidthGuidance();
            syncChartGuidance();
            renderPreview();
        };

        const syncType = () => {
            const widgetType = type?.value || 'kpi_count';
            const op = operation?.value || 'COUNT';

            limitWrap?.classList.toggle('d-none', widgetType !== 'recent');
            operationWrap?.classList.toggle('d-none', !['kpi_aggregate', 'grouped_chart'].includes(widgetType));
            valueWrap?.classList.toggle(
                'd-none',
                !(widgetType === 'kpi_aggregate' || (widgetType === 'grouped_chart' && op !== 'COUNT'))
            );
            groupWrap?.classList.toggle('d-none', widgetType !== 'grouped_chart');
            chartWrap?.classList.toggle('d-none', widgetType !== 'grouped_chart');

            const meta = currentMeta();
            const groupIsDate = widgetType === 'grouped_chart'
                && (meta.dateFields || []).includes(groupSelect?.value || '');
            dateGroupWrap?.classList.toggle('d-none', !groupIsDate);

            kpiFormatWrap?.classList.toggle('d-none', !['kpi_count', 'kpi_aggregate'].includes(widgetType));
            recentFieldsWrap?.classList.toggle('d-none', widgetType !== 'recent');
            advancedWrap?.classList.toggle('d-none', widgetType === 'quick_link');
            filterWrap?.classList.toggle('d-none', widgetType === 'quick_link');

            syncSummary();
        };

        type?.addEventListener('change', syncType);
        operation?.addEventListener('change', syncType);
        title?.addEventListener('input', syncSummary);
        limit?.addEventListener('input', syncSummary);
        valueSelect?.addEventListener('change', syncSummary);
        groupSelect?.addEventListener('change', () => {
            syncType();
            syncSummary();
        });
        filterSelect?.addEventListener('change', syncSummary);
        filterOperator?.addEventListener('change', syncSummary);
        filterValue?.addEventListener('input', syncSummary);
        globalDateSelect?.addEventListener('change', syncSummary);
        globalFilterSelects.forEach((select) => select.addEventListener('change', syncSummary));
        dateGroup?.addEventListener('change', syncSummary);
        recentFieldsSelect?.addEventListener('change', syncSummary);
        widthSelect?.addEventListener('change', syncSummary);

        const moveRecent = (direction) => {
            if (!recentFieldsSelect) return;
            const options = Array.from(recentFieldsSelect.options);

            if (direction < 0) {
                for (let i = 1; i < options.length; i += 1) {
                    if (options[i].selected && !options[i - 1].selected) {
                        recentFieldsSelect.insertBefore(options[i], options[i - 1]);
                    }
                }
            } else {
                for (let i = options.length - 2; i >= 0; i -= 1) {
                    if (options[i].selected && !options[i + 1].selected) {
                        recentFieldsSelect.insertBefore(options[i + 1], options[i]);
                    }
                }
            }

            syncSummary();
        };

        recentUp?.addEventListener('click', () => moveRecent(-1));
        recentDown?.addEventListener('click', () => moveRecent(1));

        item.querySelectorAll('select[name$="[decimals]"], input[name$="[prefix]"], input[name$="[suffix]"]').forEach((control) => {
            control.addEventListener('input', syncSummary);
            control.addEventListener('change', syncSummary);
        });

        table?.addEventListener('change', () => {
            if (valueSelect) valueSelect.dataset.selected = '';
            if (groupSelect) groupSelect.dataset.selected = '';
            if (filterSelect) filterSelect.dataset.selected = '';
            if (globalDateSelect) globalDateSelect.dataset.selected = '';
            globalFilterSelects.forEach((select) => {
                select.dataset.selected = '';
            });
            syncFields();
            rebuildRecentFields(currentMeta(), currentMeta().recentFields || []);
            syncType();
            syncSummary();
        });

        syncGlobalDefinitionMappings(item);
        syncFields();
        if (recentFieldsSelect && recentFieldsSelect.options.length === 0 && table?.value) {
            rebuildRecentFields(currentMeta(), currentMeta().recentFields || []);
        }
        syncType();
        syncSummary();
    }

    Array.from(list.querySelectorAll('.dashboard-widget-slot')).forEach(bind);

    new Sortable(list, {
        animation: 160,
        handle: '.dashboard-widget-drag',
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        onSort: refresh
    });

    syncGlobalDefinitionMappings(document);
    refresh();
});
</script>
<?= $this->endSection() ?>
