<?php

$routes->get('/usuarios', 'UsuarioController::index');

$routes->group('api', function($routes) {
    $routes->get('usuarios', 'DataTableController::getUsuarios');
});