<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'correo_institucional' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'null'       => false,
            ],
            'username' => [
                'type'       => 'VARCHAR',
                'constraint' => 18,
                'null'       => false,
            ],
            'userpass' => [
                'type' => 'TEXT',
                'null' => false,
            ],
            'persona_id' => [
                'type' => 'BIGINT',
                'null' => false,
            ],
            'rol' => [
                'type'       => 'ENUM',
                'constraint' => ['ADMIN', 'PSICOLOGO', 'DOCENTE'],
                'null'       => false,
            ],
            'estado' => [
                'type'       => 'BOOLEAN',
                'default'    => true,
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
        $this->forge->addForeignKey('persona_id', 'personas', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('usuarios');
    }
}
