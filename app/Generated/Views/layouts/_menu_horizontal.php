<?php
/**
 * Menu orizzontale Bootstrap dell'applicazione.
 * Gruppi = dropdown, sottogruppi = intestazioni interne, preferiti e ricerca
 * sono opzionali. La route corrente viene evidenziata.
 */
$menuGroups = (array) ($menuGroups ?? config('Menu')->groups ?? []);
$menuSearch = (bool) ($menuSearch ?? config('Menu')->search ?? true);
$menuFavorites = (bool) ($menuFavorites ?? config('Menu')->favorites ?? true);
$currentPath = trim(service('uri')->getPath(), '/');

$isCurrentRoute = static function (string $route) use ($currentPath): bool {
    $route = trim($route, '/');
    if ($route === '') {
        return $currentPath === '';
    }
    return $currentPath === $route || str_starts_with($currentPath, $route . '/');
};

$allItems = [];
foreach ($menuGroups as $group) {
    foreach ((array) ($group['items'] ?? []) as $item) {
        $allItems[] = $item;
    }
    foreach ((array) ($group['subgroups'] ?? []) as $subgroup) {
        foreach ((array) ($subgroup['items'] ?? []) as $item) {
            $allItems[] = $item;
        }
    }
}
$favoriteItems = array_values(array_filter($allItems, static fn (array $item): bool => !empty($item['favorite'])));
?>

<nav class="navbar navbar-expand-lg bg-body" aria-label="Menu applicazione">
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
                <?php if ($menuFavorites && $favoriteItems !== []): ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-star-fill me-1"></i> Preferiti
                        </a>
                        <ul class="dropdown-menu">
                            <?php foreach ($favoriteItems as $item): ?>
                                <?php $route = (string) ($item['route'] ?? ''); ?>
                                <li>
                                    <a class="dropdown-item <?= $isCurrentRoute($route) ? 'active' : '' ?>" href="<?= site_url($route) ?>">
                                        <?php if (!empty($item['icon'])): ?><i class="bi <?= esc($item['icon']) ?> me-2"></i><?php endif ?>
                                        <?= esc($item['label'] ?? '') ?>
                                    </a>
                                </li>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endif ?>

                <?php foreach ($menuGroups as $group): ?>
                    <?php
                    $directItems = (array) ($group['items'] ?? []);
                    $subgroups = (array) ($group['subgroups'] ?? []);
                    if ($directItems === [] && $subgroups === []) {
                        continue;
                    }

                    $groupActive = false;
                    foreach (array_merge($directItems, ...array_map(
                        static fn (array $sub): array => (array) ($sub['items'] ?? []),
                        $subgroups
                    )) as $item) {
                        if ($isCurrentRoute((string) ($item['route'] ?? ''))) {
                            $groupActive = true;
                            break;
                        }
                    }
                    ?>

                    <li class="nav-item dropdown">
                        <a
                            class="nav-link dropdown-toggle <?= $groupActive ? 'active' : '' ?>"
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
                            <?php foreach ($directItems as $item): ?>
                                <?php $route = (string) ($item['route'] ?? ''); ?>
                                <li>
                                    <a class="dropdown-item <?= $isCurrentRoute($route) ? 'active' : '' ?>" href="<?= site_url($route) ?>">
                                        <?php if (!empty($item['icon'])): ?><i class="bi <?= esc($item['icon']) ?> me-2"></i><?php endif ?>
                                        <?= esc($item['label'] ?? '') ?>
                                    </a>
                                </li>
                            <?php endforeach ?>

                            <?php foreach ($subgroups as $subgroup): ?>
                                <?php $subItems = (array) ($subgroup['items'] ?? []); if ($subItems === []) continue; ?>
                                <?php if ($directItems !== []): ?><li><hr class="dropdown-divider"></li><?php endif ?>
                                <li><h6 class="dropdown-header"><?= esc($subgroup['label'] ?? '') ?></h6></li>
                                <?php foreach ($subItems as $item): ?>
                                    <?php $route = (string) ($item['route'] ?? ''); ?>
                                    <li>
                                        <a class="dropdown-item <?= $isCurrentRoute($route) ? 'active' : '' ?>" href="<?= site_url($route) ?>">
                                            <?php if (!empty($item['icon'])): ?><i class="bi <?= esc($item['icon']) ?> me-2"></i><?php endif ?>
                                            <?= esc($item['label'] ?? '') ?>
                                        </a>
                                    </li>
                                <?php endforeach ?>
                            <?php endforeach ?>
                        </ul>
                    </li>
                <?php endforeach ?>
            </ul>

            <?php if ($menuSearch): ?>
                <div class="dropdown ms-lg-2">
                    <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside">
                        <i class="bi bi-search"></i> <span class="d-lg-none ms-1">Cerca</span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end p-2 generated-horizontal-search" style="min-width: 280px;">
                        <input type="search" class="form-control form-control-sm mb-2" placeholder="Cerca nel menu..." data-horizontal-menu-search autocomplete="off">
                        <div class="list-group list-group-flush" data-horizontal-menu-results>
                            <?php foreach ($allItems as $item): ?>
                                <a
                                    class="list-group-item list-group-item-action border-0 px-2 py-1"
                                    href="<?= site_url((string) ($item['route'] ?? '')) ?>"
                                    data-search-label="<?= esc(strtolower((string) ($item['label'] ?? ''))) ?>"
                                >
                                    <?php if (!empty($item['icon'])): ?><i class="bi <?= esc($item['icon']) ?> me-2"></i><?php endif ?>
                                    <?= esc($item['label'] ?? '') ?>
                                </a>
                            <?php endforeach ?>
                        </div>
                        <div class="small text-body-secondary px-2 py-2 d-none" data-horizontal-menu-empty>Nessuna voce trovata.</div>
                    </div>
                </div>
            <?php endif ?>
        </div>
    </div>
</nav>

<?php if ($menuSearch): ?>
<script>
(() => {
    const input = document.querySelector('[data-horizontal-menu-search]');
    const results = document.querySelector('[data-horizontal-menu-results]');
    const empty = document.querySelector('[data-horizontal-menu-empty]');
    if (!input || !results) return;

    input.addEventListener('input', () => {
        const term = input.value.toLocaleLowerCase().trim();
        let visible = 0;
        results.querySelectorAll('[data-search-label]').forEach((item) => {
            const match = term === '' || (item.dataset.searchLabel || '').includes(term);
            item.classList.toggle('d-none', !match);
            if (match) visible += 1;
        });
        empty?.classList.toggle('d-none', visible > 0);
    });
})();
</script>
<?php endif ?>