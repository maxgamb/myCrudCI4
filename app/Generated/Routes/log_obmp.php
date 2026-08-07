<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD log_obmp.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('log_obmp', static function (RouteCollection $routes): void {
    $routes->get('/', 'LogObmpController::index');
    $routes->get('export-csv', 'LogObmpController::exportCsv');
    $routes->get('export-word', 'LogObmpController::exportWord');
    $routes->get('relation-options/(:segment)', 'LogObmpController::relationOptions/$1');
    $routes->get('view/(:segment)', 'LogObmpController::view/$1');
    $routes->get('create', 'LogObmpController::create');
    $routes->post('store', 'LogObmpController::store');
    $routes->get('edit/(:segment)', 'LogObmpController::edit/$1');
    $routes->post('update/(:segment)', 'LogObmpController::update/$1');
    $routes->post('delete/(:segment)', 'LogObmpController::delete/$1');
});
$routes->group('api/v1/log_obmp', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'LogObmpApiController::index');
    $routes->get('(:segment)', 'LogObmpApiController::show/$1');
    $routes->post('/', 'LogObmpApiController::create');
    $routes->put('(:segment)', 'LogObmpApiController::update/$1');
    $routes->patch('(:segment)', 'LogObmpApiController::patch/$1');
    $routes->delete('(:segment)', 'LogObmpApiController::delete/$1');
});