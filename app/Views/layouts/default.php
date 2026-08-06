<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'myCrudGpt') ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
</head>


<body class="bg-light">
    
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold"
           href="<?= site_url('mycrud') ?>">
            <i class="bi bi-braces-asterisk"></i>
            myCrudGpt
        </a>

        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#myCrudNavbar"
            aria-controls="myCrudNavbar"
            aria-expanded="false"
            aria-label="Apri navigazione"
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
                        Generazione
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                               href="<?= site_url('mycrud/quick') ?>">
                                <i class="bi bi-lightning-charge-fill"></i>
                                Quick globale
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="<?= site_url('mycrud') ?>">
                                <i class="bi bi-sliders"></i>
                                Generazione personalizzata
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
                        Strumenti
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= site_url('mycrud/tools/routes') ?>"
                            >
                                <i class="bi bi-signpost-split"></i>
                                Genera Routes
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= site_url('mycrud/tools/fields') ?>"
                            >
                                <i class="bi bi-translate"></i>
                                Genera Fields.php
                            </a>
                        </li>

                        <li>
                            <a
                                class="dropdown-item"
                                href="<?= site_url('mycrud/tools/schema') ?>"
                            >
                                <i class="bi bi-diagram-3"></i>
                                Schema database
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
                        <i class="bi bi-clock-history"></i>
                        Legacy
                    </a>

                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item"
                               href="<?= site_url('generamodelsadvanced') ?>">
                                Genera Models
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="<?= site_url('generacontrollers') ?>">
                                Genera Controllers
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="<?= site_url('generaviews') ?>">
                                Genera Views
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="<?= site_url('generaroutesfromtables') ?>">
                                Vecchie Routes
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="<?= site_url('generagields') ?>">
                                Vecchi Fields
                            </a>
                        </li>

                        <li>
                            <a class="dropdown-item"
                               href="<?= site_url('formgenerator') ?>">
                                Vecchio Form Generator
                            </a>
                        </li>
                    </ul>
                </li>

            </ul>

            <span class="navbar-text">
                <span class="badge bg-success">
                    Production
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
