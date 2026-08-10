<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD film_category.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('film_category', static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmCategoryController::index');
    $routes->get('export-csv', 'FilmCategoryController::exportCsv');
    $routes->get('export-word', 'FilmCategoryController::exportWord');
    $routes->get('relation-options/(:segment)', 'FilmCategoryController::relationOptions/$1');
    $routes->get('create', 'FilmCategoryController::create');
    $routes->post('store', 'FilmCategoryController::store');
});
$routes->group('api/v1/film_category', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmCategoryApiController::index');
});