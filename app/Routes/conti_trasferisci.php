<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD conti_trasferisci.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('conti_trasferisci', static function (RouteCollection $routes): void {
    $routes->get('/', 'ContiTrasferisciController::index');
    $routes->get('export-csv', 'ContiTrasferisciController::exportCsv');
    $routes->get('export-word', 'ContiTrasferisciController::exportWord');
    $routes->get('relation-options/(:segment)', 'ContiTrasferisciController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ContiTrasferisciController::view/$1');
    $routes->get('create', 'ContiTrasferisciController::create');
    $routes->post('store', 'ContiTrasferisciController::store');
    $routes->get('edit/(:segment)', 'ContiTrasferisciController::edit/$1');
    $routes->post('update/(:segment)', 'ContiTrasferisciController::update/$1');
    $routes->post('delete/(:segment)', 'ContiTrasferisciController::delete/$1');
});
$routes->group('api/v1/conti_trasferisci', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ContiTrasferisciApiController::index');
    $routes->get('(:segment)', 'ContiTrasferisciApiController::show/$1');
    $routes->post('/', 'ContiTrasferisciApiController::create');
    $routes->put('(:segment)', 'ContiTrasferisciApiController::update/$1');
    $routes->patch('(:segment)', 'ContiTrasferisciApiController::patch/$1');
    $routes->delete('(:segment)', 'ContiTrasferisciApiController::delete/$1');
});