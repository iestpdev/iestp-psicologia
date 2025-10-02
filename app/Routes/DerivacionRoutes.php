<?php

$routes->group('derivaciones', function ($routes) {
    $routes->get('/', 'DerivacionController::index');
    $routes->get('crear', 'DerivacionController::crear');
    $routes->get('editar/(:num)', 'DerivacionController::editar/$1');
});
