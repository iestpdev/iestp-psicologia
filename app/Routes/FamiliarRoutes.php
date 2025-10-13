<?php

$routes->group('api', function ($routes) {
     $routes->get('familiares/obtener-por-alumnoid/(:num)', 'FamiliarController::listarPorAlumnoId/$1');
     $routes->post('familiares/add/(:num)', 'FamiliarController::saveFamiliar/$1');
});