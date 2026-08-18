<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD city.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('city', static function (RouteCollection $routes): void {
    $routes->get('/', 'CityController::index');
    $routes->get('export-csv', 'CityController::exportCsv');
    $routes->get('export-word', 'CityController::exportWord');
    $routes->get('relation-options/(:segment)', 'CityController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CityController::view/$1');
    $routes->get('create', 'CityController::create');
    $routes->post('store', 'CityController::store');
    $routes->get('edit/(:segment)', 'CityController::edit/$1');
    $routes->post('update/(:segment)', 'CityController::update/$1');
    $routes->post('delete/(:segment)', 'CityController::delete/$1');
});
$routes->group('api/v1/city', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CityApiController::index');
    $routes->get('(:segment)', 'CityApiController::show/$1');
    $routes->post('/', 'CityApiController::create');
    $routes->put('(:segment)', 'CityApiController::update/$1');
    $routes->patch('(:segment)', 'CityApiController::patch/$1');
    $routes->delete('(:segment)', 'CityApiController::delete/$1');
});
