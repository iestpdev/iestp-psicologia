<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DetalleCitaSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            [11, 'Estrés por exámenes', 'Practicar técnicas de respiración', 'Ligeramente demacrado', 'Adecuado', 'Tranquilo'],
            [12, 'Uso excesivo del celular', 'Reducir tiempo en redes sociales', null, null, 'Distraído'],
            [13, 'Conflictos en casa', 'Buscar espacios de diálogo', null, 'Descuidado', null],
            [14, 'Falta de hábitos de estudio', 'Implementar un plan de estudios', 'Postura encorvada', null, 'Respetuoso'],
            [15, 'Posible depresión leve', 'Derivación a psicólogo clínico', null, null, 'Reservado'],
            [16, null, 'Participar en actividades grupales', null, 'Aseo adecuado', 'Introvertido'],
            [17, 'Baja autoestima', 'Ejercicios de autovaloración', 'Aspecto normal', null, null],
            [18, null, 'Establecer metas pequeñas', null, null, 'Pasivo'],
            [19, 'Insomnio recurrente', 'Rutina de descanso antes de dormir', 'Ojeroso', null, 'Cooperativo'],
            [20, 'Problemas con compañeros', 'Promover comunicación asertiva', null, 'Aseo adecuado', 'Agresivo'],
        ];

        $rows = [];
        foreach ($data as $i => $detalle) {
            $rows[] = [
                'cita_id'        => $detalle[0],
                'problema'       => $detalle[1],
                'recomendacion'  => $detalle[2],
                'aspecto_fisico' => $detalle[3],
                'aseo_personal'  => $detalle[4],
                'conducta'       => $detalle[5],
            ];
        }

        $this->db->table('detalle_cita')->insertBatch($rows);
    }
}
