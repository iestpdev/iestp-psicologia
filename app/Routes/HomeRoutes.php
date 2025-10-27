<?php

$routes->get('/', 'HomeController::index', ['filter' => ['auth', 'role:ADMIN,PSICOLOGO']]);
$routes->get('api/home-data', 'HomeController::getHomeData', ['filter' => ['auth', 'role:ADMIN,PSICOLOGO']]);

$routes->get('api/ably-token', 'AblyTokenController::getToken', ['filter' => 'auth']);