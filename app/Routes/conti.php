<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD conti.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('conti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ContiController::index');
    $routes->get('export-csv', 'ContiController::exportCsv');
    $routes->get('export-word', 'ContiController::exportWord');
    $routes->get('relation-options/(:segment)', 'ContiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ContiController::view/$1');
    $routes->get('create', 'ContiController::create');
    $routes->post('store', 'ContiController::store');
    $routes->get('edit/(:segment)', 'ContiController::edit/$1');
    $routes->post('update/(:segment)', 'ContiController::update/$1');
    $routes->post('delete/(:segment)', 'ContiController::delete/$1');
});
$routes->group('api/v1/conti', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ContiApiController::index');
    $routes->get('(:segment)', 'ContiApiController::show/$1');
    $routes->post('/', 'ContiApiController::create');
    $routes->put('(:segment)', 'ContiApiController::update/$1');
    $routes->patch('(:segment)', 'ContiApiController::patch/$1');
    $routes->delete('(:segment)', 'ContiApiController::delete/$1');
});