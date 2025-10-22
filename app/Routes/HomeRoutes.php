<?php

$routes->get('/', 'HomeController::index', ['filter' => ['auth', 'role:ADMIN,PSICOLOGO']]);