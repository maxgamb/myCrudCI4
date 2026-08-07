<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD log_richieste.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('log_richieste', static function (RouteCollection $routes): void {
    $routes->get('/', 'LogRichiesteController::index');
    $routes->get('export-csv', 'LogRichiesteController::exportCsv');
    $routes->get('export-word', 'LogRichiesteController::exportWord');
    $routes->get('relation-options/(:segment)', 'LogRichiesteController::relationOptions/$1');
    $routes->get('view/(:segment)', 'LogRichiesteController::view/$1');
    $routes->get('create', 'LogRichiesteController::create');
    $routes->post('store', 'LogRichiesteController::store');
    $routes->get('edit/(:segment)', 'LogRichiesteController::edit/$1');
    $routes->post('update/(:segment)', 'LogRichiesteController::update/$1');
    $routes->post('delete/(:segment)', 'LogRichiesteController::delete/$1');
});
$routes->group('api/v1/log_richieste', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'LogRichiesteApiController::index');
    $routes->get('(:segment)', 'LogRichiesteApiController::show/$1');
    $routes->post('/', 'LogRichiesteApiController::create');
    $routes->put('(:segment)', 'LogRichiesteApiController::update/$1');
    $routes->patch('(:segment)', 'LogRichiesteApiController::patch/$1');
    $routes->delete('(:segment)', 'LogRichiesteApiController::delete/$1');
});