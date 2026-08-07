<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_payments.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_payments', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpPaymentsController::index');
    $routes->get('export-csv', 'ObmpPaymentsController::exportCsv');
    $routes->get('export-word', 'ObmpPaymentsController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpPaymentsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpPaymentsController::view/$1');
    $routes->get('create', 'ObmpPaymentsController::create');
    $routes->post('store', 'ObmpPaymentsController::store');
    $routes->get('edit/(:segment)', 'ObmpPaymentsController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpPaymentsController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpPaymentsController::delete/$1');
});
$routes->group('api/v1/obmp_payments', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpPaymentsApiController::index');
    $routes->get('(:segment)', 'ObmpPaymentsApiController::show/$1');
    $routes->post('/', 'ObmpPaymentsApiController::create');
    $routes->put('(:segment)', 'ObmpPaymentsApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpPaymentsApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpPaymentsApiController::delete/$1');
});