<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD agenzia_listini.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('agenzia_listini', static function (RouteCollection $routes): void {
    $routes->get('/', 'AgenziaListiniController::index');
    $routes->get('export-csv', 'AgenziaListiniController::exportCsv');
    $routes->get('export-word', 'AgenziaListiniController::exportWord');
    $routes->get('relation-options/(:segment)', 'AgenziaListiniController::relationOptions/$1');
    $routes->get('view/(:segment)', 'AgenziaListiniController::view/$1');
    $routes->get('create', 'AgenziaListiniController::create');
    $routes->post('store', 'AgenziaListiniController::store');
    $routes->get('edit/(:segment)', 'AgenziaListiniController::edit/$1');
    $routes->post('update/(:segment)', 'AgenziaListiniController::update/$1');
    $routes->post('delete/(:segment)', 'AgenziaListiniController::delete/$1');
});
$routes->group('api/v1/agenzia_listini', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'AgenziaListiniApiController::index');
    $routes->get('(:segment)', 'AgenziaListiniApiController::show/$1');
    $routes->post('/', 'AgenziaListiniApiController::create');
    $routes->put('(:segment)', 'AgenziaListiniApiController::update/$1');
    $routes->patch('(:segment)', 'AgenziaListiniApiController::patch/$1');
    $routes->delete('(:segment)', 'AgenziaListiniApiController::delete/$1');
});