<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD log_obmp_full.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('log_obmp_full', static function (RouteCollection $routes): void {
    $routes->get('/', 'LogObmpFullController::index');
    $routes->get('export-csv', 'LogObmpFullController::exportCsv');
    $routes->get('export-word', 'LogObmpFullController::exportWord');
    $routes->get('relation-options/(:segment)', 'LogObmpFullController::relationOptions/$1');
    $routes->get('view/(:segment)', 'LogObmpFullController::view/$1');
    $routes->get('create', 'LogObmpFullController::create');
    $routes->post('store', 'LogObmpFullController::store');
    $routes->get('edit/(:segment)', 'LogObmpFullController::edit/$1');
    $routes->post('update/(:segment)', 'LogObmpFullController::update/$1');
    $routes->post('delete/(:segment)', 'LogObmpFullController::delete/$1');
});
$routes->group('api/v1/log_obmp_full', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'LogObmpFullApiController::index');
    $routes->get('(:segment)', 'LogObmpFullApiController::show/$1');
    $routes->post('/', 'LogObmpFullApiController::create');
    $routes->put('(:segment)', 'LogObmpFullApiController::update/$1');
    $routes->patch('(:segment)', 'LogObmpFullApiController::patch/$1');
    $routes->delete('(:segment)', 'LogObmpFullApiController::delete/$1');
});