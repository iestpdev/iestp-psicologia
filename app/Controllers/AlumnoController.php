<?php

namespace App\Controllers;

class AlumnoController extends BaseController
{
    public function index(): string
    {
        return view('modules/alumnos/index');
    }

    public function crear(): string
    {
        return view('modules/alumnos/crear');
    }

    public function editar($usuarioId): string
    {
        return view('modules/alumnos/editar');
    }
}
