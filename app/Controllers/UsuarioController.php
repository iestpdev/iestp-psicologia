<?php

namespace App\Controllers;

class UsuarioController extends BaseController
{
    public function index(): string
    {
        return view('modules/usuarios/index');
    }

    public function crear(): string
    {
        return view('modules/usuarios/crear');
    }

    public function editar($usuarioId): string
    {
        return view('modules/usuarios/editar');
    }

    public function saveUsuario()
    {
        // Lógica para guardar el usuario
        return redirect()->to(base_url('usuarios'));
    }
}
