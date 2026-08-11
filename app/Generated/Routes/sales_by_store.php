<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD sales_by_store.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 * SQL VIEW: route di sola lettura; nessuna route di scrittura viene generata.
 */

/** @var RouteCollection $routes */
$routes->group('sales_by_store', static function (RouteCollection $routes): void {
    $routes->get('/', 'SalesByStoreController::index');
    $routes->get('export-csv', 'SalesByStoreController::exportCsv');
    $routes->get('export-word', 'SalesByStoreController::exportWord');
});
$routes->group('api/v1/sales_by_store', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'SalesByStoreApiController::index');
});