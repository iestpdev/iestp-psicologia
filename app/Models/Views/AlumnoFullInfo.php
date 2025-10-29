<?php

namespace App\Models\Views;

use App\Models\BaseModel;

class AlumnoFullInfo extends BaseModel
{
    protected $table      = 'view_alumnos_full_info';
    protected $primaryKey = 'id';

    protected array $visibleFields = [
        'id',
        'dni',
        'email',
        'alumno_nombres_completos',
        'ciclo',
        'turno',
        'created_at',
        'updated_at',
        'deleted_at',

        'programa_estudio_id',
        'programa_estudio',

        'religion_id',
        'religion',

        'estado_civil_id',
        'estado_civil',
    ];

    protected array $searchableFields = [
        'alumno_nombres_completos',
        'dni',
    ];
}
