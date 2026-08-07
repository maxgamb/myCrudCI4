<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD prodotti_lista.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('prodotti_lista', static function (RouteCollection $routes): void {
    $routes->get('/', 'ProdottiListaController::index');
    $routes->get('export-csv', 'ProdottiListaController::exportCsv');
    $routes->get('export-word', 'ProdottiListaController::exportWord');
    $routes->get('relation-options/(:segment)', 'ProdottiListaController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ProdottiListaController::view/$1');
    $routes->get('create', 'ProdottiListaController::create');
    $routes->post('store', 'ProdottiListaController::store');
    $routes->get('edit/(:segment)', 'ProdottiListaController::edit/$1');
    $routes->post('update/(:segment)', 'ProdottiListaController::update/$1');
    $routes->post('delete/(:segment)', 'ProdottiListaController::delete/$1');
});
$routes->group('api/v1/prodotti_lista', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ProdottiListaApiController::index');
    $routes->get('(:segment)', 'ProdottiListaApiController::show/$1');
    $routes->post('/', 'ProdottiListaApiController::create');
    $routes->put('(:segment)', 'ProdottiListaApiController::update/$1');
    $routes->patch('(:segment)', 'ProdottiListaApiController::patch/$1');
    $routes->delete('(:segment)', 'ProdottiListaApiController::delete/$1');
});