<?php

$routes->group('usuarios', function ($routes) {
    $routes->get('/', 'UsuarioController::index');
    $routes->get('crear', 'UsuarioController::crear');
    $routes->get('editar/(:num)', 'UsuarioController::editar/$1');
});


$routes->group('api', function ($routes) {
    $routes->post('usuarios/add', 'UsuarioController::saveUsuario');
});