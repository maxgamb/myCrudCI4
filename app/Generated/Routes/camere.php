<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD camere.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('camere', static function (RouteCollection $routes): void {
    $routes->get('/', 'CamereController::index');
    $routes->get('export-csv', 'CamereController::exportCsv');
    $routes->get('export-word', 'CamereController::exportWord');
    $routes->get('relation-options/(:segment)', 'CamereController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CamereController::view/$1');
    $routes->get('create', 'CamereController::create');
    $routes->post('store', 'CamereController::store');
    $routes->get('edit/(:segment)', 'CamereController::edit/$1');
    $routes->post('update/(:segment)', 'CamereController::update/$1');
    $routes->post('delete/(:segment)', 'CamereController::delete/$1');
});
$routes->group('api/v1/camere', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CamereApiController::index');
    $routes->get('(:segment)', 'CamereApiController::show/$1');
    $routes->post('/', 'CamereApiController::create');
    $routes->put('(:segment)', 'CamereApiController::update/$1');
    $routes->patch('(:segment)', 'CamereApiController::patch/$1');
    $routes->delete('(:segment)', 'CamereApiController::delete/$1');
});