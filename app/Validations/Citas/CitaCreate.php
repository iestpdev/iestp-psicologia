<?php

namespace App\Validations\Citas;

class CitaCreate
{
    public array $rules = [
        'usuario_id' => 'required',
        'fecha_atencion' => 'required|valid_date[Y-m-d]',
        'hora_inicio' => 'required|regex_match[/^([01]\d|2[0-3]):([0-5]\d)$/]|check_appointment_overlap[hora_inicio]',
        'hora_fin' => 'required|regex_match[/^([01]\d|2[0-3]):([0-5]\d)$/]|check_time_range[hora_inicio]',
        'asistencia' => 'required|in_list[PENDIENTE,ASISTIDO]',
        'motivo' => 'trim|required|min_length[10]|max_length[500]',
    ];

    public array $errors = [
        'usuario_id' => [
            'required' => 'El usuario psicologo/a es requerido',
        ],
        'fecha_atencion' => [
            'required' => 'Debe seleccionar una fecha de atención.',
            'valid_date' => 'La fecha de atención no tiene un formato válido (AAAA-MM-DD).',
        ],
        'hora_inicio' => [
            'required' => 'Debe ingresar la hora de inicio.',
            'regex_match' => 'La hora de inicio debe tener el formato HH:MM.',
            'check_appointment_overlap' => 'El horario seleccionado se cruza con las fechas de citas existentes.'
        ],
        'hora_fin' => [
            'required' => 'Debe ingresar la hora de fin.',
            'regex_match' => 'La hora de fin debe tener el formato HH:MM.',
            'check_time_range' => 'La hora de fin debe ser posterior a la hora de inicio.',
        ],
        'asistencia' => [
            'required' => 'Debe seleccionar un estado de asistencia.',
            'in_list' => 'El valor de asistencia no es válido.',
        ],
        'motivo' => [
            'required' => 'Debe ingresar el motivo de la cita.',
            'min_length' => 'El motivo debe tener al menos 10 caracteres.',
            'max_length' => 'El motivo no puede superar los 500 caracteres.',
        ],
    ];
}
