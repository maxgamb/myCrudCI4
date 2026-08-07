<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD images.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('images', static function (RouteCollection $routes): void {
    $routes->get('/', 'ImagesController::index');
    $routes->get('export-csv', 'ImagesController::exportCsv');
    $routes->get('export-word', 'ImagesController::exportWord');
    $routes->get('relation-options/(:segment)', 'ImagesController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ImagesController::view/$1');
    $routes->get('create', 'ImagesController::create');
    $routes->post('store', 'ImagesController::store');
    $routes->get('edit/(:segment)', 'ImagesController::edit/$1');
    $routes->post('update/(:segment)', 'ImagesController::update/$1');
    $routes->post('delete/(:segment)', 'ImagesController::delete/$1');
});
$routes->group('api/v1/images', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ImagesApiController::index');
    $routes->get('(:segment)', 'ImagesApiController::show/$1');
    $routes->post('/', 'ImagesApiController::create');
    $routes->put('(:segment)', 'ImagesApiController::update/$1');
    $routes->patch('(:segment)', 'ImagesApiController::patch/$1');
    $routes->delete('(:segment)', 'ImagesApiController::delete/$1');
});