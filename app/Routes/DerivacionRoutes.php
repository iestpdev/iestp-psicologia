<?php

$routes->group('derivaciones', function ($routes) {
    $routes->get('/', 'DerivacionController::index');
    $routes->get('crear', 'DerivacionController::crear');
    $routes->get('editar/(:num)', 'DerivacionController::editar/$1');
});

$routes->group('api', function ($routes) {
    $routes->post('derivaciones/add', 'DerivacionController::saveDerivacion');
    $routes->post('derivaciones/update/(:num)', 'DerivacionController::updateDerivacion/$1');
    $routes->get('derivaciones/delete/(:num)', 'DerivacionController::deleteDerivacion/$1');

    $routes->get('derivaciones/obtener-por-id/(:num)', 'DerivacionController::obtenerPorId/$1');
    $routes->get('derivaciones/obtener-pendientes', 'DerivacionController::obtenerPendientes');
});