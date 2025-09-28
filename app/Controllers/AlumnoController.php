<?php

namespace App\Controllers;

class AlumnoController extends BaseController
{
    public function index(): string
    {
        return view('modules/alumnos/index');
    }
}
