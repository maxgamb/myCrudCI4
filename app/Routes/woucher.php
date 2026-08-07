<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD woucher.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('woucher', static function (RouteCollection $routes): void {
    $routes->get('/', 'WoucherController::index');
    $routes->get('export-csv', 'WoucherController::exportCsv');
    $routes->get('export-word', 'WoucherController::exportWord');
    $routes->get('relation-options/(:segment)', 'WoucherController::relationOptions/$1');
    $routes->get('view/(:segment)', 'WoucherController::view/$1');
    $routes->get('create', 'WoucherController::create');
    $routes->post('store', 'WoucherController::store');
    $routes->get('edit/(:segment)', 'WoucherController::edit/$1');
    $routes->post('update/(:segment)', 'WoucherController::update/$1');
    $routes->post('delete/(:segment)', 'WoucherController::delete/$1');
});
$routes->group('api/v1/woucher', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'WoucherApiController::index');
    $routes->get('(:segment)', 'WoucherApiController::show/$1');
    $routes->post('/', 'WoucherApiController::create');
    $routes->put('(:segment)', 'WoucherApiController::update/$1');
    $routes->patch('(:segment)', 'WoucherApiController::patch/$1');
    $routes->delete('(:segment)', 'WoucherApiController::delete/$1');
});