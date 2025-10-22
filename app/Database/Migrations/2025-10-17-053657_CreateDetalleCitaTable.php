<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDetalleCitaTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'cita_id' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            'problema' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'recomendacion' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'aspecto_fisico' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'aseo_personal' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
            'conducta' => [
                'type'       => 'TEXT',
                'null'       => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('cita_id', 'citas', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('detalle_cita');
    }

    public function down()
    {
        $this->forge->dropTable('detalle_cita');
    }
}