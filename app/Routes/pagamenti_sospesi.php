<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD pagamenti_sospesi.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('pagamenti_sospesi', static function (RouteCollection $routes): void {
    $routes->get('/', 'PagamentiSospesiController::index');
    $routes->get('export-csv', 'PagamentiSospesiController::exportCsv');
    $routes->get('export-word', 'PagamentiSospesiController::exportWord');
    $routes->get('relation-options/(:segment)', 'PagamentiSospesiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'PagamentiSospesiController::view/$1');
    $routes->get('create', 'PagamentiSospesiController::create');
    $routes->post('store', 'PagamentiSospesiController::store');
    $routes->get('edit/(:segment)', 'PagamentiSospesiController::edit/$1');
    $routes->post('update/(:segment)', 'PagamentiSospesiController::update/$1');
    $routes->post('delete/(:segment)', 'PagamentiSospesiController::delete/$1');
});
$routes->group('api/v1/pagamenti_sospesi', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'PagamentiSospesiApiController::index');
    $routes->get('(:segment)', 'PagamentiSospesiApiController::show/$1');
    $routes->post('/', 'PagamentiSospesiApiController::create');
    $routes->put('(:segment)', 'PagamentiSospesiApiController::update/$1');
    $routes->patch('(:segment)', 'PagamentiSospesiApiController::patch/$1');
    $routes->delete('(:segment)', 'PagamentiSospesiApiController::delete/$1');
});