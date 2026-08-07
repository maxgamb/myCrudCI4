<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD lettere.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('lettere', static function (RouteCollection $routes): void {
    $routes->get('/', 'LettereController::index');
    $routes->get('export-csv', 'LettereController::exportCsv');
    $routes->get('export-word', 'LettereController::exportWord');
    $routes->get('relation-options/(:segment)', 'LettereController::relationOptions/$1');
    $routes->get('view/(:segment)', 'LettereController::view/$1');
    $routes->get('create', 'LettereController::create');
    $routes->post('store', 'LettereController::store');
    $routes->get('edit/(:segment)', 'LettereController::edit/$1');
    $routes->post('update/(:segment)', 'LettereController::update/$1');
    $routes->post('delete/(:segment)', 'LettereController::delete/$1');
});
$routes->group('api/v1/lettere', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'LettereApiController::index');
    $routes->get('(:segment)', 'LettereApiController::show/$1');
    $routes->post('/', 'LettereApiController::create');
    $routes->put('(:segment)', 'LettereApiController::update/$1');
    $routes->patch('(:segment)', 'LettereApiController::patch/$1');
    $routes->delete('(:segment)', 'LettereApiController::delete/$1');
});