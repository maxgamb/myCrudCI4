<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD doc_file.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('doc_file', static function (RouteCollection $routes): void {
    $routes->get('/', 'DocFileController::index');
    $routes->get('export-csv', 'DocFileController::exportCsv');
    $routes->get('export-word', 'DocFileController::exportWord');
    $routes->get('relation-options/(:segment)', 'DocFileController::relationOptions/$1');
    $routes->get('view/(:segment)', 'DocFileController::view/$1');
    $routes->get('create', 'DocFileController::create');
    $routes->post('store', 'DocFileController::store');
    $routes->get('edit/(:segment)', 'DocFileController::edit/$1');
    $routes->post('update/(:segment)', 'DocFileController::update/$1');
    $routes->post('delete/(:segment)', 'DocFileController::delete/$1');
});
$routes->group('api/v1/doc_file', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'DocFileApiController::index');
    $routes->get('(:segment)', 'DocFileApiController::show/$1');
    $routes->post('/', 'DocFileApiController::create');
    $routes->put('(:segment)', 'DocFileApiController::update/$1');
    $routes->patch('(:segment)', 'DocFileApiController::patch/$1');
    $routes->delete('(:segment)', 'DocFileApiController::delete/$1');
});