<?php

namespace App\Validations\Usuarios;

/**
 * Validación para la actualización de usuarios.
 *
 * Define las reglas y mensajes de error utilizados al actualizar
 * los datos de un usuario existente en el sistema.
 */
class UsuarioUpdate
{
    /**
     * Reglas de validación para los campos del formulario de actualización.
     *
     * - id: opcional, permite vacío.
     * - correo: requerido, debe ser institucional, único considerando el ID actual.
     * - username: requerido, único considerando el ID actual, longitud entre 4 y 70.
     * - rol: obligatorio, debe ser uno de los roles válidos (ADMIN, PSICOLOGO, DOCENTE).
     * - estado: opcional, solo puede ser 0 o 1.
     *
     * @var array
     */
    public array $rules = [
        'id'       => 'permit_empty',
        'correo'   => 'trim|required|valid_email|regex_match[/^[\w\.-]+@iestpchincha\.edu\.pe$/]',
        'username' => 'trim|required|min_length[4]|max_length[70]|is_unique_soft[usuarios.username,id,{id}]',
        'rol'      => 'required|in_list[ADMIN,PSICOLOGO,DOCENTE]',
        'estado'   => 'in_list[0,1]',
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
            'required' => 'Debe ingresar un nombre de usuario',
            'is_unique_soft' => 'Este nombre de usuario ya está registrado',
            'min_length' => 'El usuario debe tener mínimo 4 caracteres',
            'max_length' => 'El usuario no puede superar 70 caracteres',
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