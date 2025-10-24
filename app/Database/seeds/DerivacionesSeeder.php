<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DerivacionesSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            [11, 1, 'Dificultades de concentración en clases', 'BAJA'],
            [11, 2, 'Ansiedad por evaluaciones frecuentes', 'MEDIA'],
            [12, 3, 'Problemas de conducta en el aula', 'ALTA'],
            [13, 4, 'Falta de motivación para continuar estudios', 'BAJA'],
            [14, 5, 'Conflictos con compañeros de clase', 'MEDIA'],
            [15, 6, 'Se observa aislamiento social', 'ALTA'],
            [11, 7, 'Dificultades para adaptarse al nuevo entorno académico', 'BAJA'],
            [11, 8, 'Expresiones de estrés y cansancio frecuente', 'MEDIA'],
            [12, 9, 'Posible depresión detectada por docente', 'ALTA'],
            [13, 10, 'Problemas familiares que afectan su desempeño', 'BAJA'],
            [14, 11, 'Falta de asistencia recurrente sin justificación', 'MEDIA'],
            [15, 12, 'Bajo rendimiento académico sostenido', 'ALTA'],
            [11, 13, 'Se observa agresividad hacia compañeros', 'BAJA'],
            [11, 14, 'Alumno con dificultades de integración en grupo', 'MEDIA'],
            [12, 15, 'Episodios de ansiedad en presentaciones orales', 'ALTA'],
            [13, 16, 'Dificultad para expresar emociones', 'BAJA'],
            [14, 17, 'Alumno manifiesta problemas de autoestima', 'MEDIA'],
            [15, 18, 'Reportes de insomnio y fatiga constante', 'ALTA'],
            [11, 19, 'Conflictos con docentes en clase', 'BAJA'],
            [11, 20, 'Se percibe desinterés generalizado', 'MEDIA'],
            [12, 21, 'Alumno con antecedentes de problemas psicológicos', 'ALTA'],
            [13, 22, 'Necesita apoyo para manejo de frustración', 'BAJA'],
            [14, 23, 'Alumno refiere problemas económicos que afectan su ánimo', 'MEDIA'],
            [15, 24, 'Se detectan signos de estrés académico', 'ALTA'],
            [11, 25, 'Alumno presenta pensamientos negativos recurrentes', 'BAJA'],
            [11, 26, 'Conductas disruptivas dentro del salón', 'MEDIA'],
            [12, 27, 'Solicita acompañamiento psicológico voluntariamente', 'ALTA'],
            [13, 28, 'Dificultad para relacionarse con figuras de autoridad', 'BAJA'],
            [14, 29, 'Alumno manifiesta tristeza constante', 'MEDIA'],
            [15, 30, 'Se recomienda derivación por problemas de adicciones', 'ALTA'],
        ];

        $rows = [];
        foreach ($data as $i => $derivacion) {
            $rows[] = [
                'usuario_id'  => $derivacion[0],
                'alumno_id'   => $derivacion[1],
                'motivo'      => $derivacion[2],
                'urgencia'    => $derivacion[3],
                'recibido'    => false,
                'created_at'  => date('Y-m-d H:i:s', $baseTime + ($i + 1)),
                'updated_at'  => null,
                'deleted_at'  => null,
            ];
        }

        $this->db->table('derivaciones')->insertBatch($rows);
    }
}