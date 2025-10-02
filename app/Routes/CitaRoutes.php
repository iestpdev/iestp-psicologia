<?php

$routes->get('/consultas', 'CitaController::index');
$routes->post('/citas/generar-asistidas-pdf', 'CitaController::generarAsistidasPdf');
