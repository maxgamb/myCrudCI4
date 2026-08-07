<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD token.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('token', static function (RouteCollection $routes): void {
    $routes->get('/', 'TokenController::index');
    $routes->get('export-csv', 'TokenController::exportCsv');
    $routes->get('export-word', 'TokenController::exportWord');
    $routes->get('relation-options/(:segment)', 'TokenController::relationOptions/$1');
    $routes->get('view/(:segment)', 'TokenController::view/$1');
    $routes->get('create', 'TokenController::create');
    $routes->post('store', 'TokenController::store');
    $routes->get('edit/(:segment)', 'TokenController::edit/$1');
    $routes->post('update/(:segment)', 'TokenController::update/$1');
    $routes->post('delete/(:segment)', 'TokenController::delete/$1');
});
$routes->group('api/v1/token', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'TokenApiController::index');
    $routes->get('(:segment)', 'TokenApiController::show/$1');
    $routes->post('/', 'TokenApiController::create');
    $routes->put('(:segment)', 'TokenApiController::update/$1');
    $routes->patch('(:segment)', 'TokenApiController::patch/$1');
    $routes->delete('(:segment)', 'TokenApiController::delete/$1');
});