<?php

namespace App\Models;

class Pariente extends BaseModel
{
    protected $table      = 'parientes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
        'parentesco_id',
    ];
}