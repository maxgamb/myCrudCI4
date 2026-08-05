<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');


/** @var RouteCollection $routes */

$routes->group(
    'mycrud',
    ['namespace' => 'App\Controllers\MyCrud'],
    static function (RouteCollection $routes): void {
        $routes->get('/', 'BuilderController::index');

        $routes->get(
            'auto/(:segment)',
            'AutoCrudController::generate/$1'
        );

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



    $routes->group('agenda', static function (RouteCollection $routes): void {
        
    $routes->get('/', 'AgendaController::index');
    $routes->post('datatable', 'AgendaController::datatable');
    $routes->get('view/(:segment)', 'AgendaController::view/$1');
    $routes->get('create', 'AgendaController::create');
    $routes->post('store', 'AgendaController::store');
    $routes->get('edit/(:segment)', 'AgendaController::edit/$1');
    $routes->post('update/(:segment)', 'AgendaController::update/$1');
    $routes->post('delete/(:segment)', 'AgendaController::delete/$1');
    
});
    

require APPPATH . 'Config/MyCrudRoutes.php';
