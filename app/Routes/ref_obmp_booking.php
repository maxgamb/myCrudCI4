<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD ref_obmp_booking.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('ref_obmp_booking', static function (RouteCollection $routes): void {
    $routes->get('/', 'RefObmpBookingController::index');
    $routes->get('export-csv', 'RefObmpBookingController::exportCsv');
    $routes->get('export-word', 'RefObmpBookingController::exportWord');
    $routes->get('relation-options/(:segment)', 'RefObmpBookingController::relationOptions/$1');
    $routes->get('view/(:segment)', 'RefObmpBookingController::view/$1');
    $routes->get('create', 'RefObmpBookingController::create');
    $routes->post('store', 'RefObmpBookingController::store');
    $routes->get('edit/(:segment)', 'RefObmpBookingController::edit/$1');
    $routes->post('update/(:segment)', 'RefObmpBookingController::update/$1');
    $routes->post('delete/(:segment)', 'RefObmpBookingController::delete/$1');
});
$routes->group('api/v1/ref_obmp_booking', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'RefObmpBookingApiController::index');
    $routes->get('(:segment)', 'RefObmpBookingApiController::show/$1');
    $routes->post('/', 'RefObmpBookingApiController::create');
    $routes->put('(:segment)', 'RefObmpBookingApiController::update/$1');
    $routes->patch('(:segment)', 'RefObmpBookingApiController::patch/$1');
    $routes->delete('(:segment)', 'RefObmpBookingApiController::delete/$1');
});