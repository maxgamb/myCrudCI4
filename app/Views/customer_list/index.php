<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php /* Site list view: dynamic filters, progressive AJAX, export, and CI4 Pager. */ ?>
<?php
$navigationContext = (array) ($navigationContext ?? []);
$cascadeTrail = (array) ($cascadeTrail ?? []);
$navigationParams = $navigationContext;
$encodedTrail = \App\Libraries\Crud\CrudNavigationTrail::encode($cascadeTrail);
if ($encodedTrail !== '') $navigationParams['_trail'] = $encodedTrail;
$navigationQuery = $navigationParams === [] ? '' : '?' . http_build_query($navigationParams);
?>

<!-- mycrud:start list-page -->
<div class="container-fluid px-0">
    <nav aria-label="breadcrumb" class="mb-2">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="<?= site_url('/') ?>">Home</a></li>
            <?php $trailPrefix = []; ?>
            <?php foreach ($cascadeTrail as $segment): ?>
                <?php
                $segmentQuery = \App\Libraries\Crud\CrudNavigationTrail::encode($trailPrefix);
                $segmentUrl = site_url((string) $segment['table'] . '/view/' . rawurlencode((string) $segment['id']));
                if ($segmentQuery !== '') $segmentUrl .= '?_trail=' . rawurlencode($segmentQuery);
                ?>
                <li class="breadcrumb-item"><a href="<?= esc($segmentUrl) ?>"><?= esc((string) $segment['label']) ?></a></li>
                <?php $trailPrefix[] = $segment; ?>
            <?php endforeach; ?>
            <li class="breadcrumb-item active" aria-current="page">customer_list</li>
        </ol>
    </nav>

    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">customer_list</h1>
            <small class="text-muted">Elenco</small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a id="exportCsvButton" href="<?= site_url('customer_list/export-csv') . $navigationQuery ?>" class="btn btn-outline-success" title="Esporta i risultati filtrati in CSV">
                <i class="bi bi-filetype-csv me-1" aria-hidden="true"></i> CSV
            </a>
            <a id="exportWordButton" href="<?= site_url('customer_list/export-word') . $navigationQuery ?>" class="btn btn-outline-primary" title="Esporta i risultati filtrati in Word">
                <i class="bi bi-file-earmark-word me-1" aria-hidden="true"></i> Word
            </a>
        </div>
    </div>

    <?php
    $hasActiveFilters = array_filter(
        (array) ($filters ?? []),
        static fn ($value): bool => is_array($value)
            ? array_filter($value, static fn ($item): bool => trim((string) $item) !== '') !== []
            : trim((string) $value) !== ''
    ) !== [];
    ?>

    <!-- mycrud:start filters -->
    <details class="mb-3" <?= $hasActiveFilters ? 'open' : '' ?>>
        <summary class="fw-semibold"><?= esc(lang('CustomerList.filtersSummary')) ?></summary>
        <div class="card card-body mt-2">
            <?= view('customer_list/_filters', [
                'filters' => $filters ?? [],
                'options' => $options ?? [],
                'perPage' => $perPage ?? 25,
                'sort' => $sort ?? 'ID',
                'direction' => $direction ?? 'desc',
            ]) ?>
        </div>
    </details>
    <!-- mycrud:end filters -->

    <!-- mycrud:start table -->
    <div id="crudTableContainer" aria-live="polite" aria-busy="false">
        <?= view('customer_list/_table', [
            'rows' => $rows ?? [],
            'total' => $total ?? 0,
            'page' => $page ?? 1,
            'perPage' => $perPage ?? 25,
            'pagerLinks' => $pagerLinks ?? '',
            'primaryKey' => $primaryKey ?? 'ID',
            'sort' => $sort ?? 'ID',
            'direction' => $direction ?? 'desc',
            'query' => $query ?? [],
            'navigationContext' => $navigationContext,
            'cascadeTrail' => $cascadeTrail,
        ]) ?>
    </div>
    <!-- mycrud:end table -->
