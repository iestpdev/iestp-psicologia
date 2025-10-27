<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddEmailToAlumnos extends Migration
{
    public function up()
    {
        $fields = [
            'email' => [
                'type'       => 'VARCHAR',
                'constraint' => 120,
                'null'       => false,
                'after'      => 'dni',
            ],
        ];

        $this->forge->addColumn('alumnos', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('alumnos', 'email');
    }
}