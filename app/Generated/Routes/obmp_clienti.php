<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_clienti.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_clienti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpClientiController::index');
    $routes->get('export-csv', 'ObmpClientiController::exportCsv');
    $routes->get('export-word', 'ObmpClientiController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpClientiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpClientiController::view/$1');
    $routes->get('create', 'ObmpClientiController::create');
    $routes->post('store', 'ObmpClientiController::store');
    $routes->get('edit/(:segment)', 'ObmpClientiController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpClientiController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpClientiController::delete/$1');
});
$routes->group('api/v1/obmp_clienti', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpClientiApiController::index');
    $routes->get('(:segment)', 'ObmpClientiApiController::show/$1');
    $routes->post('/', 'ObmpClientiApiController::create');
    $routes->put('(:segment)', 'ObmpClientiApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpClientiApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpClientiApiController::delete/$1');
});