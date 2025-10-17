<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DerivacionesSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            [11, 1, 'Dificultades de concentración en clases', 'BAJA', false],
            [11, 2, 'Ansiedad por evaluaciones frecuentes', 'MEDIA', true],
            [12, 3, 'Problemas de conducta en el aula', 'ALTA', false],
            [13, 4, 'Falta de motivación para continuar estudios', 'BAJA', false],
            [14, 5, 'Conflictos con compañeros de clase', 'MEDIA', true],
            [15, 6, 'Se observa aislamiento social', 'ALTA', false],
            [11, 7, 'Dificultades para adaptarse al nuevo entorno académico', 'BAJA', true],
            [11, 8, 'Expresiones de estrés y cansancio frecuente', 'MEDIA', false],
            [12, 9, 'Posible depresión detectada por docente', 'ALTA', true],
            [13, 10, 'Problemas familiares que afectan su desempeño', 'BAJA', false],
            [14, 11, 'Falta de asistencia recurrente sin justificación', 'MEDIA', true],
            [15, 12, 'Bajo rendimiento académico sostenido', 'ALTA', false],
            [11, 13, 'Se observa agresividad hacia compañeros', 'BAJA', true],
            [11, 14, 'Alumno con dificultades de integración en grupo', 'MEDIA', false],
            [12, 15, 'Episodios de ansiedad en presentaciones orales', 'ALTA', true],
            [13, 16, 'Dificultad para expresar emociones', 'BAJA', false],
            [14, 17, 'Alumno manifiesta problemas de autoestima', 'MEDIA', true],
            [15, 18, 'Reportes de insomnio y fatiga constante', 'ALTA', false],
            [11, 19, 'Conflictos con docentes en clase', 'BAJA', true],
            [11, 20, 'Se percibe desinterés generalizado', 'MEDIA', false],
            [12, 21, 'Alumno con antecedentes de problemas psicológicos', 'ALTA', true],
            [13, 22, 'Necesita apoyo para manejo de frustración', 'BAJA', false],
            [14, 23, 'Alumno refiere problemas económicos que afectan su ánimo', 'MEDIA', true],
            [15, 24, 'Se detectan signos de estrés académico', 'ALTA', false],
            [11, 25, 'Alumno presenta pensamientos negativos recurrentes', 'BAJA', true],
            [11, 26, 'Conductas disruptivas dentro del salón', 'MEDIA', false],
            [12, 27, 'Solicita acompañamiento psicológico voluntariamente', 'ALTA', true],
            [13, 28, 'Dificultad para relacionarse con figuras de autoridad', 'BAJA', false],
            [14, 29, 'Alumno manifiesta tristeza constante', 'MEDIA', true],
            [15, 30, 'Se recomienda derivación por problemas de adicciones', 'ALTA', false],
        ];

        $rows = [];
        foreach ($data as $i => $derivacion) {
            $rows[] = [
                'usuario_id'  => $derivacion[0],
                'alumno_id'   => $derivacion[1],
                'motivo'      => $derivacion[2],
                'urgencia'    => $derivacion[3],
                'recibido'    => $derivacion[4],
                'created_at'  => date('Y-m-d H:i:s', $baseTime + ($i + 1)),
                'updated_at'  => null,
                'deleted_at'  => null,
            ];
        }

        $this->db->table('derivaciones')->insertBatch($rows);
    }
}