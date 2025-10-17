<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CitasSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            // Pendientes
            ['AUTONOMO','2024-11-01','08:00:00','09:00:00','PENDIENTE',6,1,null,null,'Consulta inicial por estrés académico'],
            ['AUTONOMO','2024-11-02','09:00:00','10:00:00','PENDIENTE',7,2,null,null,'Revisión de estado emocional'],
            ['AUTONOMO','2024-11-03','10:00:00','11:00:00','PENDIENTE',8,3,null,null,'Dificultad para concentrarse'],
            ['AUTONOMO','2024-11-04','11:00:00','12:00:00','PENDIENTE',9,4,null,null,'Problemas de convivencia'],
            ['AUTONOMO','2024-11-05','14:00:00','15:00:00','PENDIENTE',10,5,null,null,'Orientación por bajo rendimiento'],
            ['AUTONOMO','2024-11-06','15:00:00','16:00:00','PENDIENTE',6,6,null,null,'Asesoría por ansiedad leve'],
            ['AUTONOMO','2024-11-07','16:00:00','17:00:00','PENDIENTE',7,7,null,null,'Control emocional ante evaluaciones'],
            ['AUTONOMO','2024-11-08','08:30:00','09:30:00','PENDIENTE',8,8,null,null,'Orientación vocacional inicial'],
            ['AUTONOMO','2024-11-09','09:30:00','10:30:00','PENDIENTE',9,9,null,null,'Apoyo psicológico por estrés'],
            ['AUTONOMO','2024-11-10','10:30:00','11:30:00','PENDIENTE',10,10,null,null,'Dificultades para socializar'],

            // Asistidos
            ['AUTONOMO','2024-11-11','08:00:00','09:00:00','ASISTIDO',6,11,null,null,'Seguimiento de caso emocional'],
            ['AUTONOMO','2024-11-12','09:00:00','10:00:00','ASISTIDO',7,12,null,null,'Terapia breve por ansiedad'],
            ['AUTONOMO','2024-11-13','10:00:00','11:00:00','ASISTIDO',8,13,null,null,'Consulta por autoestima baja'],
            ['AUTONOMO','2024-11-14','11:00:00','12:00:00','ASISTIDO',9,14,null,null,'Acompañamiento académico'],
            ['AUTONOMO','2024-11-15','14:00:00','15:00:00','ASISTIDO',10,15,null,null,'Sesión de control emocional'],
            ['AUTONOMO','2024-11-16','15:00:00','16:00:00','ASISTIDO',6,16,null,null,'Evaluación psicológica breve'],
            ['AUTONOMO','2024-11-17','16:00:00','17:00:00','ASISTIDO',7,17,null,null,'Revisión de conducta social'],
            ['AUTONOMO','2024-11-18','08:30:00','09:30:00','ASISTIDO',8,18,null,null,'Terapia motivacional'],
            ['AUTONOMO','2024-11-19','09:30:00','10:30:00','ASISTIDO',9,19,null,null,'Seguimiento de progreso emocional'],
            ['AUTONOMO','2024-11-20','10:30:00','11:30:00','ASISTIDO',10,20,null,null,'Sesión de orientación personal'],

            // Ausentes
            ['AUTONOMO','2024-11-21','08:00:00','09:00:00','AUSENTE',6,21,null,null,'No asistió a control programado'],
            ['AUTONOMO','2024-11-22','09:00:00','10:00:00','AUSENTE',7,22,null,null,'Ausencia en cita de seguimiento'],
            ['AUTONOMO','2024-11-23','10:00:00','11:00:00','AUSENTE',8,23,null,null,'Falta injustificada a terapia'],
            ['AUTONOMO','2024-11-24','11:00:00','12:00:00','AUSENTE',9,24,null,null,'Cita perdida por motivos personales'],
            ['AUTONOMO','2024-11-25','14:00:00','15:00:00','AUSENTE',10,25,null,null,'No acudió a orientación'],
            ['AUTONOMO','2024-11-26','15:00:00','16:00:00','AUSENTE',6,26,null,null,'Falta por olvido de cita'],
            ['AUTONOMO','2024-11-27','16:00:00','17:00:00','AUSENTE',7,27,null,null,'Cita no atendida por el alumno'],
            ['AUTONOMO','2024-11-28','08:30:00','09:30:00','AUSENTE',8,28,null,null,'No llegó al centro psicológico'],
            ['AUTONOMO','2024-11-29','09:30:00','10:30:00','AUSENTE',9,29,null,null,'Falta sin justificación válida'],
            ['AUTONOMO','2024-11-30','10:30:00','11:30:00','AUSENTE',10,30,null,null,'Inasistencia por motivos académicos'],
        ];

        $rows = [];
        foreach ($data as $i => $cita) {
            $rows[] = [
                'tipo_derivacion' => $cita[0],
                'atencion_fech'   => $cita[1],
                'hora_inicio'     => $cita[2],
                'hora_fin'        => $cita[3],
                'asistencia'      => $cita[4],
                'usuario_id'      => $cita[5],
                'alumno_id'       => $cita[6],
                'derivacion_id'   => $cita[7],
                'familiar_id'     => $cita[8],
                'motivo'          => $cita[9],
                'created_at'      => date('Y-m-d H:i:s', $baseTime + ($i + 1)),
                'updated_at'      => null,
                'deleted_at'      => null,
            ];
        }

        $this->db->table('citas')->insertBatch($rows);
    }
}