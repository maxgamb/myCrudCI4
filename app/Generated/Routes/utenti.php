<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD utenti.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('utenti', static function (RouteCollection $routes): void {
    $routes->get('/', 'UtentiController::index');
    $routes->get('export-csv', 'UtentiController::exportCsv');
    $routes->get('export-word', 'UtentiController::exportWord');
    $routes->get('relation-options/(:segment)', 'UtentiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'UtentiController::view/$1');
    $routes->get('create', 'UtentiController::create');
    $routes->post('store', 'UtentiController::store');
    $routes->get('edit/(:segment)', 'UtentiController::edit/$1');
    $routes->post('update/(:segment)', 'UtentiController::update/$1');
    $routes->post('delete/(:segment)', 'UtentiController::delete/$1');
});
$routes->group('api/v1/utenti', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'UtentiApiController::index');
    $routes->get('(:segment)', 'UtentiApiController::show/$1');
    $routes->post('/', 'UtentiApiController::create');
    $routes->put('(:segment)', 'UtentiApiController::update/$1');
    $routes->patch('(:segment)', 'UtentiApiController::patch/$1');
    $routes->delete('(:segment)', 'UtentiApiController::delete/$1');
});