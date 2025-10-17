<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProgramasEstudiosSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            ['Arquitectura de Plataformas y Servicios de TI'],
            ['Construcción Civil'],
            ['Contabilidad'],
            ['Electricidad Industrial'],
            ['Electrónica Industrial'],
            ['Enfermería Técnica'],
            ['Industrias Alimentarias'],
            ['Producción Agropecuaria'],
        ];

        $rows = [];
        foreach ($data as $i => $programa) {
            $rows[] = [
                'nombre'      => $programa[0],
                'created_at'  => date('Y-m-d H:i:s', $baseTime + ($i + 1)),
                'updated_at'  => null,
                'deleted_at'  => null,
            ];
        }

        $this->db->table('programas_estudios')->insertBatch($rows);
    }
}
