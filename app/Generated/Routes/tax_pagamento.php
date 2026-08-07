<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD tax_pagamento.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('tax_pagamento', static function (RouteCollection $routes): void {
    $routes->get('/', 'TaxPagamentoController::index');
    $routes->get('export-csv', 'TaxPagamentoController::exportCsv');
    $routes->get('export-word', 'TaxPagamentoController::exportWord');
    $routes->get('relation-options/(:segment)', 'TaxPagamentoController::relationOptions/$1');
    $routes->get('view/(:segment)', 'TaxPagamentoController::view/$1');
    $routes->get('create', 'TaxPagamentoController::create');
    $routes->post('store', 'TaxPagamentoController::store');
    $routes->get('edit/(:segment)', 'TaxPagamentoController::edit/$1');
    $routes->post('update/(:segment)', 'TaxPagamentoController::update/$1');
    $routes->post('delete/(:segment)', 'TaxPagamentoController::delete/$1');
});
$routes->group('api/v1/tax_pagamento', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'TaxPagamentoApiController::index');
    $routes->get('(:segment)', 'TaxPagamentoApiController::show/$1');
    $routes->post('/', 'TaxPagamentoApiController::create');
    $routes->put('(:segment)', 'TaxPagamentoApiController::update/$1');
    $routes->patch('(:segment)', 'TaxPagamentoApiController::patch/$1');
    $routes->delete('(:segment)', 'TaxPagamentoApiController::delete/$1');
});