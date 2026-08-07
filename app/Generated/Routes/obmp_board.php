<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_board.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_board', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpBoardController::index');
    $routes->get('export-csv', 'ObmpBoardController::exportCsv');
    $routes->get('export-word', 'ObmpBoardController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpBoardController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpBoardController::view/$1');
    $routes->get('create', 'ObmpBoardController::create');
    $routes->post('store', 'ObmpBoardController::store');
    $routes->get('edit/(:segment)', 'ObmpBoardController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpBoardController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpBoardController::delete/$1');
});
$routes->group('api/v1/obmp_board', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpBoardApiController::index');
    $routes->get('(:segment)', 'ObmpBoardApiController::show/$1');
    $routes->post('/', 'ObmpBoardApiController::create');
    $routes->put('(:segment)', 'ObmpBoardApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpBoardApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpBoardApiController::delete/$1');
});