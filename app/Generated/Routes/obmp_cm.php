<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_cm.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_cm', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCmController::index');
    $routes->get('export-csv', 'ObmpCmController::exportCsv');
    $routes->get('export-word', 'ObmpCmController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpCmController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpCmController::view/$1');
    $routes->get('create', 'ObmpCmController::create');
    $routes->post('store', 'ObmpCmController::store');
    $routes->get('edit/(:segment)', 'ObmpCmController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpCmController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpCmController::delete/$1');
});
$routes->group('api/v1/obmp_cm', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCmApiController::index');
    $routes->get('(:segment)', 'ObmpCmApiController::show/$1');
    $routes->post('/', 'ObmpCmApiController::create');
    $routes->put('(:segment)', 'ObmpCmApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpCmApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpCmApiController::delete/$1');
});