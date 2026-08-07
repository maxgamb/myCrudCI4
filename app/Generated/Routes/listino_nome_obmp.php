<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD listino_nome_obmp.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('listino_nome_obmp', static function (RouteCollection $routes): void {
    $routes->get('/', 'ListinoNomeObmpController::index');
    $routes->get('export-csv', 'ListinoNomeObmpController::exportCsv');
    $routes->get('export-word', 'ListinoNomeObmpController::exportWord');
    $routes->get('relation-options/(:segment)', 'ListinoNomeObmpController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ListinoNomeObmpController::view/$1');
    $routes->get('create', 'ListinoNomeObmpController::create');
    $routes->post('store', 'ListinoNomeObmpController::store');
    $routes->get('edit/(:segment)', 'ListinoNomeObmpController::edit/$1');
    $routes->post('update/(:segment)', 'ListinoNomeObmpController::update/$1');
    $routes->post('delete/(:segment)', 'ListinoNomeObmpController::delete/$1');
});
$routes->group('api/v1/listino_nome_obmp', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ListinoNomeObmpApiController::index');
    $routes->get('(:segment)', 'ListinoNomeObmpApiController::show/$1');
    $routes->post('/', 'ListinoNomeObmpApiController::create');
    $routes->put('(:segment)', 'ListinoNomeObmpApiController::update/$1');
    $routes->patch('(:segment)', 'ListinoNomeObmpApiController::patch/$1');
    $routes->delete('(:segment)', 'ListinoNomeObmpApiController::delete/$1');
});