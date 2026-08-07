<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD tipoallogiati.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('tipoallogiati', static function (RouteCollection $routes): void {
    $routes->get('/', 'TipoallogiatiController::index');
    $routes->get('export-csv', 'TipoallogiatiController::exportCsv');
    $routes->get('export-word', 'TipoallogiatiController::exportWord');
    $routes->get('relation-options/(:segment)', 'TipoallogiatiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'TipoallogiatiController::view/$1');
    $routes->get('create', 'TipoallogiatiController::create');
    $routes->post('store', 'TipoallogiatiController::store');
    $routes->get('edit/(:segment)', 'TipoallogiatiController::edit/$1');
    $routes->post('update/(:segment)', 'TipoallogiatiController::update/$1');
    $routes->post('delete/(:segment)', 'TipoallogiatiController::delete/$1');
});
$routes->group('api/v1/tipoallogiati', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'TipoallogiatiApiController::index');
    $routes->get('(:segment)', 'TipoallogiatiApiController::show/$1');
    $routes->post('/', 'TipoallogiatiApiController::create');
    $routes->put('(:segment)', 'TipoallogiatiApiController::update/$1');
    $routes->patch('(:segment)', 'TipoallogiatiApiController::patch/$1');
    $routes->delete('(:segment)', 'TipoallogiatiApiController::delete/$1');
});