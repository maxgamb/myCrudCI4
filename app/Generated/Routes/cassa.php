<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD cassa.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('cassa', static function (RouteCollection $routes): void {
    $routes->get('/', 'CassaController::index');
    $routes->get('export-csv', 'CassaController::exportCsv');
    $routes->get('export-word', 'CassaController::exportWord');
    $routes->get('relation-options/(:segment)', 'CassaController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CassaController::view/$1');
    $routes->get('create', 'CassaController::create');
    $routes->post('store', 'CassaController::store');
    $routes->get('edit/(:segment)', 'CassaController::edit/$1');
    $routes->post('update/(:segment)', 'CassaController::update/$1');
    $routes->post('delete/(:segment)', 'CassaController::delete/$1');
});
$routes->group('api/v1/cassa', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CassaApiController::index');
    $routes->get('(:segment)', 'CassaApiController::show/$1');
    $routes->post('/', 'CassaApiController::create');
    $routes->put('(:segment)', 'CassaApiController::update/$1');
    $routes->patch('(:segment)', 'CassaApiController::patch/$1');
    $routes->delete('(:segment)', 'CassaApiController::delete/$1');
});