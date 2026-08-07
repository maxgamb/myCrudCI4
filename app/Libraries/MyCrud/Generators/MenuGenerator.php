<?php

declare(strict_types=1);

namespace App\Libraries\MyCrud\Generators;

/**
 * Genera il menu dell'applicazione come codice runtime indipendente da myCrudGpt.
 *
 * Il tool produce una sola configurazione e due renderer Bootstrap (verticale e
 * orizzontale). Dopo lo spostamento da app/Generated/ ad app/, myCrudGpt può
 * essere rimosso senza influire sulla navigazione del sito.
 */
final class MenuGenerator
{
    use GeneratorTrait;

    public function generate(array $menu, bool $force = false): array
    {
        $type = in_array(($menu['type'] ?? 'vertical'), ['vertical', 'horizontal'], true)
            ? (string) $menu['type']
            : 'vertical';

        $groups = array_values((array) ($menu['groups'] ?? []));
        $groupsCode = var_export($groups, true);

        $config = <<<PHP
<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configurazione del menu applicativo generata da myCrudGpt.
 *
 * Questo file appartiene al sito finale e non dipende dal generatore.
 * Puoi cambiare liberamente tipo, gruppi, etichette, icone, route e ordine.
 */
final class Menu extends BaseConfig
{
    /** Renderer predefinito: vertical oppure horizontal. */
    public string \$type = '{$type}';

    /** @var list<array<string, mixed>> */
    public array \$groups = {$groupsCode};
}
PHP;

        $dispatcher = <<<'PHP'
<?php
/**
 * Dispatcher del menu applicativo.
 * Cambiando Config\Menu::$type puoi passare da sidebar verticale a navbar
 * orizzontale senza rigenerare le voci del menu.
 */
$menuConfig = config('Menu');
$menuType = in_array($menuConfig->type ?? 'vertical', ['vertical', 'horizontal'], true)
    ? $menuConfig->type
    : 'vertical';
$menuGroups = (array) ($menuConfig->groups ?? []);
?>

<?= view('layouts/_menu_' . $menuType, ['menuGroups' => $menuGroups]) ?>
PHP;

        $vertical = <<<'PHP'
<?php
/**
 * Menu verticale Bootstrap dell'applicazione.
 *
 * - gruppi collassabili;
 * - un solo gruppo aperto alla volta;
 * - il gruppo della route corrente viene aperto automaticamente;
 * - la voce corrente viene evidenziata.
 */
$menuGroups = (array) ($menuGroups ?? config('Menu')->groups ?? []);
$currentPath = trim(service('uri')->getPath(), '/');

$isCurrentRoute = static function (string $route) use ($currentPath): bool {
    $route = trim($route, '/');

    if ($route === '') {
        return $currentPath === '';
    }

    return $currentPath === $route || str_starts_with($currentPath, $route . '/');
};
?>

<div class="accordion accordion-flush" id="generatedVerticalMenu">
    <?php foreach ($menuGroups as $groupIndex => $group): ?>
        <?php
        $items = (array) ($group['items'] ?? []);
        if ($items === []) {
            continue;
        }

        $groupOpen = false;
        foreach ($items as $item) {
            if ($isCurrentRoute((string) ($item['route'] ?? ''))) {
                $groupOpen = true;
                break;
            }
        }

        $collapseId = 'generatedMenuGroup' . $groupIndex;
        ?>

        <div class="accordion-item border-0 border-bottom">
            <h2 class="accordion-header">
                <button
                    class="accordion-button py-2 <?= $groupOpen ? '' : 'collapsed' ?>"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#<?= esc($collapseId) ?>"
                    aria-expanded="<?= $groupOpen ? 'true' : 'false' ?>"
                    aria-controls="<?= esc($collapseId) ?>"
                >
                    <?php if (!empty($group['icon'])): ?>
                        <i class="bi <?= esc($group['icon']) ?> me-2"></i>
                    <?php endif ?>

                    <?= esc($group['label'] ?? '') ?>
                </button>
            </h2>

            <div
                id="<?= esc($collapseId) ?>"
                class="accordion-collapse collapse <?= $groupOpen ? 'show' : '' ?>"
                data-bs-parent="#generatedVerticalMenu"
            >
                <div class="list-group list-group-flush">
                    <?php foreach ($items as $item): ?>
                        <?php
                        $route = (string) ($item['route'] ?? '');
                        $active = $isCurrentRoute($route);
                        ?>

                        <a
                            class="list-group-item list-group-item-action border-0 py-2 ps-4 <?= $active ? 'active' : '' ?>"
                            href="<?= site_url($route) ?>"
                            <?= $active ? 'aria-current="page"' : '' ?>
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
PHP;

        $horizontal = <<<'PHP'
<?php
/**
 * Menu orizzontale Bootstrap dell'applicazione.
 * I gruppi diventano dropdown responsive e la route corrente viene evidenziata.
 */
$menuGroups = (array) ($menuGroups ?? config('Menu')->groups ?? []);
$currentPath = trim(service('uri')->getPath(), '/');

$isCurrentRoute = static function (string $route) use ($currentPath): bool {
    $route = trim($route, '/');

    if ($route === '') {
        return $currentPath === '';
    }

    return $currentPath === $route || str_starts_with($currentPath, $route . '/');
};
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
                <?php foreach ($menuGroups as $group): ?>
                    <?php
                    $items = (array) ($group['items'] ?? []);
                    if ($items === []) {
                        continue;
                    }

                    $groupActive = false;
                    foreach ($items as $item) {
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
                            <?php foreach ($items as $item): ?>
                                <?php
                                $route = (string) ($item['route'] ?? '');
                                $active = $isCurrentRoute($route);
                                ?>

                                <li>
                                    <a
                                        class="dropdown-item <?= $active ? 'active' : '' ?>"
                                        href="<?= site_url($route) ?>"
                                        <?= $active ? 'aria-current="page"' : '' ?>
                                    >
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
PHP;

        return [
            'config' => $this->writeGenerated('Generated/Config/Menu.php', $config, $force),
            'menu' => $this->writeGenerated('Generated/Views/layouts/_menu.php', $dispatcher, $force),
            'vertical' => $this->writeGenerated('Generated/Views/layouts/_menu_vertical.php', $vertical, $force),
            'horizontal' => $this->writeGenerated('Generated/Views/layouts/_menu_horizontal.php', $horizontal, $force),
        ];
    }
}
