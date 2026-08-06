<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('hotels', static function (RouteCollection $routes): void {
    $routes->get('/', 'HotelController::index');
    $routes->post('datatable', 'HotelController::datatable');
    $routes->get('view/(:segment)', 'HotelController::view/$1');
    $routes->get('create', 'HotelController::create');
    $routes->post('store', 'HotelController::store');
    $routes->get('edit/(:segment)', 'HotelController::edit/$1');
    $routes->post('update/(:segment)', 'HotelController::update/$1');
    $routes->post('delete/(:segment)', 'HotelController::delete/$1');

});

