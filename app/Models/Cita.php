<?php

namespace App\Models;

class Cita extends BaseModel
{
    protected $table = 'citas';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'tipo_derivacion',
        'atencion_fech',
        'hora_inicio',
        'hora_fin',
        'asistencia',
        'usuario_id',
        'alumno_id',
        'derivacion_id',
        'familiar_id',
        'motivo'
    ];

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

    public function obtenerPorId($id)
    {
        return $this->where('id', $id)->first();
    }

    public function obtenerPendientes(): array
    {
        $builder = $this->db->table($this->table . ' c')
            ->select("
            c.id,
            c.atencion_fech,
            c.hora_inicio,
            c.hora_fin,
            c.asistencia,
            CONCAT(a.nombres, ' ', a.apellidos) AS alumno_nombres_completos
        ")
            ->join('alumnos a', 'a.id = c.alumno_id', 'left')
            ->where('c.asistencia', 'PENDIENTE')
            ->where('c.deleted_at', null)
            ->orderBy('c.atencion_fech', 'DESC');

        return $builder->get()->getResultArray();
    }

    public function listarPorAlumnoId(int $alumnoId): array
    {
        $builder = $this->db->table($this->table . ' c')
            ->select("
            c.id,
            c.tipo_derivacion,
            c.atencion_fech,
            c.hora_inicio,
            c.hora_fin,
            c.asistencia,
            c.motivo,

            c.usuario_id,
            CONCAT(p.nombres, ' ', p.apellidos) AS usuario_nombres_completos,
            p.dni AS usuario_dni,
            u.rol AS usuario_rol,

            c.created_at,
            c.updated_at
        ")
            ->join('usuarios u', 'u.id = c.usuario_id', 'left')
            ->join('personas p', 'p.id = u.persona_id', 'left')
            ->where('c.alumno_id', $alumnoId)
            ->where('c.deleted_at', null)
            ->orderBy('c.created_at', 'DESC');

        return $builder->get()->getResultArray();
    }


    public function obtenerPorDerivacionId(int $derivacionId): ?array
    {
        return $this->where('derivacion_id', $derivacionId)->first();
    }
}