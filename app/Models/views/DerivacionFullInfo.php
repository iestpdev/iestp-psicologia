<?php

namespace App\Models\Views;

use App\Models\BaseModel;

class DerivacionFullInfo extends BaseModel
{
    protected $table      = 'view_derivaciones_full_info';
    protected $primaryKey = 'id';

    protected array $visibleFields = [
        'id',
        'motivo',
        'urgencia',
        'estado',
        'created_at',
        'updated_at',
        'deleted_at',

        // Información del alumno
        'alumno_id',
        'alumno_nombres_completos',
        'alumno_dni',

        // Información del usuario
        'usuario_id',
        'usuario_correo',

        // Información del docente
        'persona_id',
        'docente_nombres_completos',
        'docente_dni'
    ];

    protected array $searchableFields = [
        'alumno_nombres_completos',
        'alumno_dni',
        'docente_nombres_completos',
        'docente_dni'
    ];
}
