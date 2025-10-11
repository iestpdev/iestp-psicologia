<?php

namespace App\Validations\Derivaciones;

class DerivacionCreate
{
    public array $rules = [
        'docente' => 'required|is_natural_no_zero',
        'alumno'  => 'required|is_natural_no_zero',
        'motivo'  => 'required|min_length[10]|max_length[500]',
        'urgencia' => 'required|in_list[BAJA,MEDIA,ALTA]',
    ];

    public array $errors = [
        'docente' => [
            'required' => 'Debe seleccionar un docente',
            'is_natural_no_zero' => 'El docente seleccionado no es válido',
        ],
        'alumno' => [
            'required' => 'Debe seleccionar un alumno',
            'is_natural_no_zero' => 'El alumno seleccionado no es válido',
        ],
        'motivo' => [
            'required' => 'Debe ingresar el motivo de la derivación',
            'min_length' => 'El motivo debe tener al menos 10 caracteres',
            'max_length' => 'El motivo no puede superar los 500 caracteres',
        ],
        'urgencia' => [
            'required' => 'Debe seleccionar un nivel de urgencia',
            'in_list' => 'La urgencia seleccionada no es válida',
        ],
    ];
}
