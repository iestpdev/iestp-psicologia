<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateNotificacionesUsuariosTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'BIGINT',
                'auto_increment' => true,
            ],
            'notificacion_id' => [
                'type'       => 'BIGINT',
                'null'       => false,
            ],
            'usuario_id' => [
                'type'       => 'BIGINT',
                'null'       => false,
            ],
            'leido' => [
                'type'    => 'BOOLEAN',
                'default' => false,
            ],
            'fecha_leido' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addUniqueKey(['notificacion_id', 'usuario_id']);
        $this->forge->addForeignKey('notificacion_id', 'notificaciones', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->addForeignKey('usuario_id', 'usuarios', 'id', 'RESTRICT', 'RESTRICT');

        $this->forge->createTable('notificaciones_usuarios');
    }

    public function down()
    {
        $this->forge->dropTable('notificaciones_usuarios', true);
    }
}