<?php

$routes->group('derivaciones', function ($routes) {
    $routes->get('/', 'DerivacionController::index');
    $routes->get('crear', 'DerivacionController::crear');
    $routes->get('editar/(:num)', 'DerivacionController::editar/$1');
});

$routes->group('api', function ($routes) {
    $routes->post('derivaciones/add', 'DerivacionController::saveDerivacion');
    $routes->get('derivaciones/obtener-por-id/(:num)', 'DerivacionController::obtenerPorId/$1');
    $routes->get('derivaciones/obtener-pendientes', 'DerivacionController::obtenerPendientes');
});