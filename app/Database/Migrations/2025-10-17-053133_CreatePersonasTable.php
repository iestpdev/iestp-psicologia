<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreatePersonasTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'nombres' => [
                'type'       => 'VARCHAR',
                'constraint' => 70,
                'null'       => false,
            ],
            'apellidos' => [
                'type'       => 'VARCHAR',
                'constraint' => 70,
                'null'       => false,
            ],
            'dni' => [
                'type'       => 'CHAR',
                'constraint' => 8,
                'null'       => false,
            ],
            'telefono' => [
                'type'       => 'VARCHAR',
                'constraint' => 9,
                'null'       => true,
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
        $this->forge->createTable('personas');
    }

    public function down()
    {
        $this->forge->dropTable('personas');
    }
}
