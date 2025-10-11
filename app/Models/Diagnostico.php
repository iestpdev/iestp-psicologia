<?php

namespace App\Models;

class Diagnostico extends BaseModel
{
    protected $table      = 'diagnosticos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'cita_id',
        'condicion_code',
        'analisis',
    ];
}