<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD pulizia.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('pulizia', static function (RouteCollection $routes): void {
    $routes->get('/', 'PuliziaController::index');
    $routes->get('export-csv', 'PuliziaController::exportCsv');
    $routes->get('export-word', 'PuliziaController::exportWord');
    $routes->get('relation-options/(:segment)', 'PuliziaController::relationOptions/$1');
    $routes->get('view/(:segment)', 'PuliziaController::view/$1');
    $routes->get('create', 'PuliziaController::create');
    $routes->post('store', 'PuliziaController::store');
    $routes->get('edit/(:segment)', 'PuliziaController::edit/$1');
    $routes->post('update/(:segment)', 'PuliziaController::update/$1');
    $routes->post('delete/(:segment)', 'PuliziaController::delete/$1');
});
$routes->group('api/v1/pulizia', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'PuliziaApiController::index');
    $routes->get('(:segment)', 'PuliziaApiController::show/$1');
    $routes->post('/', 'PuliziaApiController::create');
    $routes->put('(:segment)', 'PuliziaApiController::update/$1');
    $routes->patch('(:segment)', 'PuliziaApiController::patch/$1');
    $routes->delete('(:segment)', 'PuliziaApiController::delete/$1');
});