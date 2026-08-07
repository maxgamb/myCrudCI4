<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD black_list.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('black_list', static function (RouteCollection $routes): void {
    $routes->get('/', 'BlackListController::index');
    $routes->get('export-csv', 'BlackListController::exportCsv');
    $routes->get('export-word', 'BlackListController::exportWord');
    $routes->get('relation-options/(:segment)', 'BlackListController::relationOptions/$1');
    $routes->get('view/(:segment)', 'BlackListController::view/$1');
    $routes->get('create', 'BlackListController::create');
    $routes->post('store', 'BlackListController::store');
    $routes->get('edit/(:segment)', 'BlackListController::edit/$1');
    $routes->post('update/(:segment)', 'BlackListController::update/$1');
    $routes->post('delete/(:segment)', 'BlackListController::delete/$1');
});
$routes->group('api/v1/black_list', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'BlackListApiController::index');
    $routes->get('(:segment)', 'BlackListApiController::show/$1');
    $routes->post('/', 'BlackListApiController::create');
    $routes->put('(:segment)', 'BlackListApiController::update/$1');
    $routes->patch('(:segment)', 'BlackListApiController::patch/$1');
    $routes->delete('(:segment)', 'BlackListApiController::delete/$1');
});