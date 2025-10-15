<?php

namespace App\Models;

class Pariente extends BaseModel
{
    protected $table = 'parientes';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
        'parentesco_id',
    ];

    public function obtenerPorId($id){
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
}