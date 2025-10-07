<?php

namespace App\Models\Mantenimiento;

use App\Models\BaseModel;

class ProgramaEstudio extends BaseModel
{
    protected $table            = 'programas_estudios';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'nombre',
    ];

    public function listar(): array
    {
        return $this->orderBy('nombre', 'ASC')->findAll();
    }

    public function obtenerPorId($id)
    {
        return $this->where('id', $id)->first();
    }
}