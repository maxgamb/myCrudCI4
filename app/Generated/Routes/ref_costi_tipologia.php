<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD ref_costi_tipologia.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('ref_costi_tipologia', static function (RouteCollection $routes): void {
    $routes->get('/', 'RefCostiTipologiaController::index');
    $routes->get('export-csv', 'RefCostiTipologiaController::exportCsv');
    $routes->get('export-word', 'RefCostiTipologiaController::exportWord');
    $routes->get('relation-options/(:segment)', 'RefCostiTipologiaController::relationOptions/$1');
    $routes->get('view/(:segment)', 'RefCostiTipologiaController::view/$1');
    $routes->get('create', 'RefCostiTipologiaController::create');
    $routes->post('store', 'RefCostiTipologiaController::store');
    $routes->get('edit/(:segment)', 'RefCostiTipologiaController::edit/$1');
    $routes->post('update/(:segment)', 'RefCostiTipologiaController::update/$1');
    $routes->post('delete/(:segment)', 'RefCostiTipologiaController::delete/$1');
});
$routes->group('api/v1/ref_costi_tipologia', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'RefCostiTipologiaApiController::index');
    $routes->get('(:segment)', 'RefCostiTipologiaApiController::show/$1');
    $routes->post('/', 'RefCostiTipologiaApiController::create');
    $routes->put('(:segment)', 'RefCostiTipologiaApiController::update/$1');
    $routes->patch('(:segment)', 'RefCostiTipologiaApiController::patch/$1');
    $routes->delete('(:segment)', 'RefCostiTipologiaApiController::delete/$1');
});