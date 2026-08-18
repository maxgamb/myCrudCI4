<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD inventory.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('inventory', static function (RouteCollection $routes): void {
    $routes->get('/', 'InventoryController::index');
    $routes->get('export-csv', 'InventoryController::exportCsv');
    $routes->get('export-word', 'InventoryController::exportWord');
    $routes->get('relation-options/(:segment)', 'InventoryController::relationOptions/$1');
    $routes->get('view/(:segment)', 'InventoryController::view/$1');
    $routes->get('create', 'InventoryController::create');
    $routes->post('store', 'InventoryController::store');
    $routes->get('edit/(:segment)', 'InventoryController::edit/$1');
    $routes->post('update/(:segment)', 'InventoryController::update/$1');
    $routes->post('delete/(:segment)', 'InventoryController::delete/$1');
});
$routes->group('api/v1/inventory', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'InventoryApiController::index');
    $routes->get('(:segment)', 'InventoryApiController::show/$1');
    $routes->post('/', 'InventoryApiController::create');
    $routes->put('(:segment)', 'InventoryApiController::update/$1');
    $routes->patch('(:segment)', 'InventoryApiController::patch/$1');
    $routes->delete('(:segment)', 'InventoryApiController::delete/$1');
});
