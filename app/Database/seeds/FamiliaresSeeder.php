<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FamiliaresSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            [1, 1],
            [2, 3],
            [3, 5],
            [4, 2],
            [5, 4],
            [6, 6],
            [7, 7],
            [8, 8],
            [9, 9],
            [10, 10],
            [11, 1],
            [12, 2],
            [13, 3],
            [14, 4],
            [15, 5],
            [16, 6],
            [17, 7],
            [18, 8],
            [19, 9],
            [20, 10],
            [21, 1],
            [22, 2],
            [23, 3],
            [24, 4],
            [25, 5],
            [26, 6],
            [27, 7],
            [28, 8],
            [29, 9],
            [30, 10],
        ];

        $rows = [];
        foreach ($data as $i => $familiar) {
            $rows[] = [
                'alumno_id' => $familiar[0],
                'pariente_id' => $familiar[1],
                'created_at' => date('Y-m-d H:i:s', $baseTime + ($i + 1)),
                'updated_at' => null,
                'deleted_at' => null,
            ];
        }

        $this->db->table('familiares')->insertBatch($rows);
    }
}