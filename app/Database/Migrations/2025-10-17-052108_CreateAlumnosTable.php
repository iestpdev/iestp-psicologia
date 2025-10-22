<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateAlumnosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'nombres' => [
                'type' => 'VARCHAR',
                'constraint' => 70,
                'null' => false,
            ],
            'apellidos' => [
                'type' => 'VARCHAR',
                'constraint' => 70,
                'null' => false,
            ],
            'dni' => [
                'type' => 'CHAR',
                'constraint' => 8,
                'null' => false,
            ],
            'telefono' => [
                'type' => 'VARCHAR',
                'constraint' => 9,
                'null' => true,
            ],
            'direccion_nac' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'fecha_nac' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'domicilio' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'sexo' => [
                'type' => 'ENUM',
                'constraint' => ['M', 'F'],
                'null' => false,
            ],
            'ciclo' => [
                'type' => 'ENUM',
                'constraint' => ['1', '2', '3', '4', '5', '6'],
                'null' => false,
            ],
            'turno' => [
                'type' => 'ENUM',
                'constraint' => ['M', 'T'],
                'null' => false,
            ],
            'programa_estudio_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => false,
            ],
            'religion_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'estado_civil_id' => [
                'type' => 'INT',
                'unsigned' => true,
                'null' => true,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey('dni');

        // Claves foráneas
        $this->forge->addForeignKey('programa_estudio_id', 'programas_estudios', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('religion_id', 'religiones', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('estado_civil_id', 'estados_civiles', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable('alumnos', true);
    }

    public function down()
    {
        $this->forge->dropTable('alumnos', true);
    }
}
