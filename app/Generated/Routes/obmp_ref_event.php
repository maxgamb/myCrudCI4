<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_ref_event.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_ref_event', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRefEventController::index');
    $routes->get('export-csv', 'ObmpRefEventController::exportCsv');
    $routes->get('export-word', 'ObmpRefEventController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpRefEventController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpRefEventController::view/$1');
    $routes->get('create', 'ObmpRefEventController::create');
    $routes->post('store', 'ObmpRefEventController::store');
    $routes->get('edit/(:segment)', 'ObmpRefEventController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpRefEventController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpRefEventController::delete/$1');
});
$routes->group('api/v1/obmp_ref_event', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRefEventApiController::index');
    $routes->get('(:segment)', 'ObmpRefEventApiController::show/$1');
    $routes->post('/', 'ObmpRefEventApiController::create');
    $routes->put('(:segment)', 'ObmpRefEventApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpRefEventApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpRefEventApiController::delete/$1');
});