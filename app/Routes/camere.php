<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('camere', static function (RouteCollection $routes): void {
    $routes->get('/', 'CamereController::index');
    $routes->post('datatable', 'CamereController::datatable');
    $routes->get('view/(:segment)', 'CamereController::view/$1');
    $routes->get('create', 'CamereController::create');
    $routes->post('store', 'CamereController::store');
    $routes->get('edit/(:segment)', 'CamereController::edit/$1');
    $routes->post('update/(:segment)', 'CamereController::update/$1');
    $routes->post('delete/(:segment)', 'CamereController::delete/$1');

});

