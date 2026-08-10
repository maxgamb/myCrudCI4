<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD customer.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('customer', static function (RouteCollection $routes): void {
    $routes->get('/', 'CustomerController::index');
    $routes->get('export-csv', 'CustomerController::exportCsv');
    $routes->get('export-word', 'CustomerController::exportWord');
    $routes->get('relation-options/(:segment)', 'CustomerController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CustomerController::view/$1');
    $routes->get('create', 'CustomerController::create');
    $routes->post('store', 'CustomerController::store');
    $routes->get('edit/(:segment)', 'CustomerController::edit/$1');
    $routes->post('update/(:segment)', 'CustomerController::update/$1');
    $routes->post('delete/(:segment)', 'CustomerController::delete/$1');
});
$routes->group('api/v1/customer', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CustomerApiController::index');
    $routes->get('(:segment)', 'CustomerApiController::show/$1');
    $routes->post('/', 'CustomerApiController::create');
    $routes->put('(:segment)', 'CustomerApiController::update/$1');
    $routes->patch('(:segment)', 'CustomerApiController::patch/$1');
    $routes->delete('(:segment)', 'CustomerApiController::delete/$1');
});