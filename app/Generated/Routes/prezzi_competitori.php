<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD prezzi_competitori.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('prezzi_competitori', static function (RouteCollection $routes): void {
    $routes->get('/', 'PrezziCompetitoriController::index');
    $routes->get('export-csv', 'PrezziCompetitoriController::exportCsv');
    $routes->get('export-word', 'PrezziCompetitoriController::exportWord');
    $routes->get('relation-options/(:segment)', 'PrezziCompetitoriController::relationOptions/$1');
    $routes->get('view/(:segment)', 'PrezziCompetitoriController::view/$1');
    $routes->get('create', 'PrezziCompetitoriController::create');
    $routes->post('store', 'PrezziCompetitoriController::store');
    $routes->get('edit/(:segment)', 'PrezziCompetitoriController::edit/$1');
    $routes->post('update/(:segment)', 'PrezziCompetitoriController::update/$1');
    $routes->post('delete/(:segment)', 'PrezziCompetitoriController::delete/$1');
});
$routes->group('api/v1/prezzi_competitori', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'PrezziCompetitoriApiController::index');
    $routes->get('(:segment)', 'PrezziCompetitoriApiController::show/$1');
    $routes->post('/', 'PrezziCompetitoriApiController::create');
    $routes->put('(:segment)', 'PrezziCompetitoriApiController::update/$1');
    $routes->patch('(:segment)', 'PrezziCompetitoriApiController::patch/$1');
    $routes->delete('(:segment)', 'PrezziCompetitoriApiController::delete/$1');
});