<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD pratiche_rif.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('pratiche_rif', static function (RouteCollection $routes): void {
    $routes->get('/', 'PraticheRifController::index');
    $routes->get('export-csv', 'PraticheRifController::exportCsv');
    $routes->get('export-word', 'PraticheRifController::exportWord');
    $routes->get('relation-options/(:segment)', 'PraticheRifController::relationOptions/$1');
    $routes->get('view/(:segment)', 'PraticheRifController::view/$1');
    $routes->get('create', 'PraticheRifController::create');
    $routes->post('store', 'PraticheRifController::store');
    $routes->get('edit/(:segment)', 'PraticheRifController::edit/$1');
    $routes->post('update/(:segment)', 'PraticheRifController::update/$1');
    $routes->post('delete/(:segment)', 'PraticheRifController::delete/$1');
});
$routes->group('api/v1/pratiche_rif', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'PraticheRifApiController::index');
    $routes->get('(:segment)', 'PraticheRifApiController::show/$1');
    $routes->post('/', 'PraticheRifApiController::create');
    $routes->put('(:segment)', 'PraticheRifApiController::update/$1');
    $routes->patch('(:segment)', 'PraticheRifApiController::patch/$1');
    $routes->delete('(:segment)', 'PraticheRifApiController::delete/$1');
});