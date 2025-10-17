<?php

$routes->group('citas', function ($routes) {
    $routes->get('/', 'CitaController::index');
    $routes->get('crear', 'CitaController::crear');
    $routes->get('editar/(:num)', 'CitaController::editar/$1');
});

$routes->group('api', function ($routes) {
    $routes->post('citas/add', 'CitaController::saveCita');

    $routes->post('citas/generar-asistidas-pdf', 'CitaController::generarAsistidasPdf');
});