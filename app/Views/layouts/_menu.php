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
$menuSearch = (bool) ($menuConfig->search ?? true);
$menuFavorites = (bool) ($menuConfig->favorites ?? true);
?>

<?= view('layouts/_menu_' . $menuType, [
    'menuGroups' => $menuGroups,
    'menuSearch' => $menuSearch,
    'menuFavorites' => $menuFavorites,
]) ?>