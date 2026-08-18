<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD film_list.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 * SQL VIEW: read-only routes; no write route is generated.
 */

/** @var RouteCollection $routes */
$routes->group('film_list', static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmListController::index');
    $routes->get('export-csv', 'FilmListController::exportCsv');
    $routes->get('export-word', 'FilmListController::exportWord');
});
$routes->group('api/v1/film_list', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmListApiController::index');
});
