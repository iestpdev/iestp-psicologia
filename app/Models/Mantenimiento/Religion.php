<?php

namespace App\Models\Mantenimiento;

use App\Models\BaseModel;

class Religion extends BaseModel
{
    protected $table = 'religiones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
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

    public function obtenerPorNombre(string $nombre): ?int
    {
        $nombreLimpio = trim($nombre);

        $resultado = $this->select('id')
            ->where('nombre', $nombreLimpio)
            ->first();

        return $resultado ? (int) $resultado['id'] : null;
    }
}