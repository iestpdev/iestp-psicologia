<?php

namespace App\Validations\Profile;

class ProfileUpdate
{
    public array $rules = [
        'id' => 'permit_empty',
        'correo' => 'trim|required|valid_email|regex_match[/^[\w\.-]+@iestpchincha\.edu\.pe$/]|is_unique_soft[usuarios.correo_institucional,id,{id}]',
        'username' => 'trim|required|min_length[4]|max_length[70]|is_unique_soft[usuarios.username,id,{id}]',
    ];

    public array $errors = [
        'correo' => [
            'required' => 'Debe ingresar el correo institucional',
            'valid_email' => 'El correo no es válido',
            'regex_match' => 'El correo debe ser del dominio @iestpchincha.edu.pe',
            'is_unique_soft' => 'Este correo ya está registrado',
        ],
        'username' => [
            'required' => 'Debe ingresar un nombre de usuario',
            'is_unique_soft' => 'Este nombre de usuario ya está registrado',
            'min_length' => 'El usuario debe tener mínimo 4 caracteres',
            'max_length' => 'El usuario no puede superar 70 caracteres',
        ],
    ];
}
