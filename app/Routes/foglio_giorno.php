<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('foglio_giorno', static function (RouteCollection $routes): void {
    $routes->get('/', 'FoglioGiornoController::index');
    $routes->get('export-csv', 'FoglioGiornoController::exportCsv');
    $routes->get('export-word', 'FoglioGiornoController::exportWord');
    $routes->get('view/(:segment)', 'FoglioGiornoController::view/$1');
    $routes->get('create', 'FoglioGiornoController::create');
    $routes->post('store', 'FoglioGiornoController::store');
    $routes->get('edit/(:segment)', 'FoglioGiornoController::edit/$1');
    $routes->post('update/(:segment)', 'FoglioGiornoController::update/$1');
    $routes->post('delete/(:segment)', 'FoglioGiornoController::delete/$1');
});