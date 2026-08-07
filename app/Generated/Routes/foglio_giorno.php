<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD foglio_giorno.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('foglio_giorno', static function (RouteCollection $routes): void {
    $routes->get('/', 'FoglioGiornoController::index');
    $routes->get('export-csv', 'FoglioGiornoController::exportCsv');
    $routes->get('export-word', 'FoglioGiornoController::exportWord');
    $routes->get('relation-options/(:segment)', 'FoglioGiornoController::relationOptions/$1');
    $routes->get('view/(:segment)', 'FoglioGiornoController::view/$1');
    $routes->get('create', 'FoglioGiornoController::create');
    $routes->post('store', 'FoglioGiornoController::store');
    $routes->get('edit/(:segment)', 'FoglioGiornoController::edit/$1');
    $routes->post('update/(:segment)', 'FoglioGiornoController::update/$1');
    $routes->post('delete/(:segment)', 'FoglioGiornoController::delete/$1');
});
$routes->group('api/v1/foglio_giorno', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'FoglioGiornoApiController::index');
    $routes->get('(:segment)', 'FoglioGiornoApiController::show/$1');
    $routes->post('/', 'FoglioGiornoApiController::create');
    $routes->put('(:segment)', 'FoglioGiornoApiController::update/$1');
    $routes->patch('(:segment)', 'FoglioGiornoApiController::patch/$1');
    $routes->delete('(:segment)', 'FoglioGiornoApiController::delete/$1');
});