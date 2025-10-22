<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class Role implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        $rol = $session->get('user.rol') ?? null;

        if (!$rol) {
            $session->destroy();
            return redirect()->to('auth/login')->with('warning', 'Debes iniciar sesión');
        }

        if (!in_array($rol, $arguments)) {
            $session->destroy();
            return redirect()->to('/')->with('warning', 'No tienes permisos para acceder a esta sección');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {

    }
}