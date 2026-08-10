<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD country.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('country', static function (RouteCollection $routes): void {
    $routes->get('/', 'CountryController::index');
    $routes->get('export-csv', 'CountryController::exportCsv');
    $routes->get('export-word', 'CountryController::exportWord');
    $routes->get('relation-options/(:segment)', 'CountryController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CountryController::view/$1');
    $routes->get('create', 'CountryController::create');
    $routes->post('store', 'CountryController::store');
    $routes->get('edit/(:segment)', 'CountryController::edit/$1');
    $routes->post('update/(:segment)', 'CountryController::update/$1');
    $routes->post('delete/(:segment)', 'CountryController::delete/$1');
});
$routes->group('api/v1/country', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CountryApiController::index');
    $routes->get('(:segment)', 'CountryApiController::show/$1');
    $routes->post('/', 'CountryApiController::create');
    $routes->put('(:segment)', 'CountryApiController::update/$1');
    $routes->patch('(:segment)', 'CountryApiController::patch/$1');
    $routes->delete('(:segment)', 'CountryApiController::delete/$1');
});