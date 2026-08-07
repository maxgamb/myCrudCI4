<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD sospesi.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('sospesi', static function (RouteCollection $routes): void {
    $routes->get('/', 'SospesiController::index');
    $routes->get('export-csv', 'SospesiController::exportCsv');
    $routes->get('export-word', 'SospesiController::exportWord');
    $routes->get('relation-options/(:segment)', 'SospesiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'SospesiController::view/$1');
    $routes->get('create', 'SospesiController::create');
    $routes->post('store', 'SospesiController::store');
    $routes->get('edit/(:segment)', 'SospesiController::edit/$1');
    $routes->post('update/(:segment)', 'SospesiController::update/$1');
    $routes->post('delete/(:segment)', 'SospesiController::delete/$1');
});
$routes->group('api/v1/sospesi', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'SospesiApiController::index');
    $routes->get('(:segment)', 'SospesiApiController::show/$1');
    $routes->post('/', 'SospesiApiController::create');
    $routes->put('(:segment)', 'SospesiApiController::update/$1');
    $routes->patch('(:segment)', 'SospesiApiController::patch/$1');
    $routes->delete('(:segment)', 'SospesiApiController::delete/$1');
});