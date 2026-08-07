<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD wreh_products.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('wreh_products', static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehProductsController::index');
    $routes->get('export-csv', 'WrehProductsController::exportCsv');
    $routes->get('export-word', 'WrehProductsController::exportWord');
    $routes->get('relation-options/(:segment)', 'WrehProductsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'WrehProductsController::view/$1');
    $routes->get('create', 'WrehProductsController::create');
    $routes->post('store', 'WrehProductsController::store');
    $routes->get('edit/(:segment)', 'WrehProductsController::edit/$1');
    $routes->post('update/(:segment)', 'WrehProductsController::update/$1');
    $routes->post('delete/(:segment)', 'WrehProductsController::delete/$1');
});
$routes->group('api/v1/wreh_products', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'WrehProductsApiController::index');
    $routes->get('(:segment)', 'WrehProductsApiController::show/$1');
    $routes->post('/', 'WrehProductsApiController::create');
    $routes->put('(:segment)', 'WrehProductsApiController::update/$1');
    $routes->patch('(:segment)', 'WrehProductsApiController::patch/$1');
    $routes->delete('(:segment)', 'WrehProductsApiController::delete/$1');
});