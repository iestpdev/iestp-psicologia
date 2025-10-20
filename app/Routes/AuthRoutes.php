<?php
$routes->get('auth/login', 'AuthController::login', ['filter' => 'alreadyLoggedIn']);

$routes->group('api', function ($routes) {
    $routes->post('auth/doLogin', 'AuthController::doLogin');
    $routes->get('auth/logout', 'AuthController::logout');
});