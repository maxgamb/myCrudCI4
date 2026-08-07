<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_restrictions.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_restrictions', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRestrictionsController::index');
    $routes->get('export-csv', 'ObmpRestrictionsController::exportCsv');
    $routes->get('export-word', 'ObmpRestrictionsController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpRestrictionsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpRestrictionsController::view/$1');
    $routes->get('create', 'ObmpRestrictionsController::create');
    $routes->post('store', 'ObmpRestrictionsController::store');
    $routes->get('edit/(:segment)', 'ObmpRestrictionsController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpRestrictionsController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpRestrictionsController::delete/$1');
});
$routes->group('api/v1/obmp_restrictions', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRestrictionsApiController::index');
    $routes->get('(:segment)', 'ObmpRestrictionsApiController::show/$1');
    $routes->post('/', 'ObmpRestrictionsApiController::create');
    $routes->put('(:segment)', 'ObmpRestrictionsApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpRestrictionsApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpRestrictionsApiController::delete/$1');
});