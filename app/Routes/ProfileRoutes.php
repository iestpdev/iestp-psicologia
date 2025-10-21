<?php


$routes->group('profile',['filter' => 'auth'], function ($routes) {
    $routes->get('/', 'ProfileController::index');
});