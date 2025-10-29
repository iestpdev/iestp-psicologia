<?php

namespace App\Validations\Personas;

/**
 * Validación para la actualización de personas.
 *
 * Define las reglas y mensajes de error para los campos:
 * - persona_id: opcional, utilizado para identificar la persona al validar unicidad.
 * - nombres: requerido, entre 2 y 100 caracteres.
 * - apellidos: requerido, entre 2 y 100 caracteres.
 * - dni: requerido, exactamente 8 dígitos, único considerando la persona actual.
 * - telefono: opcional, exactamente 9 dígitos si se proporciona, numérico.
 */
class PersonaUpdate
{
    /**
     * Reglas de validación para los campos de persona al actualizar.
     *
     * @var array
     */
    public array $rules = [
        'persona_id'=> 'permit_empty',
        'nombres'  => 'trim|required|min_length[2]|max_length[100]',
        'apellidos'=> 'trim|required|min_length[2]|max_length[100]',
        'dni'      => 'trim|required|exact_length[8]|numeric|is_unique_soft[personas.dni,id,{persona_id}]',
        'telefono' => 'trim|permit_empty|exact_length[9]|numeric',
    ];

    /**
     * Mensajes personalizados para errores de validación.
     *
     * @var array
     */
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