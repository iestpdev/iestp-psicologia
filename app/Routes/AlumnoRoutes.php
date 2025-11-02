<?php

$routes->group('alumnos',['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'AlumnoController::index');
    $routes->get('crear', 'AlumnoController::crear');
    $routes->get('editar/(:num)', 'AlumnoController::editar/$1');
    $routes->get('info/(:num)', 'AlumnoController::info/$1');
});

$routes->group('api',['filter' => 'auth'], function ($routes) {
    $routes->post('alumnos/add', 'AlumnoController::saveAlumno');
    $routes->post('alumnos/update/(:num)', 'AlumnoController::updateAlumno/$1');
    $routes->get('alumnos/delete/(:num)', 'AlumnoController::deleteAlumno/$1');

    $routes->get('alumnos/obtener-alumnos', 'AlumnoController::obtenerAlumnos');
    $routes->post('alumnos/importar-xlsx', 'AlumnoController::importarDataExcel');
});
