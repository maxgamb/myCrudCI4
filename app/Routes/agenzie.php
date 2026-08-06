<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->group('agenzie', static function (RouteCollection $routes): void {
    $routes->get('/', 'AgenzieController::index');
    $routes->post('datatable', 'AgenzieController::datatable');
    $routes->get('view/(:segment)', 'AgenzieController::view/$1');
    $routes->get('create', 'AgenzieController::create');
    $routes->post('store', 'AgenzieController::store');
    $routes->get('edit/(:segment)', 'AgenzieController::edit/$1');
    $routes->post('update/(:segment)', 'AgenzieController::update/$1');
    $routes->post('delete/(:segment)', 'AgenzieController::delete/$1');

});

