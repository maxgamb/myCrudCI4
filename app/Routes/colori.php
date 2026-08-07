<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD colori.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('colori', static function (RouteCollection $routes): void {
    $routes->get('/', 'ColoriController::index');
    $routes->get('export-csv', 'ColoriController::exportCsv');
    $routes->get('export-word', 'ColoriController::exportWord');
    $routes->get('relation-options/(:segment)', 'ColoriController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ColoriController::view/$1');
    $routes->get('create', 'ColoriController::create');
    $routes->post('store', 'ColoriController::store');
    $routes->get('edit/(:segment)', 'ColoriController::edit/$1');
    $routes->post('update/(:segment)', 'ColoriController::update/$1');
    $routes->post('delete/(:segment)', 'ColoriController::delete/$1');
});
$routes->group('api/v1/colori', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ColoriApiController::index');
    $routes->get('(:segment)', 'ColoriApiController::show/$1');
    $routes->post('/', 'ColoriApiController::create');
    $routes->put('(:segment)', 'ColoriApiController::update/$1');
    $routes->patch('(:segment)', 'ColoriApiController::patch/$1');
    $routes->delete('(:segment)', 'ColoriApiController::delete/$1');
});