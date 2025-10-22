<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ParentescosSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            ['Padre/Madre'],
            ['Hijo(a)'],
            ['Hermano(a)'],
            ['Abuelo(a)'],
            ['Nieto(a)'],
            ['Tío(a)'],
            ['Sobrino(a)'],
            ['Primo(a)'],
            ['Esposo(a)'],
            ['Padrastro/Madrastra'],
            ['Hijastro(a)'],
            ['Cuñado(a)'],
            ['Suegro(a)'],
            ['Yerno/Nuera'],
            ['Tutor legal'],
            ['Otro'],
        ];

        $rows = [];
        foreach ($data as $i => $parentesco) {
            $rows[] = [
                'nombre'      => $parentesco[0],
                'created_at'  => date('Y-m-d H:i:s', $baseTime + ($i + 1)),
                'updated_at'  => null,
                'deleted_at'  => null,
            ];
        }

        $this->db->table('parentescos')->insertBatch($rows);
    }
}