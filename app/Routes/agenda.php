<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD agenda.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('agenda', static function (RouteCollection $routes): void {
    $routes->get('/', 'AgendaController::index');
    $routes->get('export-csv', 'AgendaController::exportCsv');
    $routes->get('export-word', 'AgendaController::exportWord');
    $routes->get('relation-options/(:segment)', 'AgendaController::relationOptions/$1');
    $routes->get('view/(:segment)', 'AgendaController::view/$1');
    $routes->get('create', 'AgendaController::create');
    $routes->post('store', 'AgendaController::store');
    $routes->get('edit/(:segment)', 'AgendaController::edit/$1');
    $routes->post('update/(:segment)', 'AgendaController::update/$1');
    $routes->post('delete/(:segment)', 'AgendaController::delete/$1');
});
$routes->group('api/v1/agenda', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'AgendaApiController::index');
    $routes->get('(:segment)', 'AgendaApiController::show/$1');
    $routes->post('/', 'AgendaApiController::create');
    $routes->put('(:segment)', 'AgendaApiController::update/$1');
    $routes->patch('(:segment)', 'AgendaApiController::patch/$1');
    $routes->delete('(:segment)', 'AgendaApiController::delete/$1');
});