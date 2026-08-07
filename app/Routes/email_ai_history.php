<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD email_ai_history.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('email_ai_history', static function (RouteCollection $routes): void {
    $routes->get('/', 'EmailAiHistoryController::index');
    $routes->get('export-csv', 'EmailAiHistoryController::exportCsv');
    $routes->get('export-word', 'EmailAiHistoryController::exportWord');
    $routes->get('relation-options/(:segment)', 'EmailAiHistoryController::relationOptions/$1');
    $routes->get('view/(:segment)', 'EmailAiHistoryController::view/$1');
    $routes->get('create', 'EmailAiHistoryController::create');
    $routes->post('store', 'EmailAiHistoryController::store');
    $routes->get('edit/(:segment)', 'EmailAiHistoryController::edit/$1');
    $routes->post('update/(:segment)', 'EmailAiHistoryController::update/$1');
    $routes->post('delete/(:segment)', 'EmailAiHistoryController::delete/$1');
});
$routes->group('api/v1/email_ai_history', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'EmailAiHistoryApiController::index');
    $routes->get('(:segment)', 'EmailAiHistoryApiController::show/$1');
    $routes->post('/', 'EmailAiHistoryApiController::create');
    $routes->put('(:segment)', 'EmailAiHistoryApiController::update/$1');
    $routes->patch('(:segment)', 'EmailAiHistoryApiController::patch/$1');
    $routes->delete('(:segment)', 'EmailAiHistoryApiController::delete/$1');
});