<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD address.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('address', static function (RouteCollection $routes): void {
    $routes->get('/', 'AddressController::index');
    $routes->get('export-csv', 'AddressController::exportCsv');
    $routes->get('export-word', 'AddressController::exportWord');
    $routes->get('relation-options/(:segment)', 'AddressController::relationOptions/$1');
    $routes->get('view/(:segment)', 'AddressController::view/$1');
    $routes->get('create', 'AddressController::create');
    $routes->post('store', 'AddressController::store');
    $routes->get('edit/(:segment)', 'AddressController::edit/$1');
    $routes->post('update/(:segment)', 'AddressController::update/$1');
    $routes->post('delete/(:segment)', 'AddressController::delete/$1');
});
$routes->group('api/v1/address', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'AddressApiController::index');
    $routes->get('(:segment)', 'AddressApiController::show/$1');
    $routes->post('/', 'AddressApiController::create');
    $routes->put('(:segment)', 'AddressApiController::update/$1');
    $routes->patch('(:segment)', 'AddressApiController::patch/$1');
    $routes->delete('(:segment)', 'AddressApiController::delete/$1');
});