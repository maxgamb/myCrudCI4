<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD obmp_review.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('obmp_review', static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpReviewController::index');
    $routes->get('export-csv', 'ObmpReviewController::exportCsv');
    $routes->get('export-word', 'ObmpReviewController::exportWord');
    $routes->get('relation-options/(:segment)', 'ObmpReviewController::relationOptions/$1');
    $routes->get('view/(:segment)', 'ObmpReviewController::view/$1');
    $routes->get('create', 'ObmpReviewController::create');
    $routes->post('store', 'ObmpReviewController::store');
    $routes->get('edit/(:segment)', 'ObmpReviewController::edit/$1');
    $routes->post('update/(:segment)', 'ObmpReviewController::update/$1');
    $routes->post('delete/(:segment)', 'ObmpReviewController::delete/$1');
});
$routes->group('api/v1/obmp_review', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ObmpReviewApiController::index');
    $routes->get('(:segment)', 'ObmpReviewApiController::show/$1');
    $routes->post('/', 'ObmpReviewApiController::create');
    $routes->put('(:segment)', 'ObmpReviewApiController::update/$1');
    $routes->patch('(:segment)', 'ObmpReviewApiController::patch/$1');
    $routes->delete('(:segment)', 'ObmpReviewApiController::delete/$1');
});