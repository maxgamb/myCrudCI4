<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD note_utente.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('note_utente', static function (RouteCollection $routes): void {
    $routes->get('/', 'NoteUtenteController::index');
    $routes->get('export-csv', 'NoteUtenteController::exportCsv');
    $routes->get('export-word', 'NoteUtenteController::exportWord');
    $routes->get('relation-options/(:segment)', 'NoteUtenteController::relationOptions/$1');
    $routes->get('view/(:segment)', 'NoteUtenteController::view/$1');
    $routes->get('create', 'NoteUtenteController::create');
    $routes->post('store', 'NoteUtenteController::store');
    $routes->get('edit/(:segment)', 'NoteUtenteController::edit/$1');
    $routes->post('update/(:segment)', 'NoteUtenteController::update/$1');
    $routes->post('delete/(:segment)', 'NoteUtenteController::delete/$1');
});
$routes->group('api/v1/note_utente', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'NoteUtenteApiController::index');
    $routes->get('(:segment)', 'NoteUtenteApiController::show/$1');
    $routes->post('/', 'NoteUtenteApiController::create');
    $routes->put('(:segment)', 'NoteUtenteApiController::update/$1');
    $routes->patch('(:segment)', 'NoteUtenteApiController::patch/$1');
    $routes->delete('(:segment)', 'NoteUtenteApiController::delete/$1');
});