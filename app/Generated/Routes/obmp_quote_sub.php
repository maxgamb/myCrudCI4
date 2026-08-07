<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_quote_sub.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_quote_sub', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpQuoteSubController::index');
    $routes->get('export-csv', 'ObmpQuoteSubController::exportCsv');
    $routes->get('export-word', 'ObmpQuoteSubController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpQuoteSubController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpQuoteSubController::view/$1');
    $routes->get('create', 'ObmpQuoteSubController::create');
    $routes->post('store', 'ObmpQuoteSubController::store');
    $routes->get('edit/(:segment)', 'ObmpQuoteSubController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpQuoteSubController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpQuoteSubController::delete/$1');
});
$routes->group('api/v1/obmp_quote_sub', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpQuoteSubApiController::index');
    $routes->get('(:segment)', 'ObmpQuoteSubApiController::show/$1');
    $routes->post('/', 'ObmpQuoteSubApiController::create');
    $routes->put('(:segment)', 'ObmpQuoteSubApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpQuoteSubApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpQuoteSubApiController::delete/$1');
});