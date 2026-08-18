<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD nicer_but_slower_film_list.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 * SQL VIEW: read-only routes; no write route is generated.
 */

/** @var RouteCollection $routes */
$routes->group('nicer_but_slower_film_list', static function (RouteCollection $routes): void {
    $routes->get('/', 'NicerButSlowerFilmListController::index');
    $routes->get('export-csv', 'NicerButSlowerFilmListController::exportCsv');
    $routes->get('export-word', 'NicerButSlowerFilmListController::exportWord');
});
$routes->group('api/v1/nicer_but_slower_film_list', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'NicerButSlowerFilmListApiController::index');
});
