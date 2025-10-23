<?php

namespace App\Controllers;

use App\Models\Configuracion;
use App\Models\Persona;
use App\Models\Usuario;

class ProfileController extends BaseController
{
    public function index(): string
    {
        $session = session();
        $user = $session->get('user');
        $usuarioId = $user['id'];

        $usuarioModel = new Usuario();
        $data['usuario'] = $usuarioModel->obtenerPorId($usuarioId);

        $ConfiguracionModel = new Configuracion();
        $data['configuracion'] = $ConfiguracionModel->obtenerPorUsuarioId($usuarioId);

        return view('modules/profile/index', $data);
    }

    public function updateUserLogged()
    {
        helper(['validation', 'input']);
        $errors = [];
        $errors = array_merge($errors, runValidation('persona_update', $this->request));
        $errors = array_merge($errors, runValidation('profile_update', $this->request));

        if (!empty($errors))
            return redirect()->back()->withInput()->with('errors', $errors);

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $session = session();
            $user = $session->get('user');
            $usuarioId = $user['id'];
            $usuarioUsername = $user['username'];

            $this->verificarYActualizarPassword($usuarioUsername);

            $usuarioModel = new Usuario();
            $usuarioActual = $usuarioModel->obtenerPorId($usuarioId);
            if (!$usuarioActual)
                throw new \Exception("Usuario no encontrado");

            $usuarioData = normalize_input([
                'correo_institucional' => $this->request->getPost('correo'),
                'username' => $this->request->getPost('username'),
            ]);
            $usuarioModel->actualizar($usuarioId, $usuarioData);

            $personaModel = new Persona();
            $personaData = normalize_input([
                'nombres' => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'dni' => $this->request->getPost('dni'),
                'telefono' => $this->request->getPost('telefono'),
            ]);
            $personaModel->actualizar($usuarioActual['persona_id'], $personaData);

            $ConfiguracionModel = new Configuracion();
            $configuracionData = normalize_input([
                'usuario_id' => $usuarioId,
                'auth_SMS' => $this->request->getPost('auth_SMS') ? 1 : 0,
                'auth_email' => $this->request->getPost('auth_email') ? 1 : 0,
                'notif_email' => $this->request->getPost('notif_email') ? 1 : 0,
            ]);
            $ConfiguracionModel->actualizarPorUsuarioId($usuarioId, $configuracionData);

            $this->actualizarDatosSesion([
                'nombres' => $personaData['nombres'],
                'apellidos' => $personaData['apellidos'],
                'username' => $usuarioData['username'],
            ]);
            
            $db->transCommit();
            return redirect()->to('/')->with('success', 'Perfil actualizado correctamente');
        } catch (\Exception $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    private function verificarYActualizarPassword(string $username): void
    {
        $currentPassword = $this->request->getPost('currentPassword');
        $newPassword = $this->request->getPost('newPassword');
        $confirmPassword = $this->request->getPost('confirmPassword');

        // Si no hay contraseñas nuevas, no se actualiza
        if (empty($currentPassword) && empty($newPassword) && empty($confirmPassword)) {
            return;
        }

        $usuarioModel = new Usuario();
        $usuario = $usuarioModel->obtenerPorUsername($username);

        if (!$usuario)
            throw new \Exception("Usuario no encontrado para cambio de contraseña");

        // Verificar que la contraseña actual coincida
        if (!password_verify($currentPassword, $usuario['userpass'])) {
            throw new \Exception("La contraseña actual no es correcta");
        }

        // Verificar que la nueva contraseña sea diferente
        if ($currentPassword === $newPassword) {
            throw new \Exception("La nueva contraseña no puede ser igual a la actual");
        }

        // Verificar que la confirmación coincida
        if ($newPassword !== $confirmPassword) {
            throw new \Exception("La confirmación de la contraseña no coincide");
        }

        // Actualizar la contraseña 
        $usuarioModel->actualizar($usuario['id'], ['userpass' => $newPassword]);
    }

    private function actualizarDatosSesion(array $usuarioActualizado): void
    {
        $session = session();
        $userSession = $session->get('user');

        $userSession['nombres'] = $usuarioActualizado['nombres'] ?? $userSession['nombres'];
        $userSession['apellidos'] = $usuarioActualizado['apellidos'] ?? $userSession['apellidos'];
        $userSession['username'] = $usuarioActualizado['username'] ?? $userSession['username'];

        $session->set('user', $userSession);
    }

}