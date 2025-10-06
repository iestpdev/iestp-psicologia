<?php

$routes->group('alumnos', function ($routes) {
    $routes->get('/', 'AlumnoController::index');
    $routes->get('crear', 'AlumnoController::crear');
    $routes->get('editar/(:num)', 'AlumnoController::editar/$1');
    $routes->get('info/(:num)', 'AlumnoController::info/$1');
});


$routes->group('api', function ($routes) {
    $routes->post('alumnos/add', 'AlumnoController::saveAlumno');
    $routes->get('alumnos/obtener-alumnos', 'AlumnoController::obtenerAlumnos');
});