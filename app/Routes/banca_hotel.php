<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD banca_hotel.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('banca_hotel', static function (RouteCollection $routes): void {
    $routes->get('/', 'BancaHotelController::index');
    $routes->get('export-csv', 'BancaHotelController::exportCsv');
    $routes->get('export-word', 'BancaHotelController::exportWord');
    $routes->get('relation-options/(:segment)', 'BancaHotelController::relationOptions/$1');
    $routes->get('view/(:segment)', 'BancaHotelController::view/$1');
    $routes->get('create', 'BancaHotelController::create');
    $routes->post('store', 'BancaHotelController::store');
    $routes->get('edit/(:segment)', 'BancaHotelController::edit/$1');
    $routes->post('update/(:segment)', 'BancaHotelController::update/$1');
    $routes->post('delete/(:segment)', 'BancaHotelController::delete/$1');
});
$routes->group('api/v1/banca_hotel', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'BancaHotelApiController::index');
    $routes->get('(:segment)', 'BancaHotelApiController::show/$1');
    $routes->post('/', 'BancaHotelApiController::create');
    $routes->put('(:segment)', 'BancaHotelApiController::update/$1');
    $routes->patch('(:segment)', 'BancaHotelApiController::patch/$1');
    $routes->delete('(:segment)', 'BancaHotelApiController::delete/$1');
});