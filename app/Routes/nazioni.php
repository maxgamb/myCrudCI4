<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD nazioni.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('nazioni', static function (RouteCollection $routes): void {
    $routes->get('/', 'NazioniController::index');
    $routes->get('export-csv', 'NazioniController::exportCsv');
    $routes->get('export-word', 'NazioniController::exportWord');
    $routes->get('relation-options/(:segment)', 'NazioniController::relationOptions/$1');
    $routes->get('view/(:segment)', 'NazioniController::view/$1');
    $routes->get('create', 'NazioniController::create');
    $routes->post('store', 'NazioniController::store');
    $routes->get('edit/(:segment)', 'NazioniController::edit/$1');
    $routes->post('update/(:segment)', 'NazioniController::update/$1');
    $routes->post('delete/(:segment)', 'NazioniController::delete/$1');
});
$routes->group('api/v1/nazioni', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'NazioniApiController::index');
    $routes->get('(:segment)', 'NazioniApiController::show/$1');
    $routes->post('/', 'NazioniApiController::create');
    $routes->put('(:segment)', 'NazioniApiController::update/$1');
    $routes->patch('(:segment)', 'NazioniApiController::patch/$1');
    $routes->delete('(:segment)', 'NazioniApiController::delete/$1');
});