<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD ref_agenzia_preno.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('ref_agenzia_preno', static function (RouteCollection $routes): void {
    $routes->get('/', 'RefAgenziaPrenoController::index');
    $routes->get('export-csv', 'RefAgenziaPrenoController::exportCsv');
    $routes->get('export-word', 'RefAgenziaPrenoController::exportWord');
    $routes->get('relation-options/(:segment)', 'RefAgenziaPrenoController::relationOptions/$1');
    $routes->get('view/(:segment)', 'RefAgenziaPrenoController::view/$1');
    $routes->get('create', 'RefAgenziaPrenoController::create');
    $routes->post('store', 'RefAgenziaPrenoController::store');
    $routes->get('edit/(:segment)', 'RefAgenziaPrenoController::edit/$1');
    $routes->post('update/(:segment)', 'RefAgenziaPrenoController::update/$1');
    $routes->post('delete/(:segment)', 'RefAgenziaPrenoController::delete/$1');
});
$routes->group('api/v1/ref_agenzia_preno', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'RefAgenziaPrenoApiController::index');
    $routes->get('(:segment)', 'RefAgenziaPrenoApiController::show/$1');
    $routes->post('/', 'RefAgenziaPrenoApiController::create');
    $routes->put('(:segment)', 'RefAgenziaPrenoApiController::update/$1');
    $routes->patch('(:segment)', 'RefAgenziaPrenoApiController::patch/$1');
    $routes->delete('(:segment)', 'RefAgenziaPrenoApiController::delete/$1');
});