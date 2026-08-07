<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD modifica_agenda.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('modifica_agenda', static function (RouteCollection $routes): void {
    $routes->get('/', 'ModificaAgendaController::index');
    $routes->get('export-csv', 'ModificaAgendaController::exportCsv');
    $routes->get('export-word', 'ModificaAgendaController::exportWord');
    $routes->get('relation-options/(:segment)', 'ModificaAgendaController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ModificaAgendaController::view/$1');
    $routes->get('create', 'ModificaAgendaController::create');
    $routes->post('store', 'ModificaAgendaController::store');
    $routes->get('edit/(:segment)', 'ModificaAgendaController::edit/$1');
    $routes->post('update/(:segment)', 'ModificaAgendaController::update/$1');
    $routes->post('delete/(:segment)', 'ModificaAgendaController::delete/$1');
});
$routes->group('api/v1/modifica_agenda', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ModificaAgendaApiController::index');
    $routes->get('(:segment)', 'ModificaAgendaApiController::show/$1');
    $routes->post('/', 'ModificaAgendaApiController::create');
    $routes->put('(:segment)', 'ModificaAgendaApiController::update/$1');
    $routes->patch('(:segment)', 'ModificaAgendaApiController::patch/$1');
    $routes->delete('(:segment)', 'ModificaAgendaApiController::delete/$1');
});