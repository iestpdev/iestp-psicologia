<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// rutas por módulos
require APPPATH . 'Routes/AuthRoutes.php';
require APPPATH . 'Routes/HomeRoutes.php';
require APPPATH . 'Routes/UsuarioRoutes.php';
require APPPATH . 'Routes/AlumnoRoutes.php';
require APPPATH . 'Routes/DerivacionRoutes.php';
require APPPATH . 'Routes/CitaRoutes.php';
require APPPATH . 'Routes/FamiliarRoutes.php';

require APPPATH . 'Routes/DataTableRoutes.php';

