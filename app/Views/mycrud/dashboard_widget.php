<?php
$type = (string) ($widget['type'] ?? 'kpi_count');
$title = (string) ($widget['title'] ?? '');
$table = (string) ($widget['table'] ?? '');
$operation = strtoupper((string) ($widget['operation'] ?? 'COUNT'));
$valueField = (string) ($widget['valueField'] ?? '');
$groupField = (string) ($widget['groupField'] ?? '');
$chartType = (string) ($widget['chartType'] ?? 'bar');
$dateGroup = (string) ($widget['dateGroup'] ?? 'raw');
$decimals = max(0, min(4, (int) ($widget['decimals'] ?? ($type === 'kpi_aggregate' ? 2 : 0))));
$prefix = (string) ($widget['prefix'] ?? '');
$suffix = (string) ($widget['suffix'] ?? '');
$filterField = (string) ($widget['filterField'] ?? '');
$filterOperator = (string) ($widget['filterOperator'] ?? 'eq');
$filterValue = (string) ($widget['filterValue'] ?? '');
$globalDateField = (string) ($widget['globalDateField'] ?? '');
$globalFilterFields = is_array($widget['globalFilterFields'] ?? null)
    ? $widget['globalFilterFields']
    : [];
$dashboardGlobalFilters = array_values((array) ($globalFilters ?? []));
$limit = (int) ($widget['limit'] ?? 5);
$width = (int) ($widget['width'] ?? 4);

$currentMeta = (array) (($tableMeta ?? [])[$table] ?? []);
$allFields = (array) ($currentMeta['fields'] ?? []);
$numericFields = (array) ($currentMeta['numericFields'] ?? []);
$dateFields = (array) ($currentMeta['dateFields'] ?? []);
$fieldLabels = (array) ($currentMeta['labels'] ?? []);
$defaultRecentFields = (array) ($currentMeta['recentFields'] ?? []);
$selectedRecentFields = array_key_exists('recentFields', $widget)
    ? array_values(array_filter((array) $widget['recentFields'], static fn ($field): bool => (string) $field !== ''))
    : $defaultRecentFields;

$orderedRecentOptions = [];
foreach ($selectedRecentFields as $fieldName) {
    if (in_array($fieldName, $allFields, true) && !in_array($fieldName, $orderedRecentOptions, true)) {
        $orderedRecentOptions[] = $fieldName;
    }
}
foreach ($allFields as $fieldName) {
    if (!in_array($fieldName, $orderedRecentOptions, true)) {
        $orderedRecentOptions[] = $fieldName;
    }
}

$typeLabels = [
    'kpi_count' => 'KPI Count',
    'kpi_aggregate' => 'KPI Aggregate',
    'grouped_chart' => 'Grouped chart',
    'recent' => 'Recent records',
    'quick_link' => 'Quick link',
];
$typeLabel = $typeLabels[$type] ?? 'Widget';

$presentationActive = in_array($type, ['kpi_count', 'kpi_aggregate'], true)
    && ($decimals !== 0 || $prefix !== '' || $suffix !== '');
