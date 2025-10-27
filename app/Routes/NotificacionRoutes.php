<?php

$routes->group('api', ['filter' => 'auth'], function ($routes) {
    $routes->get('notificaciones', 'NotificacionController::listarPorReceptorId');
    $routes->get('notificaciones/(:num)', 'NotificacionController::listarPorReceptorId/$1');

    $routes->patch('notificaciones/marcar-como-leido', 'NotificacionController::marcarComoLeidoPorReceptorId');
    $routes->patch('notificaciones/marcar-como-leido/(:num)', 'NotificacionController::marcarComoLeidoPorReceptorId/$1');
});