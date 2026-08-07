<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD ci_sessions.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('ci_sessions', static function (RouteCollection $routes): void {
    $routes->get('/', 'CiSessionsController::index');
    $routes->get('export-csv', 'CiSessionsController::exportCsv');
    $routes->get('export-word', 'CiSessionsController::exportWord');
    $routes->get('relation-options/(:segment)', 'CiSessionsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CiSessionsController::view/$1');
    $routes->get('create', 'CiSessionsController::create');
    $routes->post('store', 'CiSessionsController::store');
    $routes->get('edit/(:segment)', 'CiSessionsController::edit/$1');
    $routes->post('update/(:segment)', 'CiSessionsController::update/$1');
    $routes->post('delete/(:segment)', 'CiSessionsController::delete/$1');
});
$routes->group('api/v1/ci_sessions', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CiSessionsApiController::index');
    $routes->get('(:segment)', 'CiSessionsApiController::show/$1');
    $routes->post('/', 'CiSessionsApiController::create');
    $routes->put('(:segment)', 'CiSessionsApiController::update/$1');
    $routes->patch('(:segment)', 'CiSessionsApiController::patch/$1');
    $routes->delete('(:segment)', 'CiSessionsApiController::delete/$1');
});