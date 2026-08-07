<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD wreh_orders.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('wreh_orders', static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehOrdersController::index');
    $routes->get('export-csv', 'WrehOrdersController::exportCsv');
    $routes->get('export-word', 'WrehOrdersController::exportWord');
    $routes->get('relation-options/(:segment)', 'WrehOrdersController::relationOptions/$1');
    $routes->get('view/(:segment)', 'WrehOrdersController::view/$1');
    $routes->get('create', 'WrehOrdersController::create');
    $routes->post('store', 'WrehOrdersController::store');
    $routes->get('edit/(:segment)', 'WrehOrdersController::edit/$1');
    $routes->post('update/(:segment)', 'WrehOrdersController::update/$1');
    $routes->post('delete/(:segment)', 'WrehOrdersController::delete/$1');
});
$routes->group('api/v1/wreh_orders', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehOrdersApiController::index');
    $routes->get('(:segment)', 'WrehOrdersApiController::show/$1');
    $routes->post('/', 'WrehOrdersApiController::create');
    $routes->put('(:segment)', 'WrehOrdersApiController::update/$1');
    $routes->patch('(:segment)', 'WrehOrdersApiController::patch/$1');
    $routes->delete('(:segment)', 'WrehOrdersApiController::delete/$1');
});