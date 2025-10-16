<?php

$routes->group('api', function ($routes) {
     $routes->get('familiares/obtener-por-alumnoid/(:num)', 'FamiliarController::listarPorAlumnoId/$1');
     $routes->post('familiares/add/(:num)', 'FamiliarController::saveNewFamiliar/$1');
     $routes->delete('familiares/delete/(:num)', 'FamiliarController::deleteFamiliar/$1');
});