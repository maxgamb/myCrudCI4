<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_affiliati.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_affiliati', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpAffiliatiController::index');
    $routes->get('export-csv', 'ObmpAffiliatiController::exportCsv');
    $routes->get('export-word', 'ObmpAffiliatiController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpAffiliatiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpAffiliatiController::view/$1');
    $routes->get('create', 'ObmpAffiliatiController::create');
    $routes->post('store', 'ObmpAffiliatiController::store');
    $routes->get('edit/(:segment)', 'ObmpAffiliatiController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpAffiliatiController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpAffiliatiController::delete/$1');
});
$routes->group('api/v1/obmp_affiliati', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpAffiliatiApiController::index');
    $routes->get('(:segment)', 'ObmpAffiliatiApiController::show/$1');
    $routes->post('/', 'ObmpAffiliatiApiController::create');
    $routes->put('(:segment)', 'ObmpAffiliatiApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpAffiliatiApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpAffiliatiApiController::delete/$1');
});