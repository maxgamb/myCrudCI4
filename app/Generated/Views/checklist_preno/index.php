<?= $this->extend('layouts/default_app') ?>
<?= $this->section('content') ?>

<?php /* Vista elenco del sito: filtri dinamici, AJAX progressivo, export e Pager CI4. */ ?>

<div class="container-fluid px-0">
    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-3">
        <div>
            <h1 class="h3 mb-0">checklist_preno</h1>
            <small class="text-muted">Tabella Bootstrap, Pager CI4 e caricamento AJAX</small>
        </div>
        <div class="d-flex flex-wrap gap-2">
            <a href="<?= site_url('checklist_preno/create') ?>" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Nuovo
            </a>
            <a id="exportCsvButton" href="<?= site_url('checklist_preno/export-csv') ?>" class="btn btn-success">
                <i class="bi bi-filetype-csv"></i> Esporta CSV
            </a>
            <a id="exportWordButton" href="<?= site_url('checklist_preno/export-word') ?>" class="btn btn-outline-primary">
                <i class="bi bi-file-earmark-word"></i> Esporta Word
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

    <details class="mb-3" <?= $hasActiveFilters ? 'open' : '' ?>>
        <summary class="fw-semibold"><?= esc(lang('ChecklistPreno.filtersSummary')) ?></summary>
        <div class="card card-body mt-2">
            <?= view('checklist_preno/_filters', [
                'filters' => $filters ?? [],
                'options' => $options ?? [],
                'perPage' => $perPage ?? 25,
                'sort' => $sort ?? 'checklist_id',
                'direction' => $direction ?? 'desc',
            ]) ?>
        </div>
    </details>

    <div id="crudTableContainer" aria-live="polite" aria-busy="false">
        <?= view('checklist_preno/_table', [
            'rows' => $rows ?? [],
            'total' => $total ?? 0,
            'page' => $page ?? 1,
            'perPage' => $perPage ?? 25,
            'pagerLinks' => $pagerLinks ?? '',
            'primaryKey' => $primaryKey ?? 'checklist_id',
            'sort' => $sort ?? 'checklist_id',
            'direction' => $direction ?? 'desc',
            'query' => $query ?? [],
        ]) ?>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('crudFiltersForm');
    const container = document.getElementById('crudTableContainer');
    const exportCsvButton = document.getElementById('exportCsvButton');
    const exportWordButton = document.getElementById('exportWordButton');
    let activeRequest = null;

    if (!form || !container || !exportCsvButton || !exportWordButton) {
        return;
    }

    const formParameters = () => new URLSearchParams(new FormData(form));

    const exportParameters = () => {
        const params = formParameters();
        params.delete('page');
        params.delete('perPage');
        return params;
    };

    const updateExportUrls = () => {
        const params = exportParameters().toString();
        const csvUrl = new URL("<?= site_url('checklist_preno/export-csv') ?>", window.location.origin);
        const wordUrl = new URL("<?= site_url('checklist_preno/export-word') ?>", window.location.origin);
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
                throw new Error('Errore HTTP ' + response.status);
            }

            container.innerHTML = await response.text();

            if (updateHistory) {
                window.history.pushState({}, '', url);
            }
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
        url.search = formParameters().toString();
        url.searchParams.set('page', '1');
        updateExportUrls();
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
        const params = formParameters();

        for (const [name, value] of params.entries()) {
            if (value !== '') {
                url.searchParams.set(name, value);
            }
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
    updateExportUrls();
});
</script>

<?= $this->endSection() ?>
