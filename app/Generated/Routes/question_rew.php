<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD question_rew.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('question_rew', static function (RouteCollection $routes): void {
    $routes->get('/', 'QuestionRewController::index');
    $routes->get('export-csv', 'QuestionRewController::exportCsv');
    $routes->get('export-word', 'QuestionRewController::exportWord');
    $routes->get('relation-options/(:segment)', 'QuestionRewController::relationOptions/$1');
    $routes->get('view/(:segment)', 'QuestionRewController::view/$1');
    $routes->get('create', 'QuestionRewController::create');
    $routes->post('store', 'QuestionRewController::store');
    $routes->get('edit/(:segment)', 'QuestionRewController::edit/$1');
    $routes->post('update/(:segment)', 'QuestionRewController::update/$1');
    $routes->post('delete/(:segment)', 'QuestionRewController::delete/$1');
});
$routes->group('api/v1/question_rew', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'QuestionRewApiController::index');
    $routes->get('(:segment)', 'QuestionRewApiController::show/$1');
    $routes->post('/', 'QuestionRewApiController::create');
    $routes->put('(:segment)', 'QuestionRewApiController::update/$1');
    $routes->patch('(:segment)', 'QuestionRewApiController::patch/$1');
    $routes->delete('(:segment)', 'QuestionRewApiController::delete/$1');
});