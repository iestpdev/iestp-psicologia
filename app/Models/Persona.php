<?php

namespace App\Models;

class Persona extends BaseModel
{
    protected $table = 'personas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
    ];

    public function obtenerPorId($id)
    {
        return $this->where('id', $id)->first();
    }

    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }

    public function actualizar(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    public function eliminar(int $id): bool
    {
        return $this->delete($id);
    }
}
