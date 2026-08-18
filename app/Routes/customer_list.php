<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD customer_list.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 * SQL VIEW: read-only routes; no write route is generated.
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
