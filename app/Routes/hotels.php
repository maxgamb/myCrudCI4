<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD hotels.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('hotels', static function (RouteCollection $routes): void {
    $routes->get('/', 'HotelsController::index');
    $routes->get('export-csv', 'HotelsController::exportCsv');
    $routes->get('export-word', 'HotelsController::exportWord');
    $routes->get('relation-options/(:segment)', 'HotelsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'HotelsController::view/$1');
    $routes->get('create', 'HotelsController::create');
    $routes->post('store', 'HotelsController::store');
    $routes->get('edit/(:segment)', 'HotelsController::edit/$1');
    $routes->post('update/(:segment)', 'HotelsController::update/$1');
    $routes->post('delete/(:segment)', 'HotelsController::delete/$1');
});
$routes->group('api/v1/hotels', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'HotelsApiController::index');
    $routes->get('(:segment)', 'HotelsApiController::show/$1');
    $routes->post('/', 'HotelsApiController::create');
    $routes->put('(:segment)', 'HotelsApiController::update/$1');
    $routes->patch('(:segment)', 'HotelsApiController::patch/$1');
    $routes->delete('(:segment)', 'HotelsApiController::delete/$1');
});