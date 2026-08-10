<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD store.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('store', static function (RouteCollection $routes): void {
    $routes->get('/', 'StoreController::index');
    $routes->get('export-csv', 'StoreController::exportCsv');
    $routes->get('export-word', 'StoreController::exportWord');
    $routes->get('relation-options/(:segment)', 'StoreController::relationOptions/$1');
    $routes->get('view/(:segment)', 'StoreController::view/$1');
    $routes->get('create', 'StoreController::create');
    $routes->post('store', 'StoreController::store');
    $routes->get('edit/(:segment)', 'StoreController::edit/$1');
    $routes->post('update/(:segment)', 'StoreController::update/$1');
    $routes->post('delete/(:segment)', 'StoreController::delete/$1');
});
$routes->group('api/v1/store', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'StoreApiController::index');
    $routes->get('(:segment)', 'StoreApiController::show/$1');
    $routes->post('/', 'StoreApiController::create');
    $routes->put('(:segment)', 'StoreApiController::update/$1');
    $routes->patch('(:segment)', 'StoreApiController::patch/$1');
    $routes->delete('(:segment)', 'StoreApiController::delete/$1');
});