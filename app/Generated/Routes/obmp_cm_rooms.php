<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_cm_rooms.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_cm_rooms', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCmRoomsController::index');
    $routes->get('export-csv', 'ObmpCmRoomsController::exportCsv');
    $routes->get('export-word', 'ObmpCmRoomsController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpCmRoomsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpCmRoomsController::view/$1');
    $routes->get('create', 'ObmpCmRoomsController::create');
    $routes->post('store', 'ObmpCmRoomsController::store');
    $routes->get('edit/(:segment)', 'ObmpCmRoomsController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpCmRoomsController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpCmRoomsController::delete/$1');
});
$routes->group('api/v1/obmp_cm_rooms', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCmRoomsApiController::index');
    $routes->get('(:segment)', 'ObmpCmRoomsApiController::show/$1');
    $routes->post('/', 'ObmpCmRoomsApiController::create');
    $routes->put('(:segment)', 'ObmpCmRoomsApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpCmRoomsApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpCmRoomsApiController::delete/$1');
});