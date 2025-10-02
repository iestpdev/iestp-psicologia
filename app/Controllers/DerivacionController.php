<?php

namespace App\Controllers;

class DerivacionController extends BaseController
{
    public function index(): string
    {
        return view('modules/derivaciones/index');
    }

    public function crear(): string
    {
        return view('modules/derivaciones/crear');
    }

    public function editar($usuarioId): string
    {
        return view('modules/derivaciones/editar');
    }
}
