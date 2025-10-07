<?php

namespace App\Models;

class Familiar extends BaseModel
{
    protected $table      = 'familiares';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'alumno_id',
        'pariente_id',
    ];

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
            ->orderBy('p.nombres', 'ASC');

        return $builder->get()->getResultArray();
    }
}
