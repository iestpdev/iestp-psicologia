<?php

namespace App\Controllers;
use App\Models\Usuario;

class UsuarioController extends BaseController
{
    public function index(): string
    {
        $usuarios = new Usuario();
        $data['usuarios'] = $usuarios->obtenerTodos();
        return view('modules/usuarios/index', $data);
    }
}
