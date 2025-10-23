<?php

namespace App\Controllers;

use App\Models\Usuario;

class AuthController extends BaseController
{
    public function login(): string
    {
        return view('modules/auth/login');
    }

    public function doLogin()
    {
        $usuarioModel = new Usuario();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        $usuario = $usuarioModel->obtenerPorUsername($username);
        if (!$usuario)
            return redirect()->back()->withInput()->with('error', 'Usuario no encontrado');

        if (isset($usuario['estado']) && !$usuario['estado']) {
            return redirect()->back()->withInput()->with('error', 'Tu cuenta está inactiva');
        }

        if (!password_verify($password, $usuario['userpass'])) {
            return redirect()->back()->withInput()->with('error', 'Contraseña incorrecta');
        }

        $session = session();
        $session->set([
            'user' => [
                'id' => $usuario['id'],
                'persona_id' => $usuario['persona_id'],
                'nombres' => $usuario['nombres'],
                'apellidos' => $usuario['apellidos'],
                'username' => $usuario['username'],
                'rol' => $usuario['rol'],
            ],
            'isLoggedIn' => true,
        ]);

        if ($usuario['rol'] === 'DOCENTE') {
            return redirect()->to('/alumnos')->with('success', 'Bienvenido ' . esc($usuario['nombres']));
        }

        return redirect()->to('/')->with('success', 'Bienvenido ' . esc($usuario['nombres']));
    }

    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Sesión cerrada correctamente');
    }
}