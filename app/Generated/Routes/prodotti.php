<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD prodotti.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('prodotti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ProdottiController::index');
    $routes->get('export-csv', 'ProdottiController::exportCsv');
    $routes->get('export-word', 'ProdottiController::exportWord');
    $routes->get('relation-options/(:segment)', 'ProdottiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ProdottiController::view/$1');
    $routes->get('create', 'ProdottiController::create');
    $routes->post('store', 'ProdottiController::store');
    $routes->get('edit/(:segment)', 'ProdottiController::edit/$1');
    $routes->post('update/(:segment)', 'ProdottiController::update/$1');
    $routes->post('delete/(:segment)', 'ProdottiController::delete/$1');
});
$routes->group('api/v1/prodotti', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ProdottiApiController::index');
    $routes->get('(:segment)', 'ProdottiApiController::show/$1');
    $routes->post('/', 'ProdottiApiController::create');
    $routes->put('(:segment)', 'ProdottiApiController::update/$1');
    $routes->patch('(:segment)', 'ProdottiApiController::patch/$1');
    $routes->delete('(:segment)', 'ProdottiApiController::delete/$1');
});