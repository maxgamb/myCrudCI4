<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD language.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('language', static function (RouteCollection $routes): void {
    $routes->get('/', 'LanguageController::index');
    $routes->get('export-csv', 'LanguageController::exportCsv');
    $routes->get('export-word', 'LanguageController::exportWord');
    $routes->get('view/(:segment)', 'LanguageController::view/$1');
    $routes->get('create', 'LanguageController::create');
    $routes->post('store', 'LanguageController::store');
    $routes->get('edit/(:segment)', 'LanguageController::edit/$1');
    $routes->post('update/(:segment)', 'LanguageController::update/$1');
    $routes->post('delete/(:segment)', 'LanguageController::delete/$1');
});
$routes->group('api/v1/language', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'LanguageApiController::index');
    $routes->get('(:segment)', 'LanguageApiController::show/$1');
    $routes->post('/', 'LanguageApiController::create');
    $routes->put('(:segment)', 'LanguageApiController::update/$1');
    $routes->patch('(:segment)', 'LanguageApiController::patch/$1');
    $routes->delete('(:segment)', 'LanguageApiController::delete/$1');
});
