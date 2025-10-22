<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReligionesSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            ['Catolicismo'],
            ['Cristianismo Evangélico'],
            ['Islam'],
            ['Judaísmo'],
            ['Hinduismo'],
            ['Budismo'],
            ['Ateísmo'],
            ['Agnosticismo'],
            ['Testigos de Jehová'],
            ['Otra'],
        ];

        $rows = [];
        foreach ($data as $i => $religion) {
            $rows[] = [
                'nombre'      => $religion[0],
                'created_at'  => date('Y-m-d H:i:s', $baseTime + ($i + 1)),
                'updated_at'  => null,
                'deleted_at'  => null,
            ];
        }

        $this->db->table('religiones')->insertBatch($rows);
    }
}