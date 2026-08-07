<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD question.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('question', static function (RouteCollection $routes): void {
    $routes->get('/', 'QuestionController::index');
    $routes->get('export-csv', 'QuestionController::exportCsv');
    $routes->get('export-word', 'QuestionController::exportWord');
    $routes->get('relation-options/(:segment)', 'QuestionController::relationOptions/$1');
    $routes->get('view/(:segment)', 'QuestionController::view/$1');
    $routes->get('create', 'QuestionController::create');
    $routes->post('store', 'QuestionController::store');
    $routes->get('edit/(:segment)', 'QuestionController::edit/$1');
    $routes->post('update/(:segment)', 'QuestionController::update/$1');
    $routes->post('delete/(:segment)', 'QuestionController::delete/$1');
});
$routes->group('api/v1/question', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'QuestionApiController::index');
    $routes->get('(:segment)', 'QuestionApiController::show/$1');
    $routes->post('/', 'QuestionApiController::create');
    $routes->put('(:segment)', 'QuestionApiController::update/$1');
    $routes->patch('(:segment)', 'QuestionApiController::patch/$1');
    $routes->delete('(:segment)', 'QuestionApiController::delete/$1');
});