<?php

namespace App\Models\Views;

use App\Models\BaseModel;

class CitaFullInfo extends BaseModel
{
    protected $table      = 'view_citas_full_info';
    protected $primaryKey = 'id';

    protected array $visibleFields = [
        'id',
        'tipo_derivacion',
        'atencion_fech',
        'hora_inicio',
        'hora_fin',
        'asistencia',
        'usuario_id',
        'usuario_nombres_completos',
        'usuario_dni',
        'usuario_rol',

        'alumno_id',
        'alumno_nombres_completos',
        'alumno_dni',
        'alumno_fecha_nacimiento',
        'alumno_ciclo',
        'alumno_programa_estudio',

        'detalle_id',
        'motivo',
        'problema',
        'recomendacion',
        'aspecto_fisico',
        'aseo_personal',
        'conducta',

        'derivacion_id',
        'familiar_id',

        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected array $searchableFields = [
        'usuario_nombres_completos',
        'usuario_dni',
        'alumno_nombres_completos',
        'alumno_dni',
    ];
}
