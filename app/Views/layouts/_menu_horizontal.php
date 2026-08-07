<?php
/**
 * Menu orizzontale Bootstrap dell'applicazione.
 * I gruppi diventano dropdown e la navbar usa il comportamento responsive
 * standard di Bootstrap senza CSS personalizzato.
 */
$menuGroups = (array) ($menuGroups ?? config('Menu')->groups ?? []);
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary border-bottom" aria-label="Menu applicazione">
    <div class="container-fluid">
        <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#generatedAppMenu"
            aria-controls="generatedAppMenu"
            aria-expanded="false"
            aria-label="Apri navigazione"
        >
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="generatedAppMenu">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php foreach ($menuGroups as $groupIndex => $group): ?>
                    <?php $items = (array) ($group['items'] ?? []); ?>
                    <?php if ($items === []): continue; endif ?>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle"
                            href="#"
                            role="button"
                            data-bs-toggle="dropdown"
                            aria-expanded="false"
                        >
                            <?php if (!empty($group['icon'])): ?>
                                <i class="bi <?= esc($group['icon']) ?> me-1"></i>
                            <?php endif ?>
                            <?= esc($group['label'] ?? '') ?>
                        </a>

                        <ul class="dropdown-menu">
                            <?php foreach ($items as $item): ?>
                                <li>
                                    <a class="dropdown-item" href="<?= site_url((string) ($item['route'] ?? '')) ?>">
                                        <?php if (!empty($item['icon'])): ?>
                                            <i class="bi <?= esc($item['icon']) ?> me-2"></i>
                                        <?php endif ?>
                                        <?= esc($item['label'] ?? '') ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endforeach ?>
            </ul>
        </div>
    </div>
</nav>