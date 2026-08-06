<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('app_ip', static function (RouteCollection $routes): void {
    $routes->get('/', 'AppIpController::index');
    $routes->post('datatable', 'AppIpController::datatable');
    $routes->get('view/(:segment)', 'AppIpController::view/$1');
    $routes->get('create', 'AppIpController::create');
    $routes->post('store', 'AppIpController::store');
    $routes->get('edit/(:segment)', 'AppIpController::edit/$1');
    $routes->post('update/(:segment)', 'AppIpController::update/$1');
    $routes->post('delete/(:segment)', 'AppIpController::delete/$1');

});

