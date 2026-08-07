<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD punti_spesi.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('punti_spesi', static function (RouteCollection $routes): void {
    $routes->get('/', 'PuntiSpesiController::index');
    $routes->get('export-csv', 'PuntiSpesiController::exportCsv');
    $routes->get('export-word', 'PuntiSpesiController::exportWord');
    $routes->get('relation-options/(:segment)', 'PuntiSpesiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'PuntiSpesiController::view/$1');
    $routes->get('create', 'PuntiSpesiController::create');
    $routes->post('store', 'PuntiSpesiController::store');
    $routes->get('edit/(:segment)', 'PuntiSpesiController::edit/$1');
    $routes->post('update/(:segment)', 'PuntiSpesiController::update/$1');
    $routes->post('delete/(:segment)', 'PuntiSpesiController::delete/$1');
});
$routes->group('api/v1/punti_spesi', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'PuntiSpesiApiController::index');
    $routes->get('(:segment)', 'PuntiSpesiApiController::show/$1');
    $routes->post('/', 'PuntiSpesiApiController::create');
    $routes->put('(:segment)', 'PuntiSpesiApiController::update/$1');
    $routes->patch('(:segment)', 'PuntiSpesiApiController::patch/$1');
    $routes->delete('(:segment)', 'PuntiSpesiApiController::delete/$1');
});