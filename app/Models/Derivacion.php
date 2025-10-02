<?php

namespace App\Models;

class Derivacion extends BaseModel
{
    protected $table      = 'derivaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'usuario_id',
        'alumno_id',
        'motivo',
        'urgencia',
        'recibido',
    ];

    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }
}
