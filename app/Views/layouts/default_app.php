<?php

/**
 * Layout principale dell'applicazione generata.
 *
 * - indipendente da myCrudGpt a runtime;
 * - Bootstrap 5 + Bootstrap Icons;
 * - menu verticale o orizzontale da Config\Menu;
 * - sidebar verticale con scroll indipendente;
 * - contenuto principale adatto a tabelle CRUD molto larghe.
 */

$appName = $appName ?? 'Applicazione';
$menuType = null;

if (class_exists(\Config\Menu::class)) {
    $menuConfig = config('Menu');
    $configuredType = $menuConfig->type ?? null;

    if (in_array($configuredType, ['vertical', 'horizontal'], true)) {
        $menuType = $configuredType;
    }
}

$isVertical = $menuType === 'vertical';
$isHorizontal = $menuType === 'horizontal';
?>
<!doctype html>
<html lang="it">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?= esc($title ?? $appName) ?></title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
        rel="stylesheet"
    >

    <style>
        :root {
            --app-navbar-height: 56px;
            --app-sidebar-width: 250px;
        }

        html,
        body {
            min-height: 100%;
        }

        body {
            background-color: var(--bs-tertiary-bg);
        }

        /*
         * Con il menu verticale il layout si comporta come una vera
         * applicazione: sidebar e contenuto scorrono indipendentemente.
         */
        body.app-menu-vertical {
            overflow: hidden;
        }

        .app-navbar {
            min-height: var(--app-navbar-height);
            z-index: 1030;
        }

        .app-shell {
            min-width: 0;
        }

        body.app-menu-vertical .app-shell {
            height: calc(100vh - var(--app-navbar-height));
            overflow: hidden;
        }

        .app-sidebar {
            width: var(--app-sidebar-width);
            min-width: var(--app-sidebar-width);
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
            scrollbar-width: thin;
            background-color: var(--bs-body-bg);
            border-right: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color);
        }

        .app-content {
            min-width: 0;
        }

        body.app-menu-vertical .app-content {
            height: 100%;
            overflow-y: auto;
            overflow-x: hidden;
        }

        /*
         * Le tabelle CRUD possono avere molte colonne: manteniamo le celle
         * compatte e affidiamo lo scorrimento orizzontale a .table-responsive.
         */
        .crud-table {
            white-space: nowrap;
        }

        /* La colonna Azioni resta visibile durante lo scroll orizzontale. */
        .crud-table th:last-child,
        .crud-table td:last-child {
            position: sticky;
            right: 0;
            background-color: var(--bs-body-bg);
            z-index: 2;
        }

        .crud-table thead th:last-child {
            z-index: 3;
        }

        .app-sidebar .accordion-button {
            font-size: .875rem;
        }

        .app-sidebar .list-group-item {
            font-size: .875rem;
        }

        @media (max-width: 767.98px) {
            body.app-menu-vertical {
                overflow: auto;
            }

            body.app-menu-vertical .app-shell {
                display: block !important;
                height: auto;
                overflow: visible;
            }

            .app-sidebar {
                width: 100%;
                min-width: 100%;
                height: auto;
                max-height: 45vh;
                border-right: 0;
                border-bottom: var(--bs-border-width) var(--bs-border-style) var(--bs-border-color);
            }

            body.app-menu-vertical .app-content {
                height: auto;
                overflow: visible;
            }
        }
    </style>

    <?= $this->renderSection('styles') ?>
</head>

<body class="<?= $isVertical ? 'app-menu-vertical' : '' ?>">

<nav class="navbar navbar-dark bg-dark shadow-sm app-navbar">
    <div class="container-fluid">
        <a class="navbar-brand fw-semibold" href="<?= site_url('/') ?>">
            <i class="bi bi-grid me-1"></i>
            <?= esc($appName) ?>
        </a>

        <div class="ms-auto">
            <a class="btn btn-outline-light btn-sm" href="<?= site_url('/') ?>">
                <i class="bi bi-house"></i>
                <span class="d-none d-sm-inline ms-1">Home</span>
            </a>
        </div>
    </div>
</nav>

<?php if ($isHorizontal): ?>
    <div class="bg-body border-bottom">
        <?= view('layouts/_menu') ?>
    </div>
<?php endif ?>

<div class="app-shell <?= $isVertical ? 'd-flex' : '' ?>">

    <?php if ($isVertical): ?>
        <aside class="app-sidebar" aria-label="Navigazione principale">
            <?= view('layouts/_menu') ?>
        </aside>
    <?php endif ?>

    <main class="app-content flex-grow-1">
        <div class="container-fluid py-3">

            <?php if ($message = session()->getFlashdata('message')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-1"></i>
                    <?= esc($message) ?>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Chiudi"
                    ></button>
                </div>
            <?php endif ?>

            <?php if ($error = session()->getFlashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle me-1"></i>
                    <?= esc($error) ?>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Chiudi"
                    ></button>
                </div>
            <?php endif ?>

            <?php if ($warning = session()->getFlashdata('warning')): ?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-circle me-1"></i>
                    <?= esc($warning) ?>
                    <button
                        type="button"
                        class="btn-close"
                        data-bs-dismiss="alert"
                        aria-label="Chiudi"
                    ></button>
                </div>
            <?php endif ?>

            <?= $this->renderSection('content') ?>
        </div>
    </main>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>

</body>
</html>
