<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD refer_clienti.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('refer_clienti', static function (RouteCollection $routes): void {
    $routes->get('/', 'ReferClientiController::index');
    $routes->get('export-csv', 'ReferClientiController::exportCsv');
    $routes->get('export-word', 'ReferClientiController::exportWord');
    $routes->get('relation-options/(:segment)', 'ReferClientiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ReferClientiController::view/$1');
    $routes->get('create', 'ReferClientiController::create');
    $routes->post('store', 'ReferClientiController::store');
    $routes->get('edit/(:segment)', 'ReferClientiController::edit/$1');
    $routes->post('update/(:segment)', 'ReferClientiController::update/$1');
    $routes->post('delete/(:segment)', 'ReferClientiController::delete/$1');
});
$routes->group('api/v1/refer_clienti', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ReferClientiApiController::index');
    $routes->get('(:segment)', 'ReferClientiApiController::show/$1');
    $routes->post('/', 'ReferClientiApiController::create');
    $routes->put('(:segment)', 'ReferClientiApiController::update/$1');
    $routes->patch('(:segment)', 'ReferClientiApiController::patch/$1');
    $routes->delete('(:segment)', 'ReferClientiApiController::delete/$1');
});