</div>
<!-- mycrud:end list-page -->

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('crudFiltersForm');
    const container = document.getElementById('crudTableContainer');
    const exportCsvButton = document.getElementById('exportCsvButton');
    const exportWordButton = document.getElementById('exportWordButton');
    const createRecordButton = document.getElementById('createRecordButton');
    const navigationContextFields = [];
    const simpleFilterFields = [];
    const cascadeTrailParam = '_trail';
    let activeRequest = null;

    if (!form || !container || !exportCsvButton || !exportWordButton) {
        return;
    }

    const formParameters = () => new URLSearchParams(new FormData(form));

    const mergeNavigationContext = (params, sourceUrl) => {
        navigationContextFields.forEach(field => {
            const value = sourceUrl.searchParams.get(field);
            if (value !== null && value !== '' && !params.has(field)) {
                // The foreign-key parameter remains explicit even if the advanced filter
                // contains the same field: it serves as navigation context.
                params.set(field, value);
            }
        });
        const trail = sourceUrl.searchParams.get(cascadeTrailParam);
        if (trail !== null && trail !== '' && !params.has(cascadeTrailParam)) {
            params.set(cascadeTrailParam, trail);
        }
        return params;
    };

    const exportParameters = (sourceUrl = new URL(window.location.href)) => {
        const params = formParameters();
        params.delete('page');
        params.delete('perPage');

        // A quick AJAX filter lives in the query string (for example, ?title=ZHIVAGO+CORE)
        // but does not modify the already-rendered filter form. For CSV/Word we copy
        // from the current URL only fields allowed by the same whitelist
        // used server-side by CrudListRequest for the short ?field=value form.
        simpleFilterFields.forEach(field => {
            const value = sourceUrl.searchParams.get(field);
            if (value !== null && value !== '') {
                params.set(field, value);
            }
        });

        return mergeNavigationContext(params, sourceUrl);
    };

    const updateActionUrls = (source = window.location.href) => {
        const sourceUrl = new URL(source, window.location.origin);
        const context = new URLSearchParams();
        navigationContextFields.forEach(field => {
            const value = sourceUrl.searchParams.get(field);
            if (value !== null && value !== '') {
                context.set(field, value);
            }
        });

        if (createRecordButton) {
            const createUrl = new URL(createRecordButton.dataset.baseUrl, window.location.origin);
            createUrl.search = context.toString();
            createRecordButton.href = createUrl.toString();
        }

        const params = exportParameters(sourceUrl).toString();
        const csvUrl = new URL("<?= site_url('customer_list/export-csv') ?>", window.location.origin);
        const wordUrl = new URL("<?= site_url('customer_list/export-word') ?>", window.location.origin);
        csvUrl.search = params;
        wordUrl.search = params;
        exportCsvButton.href = csvUrl.toString();
        exportWordButton.href = wordUrl.toString();
    };

    const loadTable = async (url, updateHistory = true) => {
        if (activeRequest) {
            activeRequest.abort();
        }
        const request = new AbortController();
        activeRequest = request;

        container.classList.add('opacity-50');
        container.setAttribute('aria-busy', 'true');

        try {
            const response = await fetch(url, {
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                signal: request.signal
            });

            if (!response.ok) {
                throw new Error('HTTP error ' + response.status);
            }

            container.innerHTML = await response.text();

            if (updateHistory) {
                window.history.pushState({}, '', url);
            }
            updateActionUrls(url);
        } catch (error) {
            if (error.name !== 'AbortError') {
                console.error(error);
                container.innerHTML = '<div class="alert alert-danger">Impossibile caricare i dati.</div>';
            }
        } finally {
            if (activeRequest === request) {
                activeRequest = null;
                container.classList.remove('opacity-50');
                container.setAttribute('aria-busy', 'false');
            }
        }
    };

    form.addEventListener('submit', event => {
        event.preventDefault();
        const url = new URL(form.action, window.location.origin);
        const params = mergeNavigationContext(formParameters(), new URL(window.location.href));
        url.search = params.toString();
        url.searchParams.set('page', '1');
        loadTable(url.toString());
    });

    form.querySelector('[name="perPage"]')?.addEventListener('change', () => {
        form.requestSubmit();
    });

    document.addEventListener('click', event => {
        const resetLink = event.target.closest('a.js-reset-filters');
        if (!resetLink) {
            return;
        }
        event.preventDefault();
        window.location.assign(resetLink.href);
    });

    container.addEventListener('click', event => {
        const link = event.target.closest('.pagination a, a.js-list-link');
        if (!link) {
            return;
        }

        event.preventDefault();
        const url = new URL(link.href, window.location.origin);

        // I link generati dal server contengono già lo stato corrente della
        // list. In particular, quick filters use the short form
        // `?field=value`: do not convert them back to `filters[...]` here.
        if (link.matches('.pagination a')) {
            const current = new URLSearchParams(window.location.search);
            const target = new URLSearchParams(url.search);
            for (const [name, value] of current.entries()) {
                if (!name.startsWith('page')) {
                    target.set(name, value);
                }
            }
            url.search = target.toString();
        }

        if (link.dataset.sort) {
            url.searchParams.set('sort', link.dataset.sort);
            url.searchParams.set('direction', link.dataset.direction || 'asc');
            url.searchParams.set('page', '1');
            form.querySelector('[name="sort"]').value = link.dataset.sort;
            form.querySelector('[name="direction"]').value = link.dataset.direction || 'asc';
        }

        loadTable(url.toString());
    });

    window.addEventListener('popstate', () => window.location.reload());
    updateActionUrls();
});
</script>

<?= $this->endSection() ?>
