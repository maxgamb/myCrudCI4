<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_cancellations.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_cancellations', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCancellationsController::index');
    $routes->get('export-csv', 'ObmpCancellationsController::exportCsv');
    $routes->get('export-word', 'ObmpCancellationsController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpCancellationsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpCancellationsController::view/$1');
    $routes->get('create', 'ObmpCancellationsController::create');
    $routes->post('store', 'ObmpCancellationsController::store');
    $routes->get('edit/(:segment)', 'ObmpCancellationsController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpCancellationsController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpCancellationsController::delete/$1');
});
$routes->group('api/v1/obmp_cancellations', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpCancellationsApiController::index');
    $routes->get('(:segment)', 'ObmpCancellationsApiController::show/$1');
    $routes->post('/', 'ObmpCancellationsApiController::create');
    $routes->put('(:segment)', 'ObmpCancellationsApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpCancellationsApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpCancellationsApiController::delete/$1');
});