<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD ef_tipologia.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('ef_tipologia', static function (RouteCollection $routes): void {
    $routes->get('/', 'EfTipologiaController::index');
    $routes->get('export-csv', 'EfTipologiaController::exportCsv');
    $routes->get('export-word', 'EfTipologiaController::exportWord');
    $routes->get('relation-options/(:segment)', 'EfTipologiaController::relationOptions/$1');
    $routes->get('view/(:segment)', 'EfTipologiaController::view/$1');
    $routes->get('create', 'EfTipologiaController::create');
    $routes->post('store', 'EfTipologiaController::store');
    $routes->get('edit/(:segment)', 'EfTipologiaController::edit/$1');
    $routes->post('update/(:segment)', 'EfTipologiaController::update/$1');
    $routes->post('delete/(:segment)', 'EfTipologiaController::delete/$1');
});
$routes->group('api/v1/ef_tipologia', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'EfTipologiaApiController::index');
    $routes->get('(:segment)', 'EfTipologiaApiController::show/$1');
    $routes->post('/', 'EfTipologiaApiController::create');
    $routes->put('(:segment)', 'EfTipologiaApiController::update/$1');
    $routes->patch('(:segment)', 'EfTipologiaApiController::patch/$1');
    $routes->delete('(:segment)', 'EfTipologiaApiController::delete/$1');
});