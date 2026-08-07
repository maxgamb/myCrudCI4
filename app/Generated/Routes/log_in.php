<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD log_in.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('log_in', static function (RouteCollection $routes): void {
    $routes->get('/', 'LogInController::index');
    $routes->get('export-csv', 'LogInController::exportCsv');
    $routes->get('export-word', 'LogInController::exportWord');
    $routes->get('relation-options/(:segment)', 'LogInController::relationOptions/$1');
    $routes->get('view/(:segment)', 'LogInController::view/$1');
    $routes->get('create', 'LogInController::create');
    $routes->post('store', 'LogInController::store');
    $routes->get('edit/(:segment)', 'LogInController::edit/$1');
    $routes->post('update/(:segment)', 'LogInController::update/$1');
    $routes->post('delete/(:segment)', 'LogInController::delete/$1');
});
$routes->group('api/v1/log_in', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'LogInApiController::index');
    $routes->get('(:segment)', 'LogInApiController::show/$1');
    $routes->post('/', 'LogInApiController::create');
    $routes->put('(:segment)', 'LogInApiController::update/$1');
    $routes->patch('(:segment)', 'LogInApiController::patch/$1');
    $routes->delete('(:segment)', 'LogInApiController::delete/$1');
});