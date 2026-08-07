<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_cm_lingue.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_cm_lingue', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCmLingueController::index');
    $routes->get('export-csv', 'ObmpCmLingueController::exportCsv');
    $routes->get('export-word', 'ObmpCmLingueController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpCmLingueController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpCmLingueController::view/$1');
    $routes->get('create', 'ObmpCmLingueController::create');
    $routes->post('store', 'ObmpCmLingueController::store');
    $routes->get('edit/(:segment)', 'ObmpCmLingueController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpCmLingueController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpCmLingueController::delete/$1');
});
$routes->group('api/v1/obmp_cm_lingue', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCmLingueApiController::index');
    $routes->get('(:segment)', 'ObmpCmLingueApiController::show/$1');
    $routes->post('/', 'ObmpCmLingueApiController::create');
    $routes->put('(:segment)', 'ObmpCmLingueApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpCmLingueApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpCmLingueApiController::delete/$1');
});