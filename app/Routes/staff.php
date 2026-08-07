<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD staff.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('staff', static function (RouteCollection $routes): void {
    $routes->get('/', 'StaffController::index');
    $routes->get('export-csv', 'StaffController::exportCsv');
    $routes->get('export-word', 'StaffController::exportWord');
    $routes->get('relation-options/(:segment)', 'StaffController::relationOptions/$1');
    $routes->get('view/(:segment)', 'StaffController::view/$1');
    $routes->get('create', 'StaffController::create');
    $routes->post('store', 'StaffController::store');
    $routes->get('edit/(:segment)', 'StaffController::edit/$1');
    $routes->post('update/(:segment)', 'StaffController::update/$1');
    $routes->post('delete/(:segment)', 'StaffController::delete/$1');
});
$routes->group('api/v1/staff', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'StaffApiController::index');
    $routes->get('(:segment)', 'StaffApiController::show/$1');
    $routes->post('/', 'StaffApiController::create');
    $routes->put('(:segment)', 'StaffApiController::update/$1');
    $routes->patch('(:segment)', 'StaffApiController::patch/$1');
    $routes->delete('(:segment)', 'StaffApiController::delete/$1');
});