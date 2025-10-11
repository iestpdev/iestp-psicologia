<?php

$routes->get('api/decolecta/dni/(:num)', 'services\DecolectaController::getDataByDni/$1');
