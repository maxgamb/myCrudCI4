<?php

use CodeIgniter\Router\RouteCollection;

/*
 * Route modulari del CRUD actor_info.
 * myCrudCI4 intentionally generates one file per table: app/Config/Routes.php
 * può caricare app/Routes/*.php senza concentrare tutte le route in un unico file.
 * SQL VIEW: read-only routes; no write route is generated.
 */

/** @var RouteCollection $routes */
$routes->group('actor_info', static function (RouteCollection $routes): void {
    $routes->get('/', 'ActorInfoController::index');
    $routes->get('export-csv', 'ActorInfoController::exportCsv');
    $routes->get('export-word', 'ActorInfoController::exportWord');
});
$routes->group('api/v1/actor_info', ['namespace' => 'App\Controllers\Api\V1'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ActorInfoApiController::index');
});
