<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD regioni.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('regioni', static function (RouteCollection $routes): void {
    $routes->get('/', 'RegioniController::index');
    $routes->get('export-csv', 'RegioniController::exportCsv');
    $routes->get('export-word', 'RegioniController::exportWord');
    $routes->get('relation-options/(:segment)', 'RegioniController::relationOptions/$1');
    $routes->get('view/(:segment)', 'RegioniController::view/$1');
    $routes->get('create', 'RegioniController::create');
    $routes->post('store', 'RegioniController::store');
    $routes->get('edit/(:segment)', 'RegioniController::edit/$1');
    $routes->post('update/(:segment)', 'RegioniController::update/$1');
    $routes->post('delete/(:segment)', 'RegioniController::delete/$1');
});
$routes->group('api/v1/regioni', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'RegioniApiController::index');
    $routes->get('(:segment)', 'RegioniApiController::show/$1');
    $routes->post('/', 'RegioniApiController::create');
    $routes->put('(:segment)', 'RegioniApiController::update/$1');
    $routes->patch('(:segment)', 'RegioniApiController::patch/$1');
    $routes->delete('(:segment)', 'RegioniApiController::delete/$1');
});