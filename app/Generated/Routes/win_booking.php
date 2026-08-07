<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD win_booking.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('win_booking', static function (RouteCollection $routes): void {
    $routes->get('/', 'WinBookingController::index');
    $routes->get('export-csv', 'WinBookingController::exportCsv');
    $routes->get('export-word', 'WinBookingController::exportWord');
    $routes->get('relation-options/(:segment)', 'WinBookingController::relationOptions/$1');
    $routes->get('view/(:segment)', 'WinBookingController::view/$1');
    $routes->get('create', 'WinBookingController::create');
    $routes->post('store', 'WinBookingController::store');
    $routes->get('edit/(:segment)', 'WinBookingController::edit/$1');
    $routes->post('update/(:segment)', 'WinBookingController::update/$1');
    $routes->post('delete/(:segment)', 'WinBookingController::delete/$1');
});
$routes->group('api/v1/win_booking', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'WinBookingApiController::index');
    $routes->get('(:segment)', 'WinBookingApiController::show/$1');
    $routes->post('/', 'WinBookingApiController::create');
    $routes->put('(:segment)', 'WinBookingApiController::update/$1');
    $routes->patch('(:segment)', 'WinBookingApiController::patch/$1');
    $routes->delete('(:segment)', 'WinBookingApiController::delete/$1');
});