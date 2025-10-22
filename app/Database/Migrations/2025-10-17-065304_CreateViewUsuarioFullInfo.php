<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateViewUsuarioFullInfo extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE OR REPLACE VIEW view_usuario_full_info AS
            SELECT 
                u.id,
                u.correo_institucional,
                u.username,
                u.rol,
                u.estado,
                u.created_at,
                u.updated_at,
                u.deleted_at,

                p.id AS persona_id,
                CONCAT(p.nombres, ' ', p.apellidos) AS persona_nombres_completos,
                p.dni,
                p.telefono
            FROM usuarios u
            LEFT JOIN personas p ON u.persona_id = p.id;
        ");
    }

    public function down()
    {
        $this->db->query("DROP VIEW IF EXISTS view_usuario_full_info;");
    }
}