<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Tablas de mantenimiento
        $this->call('EstadosCivilesSeeder');
        $this->call('ProgramasEstudiosSeeder');
        $this->call('ReligionesSeeder');
        $this->call('ParentescosSeeder');

        // Tablas principales
        $this->call('AlumnosSeeder');
        $this->call('ParientesSeeder');
        $this->call('FamiliaresSeeder');
        $this->call('PersonasSeeder');
        $this->call('UsuariosSeeder');
        $this->call('ConfiguracionesSeeder');
        $this->call('DerivacionesSeeder');
        $this->call('CitasSeeder');
        $this->call('DetalleCitaSeeder');
    }
}