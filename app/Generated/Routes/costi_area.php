<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD costi_area.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('costi_area', static function (RouteCollection $routes): void {
    $routes->get('/', 'CostiAreaController::index');
    $routes->get('export-csv', 'CostiAreaController::exportCsv');
    $routes->get('export-word', 'CostiAreaController::exportWord');
    $routes->get('relation-options/(:segment)', 'CostiAreaController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CostiAreaController::view/$1');
    $routes->get('create', 'CostiAreaController::create');
    $routes->post('store', 'CostiAreaController::store');
    $routes->get('edit/(:segment)', 'CostiAreaController::edit/$1');
    $routes->post('update/(:segment)', 'CostiAreaController::update/$1');
    $routes->post('delete/(:segment)', 'CostiAreaController::delete/$1');
});
$routes->group('api/v1/costi_area', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CostiAreaApiController::index');
    $routes->get('(:segment)', 'CostiAreaApiController::show/$1');
    $routes->post('/', 'CostiAreaApiController::create');
    $routes->put('(:segment)', 'CostiAreaApiController::update/$1');
    $routes->patch('(:segment)', 'CostiAreaApiController::patch/$1');
    $routes->delete('(:segment)', 'CostiAreaApiController::delete/$1');
});