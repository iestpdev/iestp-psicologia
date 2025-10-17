<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCitasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'tipo_derivacion' => [
                'type'       => 'ENUM',
                'constraint' => ['AUTONOMO', 'DOCENTE', 'FAMILIAR'],
                'null'       => false,
            ],
            'atencion_fech' => [
                'type' => 'DATE',
                'null' => false,
            ],
            'hora_inicio' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'hora_fin' => [
                'type' => 'TIME',
                'null' => false,
            ],
            'asistencia' => [
                'type'       => 'ENUM',
                'constraint' => ['PENDIENTE', 'ASISTIDO', 'AUSENTE'],
                'null'       => false,
            ],
            'usuario_id' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            'alumno_id' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            'derivacion_id' => [
                'type' => 'BIGINT',
                'null' => true,
            ],
            'familiar_id' => [
                'type' => 'BIGINT',
                'null' => true,
            ],
            'motivo' => [
                'type'       => 'TEXT',
                'null'       => false,
            ],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
            'deleted_at' => ['type' => 'DATETIME', 'null' => true],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('alumno_id', 'alumnos', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('derivacion_id', 'derivaciones', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('familiar_id', 'familiares', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('citas');
    }

    public function down()
    {
        $this->forge->dropTable('citas');
    }
}