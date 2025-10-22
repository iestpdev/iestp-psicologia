<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateFamiliaresTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'alumno_id' => [
                'type' => 'BIGINT',
                'unsigned' => true,
                'null' => false,
            ],
            'pariente_id' => [
                'type' => 'BIGINT',
                'null' => false,
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
        $this->forge->addForeignKey('alumno_id', 'alumnos', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('pariente_id', 'parientes', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('familiares');
    }

    public function down()
    {
        $this->forge->dropTable('familiares');
    }
}
