<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD adebiti.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('adebiti', static function (RouteCollection $routes): void {
    $routes->get('/', 'AdebitiController::index');
    $routes->get('export-csv', 'AdebitiController::exportCsv');
    $routes->get('export-word', 'AdebitiController::exportWord');
    $routes->get('relation-options/(:segment)', 'AdebitiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'AdebitiController::view/$1');
    $routes->get('create', 'AdebitiController::create');
    $routes->post('store', 'AdebitiController::store');
    $routes->get('edit/(:segment)', 'AdebitiController::edit/$1');
    $routes->post('update/(:segment)', 'AdebitiController::update/$1');
    $routes->post('delete/(:segment)', 'AdebitiController::delete/$1');
});
$routes->group('api/v1/adebiti', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'AdebitiApiController::index');
    $routes->get('(:segment)', 'AdebitiApiController::show/$1');
    $routes->post('/', 'AdebitiApiController::create');
    $routes->put('(:segment)', 'AdebitiApiController::update/$1');
    $routes->patch('(:segment)', 'AdebitiApiController::patch/$1');
    $routes->delete('(:segment)', 'AdebitiApiController::delete/$1');
});