<?php

namespace App\Models;

class Derivacion extends BaseModel
{
    protected $table      = 'derivaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'docente_id',
        'alumno_id',
        'motivo',
        'urgencia',
        'recibido',
    ];
}