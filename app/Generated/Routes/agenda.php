<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
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

