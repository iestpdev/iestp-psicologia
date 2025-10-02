<?php

namespace App\Controllers;

use App\Models\Persona;
use App\Models\Usuario;

class UsuarioController extends BaseController
{
    /* return VIEW -- */
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
    /* -- return VIEW */

    public function deleteUsuario($id)
    {
        $usuarioModel = new Usuario();
        $personaModel = new Persona();

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $usuario = $usuarioModel->getById($id);
            if (!$usuario) throw new \Exception("Usuario no encontrado");
            if (!$usuarioModel->eliminar($id)) throw new \Exception("Error al eliminar usuario");
            if (!$personaModel->eliminar($usuario['persona_id'])) throw new \Exception("Error al eliminar persona asociada");

            $db->transCommit();
            return redirect()->to('/usuarios')->with('success', 'Usuario eliminado correctamente');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to('/usuarios')->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }


    public function saveUsuario()
    {
        helper('validation');
        $errors = [];
        $errors = array_merge($errors, runValidation('persona_create', $this->request));
        $errors = array_merge($errors, runValidation('usuario_create', $this->request));

        if (!empty($errors)) return redirect()->to('/usuarios/crear')->withInput()->with('errors', $errors);

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $personaModel = new Persona();
            $personaId = $personaModel->crear([
                'nombres'   => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'dni'       => $this->request->getPost('dni'),
                'telefono'  => $this->request->getPost('telefono'),
            ]);
            if (!$personaId) throw new \Exception("Error al crear Persona");

            $usuarioModel = new Usuario();
            $usuarioId = $usuarioModel->crear([
                'correo_institucional' => $this->request->getPost('correo'),
                'username'             => $this->request->getPost('username'),
                'userpass'             => $this->request->getPost('userpass'),
                'persona_id'           => $personaId,
                'rol'                  => $this->request->getPost('rol'),
                'estado'               => true,
            ]);
            if (!$usuarioId) throw new \Exception("Error al crear Usuario");

            $db->transCommit();
            return redirect()->to('/usuarios')->with('success', 'Usuario registrado con éxito');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function obtenerDocentes($dni = null)
    {
        $usuarioModel = new Usuario();
        if ($dni) $docentes = $usuarioModel->obtenerDocentes($dni);
        
        $docentes = $usuarioModel->obtenerDocentes();
        
        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $docentes
        ]);
    }
}
