<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD products.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('products', static function (RouteCollection $routes): void {
    $routes->get('/', 'ProductsController::index');
    $routes->get('export-csv', 'ProductsController::exportCsv');
    $routes->get('export-word', 'ProductsController::exportWord');
    $routes->get('relation-options/(:segment)', 'ProductsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ProductsController::view/$1');
    $routes->get('create', 'ProductsController::create');
    $routes->post('store', 'ProductsController::store');
    $routes->get('edit/(:segment)', 'ProductsController::edit/$1');
    $routes->post('update/(:segment)', 'ProductsController::update/$1');
    $routes->post('delete/(:segment)', 'ProductsController::delete/$1');
});
$routes->group('api/v1/products', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ProductsApiController::index');
    $routes->get('(:segment)', 'ProductsApiController::show/$1');
    $routes->post('/', 'ProductsApiController::create');
    $routes->put('(:segment)', 'ProductsApiController::update/$1');
    $routes->patch('(:segment)', 'ProductsApiController::patch/$1');
    $routes->delete('(:segment)', 'ProductsApiController::delete/$1');
});