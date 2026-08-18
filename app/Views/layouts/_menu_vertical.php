<?php
/**
 * Menu verticale Bootstrap dell'applicazione.
 *
 * - gruppi e sottogruppi collassabili;
 * - gruppo della route corrente aperto automaticamente;
 * - voce corrente evidenziata;
 * - instant browser-side search;
 * - preferiti opzionali;
 * - no database query during search.
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

$favoriteItems = array_values(array_filter(
    $allItems,
    static fn (array $item): bool => !empty($item['favorite'])
));
?>

<div class="generated-menu generated-menu-vertical" data-generated-menu>
    <?php if ($menuSearch): ?>
        <div class="p-2 border-bottom bg-body sticky-top generated-menu-search-wrap">
            <div class="input-group input-group-sm">
                <span class="input-group-text bg-body"><i class="bi bi-search"></i></span>
                <input
                    type="search"
                    class="form-control"
                    placeholder="Cerca nel menu..."
                    aria-label="Cerca nel menu"
                    data-menu-search
                    autocomplete="off"
                >
            </div>
        </div>
    <?php endif ?>

    <?php if ($menuFavorites && $favoriteItems !== []): ?>
        <div class="border-bottom py-2" data-menu-favorites>
            <div class="px-3 pb-1 small fw-semibold text-uppercase text-body-secondary">
                <i class="bi bi-star-fill me-1"></i> Preferiti
            </div>
            <nav class="nav flex-column">
                <?php foreach ($favoriteItems as $item): ?>
                    <?php
                    $route = (string) ($item['route'] ?? '');
                    $active = $isCurrentRoute($route);
                    ?>
                    <a
                        class="nav-link py-1 px-3 <?= $active ? 'active fw-semibold' : '' ?>"
                        href="<?= site_url($route) ?>"
                    >
                        <?php if (!empty($item['icon'])): ?>
                            <i class="bi <?= esc($item['icon']) ?> me-2"></i>
                        <?php endif ?>
                        <?= esc($item['label'] ?? '') ?>
                    </a>
                <?php endforeach ?>
            </nav>
        </div>
    <?php endif ?>

    <div class="accordion accordion-flush" id="generatedVerticalMenu">
        <?php foreach ($menuGroups as $groupIndex => $group): ?>
            <?php
            $directItems = (array) ($group['items'] ?? []);
            $subgroups = (array) ($group['subgroups'] ?? []);
            if ($directItems === [] && $subgroups === []) {
                continue;
            }

            $groupOpen = false;
            foreach ($directItems as $item) {
                if ($isCurrentRoute((string) ($item['route'] ?? ''))) {
                    $groupOpen = true;
                    break;
                }
            }
            if (!$groupOpen) {
                foreach ($subgroups as $subgroup) {
                    foreach ((array) ($subgroup['items'] ?? []) as $item) {
                        if ($isCurrentRoute((string) ($item['route'] ?? ''))) {
                            $groupOpen = true;
                            break 2;
                        }
                    }
                }
            }

            $collapseId = 'generatedMenuGroup' . $groupIndex;
            $groupLabel = (string) ($group['label'] ?? '');
            ?>

            <div
                class="accordion-item border-0 border-bottom"
                data-menu-group
                data-menu-group-label="<?= esc(strtolower($groupLabel)) ?>"
            >
                <h2 class="accordion-header">
                    <button
                        class="accordion-button py-2 px-3 <?= $groupOpen ? '' : 'collapsed' ?>"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#<?= esc($collapseId) ?>"
                        aria-expanded="<?= $groupOpen ? 'true' : 'false' ?>"
                        aria-controls="<?= esc($collapseId) ?>"
                    >
                        <?php if (!empty($group['icon'])): ?>
                            <i class="bi <?= esc($group['icon']) ?> me-2"></i>
                        <?php endif ?>
                        <span class="text-truncate"><?= esc($groupLabel) ?></span>
                    </button>
                </h2>

                <div
                    id="<?= esc($collapseId) ?>"
                    class="accordion-collapse collapse <?= $groupOpen ? 'show' : '' ?>"
                    data-bs-parent="#generatedVerticalMenu"
                >
                    <?php if ($directItems !== []): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($directItems as $item): ?>
                                <?php
                                $route = (string) ($item['route'] ?? '');
                                $active = $isCurrentRoute($route);
                                ?>
                                <a
                                    class="list-group-item list-group-item-action border-0 py-2 ps-4 <?= $active ? 'active' : '' ?>"
                                    href="<?= site_url($route) ?>"
                                    <?= $active ? 'aria-current="page"' : '' ?>
                                    data-menu-item
                                    data-menu-label="<?= esc(strtolower((string) ($item['label'] ?? ''))) ?>"
                                >
                                    <?php if (!empty($item['icon'])): ?>
                                        <i class="bi <?= esc($item['icon']) ?> me-2"></i>
                                    <?php endif ?>
                                    <?= esc($item['label'] ?? '') ?>
                                </a>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>

                    <?php if ($subgroups !== []): ?>
                        <div id="generatedSubgroups<?= $groupIndex ?>">
                            <?php foreach ($subgroups as $subgroupIndex => $subgroup): ?>
                                <?php
                                $subItems = (array) ($subgroup['items'] ?? []);
                                if ($subItems === []) {
                                    continue;
                                }
                                $subOpen = false;
                                foreach ($subItems as $item) {
                                    if ($isCurrentRoute((string) ($item['route'] ?? ''))) {
                                        $subOpen = true;
                                        break;
                                    }
                                }
                                $subCollapseId = 'generatedMenuSubgroup' . $groupIndex . '_' . $subgroupIndex;
                                $subLabel = (string) ($subgroup['label'] ?? '');
                                ?>
                                <div class="border-top" data-menu-subgroup data-menu-subgroup-label="<?= esc(strtolower($subLabel)) ?>">
                                    <button
                                        class="btn btn-sm w-100 text-start rounded-0 px-4 py-2 d-flex align-items-center <?= $subOpen ? '' : 'collapsed' ?>"
                                        type="button"
                                        data-bs-toggle="collapse"
                                        data-bs-target="#<?= esc($subCollapseId) ?>"
                                        aria-expanded="<?= $subOpen ? 'true' : 'false' ?>"
                                    >
                                        <i class="bi bi-chevron-right small me-2 generated-subgroup-chevron"></i>
                                        <span class="small fw-semibold text-body-secondary text-uppercase text-truncate">
                                            <?= esc($subLabel) ?>
                                        </span>
                                    </button>

                                    <div
                                        id="<?= esc($subCollapseId) ?>"
                                        class="collapse <?= $subOpen ? 'show' : '' ?>"
                                        data-bs-parent="#generatedSubgroups<?= $groupIndex ?>"
                                    >
                                        <div class="list-group list-group-flush">
                                            <?php foreach ($subItems as $item): ?>
                                                <?php
                                                $route = (string) ($item['route'] ?? '');
                                                $active = $isCurrentRoute($route);
                                                ?>
                                                <a
                                                    class="list-group-item list-group-item-action border-0 py-2 ps-5 <?= $active ? 'active' : '' ?>"
                                                    href="<?= site_url($route) ?>"
                                                    <?= $active ? 'aria-current="page"' : '' ?>
                                                    data-menu-item
                                                    data-menu-label="<?= esc(strtolower((string) ($item['label'] ?? ''))) ?>"
                                                >
                                                    <?php if (!empty($item['icon'])): ?>
                                                        <i class="bi <?= esc($item['icon']) ?> me-2"></i>
                                                    <?php endif ?>
                                                    <?= esc($item['label'] ?? '') ?>
                                                </a>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach ?>
    </div>

    <div class="px-3 py-3 small text-body-secondary d-none" data-menu-empty>
        <i class="bi bi-search me-1"></i> None voce trovata.
    </div>
</div>

<style>
.generated-menu-vertical .accordion-button { font-size: .92rem; font-weight: 600; }
.generated-menu-vertical .accordion-button:not(.collapsed) { background: var(--bs-tertiary-bg); color: var(--bs-body-color); box-shadow: none; }
.generated-menu-vertical .accordion-button:focus { box-shadow: none; }
.generated-menu-vertical .list-group-item { font-size: .9rem; }
.generated-menu-vertical .list-group-item.active { font-weight: 600; }
.generated-menu-vertical .generated-subgroup-chevron { transition: transform .2s ease; }
.generated-menu-vertical button[aria-expanded="true"] .generated-subgroup-chevron { transform: rotate(90deg); }
.generated-menu-search-wrap { z-index: 4; }
</style>

<?php if ($menuSearch): ?>
<script>
(() => {
    const root = document.currentScript?.previousElementSibling?.previousElementSibling || document.querySelector('[data-generated-menu]');
    const menu = root?.matches?.('[data-generated-menu]') ? root : document.querySelector('[data-generated-menu]');
    if (!menu) return;

    const input = menu.querySelector('[data-menu-search]');
    const empty = menu.querySelector('[data-menu-empty]');
    const favorites = menu.querySelector('[data-menu-favorites]');
    if (!input) return;

    const normalize = (value) => (value || '').toLocaleLowerCase().trim();

    input.addEventListener('input', () => {
        const term = normalize(input.value);
        let visibleTotal = 0;

        favorites?.classList.toggle('d-none', term !== '');

        menu.querySelectorAll('[data-menu-group]').forEach((group) => {
            const groupLabel = normalize(group.dataset.menuGroupLabel);
            let groupVisible = false;

            group.querySelectorAll('[data-menu-subgroup]').forEach((subgroup) => {
                const subLabel = normalize(subgroup.dataset.menuSubgroupLabel);
                let subVisible = false;

                subgroup.querySelectorAll('[data-menu-item]').forEach((item) => {
                    const match = term === ''
                        || groupLabel.includes(term)
                        || subLabel.includes(term)
                        || normalize(item.dataset.menuLabel).includes(term);
                    item.classList.toggle('d-none', !match);
                    if (match) {
                        subVisible = true;
                        visibleTotal += 1;
                    }
                });

                subgroup.classList.toggle('d-none', !subVisible && term !== '');
                if (subVisible) groupVisible = true;

                if (term !== '' && subVisible) {
                    subgroup.querySelector('.collapse')?.classList.add('show');
                    subgroup.querySelector('button')?.setAttribute('aria-expanded', 'true');
                }
            });

            group.querySelectorAll(':scope > .accordion-collapse > .list-group [data-menu-item]').forEach((item) => {
                const match = term === ''
                    || groupLabel.includes(term)
                    || normalize(item.dataset.menuLabel).includes(term);
                item.classList.toggle('d-none', !match);
                if (match) {
                    groupVisible = true;
                    visibleTotal += 1;
                }
            });

            group.classList.toggle('d-none', !groupVisible && term !== '');
            if (term !== '' && groupVisible) {
                group.querySelector(':scope > .accordion-collapse')?.classList.add('show');
                group.querySelector(':scope > .accordion-header .accordion-button')?.setAttribute('aria-expanded', 'true');
            }
        });

        empty?.classList.toggle('d-none', term === '' || visibleTotal > 0);
    });
})();
</script>
<?php endif ?>