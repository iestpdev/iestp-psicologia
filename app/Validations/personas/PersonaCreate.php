<?php

namespace App\Validations\Personas;

class PersonaCreate
{
    public array $rules = [
        'nombres' => 'required|min_length[2]|max_length[100]',
        'apellidos' => 'required|min_length[2]|max_length[100]',
        'dni' => 'required|exact_length[8]|numeric|is_unique_soft[personas.dni]',
        'telefono' => 'permit_empty|exact_length[9]|numeric',
    ];

    public array $errors = [
        'nombres' => [
            'required' => 'Debe ingresar los nombres',
            'min_length' => 'El nombre debe tener al menos 2 caracteres',
            'max_length' => 'El nombre no puede superar los 100 caracteres',
        ],
        'apellidos' => [
            'required' => 'Debe ingresar los apellidos',
            'min_length' => 'El apellido debe tener al menos 2 caracteres',
            'max_length' => 'El apellido no puede superar los 100 caracteres',
        ],
        'dni' => [
            'required' => 'El DNI es obligatorio',
            'exact_length' => 'El DNI debe tener exactamente 8 dígitos',
            'numeric' => 'El DNI solo puede contener números',
            'is_unique_soft' => 'Este DNI ya está registrado',
        ],
        'telefono' => [
            'exact_length' => 'El teléfono debe tener exactamente 9 dígitos',
            'numeric' => 'El teléfono solo puede contener números',
        ],
    ];
}
