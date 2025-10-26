<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ConfiguracionesSeeder extends Seeder
{
    public function run()
    {
        $data = [];

        for ($i = 1; $i <= 15; $i++) { // cantidad de usuarios existentes
            $data[] = [
                'usuario_id'  => $i,
                'auth_email'  => false,
                'notif_email' => false,
                'created_at'  => date('Y-m-d H:i:s'),
                'updated_at'  => null,
                'deleted_at'  => null,
            ];
        }

        // Dante Admin
        $data[] = [
            'usuario_id'  => 16,
            'auth_email'  => true,
            'notif_email' => false,
            'created_at'  => date('Y-m-d H:i:s'),
            'updated_at'  => null,
            'deleted_at'  => null,
        ];

        $this->db->table('configuraciones')->insertBatch($data);
    }
}