<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD listino_periodi_obmp.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('listino_periodi_obmp', static function (RouteCollection $routes): void {
    $routes->get('/', 'ListinoPeriodiObmpController::index');
    $routes->get('export-csv', 'ListinoPeriodiObmpController::exportCsv');
    $routes->get('export-word', 'ListinoPeriodiObmpController::exportWord');
    $routes->get('relation-options/(:segment)', 'ListinoPeriodiObmpController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ListinoPeriodiObmpController::view/$1');
    $routes->get('create', 'ListinoPeriodiObmpController::create');
    $routes->post('store', 'ListinoPeriodiObmpController::store');
    $routes->get('edit/(:segment)', 'ListinoPeriodiObmpController::edit/$1');
    $routes->post('update/(:segment)', 'ListinoPeriodiObmpController::update/$1');
    $routes->post('delete/(:segment)', 'ListinoPeriodiObmpController::delete/$1');
});
$routes->group('api/v1/listino_periodi_obmp', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ListinoPeriodiObmpApiController::index');
    $routes->get('(:segment)', 'ListinoPeriodiObmpApiController::show/$1');
    $routes->post('/', 'ListinoPeriodiObmpApiController::create');
    $routes->put('(:segment)', 'ListinoPeriodiObmpApiController::update/$1');
    $routes->patch('(:segment)', 'ListinoPeriodiObmpApiController::patch/$1');
    $routes->delete('(:segment)', 'ListinoPeriodiObmpApiController::delete/$1');
});