<?php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */
$routes->get('/', 'Home::index');

require APPPATH . 'Config/MyCrudRoutes.php';

/*
 * Ogni CRUD genera un file autonomo in app/Routes. In questo modo non viene
 * riscritto Config/Routes.php e non si accumulano gruppi duplicati o obsoleti.
 */
$routeFiles = glob(APPPATH . 'Routes/*.php') ?: [];
sort($routeFiles, SORT_STRING);

foreach ($routeFiles as $routeFile) {
    require $routeFile;
}
