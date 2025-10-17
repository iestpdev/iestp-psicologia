<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ParientesSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            ['Carlos', 'Gonzales', '12345678', '987654321', 1],
            ['María', 'Pérez', '87654321', '987123456', 2],
            ['Lucía', 'Ramírez', '23456789', '986543210', 3],
            ['Jorge', 'Fernández', '34567890', '985432109', 4],
            ['Ana', 'Lopez', '45678901', '984321098', 5],
            ['Miguel', 'Torres', '56789012', '983210987', 6],
            ['Sofía', 'Vargas', '67890123', '982109876', 7],
            ['Luis', 'Rojas', '78901234', '981098765', 8],
            ['Carolina', 'Morales', '89012345', '980987654', 9],
            ['Fernando', 'Cruz', '90123456', '979876543', 10],
        ];

        $rows = [];
        foreach ($data as $i => $pariente) {
            $rows[] = [
                'nombres'       => $pariente[0],
                'apellidos'     => $pariente[1],
                'dni'           => $pariente[2],
                'telefono'      => $pariente[3],
                'parentesco_id' => $pariente[4],
                'created_at'    => date('Y-m-d H:i:s', $baseTime + ($i + 1)),
                'updated_at'    => null,
                'deleted_at'    => null,
            ];
        }

        $this->db->table('parientes')->insertBatch($rows);
    }
}