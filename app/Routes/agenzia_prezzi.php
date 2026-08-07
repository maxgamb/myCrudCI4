<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD agenzia_prezzi.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('agenzia_prezzi', static function (RouteCollection $routes): void {
    $routes->get('/', 'AgenziaPrezziController::index');
    $routes->get('export-csv', 'AgenziaPrezziController::exportCsv');
    $routes->get('export-word', 'AgenziaPrezziController::exportWord');
    $routes->get('relation-options/(:segment)', 'AgenziaPrezziController::relationOptions/$1');
    $routes->get('view/(:segment)', 'AgenziaPrezziController::view/$1');
    $routes->get('create', 'AgenziaPrezziController::create');
    $routes->post('store', 'AgenziaPrezziController::store');
    $routes->get('edit/(:segment)', 'AgenziaPrezziController::edit/$1');
    $routes->post('update/(:segment)', 'AgenziaPrezziController::update/$1');
    $routes->post('delete/(:segment)', 'AgenziaPrezziController::delete/$1');
});
$routes->group('api/v1/agenzia_prezzi', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'AgenziaPrezziApiController::index');
    $routes->get('(:segment)', 'AgenziaPrezziApiController::show/$1');
    $routes->post('/', 'AgenziaPrezziApiController::create');
    $routes->put('(:segment)', 'AgenziaPrezziApiController::update/$1');
    $routes->patch('(:segment)', 'AgenziaPrezziApiController::patch/$1');
    $routes->delete('(:segment)', 'AgenziaPrezziApiController::delete/$1');
});