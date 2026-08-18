<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<div class="container-fluid py-4">
    <?php
    $globalDateFilter = $dashboard->globalDateFilter;
    $activeDateRange = $dashboard->activeDateRange;
    $globalDateEnabled = !empty($globalDateFilter['enabled']);
    $globalFilters = $dashboard->globalFilters;
    $activeGlobalValues = $dashboard->activeGlobalValues;
    $hasGlobalControls = $globalDateEnabled || $globalFilters !== [];
    ?>

    <div class="d-flex flex-wrap justify-content-between align-items-start gap-3 mb-4">
        <div>
            <div class="text-muted small text-uppercase">Dashboard</div>
            <h1 class="h3 mb-0"><?= esc($dashboard->title) ?></h1>
        </div>

        <?php if ($hasGlobalControls): ?>
            <form method="get" class="card shadow-sm">
                <div class="card-body py-2">
                    <div class="d-flex flex-wrap align-items-end gap-2">
                        <?php if ($globalDateEnabled): ?>
                            <div>
                                <label class="form-label small mb-1">
                                    <?= esc((string) ($globalDateFilter['label'] ?? 'Period')) ?> — From
                                </label>
                                <input
                                    type="date"
                                    class="form-control form-control-sm"
                                    name="from"
                                    value="<?= esc((string) ($activeDateRange['from'] ?? '')) ?>"
                                >
                            </div>
                            <div>
                                <label class="form-label small mb-1">
                                    <?= esc((string) ($globalDateFilter['label'] ?? 'Period')) ?> — To
                                </label>
                                <input
                                    type="date"
                                    class="form-control form-control-sm"
                                    name="to"
                                    value="<?= esc((string) ($activeDateRange['to'] ?? '')) ?>"
                                >
                            </div>
                        <?php endif ?>

                        <?php foreach ($globalFilters as $globalFilter): ?>
                            <?php
                            $globalId = (string) ($globalFilter['id'] ?? '');
                            if ($globalId === '') {
                                continue;
                            }
                            ?>
                            <div>
                                <label class="form-label small mb-1">
                                    <?= esc((string) ($globalFilter['label'] ?? $globalId)) ?>
                                </label>
                                <input
                                    type="<?= ($globalFilter['inputType'] ?? 'text') === 'number' ? 'number' : 'text' ?>"
                                    class="form-control form-control-sm"
                                    name="gf_<?= esc($globalId) ?>"
                                    value="<?= esc((string) ($activeGlobalValues[$globalId] ?? '')) ?>"
                                >
                            </div>
                        <?php endforeach ?>

                        <button class="btn btn-sm btn-primary" type="submit">
                            <i class="bi bi-funnel me-1"></i>Apply
                        </button>
                        <a class="btn btn-sm btn-outline-secondary" href="<?= current_url() ?>">
                            Reset
                        </a>
                    </div>
                </div>
            </form>
        <?php endif ?>
    </div>

    <div class="row g-3 align-items-stretch">
        <?php foreach ($dashboard->widgets as $index => $widget): ?>
            <?php
            $width = max(1, min(12, $widget->width));
            $filter = (array) $widget->get('filter', []);
            $hasFilter = trim((string) ($filter['field'] ?? '')) !== '';
            $dateRange = (array) $widget->get('dateRange', []);
            $hasDateRange = trim((string) ($dateRange['field'] ?? '')) !== ''
                && (
                    trim((string) ($dateRange['from'] ?? '')) !== ''
                    || trim((string) ($dateRange['to'] ?? '')) !== ''
                );
            $widgetGlobalFilters = (array) $widget->get('globalFilters', []);
            $hasWidgetGlobalFilters = $widgetGlobalFilters !== [];
            ?>
            <div class="col-12 col-lg-<?= $width ?> d-flex dashboard-widget-column">
                <?php if ($widget->type === 'kpi'): ?>
                    <?php $kpi = $widget->get('data'); ?>
                    <div class="card shadow-sm h-100 w-100 dashboard-widget-card">
                        <div class="card-body py-3">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <div class="text-muted small"><?= esc($kpi->label) ?></div>
                                    <div class="h2 fw-semibold mb-0 mt-1"><?= esc($kpi->formattedValue) ?></div>
                                </div>
                                <i class="bi bi-speedometer2 text-muted fs-4"></i>
                            </div>

                            <?php if (!empty($widget->get('operation'))): ?>
                                <div class="small text-muted mt-2">
                                    <?= esc((string) $widget->get('operation')) ?>
                                    <?= esc((string) $widget->get('fieldLabel', $widget->get('field', ''))) ?>
                                </div>
                            <?php endif ?>

                            <?php if ($hasFilter || $hasDateRange || $hasWidgetGlobalFilters): ?>
                                <div class="small text-muted mt-2">
                                    <?php if ($hasFilter): ?>
                                        <span class="me-2">
                                            <i class="bi bi-funnel me-1"></i>
                                            <?= esc((string) ($filter['label'] ?? $filter['field'])) ?>
                                            <?= esc((string) $filter['operator']) ?>
                                            <?= esc((string) $filter['value']) ?>
                                        </span>
                                    <?php endif ?>
                                    <?php if ($hasDateRange): ?>
                                        <span>
                                            <i class="bi bi-calendar-range me-1"></i>
                                            <?= esc((string) ($dateRange['label'] ?? $dateRange['field'])) ?>
                                            <?= esc((string) ($dateRange['from'] ?? '')) ?>
                                            <?= ($dateRange['from'] ?? '') !== '' && ($dateRange['to'] ?? '') !== '' ? ' → ' : '' ?>
                                            <?= esc((string) ($dateRange['to'] ?? '')) ?>
                                        </span>
                                    <?php endif ?>
                                    <?php foreach ($widgetGlobalFilters as $globalFilter): ?>
                                        <span class="me-2">
                                            <i class="bi bi-funnel-fill me-1"></i>
                                            <?= esc((string) ($globalFilter['label'] ?? $globalFilter['id'] ?? 'Filter')) ?>
                                            <?= esc((string) ($globalFilter['value'] ?? '')) ?>
                                        </span>
                                    <?php endforeach ?>
                                </div>
                            <?php endif ?>
                        </div>
                    </div>

                <?php elseif ($widget->type === 'chart'): ?>
                    <?php
                    $points = (array) $widget->get('points', []);
                    $labels = array_map(static fn ($point): string => (string) $point->label, $points);
                    $values = array_map(static fn ($point): int|float => $point->value, $points);
                    ?>
                    <div class="card shadow-sm h-100 w-100 dashboard-widget-card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <strong><?= esc((string) $widget->title) ?></strong>
                                    <div class="small text-muted">
                                        <?= esc((string) ($widget->get('operation') ?? 'COUNT')) ?>
                                        by <?= esc((string) $widget->get('groupLabel', $widget->get('groupField', ''))) ?>
                                        <?php if ($widget->get('dateGroup', 'raw') !== 'raw'): ?>
                                            · <?= esc((string) $widget->get('dateGroup')) ?>
                                        <?php endif ?>
                                    </div>
                                </div>
                                <div class="d-flex gap-1">
                                    <?php if ($hasFilter): ?>
                                        <span class="badge text-bg-light border">
                                            <i class="bi bi-funnel me-1"></i>
                                            <?= esc((string) ($filter['label'] ?? $filter['field'])) ?>
                                        </span>
                                    <?php endif ?>
                                    <?php if ($hasDateRange): ?>
                                        <span class="badge text-bg-light border">
                                            <i class="bi bi-calendar-range me-1"></i>
                                            <?= esc((string) ($dateRange['label'] ?? $dateRange['field'])) ?>
                                        </span>
                                    <?php endif ?>
                                    <?php foreach ($widgetGlobalFilters as $globalFilter): ?>
                                        <span class="badge text-bg-light border">
                                            <i class="bi bi-funnel-fill me-1"></i>
                                            <?= esc((string) ($globalFilter['label'] ?? $globalFilter['id'] ?? 'Filter')) ?>
                                        </span>
                                    <?php endforeach ?>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div style="height: 300px;">
                                <canvas
                                    data-dashboard-chart
                                    data-chart-type="<?= esc((string) $widget->get('chartType', 'bar')) ?>"
                                    data-labels="<?= esc(json_encode($labels, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>"
                                    data-values="<?= esc(json_encode($values, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)) ?>"
                                    aria-label="<?= esc((string) $widget->title) ?>"
                                    role="img"
                                ></canvas>
                            </div>
                        </div>
                    </div>

                <?php elseif ($widget->type === 'recent'): ?>
                    <?php
                    $recentFields = (array) $widget->get('fields', []);
                    $fieldLabels = (array) $widget->get('labels', []);
                    ?>
                    <div class="card shadow-sm h-100 w-100 dashboard-widget-card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?= esc((string) $widget->title) ?></strong>
                                <?php if ($hasFilter || $hasDateRange || $hasWidgetGlobalFilters): ?>
                                    <div class="small text-muted">
                                        <?php if ($hasFilter): ?>
                                            <span class="me-2">
                                                <i class="bi bi-funnel me-1"></i>
                                                <?= esc((string) ($filter['label'] ?? $filter['field'])) ?>
                                                <?= esc((string) $filter['operator']) ?>
                                                <?= esc((string) $filter['value']) ?>
                                            </span>
                                        <?php endif ?>
                                        <?php if ($hasDateRange): ?>
                                            <span>
                                                <i class="bi bi-calendar-range me-1"></i>
                                                <?= esc((string) ($dateRange['label'] ?? $dateRange['field'])) ?>
                                            </span>
                                        <?php endif ?>
                                        <?php foreach ($widgetGlobalFilters as $globalFilter): ?>
                                            <span class="me-2">
                                                <i class="bi bi-funnel-fill me-1"></i>
                                                <?= esc((string) ($globalFilter['label'] ?? $globalFilter['id'] ?? 'Filter')) ?>
                                                <?= esc((string) ($globalFilter['value'] ?? '')) ?>
                                            </span>
                                        <?php endforeach ?>
                                    </div>
                                <?php endif ?>
                            </div>
                            <a class="btn btn-sm btn-outline-primary" href="<?= site_url((string) $widget->get('table')) ?>">
                                View all
                            </a>
                        </div>

                        <div class="table-responsive dashboard-recent-table">
                            <table class="table table-sm align-middle mb-0">
                                <thead>
                                    <tr>
                                        <?php foreach ($recentFields as $field): ?>
                                            <th scope="col" class="text-nowrap"><?= esc((string) ($fieldLabels[$field] ?? $field)) ?></th>
                                        <?php endforeach ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ((array) $widget->get('records', []) as $record): ?>
                                        <tr>
                                            <?php foreach ($recentFields as $field): ?>
                                                <?php
                                                $value = $record->value((string) $field);
                                                $displayValue = is_scalar($value) || $value === null ? trim((string) $value) : '';
                                                ?>
                                                <td>
                                                    <span
                                                        class="dashboard-cell-text d-inline-block text-truncate align-middle"
                                                        title="<?= esc($displayValue) ?>"
                                                    ><?= esc($displayValue) ?></span>
                                                </td>
                                            <?php endforeach ?>
                                        </tr>
                                    <?php endforeach ?>

                                    <?php if ($widget->get('records', []) === []): ?>
                                        <tr>
                                            <td colspan="<?= max(1, count($recentFields)) ?>" class="text-muted text-center py-3">
                                                No records.
                                            </td>
                                        </tr>
                                    <?php endif ?>
                                </tbody>
                            </table>
                        </div>
                    </div>

                <?php elseif ($widget->type === 'quick_link'): ?>
                    <a href="<?= site_url((string) $widget->get('table')) ?>" class="card shadow-sm h-100 w-100 dashboard-widget-card text-decoration-none">
                        <div class="card-body py-3 d-flex align-items-center justify-content-between">
                            <strong><?= esc((string) $widget->title) ?></strong>
                            <i class="bi bi-arrow-right fs-4"></i>
                        </div>
                    </a>
                <?php endif ?>
            </div>
        <?php endforeach ?>
    </div>
</div>

<style>
.dashboard-widget-column {
    min-width: 0;
}
.dashboard-widget-card {
    min-width: 0;
}
.dashboard-recent-table th,
.dashboard-recent-table td {
    vertical-align: middle;
}
.dashboard-recent-table th {
    font-size: .78rem;
    color: var(--bs-secondary-color);
    font-weight: 600;
}
.dashboard-recent-table td {
    min-width: 6.5rem;
}
.dashboard-cell-text {
    max-width: 14rem;
}
@media (max-width: 1199.98px) {
    .dashboard-cell-text {
        max-width: 10rem;
    }
}
</style>

<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.7/dist/chart.umd.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-dashboard-chart]').forEach((canvas) => {
        const labels = JSON.parse(canvas.dataset.labels || '[]');
        const values = JSON.parse(canvas.dataset.values || '[]');
        const type = canvas.dataset.chartType || 'bar';

        new Chart(canvas, {
            type,
            data: {
                labels,
                datasets: [{
                    label: canvas.getAttribute('aria-label') || 'Dashboard',
                    data: values
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false
            }
        });
    });
});
</script>
<?= $this->endSection() ?>