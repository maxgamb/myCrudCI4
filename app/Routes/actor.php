<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD actor.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('actor', static function (RouteCollection $routes): void {
    $routes->get('/', 'ActorController::index');
    $routes->get('export-csv', 'ActorController::exportCsv');
    $routes->get('export-word', 'ActorController::exportWord');
    $routes->get('relation-options/(:segment)', 'ActorController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ActorController::view/$1');
    $routes->get('create', 'ActorController::create');
    $routes->post('store', 'ActorController::store');
    $routes->get('edit/(:segment)', 'ActorController::edit/$1');
    $routes->post('update/(:segment)', 'ActorController::update/$1');
    $routes->post('delete/(:segment)', 'ActorController::delete/$1');
});
$routes->group('api/v1/actor', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ActorApiController::index');
    $routes->get('(:segment)', 'ActorApiController::show/$1');
    $routes->post('/', 'ActorApiController::create');
    $routes->put('(:segment)', 'ActorApiController::update/$1');
    $routes->patch('(:segment)', 'ActorApiController::patch/$1');
    $routes->delete('(:segment)', 'ActorApiController::delete/$1');
});