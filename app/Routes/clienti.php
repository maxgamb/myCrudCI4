<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('clienti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ClientusController::index');
    $routes->get('export-csv', 'ClientusController::exportCsv');
    $routes->get('export-word', 'ClientusController::exportWord');
    $routes->get('view/(:segment)', 'ClientusController::view/$1');
    $routes->get('create', 'ClientusController::create');
    $routes->post('store', 'ClientusController::store');
    $routes->get('edit/(:segment)', 'ClientusController::edit/$1');
    $routes->post('update/(:segment)', 'ClientusController::update/$1');
    $routes->post('delete/(:segment)', 'ClientusController::delete/$1');
});