<?php

namespace App\Validations\Usuarios;

class UsuarioCreate
{
    public array $rules = [
        'correo' => 'required|valid_email|regex_match[/^[\w\.-]+@iestpchincha\.edu\.pe$/]|is_unique_soft[usuarios.correo_institucional]',
        'username' => 'required|is_unique_soft[usuarios.username]|min_length[4]|max_length[70]',
        'password' => 'required|regex_match[/^(?=.*[A-Z])(?=.*\d)(?=.*[^A-Za-z\d]).{8,}$/]',
        'rol' => 'required|in_list[ADMIN,PSICOLOGO,DOCENTE]',
    ];

    public array $errors = [
        'correo' => [
            'required' => 'Debe ingresar el correo institucional',
            'valid_email' => 'El correo no es válido',
            'regex_match' => 'El correo debe ser del dominio @iestpchincha.edu.pe',
            'is_unique_soft' => 'Este correo ya está registrado',
        ],
        'username' => [
            'required' => 'El usuario es obligatorio',
            'is_unique_soft' => 'Este nombre de usuario ya está registrado',
            'min_length' => 'El usuario debe tener mínimo 4 caracteres',
            'max_length' => 'El usuario no puede superar 70 caracteres',
        ],
        'password' => [
            'required' => 'Debe ingresar una contraseña',
            'regex_match' => 'La contraseña debe tener al menos una mayúscula, un número y un carácter especial',
        ],
        'rol' => [
            'required' => 'Debe seleccionar un rol',
            'in_list' => 'El rol seleccionado no es válido',
        ],
    ];
}
