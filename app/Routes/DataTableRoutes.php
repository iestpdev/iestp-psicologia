<?php
$routes->get('api/datatable/(:segment)', 'DataTableController::getData/$1',['filter' => 'auth']);
