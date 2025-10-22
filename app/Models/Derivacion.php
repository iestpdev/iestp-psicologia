<?php

namespace App\Models;

class Derivacion extends BaseModel
{
    protected $table = 'derivaciones';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'usuario_id',
        'alumno_id',
        'motivo',
        'urgencia',
        'recibido',
    ];

    public function eliminar(int $id): bool
    {
        return $this->delete($id);
    }

    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }

    public function actualizar(int $id, array $data): bool
    {
        return $this->update($id, $data);
    }

    public function marcarComoRecibido(int $id): bool
    {
        return $this->update($id, ['recibido' => 1]);
    }

    public function obtenerPorId(int $id)
    {
        $builder = $this->db->table($this->table . ' d')
            ->select("
                d.id,
                d.motivo,
                d.urgencia,
                d.recibido AS estado,
                d.created_at,
                d.updated_at,
                d.deleted_at,

                a.id AS alumno_id,
                CONCAT(a.nombres, ' ', a.apellidos) AS alumno_nombres_completos,
                a.dni AS alumno_dni,
                pe.nombre as alumno_programa_estudio,

                u.id AS docente_usuario_id,
                u.correo_institucional AS usuario_correo,

                p.id AS docente_persona_id,
                CONCAT(p.nombres, ' ', p.apellidos) AS docente_nombres_completos,
                p.dni AS docente_dni
            ")
            ->join('alumnos a', 'a.id = d.alumno_id', 'left')
            ->join('programas_estudios pe', 'pe.id = a.programa_estudio_id', 'left')
            ->join('usuarios u', 'u.id = d.usuario_id', 'left')
            ->join('personas p', 'p.id = u.persona_id', 'left')
            ->where('d.id', $id)
            ->where('d.deleted_at', null);

        return $builder->get()->getRowArray();
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

    public function obtenerPendientesParaHome(): array
    {
        $builder = $this->db->table($this->table . ' d')
            ->select("
            d.id,
            d.urgencia,
            d.recibido AS estado,
            a.nombres AS alumno_nombres,
            a.apellidos AS alumno_apellidos,
            pe.nombre AS programa_estudio
        ")
            ->join('alumnos a', 'a.id = d.alumno_id', 'left')
            ->join('programas_estudios pe', 'pe.id = a.programa_estudio_id', 'left')
            ->where('d.recibido', 0)
            ->where('d.deleted_at', null)
            ->orderBy('d.urgencia', 'DESC');

        return $builder->get()->getResultArray();
    }
}
