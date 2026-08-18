<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('mycrud', ['namespace' => 'App\Controllers\MyCrud'], static function (RouteCollection $routes): void {
    $routes->get('/', 'ProjectController::index');
    $routes->get('project', 'ProjectController::index');
    $routes->post('project/generate/(:segment)', 'ProjectController::generate/$1');
    $routes->post('project/generate-all', 'ProjectController::generateAll');
    $routes->get('project/diff/(:segment)', 'ProjectController::diff/$1');
    $routes->get('project/doctor/(:segment)', 'ProjectController::doctor/$1');

    $routes->get('docs', 'DocsController::index');
    $routes->get('tools/ai-context', 'AiContextController::index');
    $routes->post('tools/ai-context/generate', 'AiContextController::generate');

    $routes->get('quick', 'AutoCrudController::index');
    $routes->post('quick/generate', 'AutoCrudController::generateAll');
    $routes->get('quick/report/(:segment)', 'AutoCrudController::report/$1');

    $routes->get('dashboard', 'DashboardBuilderController::index');
    $routes->post('dashboard/save', 'DashboardBuilderController::save');
    $routes->post('dashboard/generate', 'DashboardBuilderController::generate');
    $routes->post('dashboard/publish', 'DashboardBuilderController::publish');

    $routes->get('builder', 'BuilderController::index');
    $routes->get('builder/configure/(:segment)', 'BuilderController::configure/$1');
    $routes->post('builder/save', 'BuilderController::save');
    $routes->post('builder/generate', 'BuilderController::generate');

    $routes->get('schema', 'SchemaController::index');
    $routes->get('schema/(:segment)', 'SchemaController::index/$1');

    $routes->get('tools/routes', 'ToolsController::routes');
    $routes->get('tools/fields', 'ToolsController::fields');
    $routes->get('tools/menu', 'ToolsController::menu');
    $routes->post('tools/menu/save', 'ToolsController::saveMenu');
    $routes->post('tools/menu/generate', 'ToolsController::generateMenu');
    $routes->get('tools/schema', 'ToolsController::schema');
    $routes->get('tools/schema/(:segment)', 'ToolsController::schema/$1');
});
