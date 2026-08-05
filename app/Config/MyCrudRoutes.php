<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('mycrud', ['namespace' => 'App\Controllers\MyCrud'], static function (RouteCollection $routes): void {
    $routes->get('/', 'BuilderController::index');

    $routes->get('auto/(:segment)', 'AutoCrudController::generate/$1');

    $routes->get('builder/configure/(:segment)', 'BuilderController::configure/$1');
    $routes->post('builder/save', 'BuilderController::save');
    $routes->post('builder/generate', 'BuilderController::generate');

    $routes->get('schema', 'SchemaController::index');
    $routes->get('schema/(:segment)', 'SchemaController::index/$1');
    $routes->get('tools/routes', 'ToolsController::routes');
    $routes->get('tools/fields', 'ToolsController::fields');
    $routes->get('tools/schema', 'ToolsController::schema');
    $routes->get('tools/schema/(:segment)', 'ToolsController::schema/$1');
});
