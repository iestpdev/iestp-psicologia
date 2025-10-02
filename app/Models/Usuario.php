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
        'persona_id',
        'rol',
        'estado',
    ];

    public function obtenerPorUsername($username)
    {
        return $this->where('username', $username)->first();
    }

    public function getById(int $id)
    {
        return $this->find($id);
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

    public function obtenerDocentes(?string $dni = null): array
    {
        $builder = $this->db->table($this->table . ' u')
            ->select("
            p.id AS persona_id,
            CONCAT(p.nombres, ' ', p.apellidos) AS persona_nombres_completos,
            p.dni,
            u.id,
            u.rol,
            u.created_at,
            u.updated_at,
            u.deleted_at
        ")
            ->join('personas p', 'u.persona_id = p.id', 'left')
            ->where('u.rol', 'DOCENTE');

        if (!empty($dni)) {
            $builder->where('p.dni', $dni);
        }

        return $builder->get()->getResultArray();
    }
}
