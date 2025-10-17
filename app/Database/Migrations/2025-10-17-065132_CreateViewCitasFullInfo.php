<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateViewCitasFullInfo extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE OR REPLACE VIEW view_citas_full_info AS
            SELECT
                c.id,
                c.tipo_derivacion,
                c.atencion_fech,
                c.hora_inicio,
                c.hora_fin,
                c.asistencia,
                c.motivo,

                c.usuario_id,
                CONCAT(p.nombres, ' ', p.apellidos) AS usuario_nombres_completos,
                p.dni AS usuario_dni,
                u.rol AS usuario_rol,

                c.alumno_id,
                CONCAT(a.nombres, ' ', a.apellidos) AS alumno_nombres_completos,
                a.dni AS alumno_dni,

                d.id AS detalle_id,
                d.problema,
                d.recomendacion,
                d.aspecto_fisico,
                d.aseo_personal,
                d.conducta,

                c.derivacion_id,
                c.familiar_id,

                c.created_at,
                c.updated_at,
                c.deleted_at
            FROM citas c
            LEFT JOIN usuarios u ON u.id = c.usuario_id
            LEFT JOIN personas p ON p.id = u.persona_id
            LEFT JOIN alumnos a ON a.id = c.alumno_id
            LEFT JOIN detalle_cita d ON d.cita_id = c.id;
        ");
    }

    public function down()
    {
        $this->db->query("DROP VIEW IF EXISTS view_citas_full_info;");
    }
}