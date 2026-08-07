<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD checklist_preno.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('checklist_preno', static function (RouteCollection $routes): void {
    $routes->get('/', 'ChecklistPrenoController::index');
    $routes->get('export-csv', 'ChecklistPrenoController::exportCsv');
    $routes->get('export-word', 'ChecklistPrenoController::exportWord');
    $routes->get('relation-options/(:segment)', 'ChecklistPrenoController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ChecklistPrenoController::view/$1');
    $routes->get('create', 'ChecklistPrenoController::create');
    $routes->post('store', 'ChecklistPrenoController::store');
    $routes->get('edit/(:segment)', 'ChecklistPrenoController::edit/$1');
    $routes->post('update/(:segment)', 'ChecklistPrenoController::update/$1');
    $routes->post('delete/(:segment)', 'ChecklistPrenoController::delete/$1');
});
$routes->group('api/v1/checklist_preno', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ChecklistPrenoApiController::index');
    $routes->get('(:segment)', 'ChecklistPrenoApiController::show/$1');
    $routes->post('/', 'ChecklistPrenoApiController::create');
    $routes->put('(:segment)', 'ChecklistPrenoApiController::update/$1');
    $routes->patch('(:segment)', 'ChecklistPrenoApiController::patch/$1');
    $routes->delete('(:segment)', 'ChecklistPrenoApiController::delete/$1');
});