<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD staff_list.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 * SQL VIEW: read-only routes; no write route is generated.
 */

/** @var RouteCollection $routes */
$routes->group('staff_list', static function (RouteCollection $routes): void {
    $routes->get('/', 'StaffListController::index');
    $routes->get('export-csv', 'StaffListController::exportCsv');
    $routes->get('export-word', 'StaffListController::exportWord');
});
$routes->group('api/v1/staff_list', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'StaffListApiController::index');
});
