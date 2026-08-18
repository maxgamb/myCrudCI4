<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD film.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('film', static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmController::index');
    $routes->get('export-csv', 'FilmController::exportCsv');
    $routes->get('export-word', 'FilmController::exportWord');
    $routes->get('relation-options/(:segment)', 'FilmController::relationOptions/$1');
    $routes->get('upload/(:segment)/(:segment)', 'FilmController::upload/$1/$2');
    $routes->get('view/(:segment)', 'FilmController::view/$1');
    $routes->get('create', 'FilmController::create');
    $routes->post('store', 'FilmController::store');
    $routes->get('edit/(:segment)', 'FilmController::edit/$1');
    $routes->post('update/(:segment)', 'FilmController::update/$1');
    $routes->post('delete/(:segment)', 'FilmController::delete/$1');
});
$routes->group('api/v1/film', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'FilmApiController::index');
    $routes->get('(:segment)', 'FilmApiController::show/$1');
    $routes->post('/', 'FilmApiController::create');
    $routes->put('(:segment)', 'FilmApiController::update/$1');
    $routes->patch('(:segment)', 'FilmApiController::patch/$1');
    $routes->delete('(:segment)', 'FilmApiController::delete/$1');
    $routes->post('(:segment)/upload', 'FilmApiController::upload/$1');
});
