<?php

namespace App\Models;

class Familiar extends BaseModel
{
    protected $table      = 'familiares';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'alumno_id',
        'pariente_id',
    ];
}