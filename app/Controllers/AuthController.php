<?php

namespace App\Controllers;

use App\Models\Configuracion;
use App\Models\Usuario;
use CodeIgniter\I18n\Time;

/**
 * Controlador AuthController
 *
 * Gestiona la autenticación de usuarios, incluyendo el inicio de sesión, 
 * verificación de dos factores (2FA) y cierre de sesión.
 * 
 * Flujo principal:
 *  - Validación de usuario y contraseña
 *  - Activación del flujo 2FA si está habilitado en la configuración del usuario
 *  - Inicio de sesión directo si el 2FA está desactivado
 *  - Verificación del código 2FA
 *  - Cierre de sesión
 *
 * @package App\Controllers
 */
class AuthController extends BaseController
{
    /**
     * Constructor del controlador.
     * Carga el helper de email necesario para el envío de códigos 2FA.
     */
    public function __construct()
    {
        helper('email');
    }

    /**
     * Muestra la vista del formulario de inicio de sesión.
     *
     * @return string Vista HTML del formulario de login.
     */
    public function login(): string
    {
        return view('modules/auth/login');
    }

    /**
     * Procesa la solicitud de inicio de sesión.
     * 
     * 1. Verifica las credenciales del usuario.
     * 2. Si el usuario tiene 2FA activado, genera y envía un código por correo.
     * 3. Si no tiene 2FA, inicia sesión directamente.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección según el resultado del login.
     */
    public function doLogin()
    {
        $usuarioModel = new Usuario();
        $username = $this->request->getPost('username');
        $password = $this->request->getPost('password');

        // Validar usuario
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

        // Si el usuario tiene 2FA activado, iniciamos el flujo
        if ($configuracionUser && $configuracionUser['auth_email']) {
            if (autenticacion2FA($usuario)) {
                return redirect()->to('/auth/verify2fa')->with('success', 'Hemos enviado un código de verificación a tu correo electrónico.');
            }

            return redirect()->back()->withInput()->with('error', 'Fallo en la activación de 2FA. Inténtalo de nuevo.');
        }

        // Si 2FA no está activo, autenticación directa
        return $this->doAuthLogin($usuario);
    }

    /**
     * Inicia la sesión del usuario después de validar credenciales o pasar 2FA.
     *
     * @param array $usuario Datos del usuario autenticado.
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección a la vista correspondiente según el rol.
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
     * Muestra el formulario de verificación del código 2FA.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse|string Redirige al login si no hay sesión temporal o muestra la vista.
     */
    public function verify2fa()
    {
        if (!session()->has('temp_user_id')) {
            return redirect()->to('/auth/login')->with('error', 'Sesión de verificación expirada.');
        }

        return view('modules/auth/verify_2fa');
    }

    /**
     * Procesa la verificación del código 2FA ingresado por el usuario.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección según el resultado de la verificación.
     */
    public function doVerify2fa()
    {
        if (!session()->has('temp_user_id')) {
            return redirect()->to('/auth/login')->with('error', 'Sesión de verificación expirada.');
        }

        $usuarioModel = new Usuario();
        $code = $this->request->getPost('code');
        $userId = session()->get('temp_user_id');

        $usuario = $usuarioModel->obtenerPorId($userId);

        if (!$usuario) {
            session()->remove('temp_user_id');
            return redirect()->to('/auth/login')->with('error', 'Error de usuario. Vuelve a iniciar sesión.');
        }

        $currentTime = Time::now();
        $expirationTime = Time::parse($usuario['codigo_2fa_expira']);

        if ($code != $usuario['codigo_2fa']) {
            return redirect()->back()->withInput()->with('error', 'Código de verificación incorrecto.');
        }

        if ($currentTime->isAfter($expirationTime)) {
            $usuarioModel->update($userId, ['codigo_2fa' => null, 'codigo_2fa_expira' => null]);
            return redirect()->back()->withInput()->with('error', 'El código de verificación ha expirado. Intenta iniciar sesión de nuevo.');
        }

        // Limpiar código y completar login
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

    /**
     * Cierra la sesión actual del usuario.
     *
     * @return \CodeIgniter\HTTP\RedirectResponse Redirección al login con mensaje de éxito.
     */
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/auth/login')->with('success', 'Sesión cerrada correctamente');
    }
}