<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD modifica_conti.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('modifica_conti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ModificaContiController::index');
    $routes->get('export-csv', 'ModificaContiController::exportCsv');
    $routes->get('export-word', 'ModificaContiController::exportWord');
    $routes->get('relation-options/(:segment)', 'ModificaContiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ModificaContiController::view/$1');
    $routes->get('create', 'ModificaContiController::create');
    $routes->post('store', 'ModificaContiController::store');
    $routes->get('edit/(:segment)', 'ModificaContiController::edit/$1');
    $routes->post('update/(:segment)', 'ModificaContiController::update/$1');
    $routes->post('delete/(:segment)', 'ModificaContiController::delete/$1');
});
$routes->group('api/v1/modifica_conti', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ModificaContiApiController::index');
    $routes->get('(:segment)', 'ModificaContiApiController::show/$1');
    $routes->post('/', 'ModificaContiApiController::create');
    $routes->put('(:segment)', 'ModificaContiApiController::update/$1');
    $routes->patch('(:segment)', 'ModificaContiApiController::patch/$1');
    $routes->delete('(:segment)', 'ModificaContiApiController::delete/$1');
});