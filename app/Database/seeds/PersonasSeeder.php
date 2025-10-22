<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class PersonasSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // ADMINISTRADORES
            ['Carlos', 'Ramirez Lopez', '12345678', '987654321', '2025-09-27 08:00:00'],
            ['Ana', 'Torres Vega', '23456789', '912345678', '2025-09-27 09:00:00'],
            ['Luis', 'Fernandez Ruiz', '34567890', '934567890', '2025-09-27 10:00:00'],
            ['Maria', 'Gomez Paredes', '45678901', '956789012', '2025-09-27 11:00:00'],
            ['Jorge', 'Sanchez Diaz', '56789012', '978901234', '2025-09-27 12:00:00'],

            // PSICÓLOGOS
            ['Carmen', 'Valdez Soto', '67890123', '945612378', '2025-09-27 13:00:00'],
            ['Ricardo', 'Mendoza Torres', '78901234', '956123789', '2025-09-27 14:00:00'],
            ['Elena', 'Morales Rivas', '89012345', '967834561', '2025-09-27 15:00:00'],
            ['Gabriel', 'Chavez Flores', '90123456', '978345612', '2025-09-27 16:00:00'],
            ['Patricia', 'Cruz Salas', '01234567', '989456123', '2025-09-27 17:00:00'],

            // DOCENTES
            ['Oscar', 'Huaman Peña', '11223344', '912398765', '2025-09-27 18:00:00'],
            ['Rosa', 'Carrillo Vela', '22334455', '923987651', '2025-09-27 19:00:00'],
            ['Pedro', 'Lopez Medina', '33445566', '934126589', '2025-09-27 20:00:00'],
            ['Lucia', 'Salazar Rojas', '44556677', '945612398', '2025-09-27 21:00:00'],
            ['Diego', 'Reyes Campos', '55667788', '956781234', '2025-09-27 22:00:00'],
        ];

        $rows = [];
        foreach ($data as $persona) {
            $rows[] = [
                'nombres'    => $persona[0],
                'apellidos'  => $persona[1],
                'dni'        => $persona[2],
                'telefono'   => $persona[3],
                'created_at' => $persona[4],
                'updated_at' => $persona[4],
                'deleted_at' => null,
            ];
        }

        $this->db->table('personas')->insertBatch($rows);
    }
}