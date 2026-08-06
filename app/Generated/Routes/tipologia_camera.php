<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('tipologia_camera', static function (RouteCollection $routes): void {
    $routes->get('/', 'TipologiaCameraController::index');
    $routes->post('datatable', 'TipologiaCameraController::datatable');
    $routes->get('view/(:segment)', 'TipologiaCameraController::view/$1');
    $routes->get('create', 'TipologiaCameraController::create');
    $routes->post('store', 'TipologiaCameraController::store');
    $routes->get('edit/(:segment)', 'TipologiaCameraController::edit/$1');
    $routes->post('update/(:segment)', 'TipologiaCameraController::update/$1');
    $routes->post('delete/(:segment)', 'TipologiaCameraController::delete/$1');

});

