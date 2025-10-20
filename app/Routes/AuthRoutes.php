<?php


$routes->group('auth', ['filter' => 'alreadyLoggedIn'], function ($routes) {
    $routes->get('login', 'AuthController::login');
});

$routes->group('api', function ($routes) {
    $routes->post('auth/doLogin', 'AuthController::doLogin', ['filter' => 'alreadyLoggedIn']);
    $routes->get('auth/logout', 'AuthController::logout');
});