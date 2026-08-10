<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD film_list.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('film_list', static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmListController::index');
    $routes->get('export-csv', 'FilmListController::exportCsv');
    $routes->get('export-word', 'FilmListController::exportWord');
    $routes->get('relation-options/(:segment)', 'FilmListController::relationOptions/$1');
});
$routes->group('api/v1/film_list', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmListApiController::index');
});