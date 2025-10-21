<?php

$routes->group('citas',['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'CitaController::index');
    $routes->get('crear', 'CitaController::crear');
    $routes->get('editar/(:num)', 'CitaController::editar/$1');
    $routes->get('info/(:num)', 'CitaController::infoCita/$1');
});

$routes->group('api',['filter' => 'auth'], function ($routes) {
    $routes->post('citas/add', 'CitaController::saveCita');
    $routes->post('citas/update/(:num)', 'CitaController::updateCita/$1');
    $routes->get('citas/delete/(:num)', 'CitaController::deleteCita/$1');

    $routes->post('citas/generar-asistidas-pdf', 'CitaController::generarAsistidasPdf');
});