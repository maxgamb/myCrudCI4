<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD customer_list.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 * SQL VIEW: route di sola lettura; nessuna route di scrittura viene generata.
 */

/** @var RouteCollection $routes */
$routes->group('customer_list', static function (RouteCollection $routes): void {
    $routes->get('/', 'CustomerListController::index');
    $routes->get('export-csv', 'CustomerListController::exportCsv');
    $routes->get('export-word', 'CustomerListController::exportWord');
});
$routes->group('api/v1/customer_list', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CustomerListApiController::index');
});