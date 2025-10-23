<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Add2faFieldsToUsuariosTable extends Migration
{
    public function up()
    {
        $fields = [
            'codigo_2fa' => [
                'type'       => 'VARCHAR',
                'constraint' => '6',
                'null'       => true,
                'after'      => 'estado',
                'comment'    => 'Código temporal para Autenticación de Dos Factores (2FA)'
            ],
            'codigo_2fa_expira' => [
                'type'       => 'DATETIME',
                'null'       => true,
                'after'      => 'codigo_2fa',
                'comment'    => 'Marca de tiempo en la que expira el código 2FA'
            ],
        ];

        $this->forge->addColumn('usuarios', $fields);

        log_message('info', 'Migración Add2faFieldsToUsuariosTable aplicada exitosamente (UP)');
    }

    public function down()
    {
        $this->forge->dropColumn('usuarios', ['codigo_2fa', 'codigo_2fa_expira']);
        log_message('info', 'Migración Add2faFieldsToUsuariosTable revertida exitosamente (DOWN)');
    }
}
