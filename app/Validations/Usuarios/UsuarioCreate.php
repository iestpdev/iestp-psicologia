<?php

namespace App\Validations\Usuarios;

/**
 * Validación para la creación de usuarios.
 *
 * Define las reglas y mensajes de error utilizados al registrar
 * un nuevo usuario dentro del sistema.
 */
class UsuarioCreate
{
    /**
     * Reglas de validación para los campos del formulario de creación.
     *
     * - correo: debe ser institucional, único y válido.
     * - username: requerido, único y con longitud entre 4 y 70 caracteres.
     * - password: mínimo una mayúscula, un número y un carácter especial.
     * - rol: debe ser uno de los roles válidos (ADMIN, PSICOLOGO, DOCENTE).
     * - estado: opcional, solo puede ser 0 o 1.
     *
     * @var array
     */
    public array $rules = [
        'correo' => 'trim|required|valid_email|regex_match[/^[\w\.-]+@iestpchincha\.edu\.pe$/]',
        'username' => 'trim|required|min_length[4]|max_length[18]|is_unique_soft[usuarios.username]',
        'password' => 'required|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/]',
        'rol' => 'required|in_list[ADMIN,PSICOLOGO,DOCENTE]',
        'estado' => 'in_list[0,1]',
    ];

    /**
     * Mensajes personalizados para los errores de validación.
     *
     * @var array
     */
    public array $errors = [
        'correo' => [
            'required' => 'Debe ingresar el correo institucional',
            'valid_email' => 'El correo no es válido',
            'regex_match' => 'El correo debe ser del dominio @iestpchincha.edu.pe',
        ],
        'username' => [
            'required' => 'El usuario es obligatorio',
            'is_unique_soft' => 'Este nombre de usuario ya está registrado',
            'min_length' => 'El usuario debe tener mínimo 4 caracteres',
            'max_length' => 'El usuario no puede superar 18 caracteres',
        ],
        'password' => [
            'required' => 'Debe ingresar una contraseña',
            'regex_match' => 'La contraseña debe tener al menos una mayúscula, un número y un carácter especial',
        ],
        'rol' => [
            'required' => 'Debe seleccionar un rol',
            'in_list' => 'El rol seleccionado no es válido',
        ],
        'estado' => [
            'in_list' => 'El estado del usuario no es válido.',
        ],
    ];
}