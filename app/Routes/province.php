<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD province.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('province', static function (RouteCollection $routes): void {
    $routes->get('/', 'ProvinceController::index');
    $routes->get('export-csv', 'ProvinceController::exportCsv');
    $routes->get('export-word', 'ProvinceController::exportWord');
    $routes->get('relation-options/(:segment)', 'ProvinceController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ProvinceController::view/$1');
    $routes->get('create', 'ProvinceController::create');
    $routes->post('store', 'ProvinceController::store');
    $routes->get('edit/(:segment)', 'ProvinceController::edit/$1');
    $routes->post('update/(:segment)', 'ProvinceController::update/$1');
    $routes->post('delete/(:segment)', 'ProvinceController::delete/$1');
});
$routes->group('api/v1/province', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ProvinceApiController::index');
    $routes->get('(:segment)', 'ProvinceApiController::show/$1');
    $routes->post('/', 'ProvinceApiController::create');
    $routes->put('(:segment)', 'ProvinceApiController::update/$1');
    $routes->patch('(:segment)', 'ProvinceApiController::patch/$1');
    $routes->delete('(:segment)', 'ProvinceApiController::delete/$1');
});