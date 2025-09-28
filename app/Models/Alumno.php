<?php

namespace App\Models;

class Alumno extends BaseModel
{
    protected $table      = 'alumnos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
        'direccion_nac',
        'fecha_nac',
        'domicilio',
        'sexo',
        'ciclo',
        'turno',
        'programa_estudio_id',
        'religion_id',
        'estado_civil_id',
    ];
}