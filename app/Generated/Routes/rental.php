<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD rental.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('rental', static function (RouteCollection $routes): void {
    $routes->get('/', 'RentalController::index');
    $routes->get('export-csv', 'RentalController::exportCsv');
    $routes->get('export-word', 'RentalController::exportWord');
    $routes->get('relation-options/(:segment)', 'RentalController::relationOptions/$1');
    $routes->get('view/(:segment)', 'RentalController::view/$1');
    $routes->get('create', 'RentalController::create');
    $routes->post('store', 'RentalController::store');
    $routes->get('edit/(:segment)', 'RentalController::edit/$1');
    $routes->post('update/(:segment)', 'RentalController::update/$1');
    $routes->post('delete/(:segment)', 'RentalController::delete/$1');
});
$routes->group('api/v1/rental', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'RentalApiController::index');
    $routes->get('(:segment)', 'RentalApiController::show/$1');
    $routes->post('/', 'RentalApiController::create');
    $routes->put('(:segment)', 'RentalApiController::update/$1');
    $routes->patch('(:segment)', 'RentalApiController::patch/$1');
    $routes->delete('(:segment)', 'RentalApiController::delete/$1');
});