<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD payment.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('payment', static function (RouteCollection $routes): void {
    $routes->get('/', 'PaymentController::index');
    $routes->get('export-csv', 'PaymentController::exportCsv');
    $routes->get('export-word', 'PaymentController::exportWord');
    $routes->get('relation-options/(:segment)', 'PaymentController::relationOptions/$1');
    $routes->get('view/(:segment)', 'PaymentController::view/$1');
    $routes->get('create', 'PaymentController::create');
    $routes->post('store', 'PaymentController::store');
    $routes->get('edit/(:segment)', 'PaymentController::edit/$1');
    $routes->post('update/(:segment)', 'PaymentController::update/$1');
    $routes->post('delete/(:segment)', 'PaymentController::delete/$1');
});
$routes->group('api/v1/payment', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'PaymentApiController::index');
    $routes->get('(:segment)', 'PaymentApiController::show/$1');
    $routes->post('/', 'PaymentApiController::create');
    $routes->put('(:segment)', 'PaymentApiController::update/$1');
    $routes->patch('(:segment)', 'PaymentApiController::patch/$1');
    $routes->delete('(:segment)', 'PaymentApiController::delete/$1');
});
