<?php

namespace App\Models;

class Familiar extends BaseModel
{
    protected $table = 'familiares';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'alumno_id',
        'pariente_id',
    ];
    public function eliminar(int $id): bool
    {
        return $this->delete($id);
    }

    public function listarPorAlumnoId(int $alumnoId): array
    {
        $builder = $this->db->table($this->table . ' f')
            ->select("
            f.*,
            p.nombres AS pariente_nombres,
            p.apellidos AS pariente_apellidos,
            p.dni AS pariente_dni,
            p.telefono AS pariente_telefono,
            pa.nombre AS pariente_parentesco,
            CONCAT(p.nombres, ' ', p.apellidos, ' - ', pa.nombre) AS info_pariente
        ")
            ->join('parientes p', 'p.id = f.pariente_id', 'left')
            ->join('parentescos pa', 'pa.id = p.parentesco_id', 'left')
            ->where('f.alumno_id', $alumnoId)
            ->where('f.deleted_at', null)
            ->where('p.deleted_at', null)
            ->orderBy('p.nombres', 'ASC');

        return $builder->get()->getResultArray();
    }

    public function obtenerPorId(int $familiarId): ?array
    {
        $builder = $this->db->table($this->table . ' f')
            ->select("
            f.*,
            p.nombres AS pariente_nombres,
            p.apellidos AS pariente_apellidos,
            p.dni AS pariente_dni,
            p.telefono AS pariente_telefono,
            pa.nombre AS pariente_parentesco
        ")
            ->join('parientes p', 'p.id = f.pariente_id', 'left')
            ->join('parentescos pa', 'pa.id = p.parentesco_id', 'left')
            ->where('f.id', $familiarId)
            ->where('f.deleted_at', null)
            ->where('p.deleted_at', null);

        return $builder->get()->getRowArray();
    }


    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }
}
