<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD customer.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('customer', static function (RouteCollection $routes): void {
    $routes->get('/', 'CustomerController::index');
    $routes->get('export-csv', 'CustomerController::exportCsv');
    $routes->get('export-word', 'CustomerController::exportWord');
    $routes->get('relation-options/(:segment)', 'CustomerController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CustomerController::view/$1');
    $routes->get('create', 'CustomerController::create');
    $routes->post('store', 'CustomerController::store');
    $routes->get('edit/(:segment)', 'CustomerController::edit/$1');
    $routes->post('update/(:segment)', 'CustomerController::update/$1');
    $routes->post('delete/(:segment)', 'CustomerController::delete/$1');
});
