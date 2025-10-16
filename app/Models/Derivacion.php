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

    public function getById(int $id)
    {
        return $this->find($id);
    }

    public function obtenerPendientes(): array
    {
        $builder = $this->db->table($this->table . ' d')
            ->select("
            d.*,
            CONCAT(a.nombres, ' ', a.apellidos) AS alumno_nombres_completos,
            CONCAT(p.nombres, ' ', p.apellidos) AS docente_nombres_completos,
            CONCAT('DOCENTE: ',p.nombres, ' ', p.apellidos,' -> ALUMNO: ',a.nombres, ' ', a.apellidos,'- URGENCIA: ',d.urgencia) AS data_derivacion
        ")
            ->join('alumnos a', 'a.id = d.alumno_id', 'left')
            ->join('usuarios u', 'u.id = d.usuario_id', 'left')
            ->join('personas p', 'p.id = u.persona_id', 'left')
            ->where('d.recibido', 0)
            ->where('d.deleted_at', null)
            ->orderBy('d.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }
}
