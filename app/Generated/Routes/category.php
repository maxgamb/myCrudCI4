<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD category.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('category', static function (RouteCollection $routes): void {
    $routes->get('/', 'CategoryController::index');
    $routes->get('export-csv', 'CategoryController::exportCsv');
    $routes->get('export-word', 'CategoryController::exportWord');
    $routes->get('relation-options/(:segment)', 'CategoryController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CategoryController::view/$1');
    $routes->get('create', 'CategoryController::create');
    $routes->post('store', 'CategoryController::store');
    $routes->get('edit/(:segment)', 'CategoryController::edit/$1');
    $routes->post('update/(:segment)', 'CategoryController::update/$1');
    $routes->post('delete/(:segment)', 'CategoryController::delete/$1');
});
$routes->group('api/v1/category', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CategoryApiController::index');
    $routes->get('(:segment)', 'CategoryApiController::show/$1');
    $routes->post('/', 'CategoryApiController::create');
    $routes->put('(:segment)', 'CategoryApiController::update/$1');
    $routes->patch('(:segment)', 'CategoryApiController::patch/$1');
    $routes->delete('(:segment)', 'CategoryApiController::delete/$1');
});