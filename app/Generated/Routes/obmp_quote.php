<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_quote.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_quote', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpQuoteController::index');
    $routes->get('export-csv', 'ObmpQuoteController::exportCsv');
    $routes->get('export-word', 'ObmpQuoteController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpQuoteController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpQuoteController::view/$1');
    $routes->get('create', 'ObmpQuoteController::create');
    $routes->post('store', 'ObmpQuoteController::store');
    $routes->get('edit/(:segment)', 'ObmpQuoteController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpQuoteController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpQuoteController::delete/$1');
});
$routes->group('api/v1/obmp_quote', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpQuoteApiController::index');
    $routes->get('(:segment)', 'ObmpQuoteApiController::show/$1');
    $routes->post('/', 'ObmpQuoteApiController::create');
    $routes->put('(:segment)', 'ObmpQuoteApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpQuoteApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpQuoteApiController::delete/$1');
});