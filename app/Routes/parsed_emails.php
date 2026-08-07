<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD parsed_emails.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('parsed_emails', static function (RouteCollection $routes): void {
    $routes->get('/', 'ParsedEmailsController::index');
    $routes->get('export-csv', 'ParsedEmailsController::exportCsv');
    $routes->get('export-word', 'ParsedEmailsController::exportWord');
    $routes->get('relation-options/(:segment)', 'ParsedEmailsController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ParsedEmailsController::view/$1');
    $routes->get('create', 'ParsedEmailsController::create');
    $routes->post('store', 'ParsedEmailsController::store');
    $routes->get('edit/(:segment)', 'ParsedEmailsController::edit/$1');
    $routes->post('update/(:segment)', 'ParsedEmailsController::update/$1');
    $routes->post('delete/(:segment)', 'ParsedEmailsController::delete/$1');
});
$routes->group('api/v1/parsed_emails', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ParsedEmailsApiController::index');
    $routes->get('(:segment)', 'ParsedEmailsApiController::show/$1');
    $routes->post('/', 'ParsedEmailsApiController::create');
    $routes->put('(:segment)', 'ParsedEmailsApiController::update/$1');
    $routes->patch('(:segment)', 'ParsedEmailsApiController::patch/$1');
    $routes->delete('(:segment)', 'ParsedEmailsApiController::delete/$1');
});