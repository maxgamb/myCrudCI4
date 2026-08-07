<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD app_ip.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('app_ip', static function (RouteCollection $routes): void {
    $routes->get('/', 'AppIpController::index');
    $routes->get('export-csv', 'AppIpController::exportCsv');
    $routes->get('export-word', 'AppIpController::exportWord');
    $routes->get('relation-options/(:segment)', 'AppIpController::relationOptions/$1');
    $routes->get('view/(:segment)', 'AppIpController::view/$1');
    $routes->get('create', 'AppIpController::create');
    $routes->post('store', 'AppIpController::store');
    $routes->get('edit/(:segment)', 'AppIpController::edit/$1');
    $routes->post('update/(:segment)', 'AppIpController::update/$1');
    $routes->post('delete/(:segment)', 'AppIpController::delete/$1');
});
$routes->group('api/v1/app_ip', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'AppIpApiController::index');
    $routes->get('(:segment)', 'AppIpApiController::show/$1');
    $routes->post('/', 'AppIpApiController::create');
    $routes->put('(:segment)', 'AppIpApiController::update/$1');
    $routes->patch('(:segment)', 'AppIpApiController::patch/$1');
    $routes->delete('(:segment)', 'AppIpApiController::delete/$1');
});