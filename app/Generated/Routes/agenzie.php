<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD agenzie.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('agenzie', static function (RouteCollection $routes): void {
    $routes->get('/', 'AgenzieController::index');
    $routes->get('export-csv', 'AgenzieController::exportCsv');
    $routes->get('export-word', 'AgenzieController::exportWord');
    $routes->get('relation-options/(:segment)', 'AgenzieController::relationOptions/$1');
    $routes->get('view/(:segment)', 'AgenzieController::view/$1');
    $routes->get('create', 'AgenzieController::create');
    $routes->post('store', 'AgenzieController::store');
    $routes->get('edit/(:segment)', 'AgenzieController::edit/$1');
    $routes->post('update/(:segment)', 'AgenzieController::update/$1');
    $routes->post('delete/(:segment)', 'AgenzieController::delete/$1');
});
$routes->group('api/v1/agenzie', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'AgenzieApiController::index');
    $routes->get('(:segment)', 'AgenzieApiController::show/$1');
    $routes->post('/', 'AgenzieApiController::create');
    $routes->put('(:segment)', 'AgenzieApiController::update/$1');
    $routes->patch('(:segment)', 'AgenzieApiController::patch/$1');
    $routes->delete('(:segment)', 'AgenzieApiController::delete/$1');
});