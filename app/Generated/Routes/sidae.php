<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD sidae.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('sidae', static function (RouteCollection $routes): void {
    $routes->get('/', 'SidaeController::index');
    $routes->get('export-csv', 'SidaeController::exportCsv');
    $routes->get('export-word', 'SidaeController::exportWord');
    $routes->get('relation-options/(:segment)', 'SidaeController::relationOptions/$1');
    $routes->get('view/(:segment)', 'SidaeController::view/$1');
    $routes->get('create', 'SidaeController::create');
    $routes->post('store', 'SidaeController::store');
    $routes->get('edit/(:segment)', 'SidaeController::edit/$1');
    $routes->post('update/(:segment)', 'SidaeController::update/$1');
    $routes->post('delete/(:segment)', 'SidaeController::delete/$1');
});
$routes->group('api/v1/sidae', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'SidaeApiController::index');
    $routes->get('(:segment)', 'SidaeApiController::show/$1');
    $routes->post('/', 'SidaeApiController::create');
    $routes->put('(:segment)', 'SidaeApiController::update/$1');
    $routes->patch('(:segment)', 'SidaeApiController::patch/$1');
    $routes->delete('(:segment)', 'SidaeApiController::delete/$1');
});