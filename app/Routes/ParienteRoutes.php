<?php

$routes->group('api',['filter' => 'auth'], function ($routes) {
    $routes->get('parientes/obtener-por-id/(:num)', 'ParienteController::obtenerPorId/$1');
    $routes->post('parientes/update/(:num)', 'ParienteController::updatePariente/$1');
});