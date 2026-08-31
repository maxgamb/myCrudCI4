<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'myCrudCI4') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>


<body class="bg-light">
    
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold"
           href="<?= site_url('mycrud') ?>">
            <i class="bi bi-braces-asterisk"></i>
            myCrudCI4
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#myCrudNavbar"
            aria-controls="myCrudNavbar"
            aria-expanded="false"
            aria-label="Open navigation"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse"
             id="myCrudNavbar">

            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <li class="nav-item">
                    <a class="nav-link"
                       href="<?= site_url('mycrud') ?>">
                        <i class="bi bi-house"></i>
                        Home
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                    >
                        <i class="bi bi-stars"></i>
                        Generation
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                               href="<?= site_url('mycrud/quick') ?>">
                                <i class="bi bi-lightning-charge-fill"></i>
                                Quick generation
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="<?= site_url('mycrud/builder') ?>">
                                <i class="bi bi-sliders"></i>
                                Builder
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item dropdown">
                    <a
                        class="nav-link dropdown-toggle"
                        href="#"
                        role="button"
                        data-bs-toggle="dropdown"
                    >
                        <i class="bi bi-tools"></i>
                        Tools
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= site_url('mycrud/tools/routes') ?>"
                            >
                                <i class="bi bi-signpost-split"></i>
                                Generate Routes
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= site_url('mycrud/tools/fields') ?>"
                            >
                                <i class="bi bi-translate"></i>
                                Generate Fields.php
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= site_url('mycrud/tools/menu') ?>"
                            >
                                <i class="bi bi-list"></i>
                                Generate Menu
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= site_url('mycrud/tools/ai-context') ?>"
                            >
                                <i class="bi bi-robot"></i>
                                AI Context
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= site_url('mycrud/tools/domain') ?>"
                            >
                                <i class="bi bi-bezier2"></i>
                                Domain Analyzer
                            </a>
                        </li>
                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= site_url('mycrud/tools/schema') ?>"
                            >
                                <i class="bi bi-diagram-3"></i>
                                Database Schema
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('mycrud/dashboard') ?>">
                        <i class="bi bi-grid-1x2"></i>
                        Dashboard Builder
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="<?= site_url('mycrud/docs') ?>">
                        <i class="bi bi-book"></i>
                        Documentation
                    </a>
                </li>

            </ul>

            <span class="navbar-text">
                <span class="badge text-bg-secondary">
                    <?= esc((string) config('MyCrud')->version) ?>
                </span>
            </span>
        </div>
    </div>
</nav>

<main>
    <?= $this->renderSection('content') ?>
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->renderSection('scripts') ?>
</body>
</html>
