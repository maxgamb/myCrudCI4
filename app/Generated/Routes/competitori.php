<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD competitori.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('competitori', static function (RouteCollection $routes): void {
    $routes->get('/', 'CompetitoriController::index');
    $routes->get('export-csv', 'CompetitoriController::exportCsv');
    $routes->get('export-word', 'CompetitoriController::exportWord');
    $routes->get('relation-options/(:segment)', 'CompetitoriController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CompetitoriController::view/$1');
    $routes->get('create', 'CompetitoriController::create');
    $routes->post('store', 'CompetitoriController::store');
    $routes->get('edit/(:segment)', 'CompetitoriController::edit/$1');
    $routes->post('update/(:segment)', 'CompetitoriController::update/$1');
    $routes->post('delete/(:segment)', 'CompetitoriController::delete/$1');
});
$routes->group('api/v1/competitori', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CompetitoriApiController::index');
    $routes->get('(:segment)', 'CompetitoriApiController::show/$1');
    $routes->post('/', 'CompetitoriApiController::create');
    $routes->put('(:segment)', 'CompetitoriApiController::update/$1');
    $routes->patch('(:segment)', 'CompetitoriApiController::patch/$1');
    $routes->delete('(:segment)', 'CompetitoriApiController::delete/$1');
});