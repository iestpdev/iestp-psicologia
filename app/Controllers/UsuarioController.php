<?php

namespace App\Controllers;

use App\Models\Configuracion;
use App\Models\Persona;
use App\Models\Usuario;

/**
 * Controlador responsable de la gestión de usuarios dentro del sistema.
 *
 * Permite crear, editar, eliminar y actualizar usuarios, así como manejar sus datos
 * personales asociados (tabla `personas`). También ofrece métodos para actualizar contraseñas
 * y obtener listados de docentes.
 *
 * @package App\Controllers
 */
class UsuarioController extends BaseController
{
    /**
     * Muestra la vista principal del módulo de usuarios.
     *
     * @return string Vista principal de usuarios.
     */
    public function index(): string
    {
        return view('modules/usuarios/index');
    }

    /**
     * Muestra el formulario para crear un nuevo usuario.
     *
     * @return string Vista de creación de usuario.
     */
    public function crear(): string
    {
        return view('modules/usuarios/crear');
    }

    /**
     * Muestra la vista para editar un usuario existente.
     *
     * @param int $usuarioId ID del usuario a editar.
     * @return string Vista de edición o vista de error si el usuario no existe.
     */
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

    /**
     * Elimina un usuario y su persona asociada dentro de una transacción.
     *
     * @param int $id ID del usuario a eliminar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de éxito o error.
     */
    public function deleteUsuario($id)
    {
        $usuarioModel = new Usuario();

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $usuario = $usuarioModel->obtenerPorId($id);
            if (!$usuario)
                throw new \Exception("Usuario no encontrado");
            if (!$usuarioModel->eliminar($id))
                throw new \Exception("Error al eliminar usuario");

            $db->transCommit();
            return redirect()->to('/usuarios')->with('success', 'Usuario eliminado correctamente');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to('/usuarios')->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    /**
     * Crea un nuevo usuario junto con su persona asociada y configuración predeterminada.
     *
     * Aplica validaciones, normaliza los datos y ejecuta la transacción completa.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensajes de éxito o error.
     */
    public function saveUsuario()
    {
        helper(['validation', 'input']);
        $errors = [];
        $errors = array_merge($errors, runValidation('persona_create', $this->request));
        $errors = array_merge($errors, runValidation('usuario_create', $this->request));

        $dni = $this->request->getPost('dni');
        $rol = $this->request->getPost('rol');

        if (empty($errors) && $dni && $rol) {
            $usuarioModel = new Usuario();
            if ($usuarioModel->existeOtroUsuarioConDniYRol($dni, $rol)) {
                $errors['rol'] = 'La persona con DNI ' . $dni . ' ya tiene un usuario registrado con el rol ' . $rol . '. Para asignarle otro, el rol debe ser diferente.';
            }
        }
        if (!empty($errors))
            return redirect()->to('/usuarios/crear')->withInput()->with('errors', $errors);

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $personaModel = new Persona();
            $personaExistente = $personaModel->where('dni', $dni)->first();
            $personaData = normalize_input([
                'nombres' => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'dni' => $this->request->getPost('dni'),
                'telefono' => $this->request->getPost('telefono'),
            ]);

            if ($personaExistente) {
                $personaId = (int) $personaExistente['id'];
                $personaModel->update($personaId, $personaData);

            } else {
                $personaId = $personaModel->crear($personaData);
                if (!$personaId)
                    throw new \Exception("Error al crear Persona");
            }

            $usuarioData = normalize_input([
                'correo_institucional' => $this->request->getPost('correo'),
                'username' => $this->request->getPost('username'),
                'userpass' => $this->request->getPost('password'),
                'persona_id' => $personaId,
                'rol' => $this->request->getPost('rol'),
                'estado' => $this->request->getPost('estado') ?? 1,
            ]);
            $usuarioModel = new Usuario();
            $usuarioId = $usuarioModel->crear($usuarioData);
            if (!$usuarioId)
                throw new \Exception("Error al crear Usuario");

            $configuracionModel = new Configuracion();
            $configuracionId = $configuracionModel->crear([
                "usuario_id" => $usuarioId,
                "auth_email" => false,
                "notif_email" => false,
            ]);
            if (!$configuracionId)
                throw new \Exception("Error al crear configuraciones predeterminadas");
            $db->transCommit();
            return redirect()->to('/usuarios')->with('success', 'Usuario registrado con éxito');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    /**
     * Actualiza los datos de un usuario y su persona asociada.
     *
     * Ejecuta las validaciones necesarias y aplica los cambios dentro de una transacción.
     *
     * @param int $id ID del usuario a actualizar.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección con mensaje de éxito o error.
     */
    public function updateUsuario($id)
    {
        helper(['validation', 'input']);
        $errors = [];
        $errors = array_merge($errors, runValidation('persona_update', $this->request));
        $errors = array_merge($errors, runValidation('usuario_update', $this->request));

        $usuarioModel = new Usuario();
        $dni = $this->request->getPost('dni');
        $rol = $this->request->getPost('rol');
        if ($dni && $rol) {
            if ($usuarioModel->existeOtroUsuarioConDniYRol($dni, $rol, (int) $id)) {
                $errors['dni'] = "Ya existe otro usuario registrado con el DNI {$dni} y el Rol {$rol}.";
            }
        }
        if (!empty($errors)) return redirect()->back()->withInput()->with('errors', $errors);

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $usuarioActual = $usuarioModel->obtenerPorId($id);
            if (!$usuarioActual) throw new \Exception("Usuario no encontrado (ID: {$id})");

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

    /**
     * Actualiza la contraseña de un usuario específico.
     *
     * Recibe el nuevo password en formato JSON y actualiza su hash en la base de datos.
     *
     * @param int $id ID del usuario cuya contraseña se actualizará.
     * @return \CodeIgniter\HTTP\Response JSON con mensaje de resultado.
     */
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

    /**
     * Obtiene un listado de usuarios con rol docente.
     *
     * Si se proporciona un DNI, se filtra el resultado.
     *
     * @param string|null $dni DNI del docente a buscar (opcional).
     * @return \CodeIgniter\HTTP\Response JSON con la lista de docentes.
     */
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