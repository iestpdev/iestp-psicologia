<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EstadosCivilesSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            ['Soltero/a'],
            ['Casado/a'],
            ['Divorciado/a'],
            ['Viudo/a'],
            ['Unión libre'],
            ['Separado/a'],
        ];

        $rows = [];
        foreach ($data as $i => $estado) {
            $rows[] = [
                'nombre' => $estado[0],
                'created_at' => date('Y-m-d H:i:s', $baseTime + ($i + 1)),
                'updated_at' => null,
                'deleted_at' => null,
            ];
        }

        $this->db->table('estados_civiles')->insertBatch($rows);
    }
}
