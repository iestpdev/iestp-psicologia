<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateViewAlumnosFullInfo extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE OR REPLACE VIEW view_alumnos_full_info AS
            SELECT 
                a.id,
                a.dni,
                a.email,
                CONCAT(a.nombres, ' ', a.apellidos) AS alumno_nombres_completos,
                a.ciclo,
                a.turno,
                a.created_at,
                a.updated_at,
                a.deleted_at,

                pe.id AS programa_estudio_id,
                pe.nombre AS programa_estudio,

                r.id AS religion_id,
                r.nombre AS religion,

                ec.id AS estado_civil_id,
                ec.nombre AS estado_civil
            FROM alumnos AS a
            LEFT JOIN programas_estudios pe ON pe.id = a.programa_estudio_id
            LEFT JOIN religiones r ON r.id = a.religion_id
            LEFT JOIN estados_civiles ec ON ec.id = a.estado_civil_id;
        ");
    }

    public function down()
    {
        $this->db->query("DROP VIEW IF EXISTS view_alumnos_full_info;");
    }
}
