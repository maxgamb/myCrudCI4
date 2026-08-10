<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD film_actor.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('film_actor', static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmActorController::index');
    $routes->get('export-csv', 'FilmActorController::exportCsv');
    $routes->get('export-word', 'FilmActorController::exportWord');
    $routes->get('relation-options/(:segment)', 'FilmActorController::relationOptions/$1');
    $routes->get('create', 'FilmActorController::create');
    $routes->post('store', 'FilmActorController::store');
});
$routes->group('api/v1/film_actor', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmActorApiController::index');
});