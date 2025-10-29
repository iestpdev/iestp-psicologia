<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CrearEventoMarcarCitasAusentes extends Migration
{
    public function up()
    {
        $this->db->query('DROP EVENT IF EXISTS marcar_citas_ausentes;');

        $sql = "
            CREATE EVENT marcar_citas_ausentes
            ON SCHEDULE EVERY 1 DAY
            STARTS TIMESTAMP(CURRENT_DATE, '00:30:00')
            DO
            BEGIN
                UPDATE citas
                SET asistencia = 'AUSENTE',
                    updated_at = NOW()
                WHERE asistencia = 'PENDIENTE'
                  AND deleted_at IS NULL
                  AND atencion_fech < CURDATE();
            END
        ";

        $this->db->query($sql);
    }

    public function down()
    {
        $this->db->query('DROP EVENT IF EXISTS marcar_citas_ausentes;');
    }
}