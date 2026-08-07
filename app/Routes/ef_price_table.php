<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD ef_price_table.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('ef_price_table', static function (RouteCollection $routes): void {
    $routes->get('/', 'EfPriceTableController::index');
    $routes->get('export-csv', 'EfPriceTableController::exportCsv');
    $routes->get('export-word', 'EfPriceTableController::exportWord');
    $routes->get('relation-options/(:segment)', 'EfPriceTableController::relationOptions/$1');
    $routes->get('view/(:segment)', 'EfPriceTableController::view/$1');
    $routes->get('create', 'EfPriceTableController::create');
    $routes->post('store', 'EfPriceTableController::store');
    $routes->get('edit/(:segment)', 'EfPriceTableController::edit/$1');
    $routes->post('update/(:segment)', 'EfPriceTableController::update/$1');
    $routes->post('delete/(:segment)', 'EfPriceTableController::delete/$1');
});
$routes->group('api/v1/ef_price_table', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'EfPriceTableApiController::index');
    $routes->get('(:segment)', 'EfPriceTableApiController::show/$1');
    $routes->post('/', 'EfPriceTableApiController::create');
    $routes->put('(:segment)', 'EfPriceTableApiController::update/$1');
    $routes->patch('(:segment)', 'EfPriceTableApiController::patch/$1');
    $routes->delete('(:segment)', 'EfPriceTableApiController::delete/$1');
});