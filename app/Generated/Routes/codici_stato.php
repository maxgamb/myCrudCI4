<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD codici_stato.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('codici_stato', static function (RouteCollection $routes): void {
    $routes->get('/', 'CodiciStatoController::index');
    $routes->get('export-csv', 'CodiciStatoController::exportCsv');
    $routes->get('export-word', 'CodiciStatoController::exportWord');
    $routes->get('relation-options/(:segment)', 'CodiciStatoController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CodiciStatoController::view/$1');
    $routes->get('create', 'CodiciStatoController::create');
    $routes->post('store', 'CodiciStatoController::store');
    $routes->get('edit/(:segment)', 'CodiciStatoController::edit/$1');
    $routes->post('update/(:segment)', 'CodiciStatoController::update/$1');
    $routes->post('delete/(:segment)', 'CodiciStatoController::delete/$1');
});
$routes->group('api/v1/codici_stato', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CodiciStatoApiController::index');
    $routes->get('(:segment)', 'CodiciStatoApiController::show/$1');
    $routes->post('/', 'CodiciStatoApiController::create');
    $routes->put('(:segment)', 'CodiciStatoApiController::update/$1');
    $routes->patch('(:segment)', 'CodiciStatoApiController::patch/$1');
    $routes->delete('(:segment)', 'CodiciStatoApiController::delete/$1');
});