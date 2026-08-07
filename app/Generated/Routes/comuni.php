<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD comuni.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('comuni', static function (RouteCollection $routes): void {
    $routes->get('/', 'ComuniController::index');
    $routes->get('export-csv', 'ComuniController::exportCsv');
    $routes->get('export-word', 'ComuniController::exportWord');
    $routes->get('relation-options/(:segment)', 'ComuniController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ComuniController::view/$1');
    $routes->get('create', 'ComuniController::create');
    $routes->post('store', 'ComuniController::store');
    $routes->get('edit/(:segment)', 'ComuniController::edit/$1');
    $routes->post('update/(:segment)', 'ComuniController::update/$1');
    $routes->post('delete/(:segment)', 'ComuniController::delete/$1');
});
$routes->group('api/v1/comuni', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ComuniApiController::index');
    $routes->get('(:segment)', 'ComuniApiController::show/$1');
    $routes->post('/', 'ComuniApiController::create');
    $routes->put('(:segment)', 'ComuniApiController::update/$1');
    $routes->patch('(:segment)', 'ComuniApiController::patch/$1');
    $routes->delete('(:segment)', 'ComuniApiController::delete/$1');
});