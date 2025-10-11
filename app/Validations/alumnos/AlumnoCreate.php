<?php

namespace App\Validations\Alumnos;

class AlumnoCreate
{
    public array $rules = [
        'dni'               => 'required|exact_length[8]|numeric|is_unique_soft[alumnos.dni]',
        'nombres'           => 'required|min_length[2]|max_length[100]',
        'apellidos'         => 'required|min_length[2]|max_length[100]',
        'telefono'          => 'permit_empty|exact_length[9]|numeric',
        'programa_estudio'  => 'required|is_natural_no_zero',
        'ciclo'             => 'required|in_list[1,2,3,4,5,6]',
        'turno'             => 'required|in_list[M,T]',
        'sexo'              => 'required|in_list[M,F]',
        'direccion_nac'     => 'permit_empty|min_length[5]|max_length[255]',
        'domicilio'         => 'permit_empty|min_length[5]|max_length[255]',
        'fecha_nac'         => 'permit_empty|valid_date',
        'religion'          => 'required|is_natural_no_zero',
        'estado_civil'      => 'required|is_natural_no_zero',
    ];

    public array $errors = [
        'dni' => [
            'required'        => 'El DNI es obligatorio',
            'exact_length'    => 'El DNI debe tener exactamente 8 dígitos',
            'numeric'         => 'El DNI debe ser numérico',
            'is_unique_soft'  => 'Este DNI ya está registrado',
        ],
        'nombres' => [
            'required'        => 'Los nombres son obligatorios',
            'min_length'      => 'Los nombres deben tener al menos 2 caracteres',
            'max_length'      => 'Los nombres no pueden superar los 100 caracteres',
        ],
        'apellidos' => [
            'required'        => 'Los apellidos son obligatorios',
            'min_length'      => 'Los apellidos deben tener al menos 2 caracteres',
            'max_length'      => 'Los apellidos no pueden superar los 100 caracteres',
        ],
        'telefono' => [
            'exact_length'    => 'El teléfono debe tener exactamente 9 dígitos',
            'numeric'         => 'El teléfono debe ser numérico',
        ],
        'programa_estudio' => [
            'required'        => 'El programa de estudio es obligatorio',
            'is_natural_no_zero' => 'Seleccione un programa de estudio válido',
        ],
        'ciclo' => [
            'required'        => 'El ciclo es obligatorio',
            'in_list'         => 'Seleccione un ciclo válido',
        ],
        'turno' => [
            'required'        => 'El turno es obligatorio',
            'in_list'         => 'Seleccione un turno válido',
        ],
        'sexo' => [
            'required'        => 'El sexo es obligatorio',
            'in_list'         => 'Seleccione un sexo válido',
        ],
        'direccion_nac' => [
            'min_length'      => 'La dirección de nacimiento debe tener al menos 5 caracteres',
            'max_length'      => 'La dirección de nacimiento no puede superar los 255 caracteres',
        ],
        'domicilio' => [
            'min_length'      => 'El domicilio debe tener al menos 5 caracteres',
            'max_length'      => 'El domicilio no puede superar los 255 caracteres',
        ],
        'fecha_nac' => [
            'valid_date'      => 'La fecha de nacimiento no es válida',
        ],
        'religion' => [
            'required'        => 'La religión es obligatoria',
            'is_natural_no_zero' => 'Seleccione una religión válida',
        ],
        'estado_civil' => [
            'required'        => 'El estado civil es obligatorio',
            'is_natural_no_zero' => 'Seleccione un estado civil válido',
        ],
    ];
}