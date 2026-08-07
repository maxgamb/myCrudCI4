<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD prezzi.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('prezzi', static function (RouteCollection $routes): void {
    $routes->get('/', 'PrezziController::index');
    $routes->get('export-csv', 'PrezziController::exportCsv');
    $routes->get('export-word', 'PrezziController::exportWord');
    $routes->get('relation-options/(:segment)', 'PrezziController::relationOptions/$1');
    $routes->get('view/(:segment)', 'PrezziController::view/$1');
    $routes->get('create', 'PrezziController::create');
    $routes->post('store', 'PrezziController::store');
    $routes->get('edit/(:segment)', 'PrezziController::edit/$1');
    $routes->post('update/(:segment)', 'PrezziController::update/$1');
    $routes->post('delete/(:segment)', 'PrezziController::delete/$1');
});
$routes->group('api/v1/prezzi', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'PrezziApiController::index');
    $routes->get('(:segment)', 'PrezziApiController::show/$1');
    $routes->post('/', 'PrezziApiController::create');
    $routes->put('(:segment)', 'PrezziApiController::update/$1');
    $routes->patch('(:segment)', 'PrezziApiController::patch/$1');
    $routes->delete('(:segment)', 'PrezziApiController::delete/$1');
});