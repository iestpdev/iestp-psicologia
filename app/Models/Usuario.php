<?php

namespace App\Models;

class Usuario extends BaseModel
{
    protected $table      = 'usuarios';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'correo_institucional',
        'username',
        'userpass',
        'docente_id',
        'psicologo_id',
        'rol',
        'estado',
    ];

    public function obtenerPorUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function crear(array $data): int
    {
        $data['userpass'] = password_hash($data['userpass'], PASSWORD_BCRYPT);
        return $this->insert($data, true);
    }

    public function actualizar(int $id, array $data): bool
    {
        if (!empty($data['userpass'])) {
            $data['userpass'] = password_hash($data['userpass'], PASSWORD_BCRYPT);
        } else {
            unset($data['userpass']);
        }

        return $this->update($id, $data);
    }

    public function eliminar(int $id): bool
    {
        return $this->delete($id);
    }
}