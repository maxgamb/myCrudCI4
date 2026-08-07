<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD listino_obmp.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('listino_obmp', static function (RouteCollection $routes): void {
    $routes->get('/', 'ListinoObmpController::index');
    $routes->get('export-csv', 'ListinoObmpController::exportCsv');
    $routes->get('export-word', 'ListinoObmpController::exportWord');
    $routes->get('relation-options/(:segment)', 'ListinoObmpController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ListinoObmpController::view/$1');
    $routes->get('create', 'ListinoObmpController::create');
    $routes->post('store', 'ListinoObmpController::store');
    $routes->get('edit/(:segment)', 'ListinoObmpController::edit/$1');
    $routes->post('update/(:segment)', 'ListinoObmpController::update/$1');
    $routes->post('delete/(:segment)', 'ListinoObmpController::delete/$1');
});
$routes->group('api/v1/listino_obmp', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ListinoObmpApiController::index');
    $routes->get('(:segment)', 'ListinoObmpApiController::show/$1');
    $routes->post('/', 'ListinoObmpApiController::create');
    $routes->put('(:segment)', 'ListinoObmpApiController::update/$1');
    $routes->patch('(:segment)', 'ListinoObmpApiController::patch/$1');
    $routes->delete('(:segment)', 'ListinoObmpApiController::delete/$1');
});