<?php

namespace App\Models;

class Docente extends BaseModel
{
    protected $table      = 'docentes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
    ];
}