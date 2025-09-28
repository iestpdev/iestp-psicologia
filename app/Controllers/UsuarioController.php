<?php

namespace App\Controllers;

class UsuarioController extends BaseController
{
    public function index(): string
    {
        return view('modules/usuarios/index');
    }
}
