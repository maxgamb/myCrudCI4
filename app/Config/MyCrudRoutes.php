<?php

use CodeIgniter\Router\RouteCollection;



$routes->group(
    'mycrud',
    ['namespace' => 'App\Controllers\MyCrud'],
    static function (RouteCollection $routes): void {
        /*
         * Home / Builder.
         */
        $routes->get('/', 'BuilderController::index');
        $routes->get('builder', 'BuilderController::index');

        $routes->get(
            'builder/configure/(:segment)',
            'BuilderController::configure/$1'
        );

        $routes->post(
            'builder/save',
            'BuilderController::save'
        );

        $routes->post(
            'builder/generate',
            'BuilderController::generate'
        );

        /*
         * Quick globale.
         */
        $routes->get(
            'quick',
            'AutoCrudController::index'
        );

        $routes->post(
            'quick/generate',
            'AutoCrudController::generateAll'
        );

        $routes->get(
            'quick/report/(:segment)',
            'AutoCrudController::report/$1'
        );

        /*
         * Strumenti.
         */
        $routes->get(
            'tools/routes',
            'ToolsController::routes'
        );

        $routes->get(
            'tools/fields',
            'ToolsController::fields'
        );

        $routes->get(
            'tools/schema',
            'ToolsController::schema'
        );

        $routes->get(
            'tools/schema/(:segment)',
            'ToolsController::schema/$1'
        );
    }
);