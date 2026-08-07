<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD manutenzioni.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('manutenzioni', static function (RouteCollection $routes): void {
    $routes->get('/', 'ManutenzioniController::index');
    $routes->get('export-csv', 'ManutenzioniController::exportCsv');
    $routes->get('export-word', 'ManutenzioniController::exportWord');
    $routes->get('relation-options/(:segment)', 'ManutenzioniController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ManutenzioniController::view/$1');
    $routes->get('create', 'ManutenzioniController::create');
    $routes->post('store', 'ManutenzioniController::store');
    $routes->get('edit/(:segment)', 'ManutenzioniController::edit/$1');
    $routes->post('update/(:segment)', 'ManutenzioniController::update/$1');
    $routes->post('delete/(:segment)', 'ManutenzioniController::delete/$1');
});
$routes->group('api/v1/manutenzioni', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ManutenzioniApiController::index');
    $routes->get('(:segment)', 'ManutenzioniApiController::show/$1');
    $routes->post('/', 'ManutenzioniApiController::create');
    $routes->put('(:segment)', 'ManutenzioniApiController::update/$1');
    $routes->patch('(:segment)', 'ManutenzioniApiController::patch/$1');
    $routes->delete('(:segment)', 'ManutenzioniApiController::delete/$1');
});