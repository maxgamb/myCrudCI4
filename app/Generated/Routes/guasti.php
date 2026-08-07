<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD guasti.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('guasti', static function (RouteCollection $routes): void {
    $routes->get('/', 'GuastiController::index');
    $routes->get('export-csv', 'GuastiController::exportCsv');
    $routes->get('export-word', 'GuastiController::exportWord');
    $routes->get('relation-options/(:segment)', 'GuastiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'GuastiController::view/$1');
    $routes->get('create', 'GuastiController::create');
    $routes->post('store', 'GuastiController::store');
    $routes->get('edit/(:segment)', 'GuastiController::edit/$1');
    $routes->post('update/(:segment)', 'GuastiController::update/$1');
    $routes->post('delete/(:segment)', 'GuastiController::delete/$1');
});
$routes->group('api/v1/guasti', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'GuastiApiController::index');
    $routes->get('(:segment)', 'GuastiApiController::show/$1');
    $routes->post('/', 'GuastiApiController::create');
    $routes->put('(:segment)', 'GuastiApiController::update/$1');
    $routes->patch('(:segment)', 'GuastiApiController::patch/$1');
    $routes->delete('(:segment)', 'GuastiApiController::delete/$1');
});