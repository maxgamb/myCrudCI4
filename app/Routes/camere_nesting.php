<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD camere_nesting.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('camere_nesting', static function (RouteCollection $routes): void {
    $routes->get('/', 'CamereNestingController::index');
    $routes->get('export-csv', 'CamereNestingController::exportCsv');
    $routes->get('export-word', 'CamereNestingController::exportWord');
    $routes->get('relation-options/(:segment)', 'CamereNestingController::relationOptions/$1');
    $routes->get('view/(:segment)', 'CamereNestingController::view/$1');
    $routes->get('create', 'CamereNestingController::create');
    $routes->post('store', 'CamereNestingController::store');
    $routes->get('edit/(:segment)', 'CamereNestingController::edit/$1');
    $routes->post('update/(:segment)', 'CamereNestingController::update/$1');
    $routes->post('delete/(:segment)', 'CamereNestingController::delete/$1');
});
$routes->group('api/v1/camere_nesting', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'CamereNestingApiController::index');
    $routes->get('(:segment)', 'CamereNestingApiController::show/$1');
    $routes->post('/', 'CamereNestingApiController::create');
    $routes->put('(:segment)', 'CamereNestingApiController::update/$1');
    $routes->patch('(:segment)', 'CamereNestingApiController::patch/$1');
    $routes->delete('(:segment)', 'CamereNestingApiController::delete/$1');
});