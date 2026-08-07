<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD cax_motivo.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('cax_motivo', static function (RouteCollection $routes): void {
    $routes->get('/', 'CaxMotivoController::index');
    $routes->get('export-csv', 'CaxMotivoController::exportCsv');
    $routes->get('export-word', 'CaxMotivoController::exportWord');
    $routes->get('relation-options/(:segment)', 'CaxMotivoController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CaxMotivoController::view/$1');
    $routes->get('create', 'CaxMotivoController::create');
    $routes->post('store', 'CaxMotivoController::store');
    $routes->get('edit/(:segment)', 'CaxMotivoController::edit/$1');
    $routes->post('update/(:segment)', 'CaxMotivoController::update/$1');
    $routes->post('delete/(:segment)', 'CaxMotivoController::delete/$1');
});
$routes->group('api/v1/cax_motivo', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CaxMotivoApiController::index');
    $routes->get('(:segment)', 'CaxMotivoApiController::show/$1');
    $routes->post('/', 'CaxMotivoApiController::create');
    $routes->put('(:segment)', 'CaxMotivoApiController::update/$1');
    $routes->patch('(:segment)', 'CaxMotivoApiController::patch/$1');
    $routes->delete('(:segment)', 'CaxMotivoApiController::delete/$1');
});