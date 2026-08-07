<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD nazioni_linque.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('nazioni_linque', static function (RouteCollection $routes): void {
    $routes->get('/', 'NazioniLinqueController::index');
    $routes->get('export-csv', 'NazioniLinqueController::exportCsv');
    $routes->get('export-word', 'NazioniLinqueController::exportWord');
    $routes->get('relation-options/(:segment)', 'NazioniLinqueController::relationOptions/$1');
    $routes->get('view/(:segment)', 'NazioniLinqueController::view/$1');
    $routes->get('create', 'NazioniLinqueController::create');
    $routes->post('store', 'NazioniLinqueController::store');
    $routes->get('edit/(:segment)', 'NazioniLinqueController::edit/$1');
    $routes->post('update/(:segment)', 'NazioniLinqueController::update/$1');
    $routes->post('delete/(:segment)', 'NazioniLinqueController::delete/$1');
});
$routes->group('api/v1/nazioni_linque', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'NazioniLinqueApiController::index');
    $routes->get('(:segment)', 'NazioniLinqueApiController::show/$1');
    $routes->post('/', 'NazioniLinqueApiController::create');
    $routes->put('(:segment)', 'NazioniLinqueApiController::update/$1');
    $routes->patch('(:segment)', 'NazioniLinqueApiController::patch/$1');
    $routes->delete('(:segment)', 'NazioniLinqueApiController::delete/$1');
});