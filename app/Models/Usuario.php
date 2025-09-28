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

    protected $columnOrder = [
        'id',
        'correo_institucional',
        'username',
        'rol',
        'created_at',
        'estado'
    ];

    public function getDatatables($start, $length, $searchValue, $orderColumn, $orderDir)
    {
        $builder = $this->db->table($this->table);

        // Seleccionamos los campos
        $builder->select('*');

        // Filtro de búsqueda global
        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('correo_institucional', $searchValue)
                ->orLike('username', $searchValue)
                ->orLike('rol', $searchValue)
                ->groupEnd();
        }

        // Ordenamiento
        if (isset($this->columnOrder[$orderColumn])) {
            $builder->orderBy($this->columnOrder[$orderColumn], $orderDir);
        } else {
            $builder->orderBy('id', 'DESC'); // default
        }

        // Paginación
        if ($length != -1) {
            $builder->limit($length, $start);
        }

        $query = $builder->get();
        return $query->getResultArray();
    }

    public function countAll()
    {
        return $this->db->table($this->table)->countAllResults();
    }

    public function countFiltered($searchValue)
    {
        $builder = $this->db->table($this->table);
        $builder->select('COUNT(*) as total');

        if (!empty($searchValue)) {
            $builder->groupStart()
                ->like('correo_institucional', $searchValue)
                ->orLike('username', $searchValue)
                ->orLike('rol', $searchValue)
                ->groupEnd();
        }

        return $builder->get()->getRow()->total;
    }


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
