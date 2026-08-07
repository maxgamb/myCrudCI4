<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD ref_agenda_clienti.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('ref_agenda_clienti', static function (RouteCollection $routes): void {
    $routes->get('/', 'RefAgendaClientiController::index');
    $routes->get('export-csv', 'RefAgendaClientiController::exportCsv');
    $routes->get('export-word', 'RefAgendaClientiController::exportWord');
    $routes->get('relation-options/(:segment)', 'RefAgendaClientiController::relationOptions/$1');
    $routes->get('view/(:segment)', 'RefAgendaClientiController::view/$1');
    $routes->get('create', 'RefAgendaClientiController::create');
    $routes->post('store', 'RefAgendaClientiController::store');
    $routes->get('edit/(:segment)', 'RefAgendaClientiController::edit/$1');
    $routes->post('update/(:segment)', 'RefAgendaClientiController::update/$1');
    $routes->post('delete/(:segment)', 'RefAgendaClientiController::delete/$1');
});
$routes->group('api/v1/ref_agenda_clienti', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'RefAgendaClientiApiController::index');
    $routes->get('(:segment)', 'RefAgendaClientiApiController::show/$1');
    $routes->post('/', 'RefAgendaClientiApiController::create');
    $routes->put('(:segment)', 'RefAgendaClientiApiController::update/$1');
    $routes->patch('(:segment)', 'RefAgendaClientiApiController::patch/$1');
    $routes->delete('(:segment)', 'RefAgendaClientiApiController::delete/$1');
});