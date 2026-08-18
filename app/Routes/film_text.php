<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD film_text.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('film_text', static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmTextController::index');
    $routes->get('export-csv', 'FilmTextController::exportCsv');
    $routes->get('export-word', 'FilmTextController::exportWord');
    $routes->get('view/(:segment)', 'FilmTextController::view/$1');
    $routes->get('create', 'FilmTextController::create');
    $routes->post('store', 'FilmTextController::store');
    $routes->get('edit/(:segment)', 'FilmTextController::edit/$1');
    $routes->post('update/(:segment)', 'FilmTextController::update/$1');
    $routes->post('delete/(:segment)', 'FilmTextController::delete/$1');
});
$routes->group('api/v1/film_text', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmTextApiController::index');
    $routes->get('(:segment)', 'FilmTextApiController::show/$1');
    $routes->post('/', 'FilmTextApiController::create');
    $routes->put('(:segment)', 'FilmTextApiController::update/$1');
    $routes->patch('(:segment)', 'FilmTextApiController::patch/$1');
    $routes->delete('(:segment)', 'FilmTextApiController::delete/$1');
});
