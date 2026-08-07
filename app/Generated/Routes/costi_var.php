<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD costi_var.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('costi_var', static function (RouteCollection $routes): void {
    $routes->get('/', 'CostiVarController::index');
    $routes->get('export-csv', 'CostiVarController::exportCsv');
    $routes->get('export-word', 'CostiVarController::exportWord');
    $routes->get('relation-options/(:segment)', 'CostiVarController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CostiVarController::view/$1');
    $routes->get('create', 'CostiVarController::create');
    $routes->post('store', 'CostiVarController::store');
    $routes->get('edit/(:segment)', 'CostiVarController::edit/$1');
    $routes->post('update/(:segment)', 'CostiVarController::update/$1');
    $routes->post('delete/(:segment)', 'CostiVarController::delete/$1');
});
$routes->group('api/v1/costi_var', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CostiVarApiController::index');
    $routes->get('(:segment)', 'CostiVarApiController::show/$1');
    $routes->post('/', 'CostiVarApiController::create');
    $routes->put('(:segment)', 'CostiVarApiController::update/$1');
    $routes->patch('(:segment)', 'CostiVarApiController::patch/$1');
    $routes->delete('(:segment)', 'CostiVarApiController::delete/$1');
});