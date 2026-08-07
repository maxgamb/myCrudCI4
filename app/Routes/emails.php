<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD emails.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('emails', static function (RouteCollection $routes): void {
    $routes->get('/', 'EmailsController::index');
    $routes->get('export-csv', 'EmailsController::exportCsv');
    $routes->get('export-word', 'EmailsController::exportWord');
    $routes->get('relation-options/(:segment)', 'EmailsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'EmailsController::view/$1');
    $routes->get('create', 'EmailsController::create');
    $routes->post('store', 'EmailsController::store');
    $routes->get('edit/(:segment)', 'EmailsController::edit/$1');
    $routes->post('update/(:segment)', 'EmailsController::update/$1');
    $routes->post('delete/(:segment)', 'EmailsController::delete/$1');
});
$routes->group('api/v1/emails', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'EmailsApiController::index');
    $routes->get('(:segment)', 'EmailsApiController::show/$1');
    $routes->post('/', 'EmailsApiController::create');
    $routes->put('(:segment)', 'EmailsApiController::update/$1');
    $routes->patch('(:segment)', 'EmailsApiController::patch/$1');
    $routes->delete('(:segment)', 'EmailsApiController::delete/$1');
});