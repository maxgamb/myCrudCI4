<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD sales_by_film_category.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 * SQL VIEW: read-only routes; no write route is generated.
 */

/** @var RouteCollection $routes */
$routes->group('sales_by_film_category', static function (RouteCollection $routes): void {
    $routes->get('/', 'SalesByFilmCategoryController::index');
    $routes->get('export-csv', 'SalesByFilmCategoryController::exportCsv');
    $routes->get('export-word', 'SalesByFilmCategoryController::exportWord');
});
$routes->group('api/v1/sales_by_film_category', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'SalesByFilmCategoryApiController::index');
});
