<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('comuni', static function (RouteCollection $routes): void {
    $routes->get('/', 'ComuniController::index');
    $routes->post('datatable', 'ComuniController::datatable');
    $routes->get('view/(:segment)', 'ComuniController::view/$1');
    $routes->get('create', 'ComuniController::create');
    $routes->post('store', 'ComuniController::store');
    $routes->get('edit/(:segment)', 'ComuniController::edit/$1');
    $routes->post('update/(:segment)', 'ComuniController::update/$1');
    $routes->post('delete/(:segment)', 'ComuniController::delete/$1');

});

