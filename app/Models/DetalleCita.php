<?php

namespace App\Models;

class DetalleCita extends BaseModel
{
    protected $table      = 'detalle_cita';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'cita_id',
        'problema',
        'recomendacion',
        'aspecto_fisico',
        'aseo_personal',
        'conducta',
    ];
}