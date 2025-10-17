<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDerivacionesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'usuario_id' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            'alumno_id' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            'motivo' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'urgencia' => [
                'type'       => 'ENUM',
                'constraint' => ['BAJA', 'MEDIA', 'ALTA'],
                'null'       => false,
            ],
            'recibido' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('alumno_id', 'alumnos', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('derivaciones');
    }

    public function down()
    {
        $this->forge->dropTable('derivaciones');
    }
}