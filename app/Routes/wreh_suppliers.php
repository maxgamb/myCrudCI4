<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD wreh_suppliers.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('wreh_suppliers', static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehSuppliersController::index');
    $routes->get('export-csv', 'WrehSuppliersController::exportCsv');
    $routes->get('export-word', 'WrehSuppliersController::exportWord');
    $routes->get('relation-options/(:segment)', 'WrehSuppliersController::relationOptions/$1');
    $routes->get('view/(:segment)', 'WrehSuppliersController::view/$1');
    $routes->get('create', 'WrehSuppliersController::create');
    $routes->post('store', 'WrehSuppliersController::store');
    $routes->get('edit/(:segment)', 'WrehSuppliersController::edit/$1');
    $routes->post('update/(:segment)', 'WrehSuppliersController::update/$1');
    $routes->post('delete/(:segment)', 'WrehSuppliersController::delete/$1');
});
$routes->group('api/v1/wreh_suppliers', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehSuppliersApiController::index');
    $routes->get('(:segment)', 'WrehSuppliersApiController::show/$1');
    $routes->post('/', 'WrehSuppliersApiController::create');
    $routes->put('(:segment)', 'WrehSuppliersApiController::update/$1');
    $routes->patch('(:segment)', 'WrehSuppliersApiController::patch/$1');
    $routes->delete('(:segment)', 'WrehSuppliersApiController::delete/$1');
});