<?php

namespace App\Models;

use CodeIgniter\Model;

class DetalleCita extends Model
{
    protected $table = 'detalle_cita';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'cita_id',
        'problema',
        'recomendacion',
        'aspecto_fisico',
        'aseo_personal',
        'conducta',
    ];

    public function crear(array $data): int
    {
        return $this->insert($data, true);
    }

    public function obtenerPorCitaId($citaId){
         return $this->where('cita_id', $citaId)->first();
    }
}