<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_ref_site.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_ref_site', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRefSiteController::index');
    $routes->get('export-csv', 'ObmpRefSiteController::exportCsv');
    $routes->get('export-word', 'ObmpRefSiteController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpRefSiteController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpRefSiteController::view/$1');
    $routes->get('create', 'ObmpRefSiteController::create');
    $routes->post('store', 'ObmpRefSiteController::store');
    $routes->get('edit/(:segment)', 'ObmpRefSiteController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpRefSiteController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpRefSiteController::delete/$1');
});
$routes->group('api/v1/obmp_ref_site', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpRefSiteApiController::index');
    $routes->get('(:segment)', 'ObmpRefSiteApiController::show/$1');
    $routes->post('/', 'ObmpRefSiteApiController::create');
    $routes->put('(:segment)', 'ObmpRefSiteApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpRefSiteApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpRefSiteApiController::delete/$1');
});