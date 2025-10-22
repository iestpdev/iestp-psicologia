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
        $usuarioModel = new Usuario();
        $usuarioEncontrado = $usuarioModel->obtenerPorId($usuarioId);

        if (!$usuarioEncontrado) {
            return view('errors/html/error_404', [
                'message' => 'Usuario no encontrado'
            ]);
        }

        $data['usuario'] = $usuarioEncontrado;
        return view('modules/usuarios/editar', $data);
    }
    /* -- return VIEW */

    public function deleteUsuario($id)
    {
        $usuarioModel = new Usuario();
        $personaModel = new Persona();

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $usuario = $usuarioModel->obtenerPorId($id);
            if (!$usuario)
                throw new \Exception("Usuario no encontrado");
            if (!$usuarioModel->eliminar($id))
                throw new \Exception("Error al eliminar usuario");
            if (!$personaModel->eliminar($usuario['persona_id']))
                throw new \Exception("Error al eliminar persona asociada");

            $db->transCommit();
            return redirect()->to('/usuarios')->with('success', 'Usuario eliminado correctamente');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to('/usuarios')->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function saveUsuario()
    {
        helper(['validation', 'input']);
        $errors = [];
        $errors = array_merge($errors, runValidation('persona_create', $this->request));
        $errors = array_merge($errors, runValidation('usuario_create', $this->request));

        if (!empty($errors))
            return redirect()->to('/usuarios/crear')->withInput()->with('errors', $errors);

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $personaData = normalize_input([
                'nombres' => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'dni' => $this->request->getPost('dni'),
                'telefono' => $this->request->getPost('telefono'),
            ]);
            $personaModel = new Persona();
            $personaId = $personaModel->crear($personaData);
            if (!$personaId)
                throw new \Exception("Error al crear Persona");

            $usuarioData = normalize_input([
                'correo_institucional' => $this->request->getPost('correo'),
                'username' => $this->request->getPost('username'),
                'userpass' => $this->request->getPost('userpass'),
                'persona_id' => $personaId,
                'rol' => $this->request->getPost('rol'),
                'estado' => $this->request->getPost('estado') ?? 1,
            ]);
            $usuarioModel = new Usuario();
            $usuarioId = $usuarioModel->crear($usuarioData);
            if (!$usuarioId)
                throw new \Exception("Error al crear Usuario");

            $db->transCommit();
            return redirect()->to('/usuarios')->with('success', 'Usuario registrado con éxito');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function updateUsuario($id)
    {
        helper(['validation', 'input']);
        $errors = [];
        $errors = array_merge($errors, runValidation('persona_update', $this->request));
        $errors = array_merge($errors, runValidation('usuario_update', $this->request));

        if (!empty($errors))
            return redirect()->back()->withInput()->with('errors', $errors);

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $usuarioModel = new Usuario();
            $usuarioActual = $usuarioModel->obtenerPorId($id);
            if (!$usuarioActual)
                throw new \Exception("Usuario no encontrado");

            $usuarioData = normalize_input([
                'correo_institucional' => $this->request->getPost('correo'),
                'username' => $this->request->getPost('username'),
                'rol' => $this->request->getPost('rol'),
                'estado' => $this->request->getPost('estado'),
            ]);
            $usuarioModel->actualizar($id, $usuarioData);

            $personaModel = new Persona();
            $personaData = normalize_input([
                'nombres' => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'dni' => $this->request->getPost('dni'),
                'telefono' => $this->request->getPost('telefono'),
            ]);
            $personaModel->actualizar($usuarioActual['persona_id'], $personaData);

            $db->transCommit();
            return redirect()->to('/usuarios')->with('success', 'Usuario actualizado correctamente');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function updatePassword($id)
    {
        $usuarioModel = new Usuario();
        $data = $this->request->getJSON(true);
        $newPassword = $data['password'] ?? null;

        if (!$newPassword)
            return $this->response->setJSON(['message' => 'Contraseña no proporcionada'])->setStatusCode(400);

        try {
            $usuario = $usuarioModel->find($id);
            if (!$usuario)
                return $this->response->setJSON(['message' => 'Usuario no encontrado'])->setStatusCode(404);

            $usuarioModel->update($id, [
                'userpass' => password_hash($newPassword, PASSWORD_BCRYPT),
            ]);

            return $this->response->setJSON(['message' => 'Contraseña actualizada']);
        } catch (\Throwable $e) {
            return $this->response->setJSON(['message' => 'Error: ' . $e->getMessage()])->setStatusCode(500);
        }
    }

    public function obtenerDocentes($dni = null)
    {
        $usuarioModel = new Usuario();
        if ($dni) {
            $docentes = $usuarioModel->obtenerDocentes($dni);
        } else {
            $docentes = $usuarioModel->obtenerDocentes();
        }

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $docentes
        ]);
    }
}
