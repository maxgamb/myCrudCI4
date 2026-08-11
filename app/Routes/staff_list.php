<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD staff_list.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 * SQL VIEW: route di sola lettura; nessuna route di scrittura viene generata.
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