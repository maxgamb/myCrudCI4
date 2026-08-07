<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD tex_lingue.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('tex_lingue', static function (RouteCollection $routes): void {
    $routes->get('/', 'TexLingueController::index');
    $routes->get('export-csv', 'TexLingueController::exportCsv');
    $routes->get('export-word', 'TexLingueController::exportWord');
    $routes->get('relation-options/(:segment)', 'TexLingueController::relationOptions/$1');
    $routes->get('view/(:segment)', 'TexLingueController::view/$1');
    $routes->get('create', 'TexLingueController::create');
    $routes->post('store', 'TexLingueController::store');
    $routes->get('edit/(:segment)', 'TexLingueController::edit/$1');
    $routes->post('update/(:segment)', 'TexLingueController::update/$1');
    $routes->post('delete/(:segment)', 'TexLingueController::delete/$1');
});
$routes->group('api/v1/tex_lingue', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'TexLingueApiController::index');
    $routes->get('(:segment)', 'TexLingueApiController::show/$1');
    $routes->post('/', 'TexLingueApiController::create');
    $routes->put('(:segment)', 'TexLingueApiController::update/$1');
    $routes->patch('(:segment)', 'TexLingueApiController::patch/$1');
    $routes->delete('(:segment)', 'TexLingueApiController::delete/$1');
});