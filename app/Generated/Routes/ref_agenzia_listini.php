<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD ref_agenzia_listini.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('ref_agenzia_listini', static function (RouteCollection $routes): void {
    $routes->get('/', 'RefAgenziaListiniController::index');
    $routes->get('export-csv', 'RefAgenziaListiniController::exportCsv');
    $routes->get('export-word', 'RefAgenziaListiniController::exportWord');
    $routes->get('relation-options/(:segment)', 'RefAgenziaListiniController::relationOptions/$1');
    $routes->get('view/(:segment)', 'RefAgenziaListiniController::view/$1');
    $routes->get('create', 'RefAgenziaListiniController::create');
    $routes->post('store', 'RefAgenziaListiniController::store');
    $routes->get('edit/(:segment)', 'RefAgenziaListiniController::edit/$1');
    $routes->post('update/(:segment)', 'RefAgenziaListiniController::update/$1');
    $routes->post('delete/(:segment)', 'RefAgenziaListiniController::delete/$1');
});
$routes->group('api/v1/ref_agenzia_listini', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'RefAgenziaListiniApiController::index');
    $routes->get('(:segment)', 'RefAgenziaListiniApiController::show/$1');
    $routes->post('/', 'RefAgenziaListiniApiController::create');
    $routes->put('(:segment)', 'RefAgenziaListiniApiController::update/$1');
    $routes->patch('(:segment)', 'RefAgenziaListiniApiController::patch/$1');
    $routes->delete('(:segment)', 'RefAgenziaListiniApiController::delete/$1');
});