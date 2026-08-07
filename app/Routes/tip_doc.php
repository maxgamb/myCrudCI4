<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD tip_doc.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('tip_doc', static function (RouteCollection $routes): void {
    $routes->get('/', 'TipDocController::index');
    $routes->get('export-csv', 'TipDocController::exportCsv');
    $routes->get('export-word', 'TipDocController::exportWord');
    $routes->get('relation-options/(:segment)', 'TipDocController::relationOptions/$1');
    $routes->get('view/(:segment)', 'TipDocController::view/$1');
    $routes->get('create', 'TipDocController::create');
    $routes->post('store', 'TipDocController::store');
    $routes->get('edit/(:segment)', 'TipDocController::edit/$1');
    $routes->post('update/(:segment)', 'TipDocController::update/$1');
    $routes->post('delete/(:segment)', 'TipDocController::delete/$1');
});
$routes->group('api/v1/tip_doc', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'TipDocApiController::index');
    $routes->get('(:segment)', 'TipDocApiController::show/$1');
    $routes->post('/', 'TipDocApiController::create');
    $routes->put('(:segment)', 'TipDocApiController::update/$1');
    $routes->patch('(:segment)', 'TipDocApiController::patch/$1');
    $routes->delete('(:segment)', 'TipDocApiController::delete/$1');
});