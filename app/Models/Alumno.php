<?php

namespace App\Models;

class Alumno extends BaseModel
{
    protected $table = 'alumnos';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'nombres',
        'apellidos',
        'dni',
        'telefono',
        'direccion_nac',
        'fecha_nac',
        'domicilio',
        'sexo',
        'ciclo',
        'turno',
        'programa_estudio_id',
        'religion_id',
        'estado_civil_id',
    ];

    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }

    public function obtenerAlumnos(
        ?string $dni = null,
        ?int $programa_estudio_id = null,
        ?int $ciclo = null,
        ?string $turno = null
    ): array {
        $builder = $this->db->table($this->table);

        if (!empty($dni))
            $builder->where('dni', $dni);
        if (!empty($programa_estudio_id))
            $builder->where('programa_estudio_id', $programa_estudio_id);
        if (!empty($ciclo))
            $builder->where('ciclo', $ciclo);
        if (!empty($turno))
            $builder->where('turno', $turno);

        $builder->select('
            id, 
            CONCAT(nombres, " ", apellidos) AS alumno_nombres_completos, 
            dni, 
            programa_estudio_id, 
            ciclo, 
            turno'
        );

        return $builder->get()->getResultArray();
    }
}
