<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD registro_ps.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('registro_ps', static function (RouteCollection $routes): void {
    $routes->get('/', 'RegistroPsController::index');
    $routes->get('export-csv', 'RegistroPsController::exportCsv');
    $routes->get('export-word', 'RegistroPsController::exportWord');
    $routes->get('relation-options/(:segment)', 'RegistroPsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'RegistroPsController::view/$1');
    $routes->get('create', 'RegistroPsController::create');
    $routes->post('store', 'RegistroPsController::store');
    $routes->get('edit/(:segment)', 'RegistroPsController::edit/$1');
    $routes->post('update/(:segment)', 'RegistroPsController::update/$1');
    $routes->post('delete/(:segment)', 'RegistroPsController::delete/$1');
});
$routes->group('api/v1/registro_ps', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'RegistroPsApiController::index');
    $routes->get('(:segment)', 'RegistroPsApiController::show/$1');
    $routes->post('/', 'RegistroPsApiController::create');
    $routes->put('(:segment)', 'RegistroPsApiController::update/$1');
    $routes->patch('(:segment)', 'RegistroPsApiController::patch/$1');
    $routes->delete('(:segment)', 'RegistroPsApiController::delete/$1');
});