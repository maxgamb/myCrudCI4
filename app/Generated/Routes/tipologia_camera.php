<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD tipologia_camera.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('tipologia_camera', static function (RouteCollection $routes): void {
    $routes->get('/', 'TipologiaCameraController::index');
    $routes->get('export-csv', 'TipologiaCameraController::exportCsv');
    $routes->get('export-word', 'TipologiaCameraController::exportWord');
    $routes->get('relation-options/(:segment)', 'TipologiaCameraController::relationOptions/$1');
    $routes->get('view/(:segment)', 'TipologiaCameraController::view/$1');
    $routes->get('create', 'TipologiaCameraController::create');
    $routes->post('store', 'TipologiaCameraController::store');
    $routes->get('edit/(:segment)', 'TipologiaCameraController::edit/$1');
    $routes->post('update/(:segment)', 'TipologiaCameraController::update/$1');
    $routes->post('delete/(:segment)', 'TipologiaCameraController::delete/$1');
});
$routes->group('api/v1/tipologia_camera', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'TipologiaCameraApiController::index');
    $routes->get('(:segment)', 'TipologiaCameraApiController::show/$1');
    $routes->post('/', 'TipologiaCameraApiController::create');
    $routes->put('(:segment)', 'TipologiaCameraApiController::update/$1');
    $routes->patch('(:segment)', 'TipologiaCameraApiController::patch/$1');
    $routes->delete('(:segment)', 'TipologiaCameraApiController::delete/$1');
});