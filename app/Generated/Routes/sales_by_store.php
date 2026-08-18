<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD sales_by_store.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 * SQL VIEW: read-only routes; no write route is generated.
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
