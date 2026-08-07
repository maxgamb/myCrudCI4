<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD shifts.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('shifts', static function (RouteCollection $routes): void {
    $routes->get('/', 'ShiftsController::index');
    $routes->get('export-csv', 'ShiftsController::exportCsv');
    $routes->get('export-word', 'ShiftsController::exportWord');
    $routes->get('relation-options/(:segment)', 'ShiftsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ShiftsController::view/$1');
    $routes->get('create', 'ShiftsController::create');
    $routes->post('store', 'ShiftsController::store');
    $routes->get('edit/(:segment)', 'ShiftsController::edit/$1');
    $routes->post('update/(:segment)', 'ShiftsController::update/$1');
    $routes->post('delete/(:segment)', 'ShiftsController::delete/$1');
});
$routes->group('api/v1/shifts', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ShiftsApiController::index');
    $routes->get('(:segment)', 'ShiftsApiController::show/$1');
    $routes->post('/', 'ShiftsApiController::create');
    $routes->put('(:segment)', 'ShiftsApiController::update/$1');
    $routes->patch('(:segment)', 'ShiftsApiController::patch/$1');
    $routes->delete('(:segment)', 'ShiftsApiController::delete/$1');
});