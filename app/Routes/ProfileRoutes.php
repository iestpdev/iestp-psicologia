<?php

$routes->group('profile',['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ProfileController::index');
    $routes->post('update-userlogged', 'ProfileController::updateUserLogged');
});