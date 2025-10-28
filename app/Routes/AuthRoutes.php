<?php


$routes->group('auth', ['filter' => 'alreadyLoggedIn'], function ($routes) {
    $routes->get('login', 'AuthController::login');
    $routes->get('verify2fa', 'AuthController::verify2fa');
});

$routes->group('api', function ($routes) {
    $routes->post('auth/doLogin', 'AuthController::doLogin', ['filter' => 'alreadyLoggedIn']);
    $routes->post('auth/doVerify2fa', 'AuthController::doVerify2fa');
    $routes->get('auth/logout', 'AuthController::logout');
});