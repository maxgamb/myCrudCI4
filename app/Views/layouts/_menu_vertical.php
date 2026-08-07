<?php
/**
 * Menu verticale Bootstrap dell'applicazione.
 * Le voci arrivano esclusivamente da Config\Menu e possono essere modificate
 * senza toccare questo renderer.
 */
$menuGroups = (array) ($menuGroups ?? config('Menu')->groups ?? []);
?>

<nav class="nav flex-column" aria-label="Menu applicazione">
    <?php foreach ($menuGroups as $group): ?>
        <?php $items = (array) ($group['items'] ?? []); ?>
        <?php if ($items === []): continue; endif ?>

        <div class="small fw-semibold text-body-secondary px-3 mt-3 mb-1">
            <?php if (!empty($group['icon'])): ?>
                <i class="bi <?= esc($group['icon']) ?> me-1"></i>
            <?php endif ?>
            <?= esc($group['label'] ?? '') ?>
        </div>

        <?php foreach ($items as $item): ?>
            <a class="nav-link" href="<?= site_url((string) ($item['route'] ?? '')) ?>">
                <?php if (!empty($item['icon'])): ?>
                    <i class="bi <?= esc($item['icon']) ?> me-2"></i>
                <?php endif ?>
                <?= esc($item['label'] ?? '') ?>
            </a>
        <?php endforeach ?>
    <?php endforeach ?>
</nav>