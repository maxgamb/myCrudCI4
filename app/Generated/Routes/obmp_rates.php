<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_rates.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_rates', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRatesController::index');
    $routes->get('export-csv', 'ObmpRatesController::exportCsv');
    $routes->get('export-word', 'ObmpRatesController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpRatesController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpRatesController::view/$1');
    $routes->get('create', 'ObmpRatesController::create');
    $routes->post('store', 'ObmpRatesController::store');
    $routes->get('edit/(:segment)', 'ObmpRatesController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpRatesController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpRatesController::delete/$1');
});
$routes->group('api/v1/obmp_rates', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRatesApiController::index');
    $routes->get('(:segment)', 'ObmpRatesApiController::show/$1');
    $routes->post('/', 'ObmpRatesApiController::create');
    $routes->put('(:segment)', 'ObmpRatesApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpRatesApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpRatesApiController::delete/$1');
});