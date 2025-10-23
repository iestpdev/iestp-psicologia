<?php

namespace App\Controllers;

use App\Models\Configuracion;
use App\Models\Usuario;
use CodeIgniter\I18n\Time;

class AuthController extends BaseController
{
    public function __construct()
    {
        helper('email');
    }

    public function login(): string
    {
        return view('modules/auth/login');
    }

    public function doLogin()
    {
        $usuarioModel = new Usuario();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        //Validación de Usuario y Contraseña
        $usuario = $usuarioModel->obtenerPorUsername($username);
        if (!$usuario) {
            return redirect()->back()->withInput()->with('error', 'Usuario no encontrado');
        }

        if (isset($usuario['estado']) && !$usuario['estado']) {
            return redirect()->back()->withInput()->with('error', 'Tu cuenta está inactiva');
        }

        if (!password_verify($password, $usuario['userpass'])) {
            return redirect()->back()->withInput()->with('error', 'Contraseña incorrecta');
        }

        $configuracionModel = new Configuracion();
        $configuracionUser = $configuracionModel->obtenerPorUsuarioId($usuario['id']);

        if ($configuracionUser && $configuracionUser['auth_email']) {
            // --- INICIO DEL FLUJO 2FA ---
            // Ejecutar autenticación 2FA (Generar código, guardar, enviar email)
            if (autenticacion2FA($usuario)) {
                //Redirigir a la vista de verificación de código 2FA
                return redirect()->to('/auth/verify2fa')->with('success', 'Hemos enviado un código de verificación a tu correo electrónico.');
            }

            // Fallo en 2FA (ej. No se pudo enviar el correo o guardar el código)
            return redirect()->back()->withInput()->with('error', 'Fallo en la activación de 2FA. Inténtalo de nuevo.');
        } else {
            // --- FLUJO LOGIN DIRECTO (2FA DESACTIVADO) ---
            return $this->doAuthLogin($usuario);
        }
    }

    /**
     * Inicia la sesión del usuario después de pasar todas las verificaciones.
     * Este método se usa si el 2FA está desactivado, o después de pasar el 2FA.
     */
    private function doAuthLogin(array $usuario)
    {
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

    /**
     * Muestra el formulario para ingresar el código 2FA.
     * El usuario debe tener un temp_user_id en la sesión.
     */
    public function verify2fa()
    {
        if (!session()->has('temp_user_id')) {
            // Si no hay un usuario pendiente de 2FA, redirigir al login
            return redirect()->to('/auth/login')->with('error', 'Sesión de verificación expirada.');
        }

        return view('modules/auth/verify_2fa');
    }

    /**
     * Procesa el código 2FA ingresado por el usuario.
     */
    public function doVerify2fa()
    {
        if (!session()->has('temp_user_id')) {
            return redirect()->to('/auth/login')->with('error', 'Sesión de verificación expirada.');
        }

        $usuarioModel = new Usuario();
        $code = $this->request->getPost('code');
        $userId = session()->get('temp_user_id');

        // Obtener el usuario pendiente
        $usuario = $usuarioModel->obtenerPorId($userId);

        if (!$usuario) {
            session()->remove('temp_user_id');
            return redirect()->to('/auth/login')->with('error', 'Error de usuario. Vuelve a iniciar sesión.');
        }

        // Verificar el código y la expiración
        $currentTime = Time::now();
        $expirationTime = Time::parse($usuario['codigo_2fa_expira']);

        if ($code != $usuario['codigo_2fa']) {
            return redirect()->back()->withInput()->with('error', 'Código de verificación incorrecto.');
        }

        if ($currentTime->isAfter($expirationTime)) {
            // Limpiar el código después de un intento fallido o expirado
            $usuarioModel->update($userId, ['codigo_2fa' => null, 'codigo_2fa_expira' => null]);
            return redirect()->back()->withInput()->with('error', 'El código de verificación ha expirado. Intenta iniciar sesión de nuevo.');
        }

        // Éxito: Iniciar Sesión Definitivamente
        // Limpiar código 2FA y la variable temporal de sesión
        $usuarioModel->update($userId, ['codigo_2fa' => null, 'codigo_2fa_expira' => null]);
        session()->remove('temp_user_id');

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