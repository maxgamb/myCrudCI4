<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD wreh_order_details.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('wreh_order_details', static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehOrderDetailsController::index');
    $routes->get('export-csv', 'WrehOrderDetailsController::exportCsv');
    $routes->get('export-word', 'WrehOrderDetailsController::exportWord');
    $routes->get('relation-options/(:segment)', 'WrehOrderDetailsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'WrehOrderDetailsController::view/$1');
    $routes->get('create', 'WrehOrderDetailsController::create');
    $routes->post('store', 'WrehOrderDetailsController::store');
    $routes->get('edit/(:segment)', 'WrehOrderDetailsController::edit/$1');
    $routes->post('update/(:segment)', 'WrehOrderDetailsController::update/$1');
    $routes->post('delete/(:segment)', 'WrehOrderDetailsController::delete/$1');
});
$routes->group('api/v1/wreh_order_details', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehOrderDetailsApiController::index');
    $routes->get('(:segment)', 'WrehOrderDetailsApiController::show/$1');
    $routes->post('/', 'WrehOrderDetailsApiController::create');
    $routes->put('(:segment)', 'WrehOrderDetailsApiController::update/$1');
    $routes->patch('(:segment)', 'WrehOrderDetailsApiController::patch/$1');
    $routes->delete('(:segment)', 'WrehOrderDetailsApiController::delete/$1');
});