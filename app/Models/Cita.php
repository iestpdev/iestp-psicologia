<?php

namespace App\Models;

class Cita extends BaseModel
{
    protected $table      = 'citas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tipo_derivacion',
        'atencion_fech',
        'hora_inicio',
        'hora_fin',
        'asistencia',
        'psicologo_id',
        'alumno_id',
        'derivacion_id',
        'familiar_id',
        'motivo'
    ];
}