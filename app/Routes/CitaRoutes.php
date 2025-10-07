<?php

$routes->get('/citas', 'CitaController::index');
$routes->get('/citas/crear', 'CitaController::crear');
$routes->get('/citas/editar/(:num)', 'CitaController::editar/$1');

$routes->post('/citas/generar-asistidas-pdf', 'CitaController::generarAsistidasPdf');
