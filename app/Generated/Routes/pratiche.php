<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD pratiche.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('pratiche', static function (RouteCollection $routes): void {
    $routes->get('/', 'PraticheController::index');
    $routes->get('export-csv', 'PraticheController::exportCsv');
    $routes->get('export-word', 'PraticheController::exportWord');
    $routes->get('relation-options/(:segment)', 'PraticheController::relationOptions/$1');
    $routes->get('view/(:segment)', 'PraticheController::view/$1');
    $routes->get('create', 'PraticheController::create');
    $routes->post('store', 'PraticheController::store');
    $routes->get('edit/(:segment)', 'PraticheController::edit/$1');
    $routes->post('update/(:segment)', 'PraticheController::update/$1');
    $routes->post('delete/(:segment)', 'PraticheController::delete/$1');
});
$routes->group('api/v1/pratiche', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'PraticheApiController::index');
    $routes->get('(:segment)', 'PraticheApiController::show/$1');
    $routes->post('/', 'PraticheApiController::create');
    $routes->put('(:segment)', 'PraticheApiController::update/$1');
    $routes->patch('(:segment)', 'PraticheApiController::patch/$1');
    $routes->delete('(:segment)', 'PraticheApiController::delete/$1');
});