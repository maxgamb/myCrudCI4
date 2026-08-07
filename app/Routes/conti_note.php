<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD conti_note.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('conti_note', static function (RouteCollection $routes): void {
    $routes->get('/', 'ContiNoteController::index');
    $routes->get('export-csv', 'ContiNoteController::exportCsv');
    $routes->get('export-word', 'ContiNoteController::exportWord');
    $routes->get('relation-options/(:segment)', 'ContiNoteController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ContiNoteController::view/$1');
    $routes->get('create', 'ContiNoteController::create');
    $routes->post('store', 'ContiNoteController::store');
    $routes->get('edit/(:segment)', 'ContiNoteController::edit/$1');
    $routes->post('update/(:segment)', 'ContiNoteController::update/$1');
    $routes->post('delete/(:segment)', 'ContiNoteController::delete/$1');
});
$routes->group('api/v1/conti_note', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ContiNoteApiController::index');
    $routes->get('(:segment)', 'ContiNoteApiController::show/$1');
    $routes->post('/', 'ContiNoteApiController::create');
    $routes->put('(:segment)', 'ContiNoteApiController::update/$1');
    $routes->patch('(:segment)', 'ContiNoteApiController::patch/$1');
    $routes->delete('(:segment)', 'ContiNoteApiController::delete/$1');
});