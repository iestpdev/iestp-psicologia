<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UsuariosSeeder extends Seeder
{
    public function run()
    {
        $PASSWORD_HASH = '$2y$10$Uq9O19j3wGY0dS6fU6gC0u/8K7aWZCkFYHAcJIkAMhafqWpOSBdO.'; // Holaquehace123*

        $data = [
            // ADMINISTRADORES
            ['carlos.ramirez@iestpchincha.edu.pe', 'carlosr', $PASSWORD_HASH, 1, 'ADMIN', '2025-09-27 08:00:00'],
            ['ana.torres@iestpchincha.edu.pe', 'anatorres', $PASSWORD_HASH, 2, 'ADMIN', '2025-09-27 09:00:00'],
            ['luis.fernandez@iestpchincha.edu.pe', 'luisf', $PASSWORD_HASH, 3, 'ADMIN', '2025-09-27 10:00:00'],
            ['maria.gomez@iestpchincha.edu.pe', 'mariag', $PASSWORD_HASH, 4, 'ADMIN', '2025-09-27 11:00:00'],
            ['jorge.sanchez@iestpchincha.edu.pe', 'jorges', $PASSWORD_HASH, 5, 'ADMIN', '2025-09-27 12:00:00'],

            // PSICÓLOGOS
            ['carmen.valdez@iestpchincha.edu.pe', 'cvaldez', $PASSWORD_HASH, 6, 'PSICOLOGO', '2025-09-27 13:00:00'],
            ['ricardo.mendoza@iestpchincha.edu.pe', 'rmendoza', $PASSWORD_HASH, 7, 'PSICOLOGO', '2025-09-27 14:00:00'],
            ['elena.morales@iestpchincha.edu.pe', 'emorales', $PASSWORD_HASH, 8, 'PSICOLOGO', '2025-09-27 15:00:00'],
            ['gabriel.chavez@iestpchincha.edu.pe', 'gchavez', $PASSWORD_HASH, 9, 'PSICOLOGO', '2025-09-27 16:00:00'],
            ['patricia.cruz@iestpchincha.edu.pe', 'pcruz', $PASSWORD_HASH, 10, 'PSICOLOGO', '2025-09-27 17:00:00'],

            // DOCENTES
            ['oscar.huaman@iestpchincha.edu.pe', 'ohuaman', $PASSWORD_HASH, 11, 'DOCENTE', '2025-09-27 18:00:00'],
            ['rosa.carrillo@iestpchincha.edu.pe', 'rcarrillo', $PASSWORD_HASH, 12, 'DOCENTE', '2025-09-27 19:00:00'],
            ['pedro.lopez@iestpchincha.edu.pe', 'plopez', $PASSWORD_HASH, 13, 'DOCENTE', '2025-09-27 20:00:00'],
            ['lucia.salazar@iestpchincha.edu.pe', 'lsalazar', $PASSWORD_HASH, 14, 'DOCENTE', '2025-09-27 21:00:00'],
            ['diego.reyes@iestpchincha.edu.pe', 'dreyes', $PASSWORD_HASH, 15, 'DOCENTE', '2025-09-27 22:00:00'],
        ];

        $rows = [];
        foreach ($data as $usuario) {
            $rows[] = [
                'correo_institucional' => $usuario[0],
                'username'             => $usuario[1],
                'userpass'             => $usuario[2],
                'persona_id'           => $usuario[3],
                'rol'                  => $usuario[4],
                'estado'               => true,
                'created_at'           => $usuario[5],
                'updated_at'           => null,
                'deleted_at'           => null,
            ];
        }

        $this->db->table('usuarios')->insertBatch($rows);
    }
}