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
        'email',
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

    public function obtenerPorId(int $id): ?array
    {
        $builder = $this->db->table("{$this->table} AS a");

        $builder->select("
        a.id,
        a.dni,
        a.email,
        CONCAT(a.nombres, ' ', a.apellidos) AS alumno_nombres_completos,
        a.nombres,
        a.apellidos,
        a.telefono,
        a.direccion_nac,
        a.fecha_nac,
        a.domicilio,
        a.sexo,
        a.ciclo,
        a.turno,
        pe.nombre AS programa_estudio,
        r.nombre AS religion,
        ec.nombre AS estado_civil
    ");

        $builder->join('programas_estudios AS pe', 'pe.id = a.programa_estudio_id', 'left');
        $builder->join('religiones AS r', 'r.id = a.religion_id', 'left');
        $builder->join('estados_civiles AS ec', 'ec.id = a.estado_civil_id', 'left');
        $builder->where('a.deleted_at', null);
        $builder->where('a.id', $id);

        $query = $builder->get();
        $result = $query->getRowArray();

        return $result ?: null;
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
            email,
            programa_estudio_id, 
            ciclo, 
            turno'
        );
        $builder->where('deleted_at', null);

        return $builder->get()->getResultArray();
    }
}
