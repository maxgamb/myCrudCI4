<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD nazioni_bandiera.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('nazioni_bandiera', static function (RouteCollection $routes): void {
    $routes->get('/', 'NazioniBandieraController::index');
    $routes->get('export-csv', 'NazioniBandieraController::exportCsv');
    $routes->get('export-word', 'NazioniBandieraController::exportWord');
    $routes->get('relation-options/(:segment)', 'NazioniBandieraController::relationOptions/$1');
    $routes->get('view/(:segment)', 'NazioniBandieraController::view/$1');
    $routes->get('create', 'NazioniBandieraController::create');
    $routes->post('store', 'NazioniBandieraController::store');
    $routes->get('edit/(:segment)', 'NazioniBandieraController::edit/$1');
    $routes->post('update/(:segment)', 'NazioniBandieraController::update/$1');
    $routes->post('delete/(:segment)', 'NazioniBandieraController::delete/$1');
});
$routes->group('api/v1/nazioni_bandiera', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'NazioniBandieraApiController::index');
    $routes->get('(:segment)', 'NazioniBandieraApiController::show/$1');
    $routes->post('/', 'NazioniBandieraApiController::create');
    $routes->put('(:segment)', 'NazioniBandieraApiController::update/$1');
    $routes->patch('(:segment)', 'NazioniBandieraApiController::patch/$1');
    $routes->delete('(:segment)', 'NazioniBandieraApiController::delete/$1');
});