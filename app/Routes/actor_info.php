<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD actor_info.
 * myCrudGpt genera volutamente un file per tabella: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 */

/** @var RouteCollection $routes */
$routes->group('actor_info', static function (RouteCollection $routes): void {
    $routes->get('/', 'ActorInfoController::index');
    $routes->get('export-csv', 'ActorInfoController::exportCsv');
    $routes->get('export-word', 'ActorInfoController::exportWord');
    $routes->get('relation-options/(:segment)', 'ActorInfoController::relationOptions/$1');
});
$routes->group('api/v1/actor_info', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ActorInfoApiController::index');
});