<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD clienti.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('clienti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ClientiController::index');
    $routes->get('export-csv', 'ClientiController::exportCsv');
    $routes->get('export-word', 'ClientiController::exportWord');
    $routes->get('relation-options/(:segment)', 'ClientiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ClientiController::view/$1');
    $routes->get('create', 'ClientiController::create');
    $routes->post('store', 'ClientiController::store');
    $routes->get('edit/(:segment)', 'ClientiController::edit/$1');
    $routes->post('update/(:segment)', 'ClientiController::update/$1');
    $routes->post('delete/(:segment)', 'ClientiController::delete/$1');
});
$routes->group('api/v1/clienti', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ClientiApiController::index');
    $routes->get('(:segment)', 'ClientiApiController::show/$1');
    $routes->post('/', 'ClientiApiController::create');
    $routes->put('(:segment)', 'ClientiApiController::update/$1');
    $routes->patch('(:segment)', 'ClientiApiController::patch/$1');
    $routes->delete('(:segment)', 'ClientiApiController::delete/$1');
});