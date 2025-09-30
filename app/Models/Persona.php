<?php

namespace App\Models;

class Persona extends BaseModel
{
    protected $table      = 'personas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
    ];

    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }
}