$periodActive = $globalDateField !== '';
$filterActive = $filterField !== '' && $filterValue !== '';
?>
<div class="col-12 col-md-6 col-xl-4 dashboard-widget-slot" data-widget-id="<?= esc($id) ?>">
    <div class="card dashboard-widget shadow-sm h-100">
    <input type="hidden" name="widgetOrder[]" value="<?= esc($id) ?>" data-widget-order>

    <div class="card-header dashboard-widget-header py-2 px-3">
        <div class="d-flex align-items-center gap-2 min-w-0">
            <button
                type="button"
                class="btn btn-sm btn-light border-0 dashboard-widget-drag flex-shrink-0"
                title="Drag to reorder"
                aria-label="Drag widget"
            >
                <i class="bi bi-grip-vertical"></i>
            </button>

            <div class="min-w-0 flex-grow-1">
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <strong class="dashboard-widget-summary-title text-truncate" data-widget-summary-title>
                        <?= esc($title !== '' ? $title : $typeLabel) ?>
                    </strong>
                    <span class="badge text-bg-primary-subtle border text-primary-emphasis" data-widget-summary-type>
                        <?= esc($typeLabel) ?>
                    </span>
                    <span
                        class="badge text-bg-light border text-body-secondary <?= $table === '' ? 'd-none' : '' ?>"
                        data-widget-summary-source
                    >
                        <?= esc($table) ?>
                    </span>
                </div>
                <div class="small text-muted mt-1">
                    <span data-widget-summary-detail>
                        <?php if ($type === 'kpi_aggregate'): ?>
                            <?= esc($operation) ?> <?= esc($valueField) ?>
                        <?php elseif ($type === 'grouped_chart'): ?>
                            <?= esc($operation) ?> by <?= esc($groupField) ?>
                        <?php elseif ($type === 'recent'): ?>
                            Last <?= $limit ?> records
                        <?php elseif ($type === 'quick_link'): ?>
                            CRUD navigation
                        <?php else: ?>
                            Record count
                        <?php endif ?>
                    </span>
                </div>
            </div>

            <button
                type="button"
                class="btn btn-sm btn-outline-danger flex-shrink-0"
                data-remove-widget
                title="Remove widget"
            >
                <i class="bi bi-trash"></i>
            </button>
        </div>
    </div>

    <div class="card-body p-3">
        <div class="row g-2 align-items-start">
            <div class="col-12 col-sm-6">
                <label class="form-label small fw-semibold mb-1">Type</label>
                <select name="widgets[<?= esc($id) ?>][type]" class="form-select form-select-sm" data-widget-type>
                    <option value="kpi_count" <?= $type === 'kpi_count' ? 'selected' : '' ?>>KPI — Count</option>
                    <option value="kpi_aggregate" <?= $type === 'kpi_aggregate' ? 'selected' : '' ?>>KPI — Aggregate</option>
                    <option value="grouped_chart" <?= $type === 'grouped_chart' ? 'selected' : '' ?>>Grouped chart</option>
                    <option value="recent" <?= $type === 'recent' ? 'selected' : '' ?>>Recent records</option>
                    <option value="quick_link" <?= $type === 'quick_link' ? 'selected' : '' ?>>Quick link</option>
                </select>
            </div>

            <div class="col-12 col-sm-6">
                <label class="form-label small fw-semibold mb-1">Source CRUD</label>
                <select
                    name="widgets[<?= esc($id) ?>][table]"
                    class="form-select form-select-sm"
                    data-dashboard-table
                    required
                >
                    <option value="">Select...</option>
                    <?php foreach ((array) $tables as $availableTable): ?>
                        <option value="<?= esc($availableTable) ?>" <?= $table === $availableTable ? 'selected' : '' ?>>
                            <?= esc($availableTable) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-12">
                <label class="form-label small fw-semibold mb-1">Widget title</label>
                <input
                    class="form-control form-control-sm"
                    name="widgets[<?= esc($id) ?>][title]"
                    value="<?= esc($title) ?>"
                    placeholder="Automatic if empty"
                    data-widget-title
                >
            </div>

            <div class="col-6">
                <label class="form-label small fw-semibold mb-1">Width</label>
                <select class="form-select form-select-sm" name="widgets[<?= esc($id) ?>][width]" data-widget-width>
                    <?php foreach ([3,4,6,8,12] as $optionWidth): ?>
                        <option value="<?= $optionWidth ?>" <?= $width === $optionWidth ? 'selected' : '' ?>><?= $optionWidth ?></option>
                    <?php endforeach ?>
                </select>
                <div class="form-text d-none" data-width-guidance></div>
            </div>

            <div class="col-6 <?= $type === 'recent' ? '' : 'd-none' ?>" data-limit-wrap>
                <label class="form-label small fw-semibold mb-1">Records</label>
                <input
                    type="number"
                    min="1"
                    max="50"
                    class="form-control form-control-sm"
                    name="widgets[<?= esc($id) ?>][limit]"
                    value="<?= $limit ?>"
                    data-widget-limit
                >
            </div>
        </div>

        <div class="row g-2 mt-1 dashboard-widget-primary-options">
            <div class="col-12 col-sm-6 <?= in_array($type, ['kpi_aggregate', 'grouped_chart'], true) ? '' : 'd-none' ?>" data-operation-wrap>
                <label class="form-label small fw-semibold mb-1">Operation</label>
                <select name="widgets[<?= esc($id) ?>][operation]" class="form-select form-select-sm" data-dashboard-operation>
                    <?php foreach (['COUNT','SUM','AVG','MIN','MAX'] as $op): ?>
                        <option value="<?= $op ?>" <?= $operation === $op ? 'selected' : '' ?>><?= $op ?></option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-12 col-sm-6 <?= ($type === 'kpi_aggregate' || ($type === 'grouped_chart' && $operation !== 'COUNT')) ? '' : 'd-none' ?>" data-value-field-wrap>
                <label class="form-label small fw-semibold mb-1">Value field</label>
                <select
                    name="widgets[<?= esc($id) ?>][valueField]"
                    class="form-select form-select-sm"
                    data-value-field
                    data-selected="<?= esc($valueField) ?>"
                >
                    <option value="">Select numeric field...</option>
                    <?php foreach ($numericFields as $fieldName): ?>
                        <option value="<?= esc($fieldName) ?>" <?= $valueField === $fieldName ? 'selected' : '' ?>>
                            <?= esc((string) ($fieldLabels[$fieldName] ?? $fieldName)) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-12 col-sm-6 <?= $type === 'grouped_chart' ? '' : 'd-none' ?>" data-group-field-wrap>
                <label class="form-label small fw-semibold mb-1">Group by</label>
                <select
                    name="widgets[<?= esc($id) ?>][groupField]"
                    class="form-select form-select-sm"
                    data-group-field
                    data-selected="<?= esc($groupField) ?>"
                >
                    <option value="">Select group field...</option>
                    <?php foreach ($allFields as $fieldName): ?>
                        <option value="<?= esc($fieldName) ?>" <?= $groupField === $fieldName ? 'selected' : '' ?>>
                            <?= esc((string) ($fieldLabels[$fieldName] ?? $fieldName)) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div class="col-12 col-sm-6 <?= $type === 'grouped_chart' ? '' : 'd-none' ?>" data-chart-type-wrap>
                <label class="form-label small fw-semibold mb-1">Chart</label>
                <select name="widgets[<?= esc($id) ?>][chartType]" class="form-select form-select-sm">
                    <?php foreach (['bar','line','doughnut'] as $availableChart): ?>
                        <option value="<?= $availableChart ?>" <?= $chartType === $availableChart ? 'selected' : '' ?>>
                            <?= ucfirst($availableChart) ?>
                        </option>
                    <?php endforeach ?>
                </select>
            </div>

            <div
                class="col-12 col-sm-6 <?= $type === 'grouped_chart' && in_array($groupField, $dateFields, true) ? '' : 'd-none' ?>"
                data-date-group-wrap
            >
                <label class="form-label small fw-semibold mb-1">Date grouping</label>
                <select
                    name="widgets[<?= esc($id) ?>][dateGroup]"
                    class="form-select form-select-sm"
                    data-date-group
                >
                    <option value="raw" <?= $dateGroup === 'raw' ? 'selected' : '' ?>>Exact value</option>
                    <option value="day" <?= $dateGroup === 'day' ? 'selected' : '' ?>>Day</option>
                    <option value="month" <?= $dateGroup === 'month' ? 'selected' : '' ?>>Month</option>
                    <option value="year" <?= $dateGroup === 'year' ? 'selected' : '' ?>>Year</option>
                </select>
            </div>
        </div>

        <div class="dashboard-widget-advanced mt-3 <?= $type === 'quick_link' ? 'd-none' : '' ?>" data-advanced-wrap>
            <div class="row g-2">
                <div class="col-12 <?= $type === 'recent' ? '' : 'd-none' ?>" data-recent-fields-wrap>
                    <details class="dashboard-option-panel" <?= $type === 'recent' ? 'open' : '' ?>>
                        <summary>
                            <span>
                                <i class="bi bi-columns-gap me-1"></i>Recent columns
                            </span>
                            <span class="badge text-bg-light border" data-recent-fields-status>
                                <?= count($selectedRecentFields) ?> selected
                            </span>
                        </summary>
                        <div class="dashboard-option-panel-body">
                            <label class="form-label small mb-1">Columns and order</label>
                            <select
                                class="form-select form-select-sm"
                                name="widgets[<?= esc($id) ?>][recentFields][]"
                                multiple
                                size="6"
                                data-recent-fields
                            >
                                <?php foreach ($orderedRecentOptions as $fieldName): ?>
                                    <option
                                        value="<?= esc($fieldName) ?>"
                                        <?= in_array($fieldName, $selectedRecentFields, true) ? 'selected' : '' ?>
                                    >
                                        <?= esc((string) ($fieldLabels[$fieldName] ?? $fieldName)) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="d-flex gap-2 mt-2">
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-recent-up>
                                    <i class="bi bi-arrow-up"></i> Up
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-secondary" data-recent-down>
                                    <i class="bi bi-arrow-down"></i> Down
                                </button>
                            </div>
                            <div class="form-text mt-2">
                                Select the columns to display. Use Up/Down to define their generated order. Foreign-key columns use their configured relation labels in the generated Dashboard.
                            </div>
                        </div>
                    </details>
                </div>
                <div class="col-12 <?= in_array($type, ['kpi_count', 'kpi_aggregate'], true) ? '' : 'd-none' ?>" data-kpi-format-wrap>
                    <details class="dashboard-option-panel h-100" <?= $presentationActive ? 'open' : '' ?>>
                        <summary>
                            <span>
                                <i class="bi bi-fonts me-1"></i>Presentation
                            </span>
                            <span class="badge text-bg-light border" data-presentation-status>
                                <?= $presentationActive ? 'Configured' : 'Default' ?>
                            </span>
                        </summary>
                        <div class="dashboard-option-panel-body">
                            <div class="row g-2">
                                <div class="col-4">
                                    <label class="form-label small mb-1">Decimals</label>
                                    <select
                                        class="form-select form-select-sm"
                                        name="widgets[<?= esc($id) ?>][decimals]"
                                    >
                                        <?php foreach ([0,1,2,3,4] as $decimalOption): ?>
                                            <option value="<?= $decimalOption ?>" <?= $decimals === $decimalOption ? 'selected' : '' ?>>
                                                <?= $decimalOption ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label class="form-label small mb-1">Prefix</label>
                                    <input
                                        class="form-control form-control-sm"
                                        name="widgets[<?= esc($id) ?>][prefix]"
                                        value="<?= esc($prefix) ?>"
                                        placeholder="€"
                                        maxlength="12"
                                    >
                                </div>
                                <div class="col-4">
                                    <label class="form-label small mb-1">Suffix</label>
                                    <input
                                        class="form-control form-control-sm"
                                        name="widgets[<?= esc($id) ?>][suffix]"
                                        value="<?= esc($suffix) ?>"
                                        placeholder="%"
                                        maxlength="12"
                                    >
                                </div>
                            </div>
                            <div class="form-text mt-2">Display formatting only; DTO value stays numeric.</div>
                        </div>
                    </details>
                </div>

                <div class="col-12">
                    <details class="dashboard-option-panel h-100" <?= $periodActive ? 'open' : '' ?>>
                        <summary>
                            <span>
                                <i class="bi bi-calendar-range me-1"></i>Global period
                            </span>
                            <span class="badge text-bg-light border" data-period-status>
                                <?= $periodActive ? esc($globalDateField) : 'Not mapped' ?>
                            </span>
                        </summary>
                        <div class="dashboard-option-panel-body">
                            <label class="form-label small mb-1">Date field</label>
                            <select
                                class="form-select form-select-sm"
                                name="widgets[<?= esc($id) ?>][globalDateField]"
                                data-global-date-field
                                data-selected="<?= esc($globalDateField) ?>"
                            >
                                <option value="">Do not use global period</option>
                                <?php foreach ($dateFields as $fieldName): ?>
                                    <option value="<?= esc($fieldName) ?>" <?= $globalDateField === $fieldName ? 'selected' : '' ?>>
                                        <?= esc((string) ($fieldLabels[$fieldName] ?? $fieldName)) ?>
                                    </option>
                                <?php endforeach ?>
                            </select>
                            <div class="form-text mt-2">
                                Maps Dashboard From/To to this widget's date field.
                            </div>
                        </div>
                    </details>
                </div>

                <div class="col-12">
                    <details class="dashboard-option-panel h-100">
                        <summary>
                            <span>
                                <i class="bi bi-funnel-fill me-1"></i>Global filter mappings
                            </span>
                            <span class="badge text-bg-light border" data-global-filter-status>
                                <?= count(array_filter($globalFilterFields)) ?> mapped
                            </span>
                        </summary>
                        <div class="dashboard-option-panel-body">
                            <?php foreach ($dashboardGlobalFilters as $globalFilterSlot => $globalFilter): ?>
                                <?php
                                $globalFilterId = (string) ($globalFilter['id'] ?? '');
                                $globalFilterLabel = trim((string) ($globalFilter['label'] ?? ''))
                                    ?: $globalFilterId;
                                $mappedField = (string) ($globalFilterFields[$globalFilterId] ?? '');
                                ?>
                                <?php if ($globalFilterId !== ''): ?>
                                    <div class="mb-2" data-global-filter-mapping-row>
                                        <label class="form-label small mb-1">
                                            <span data-global-filter-map-label><?= esc($globalFilterLabel) ?></span>
                                            <?php if (empty($globalFilter['enabled'])): ?>
                                                <span class="text-muted">(disabled)</span>
                                            <?php endif ?>
                                        </label>
                                        <select
                                            class="form-select form-select-sm"
                                            name="widgets[<?= esc($id) ?>][globalFilterFields][<?= esc($globalFilterId) ?>]"
                                            data-global-filter-field
                                            data-global-filter-slot="<?= esc((string) $globalFilterSlot) ?>"
                                            data-global-filter-id="<?= esc($globalFilterId) ?>"
                                            data-selected="<?= esc($mappedField) ?>"
                                        >
                                            <option value="">Do not apply</option>
                                            <?php foreach ($allFields as $fieldName): ?>
                                                <option
                                                    value="<?= esc($fieldName) ?>"
                                                    <?= $mappedField === $fieldName ? 'selected' : '' ?>
                                                >
                                                    <?= esc((string) ($fieldLabels[$fieldName] ?? $fieldName)) ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>

                            <div class="form-text mt-2">
                                The same Dashboard filter can target a different field in every widget.
                            </div>
                        </div>
                    </details>
                </div>

                <div class="col-12" data-filter-wrap>
                    <details class="dashboard-option-panel h-100" <?= $filterActive ? 'open' : '' ?>>
                        <summary>
                            <span>
                                <i class="bi bi-funnel me-1"></i>Local filter
                            </span>
                            <span class="badge text-bg-light border" data-filter-status>
                                <?= $filterActive ? 'Configured' : 'None' ?>
                            </span>
                        </summary>
                        <div class="dashboard-option-panel-body">
                            <div class="row g-2">
                                <div class="col-12">
                                    <label class="form-label small mb-1">Field</label>
                                    <select
                                        class="form-select form-select-sm"
                                        name="widgets[<?= esc($id) ?>][filterField]"
                                        data-filter-field
                                        data-selected="<?= esc($filterField) ?>"
                                    >
                                        <option value="">No filter</option>
                                        <?php foreach ($allFields as $fieldName): ?>
                                            <option value="<?= esc($fieldName) ?>" <?= $filterField === $fieldName ? 'selected' : '' ?>>
                                                <?= esc((string) ($fieldLabels[$fieldName] ?? $fieldName)) ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label class="form-label small mb-1">Operator</label>
                                    <select
                                        class="form-select form-select-sm"
                                        name="widgets[<?= esc($id) ?>][filterOperator]"
                                        data-filter-operator
                                    >
                                        <?php
                                        $operators = [
                                            'eq' => '=',
                                            'neq' => '!=',
                                            'gt' => '>',
                                            'gte' => '>=',
                                            'lt' => '<',
                                            'lte' => '<=',
                                            'contains' => 'contains',
                                            'starts_with' => 'starts with',
                                        ];
                                        ?>
                                        <?php foreach ($operators as $operatorKey => $operatorLabel): ?>
                                            <option value="<?= esc($operatorKey) ?>" <?= $filterOperator === $operatorKey ? 'selected' : '' ?>>
                                                <?= esc($operatorLabel) ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="col-8">
                                    <label class="form-label small mb-1">Value</label>
                                    <input
                                        class="form-control form-control-sm"
                                        name="widgets[<?= esc($id) ?>][filterValue]"
                                        value="<?= esc($filterValue) ?>"
                                        placeholder="Filter value"
                                        maxlength="255"
                                        data-filter-value
                                    >
                                </div>
                            </div>
                        </div>
                    </details>
                </div>
            </div>
        </div>
    </div>

    <div class="card-footer bg-body-tertiary py-2 px-3">
        <div class="d-flex justify-content-between align-items-center gap-2 mb-2">
            <span class="small fw-semibold">
                <i class="bi bi-eye me-1"></i>Preview
            </span>
            <span class="badge text-bg-light border">Builder preview</span>
        </div>
        <div class="dashboard-widget-preview" data-widget-preview></div>
    </div>
    </div>
</div>
