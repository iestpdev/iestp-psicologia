<?php

$routes->get('/usuarios', 'UsuarioController::index');


$routes->get('/api/usuarios', 'UsuarioController::getUsuarios');