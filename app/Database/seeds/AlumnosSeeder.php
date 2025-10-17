<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class AlumnosSeeder extends Seeder
{
    public function run()
    {
        $baseTime = strtotime(date('Y-m-d H:i:00'));

        $data = [
            ['Lucía', 'Ramírez', '84539210', '924156837', 'Av. Los Álamos 123, Lima', '2000-05-12', 'Jr. Las Flores 345, Lima', 'F', '3', 'M', 1, 1, 1],
            ['Carlos', 'Fernández', '73284015', '913284760', 'Calle Puno 456, Arequipa', '1998-09-20', 'Av. Grau 789, Arequipa', 'M', '2', 'T', 2, 3, 2],
            ['María', 'Lopez', '74829310', '987654321', 'Av. Lima 123, Cusco', '1999-01-10', 'Av. Ayacucho 456, Cusco', 'F', '4', 'M', 3, 2, 3],
            ['Andrés', 'Quispe', '70938471', '912345678', 'Jr. Bolívar 789, Piura', '2001-07-05', 'Jr. Piura 321, Piura', 'M', '1', 'T', 4, 4, 4],
            ['Rosa', 'Sánchez', '73829104', '923456789', 'Av. Perú 321, Trujillo', '2000-03-22', 'Jr. Zela 111, Trujillo', 'F', '5', 'M', 5, 5, 1],
            ['Luis', 'Martínez', '78392048', '934567890', 'Av. San Martín 654, Lima', '2002-12-15', 'Av. Universitaria 222, Lima', 'M', '6', 'T', 6, 6, 6],
            ['Diana', 'Pérez', '79482039', '945678901', 'Jr. Arequipa 147, Huancayo', '1997-06-01', 'Av. Central 543, Huancayo', 'F', '2', 'M', 7, 7, 2],
            ['Jorge', 'Ríos', '70394820', '956789012', 'Av. Grau 210, Ica', '1999-11-11', 'Calle Lima 678, Ica', 'M', '3', 'T', 8, 8, 3],
            ['Karen', 'Silva', '73810492', '967890123', 'Jr. Ayacucho 893, Chiclayo', '2000-08-08', 'Jr. Cuzco 321, Chiclayo', 'F', '4', 'M', 1, 9, 4],
            ['Pablo', 'Torres', '78493012', '978901234', 'Av. Larco 444, Lima', '1998-10-25', 'Calle San Juan 890, Lima', 'M', '5', 'T', 2, 10, 5],
            ['Ana', 'Cruz', '74829387', '934561278', 'Jr. Progreso 123, Lima', '1999-09-12', 'Av. Brasil 789, Lima', 'F', '1', 'M', 3, 1, 6],
            ['Miguel', 'Gómez', '78934521', '925648372', 'Av. Abancay 567, Lima', '1997-03-09', 'Jr. La Mar 456, Lima', 'M', '6', 'T', 4, 2, 1],
            ['Fiorella', 'Chávez', '74382910', '912837465', 'Jr. Callao 234, Arequipa', '2001-04-17', 'Calle Misti 123, Arequipa', 'F', '2', 'M', 5, 3, 2],
            ['Héctor', 'Rojas', '79483012', '934837261', 'Av. Benavides 333, Lima', '1998-06-20', 'Jr. Santa Rosa 999, Lima', 'M', '3', 'T', 6, 4, 3],
            ['Juliana', 'Morales', '73928401', '901234567', 'Jr. Junín 556, Huancayo', '2000-01-29', 'Av. Tupac Amaru 456, Huancayo', 'F', '4', 'M', 7, 5, 4],
            ['Ricardo', 'Castro', '73029384', '913245678', 'Av. Grau 101, Lima', '1999-12-12', 'Jr. Iquitos 789, Lima', 'M', '5', 'T', 8, 6, 5],
            ['Camila', 'Vargas', '74920384', '956789321', 'Calle Piura 887, Trujillo', '2002-02-10', 'Av. Huánuco 432, Trujillo', 'F', '6', 'M', 1, 7, 6],
            ['Fernando', 'Salazar', '74829385', '934823765', 'Av. Tacna 234, Cusco', '1998-08-30', 'Calle Manco Cápac 555, Cusco', 'M', '1', 'T', 2, 8, 1],
            ['Natalia', 'Romero', '73920194', '965432178', 'Jr. Lima 332, Piura', '1997-05-19', 'Av. Callao 222, Piura', 'F', '2', 'M', 3, 9, 2],
            ['Óscar', 'Herrera', '73928491', '912345670', 'Av. Bolívar 776, Arequipa', '1999-10-11', 'Jr. Puno 987, Arequipa', 'M', '3', 'T', 4, 10, 3],
            ['Patricia', 'Meza', '74829134', '923456781', 'Av. Lima 543, Chiclayo', '2001-06-06', 'Jr. Amazonas 321, Chiclayo', 'F', '4', 'M', 5, 1, 4],
            ['Sebastián', 'Gallardo', '73829410', '934561239', 'Calle Pisco 333, Ica', '1998-07-03', 'Jr. Junín 432, Ica', 'M', '5', 'T', 6, 2, 5],
            ['Claudia', 'Villanueva', '78493028', '956789054', 'Jr. Cusco 112, Cusco', '2000-11-09', 'Av. La Paz 678, Cusco', 'F', '6', 'M', 7, 3, 6],
            ['Iván', 'Paredes', '73928412', '978901267', 'Av. Grau 222, Trujillo', '1997-09-14', 'Calle San Martín 432, Trujillo', 'M', '1', 'T', 8, 4, 1],
            ['Lorena', 'Campos', '74820384', '945678934', 'Jr. Lima 765, Lima', '1999-12-01', 'Av. Arequipa 111, Lima', 'F', '2', 'M', 1, 5, 2],
            ['Alonso', 'Peña', '73920483', '987654321', 'Jr. Piura 333, Ica', '1998-05-05', 'Av. El Sol 777, Ica', 'M', '3', 'T', 2, 6, 3],
            ['Daniela', 'López', '74920385', '967890452', 'Calle Amazonas 123, Lima', '2000-03-27', 'Av. Universitaria 321, Lima', 'F', '4', 'M', 3, 7, 4],
            ['Esteban', 'Suárez', '74829122', '978901456', 'Av. El Inca 456, Cusco', '1999-08-13', 'Jr. Pachacútec 432, Cusco', 'M', '5', 'T', 4, 8, 5],
            ['Valeria', 'Aguilar', '73928417', '912345987', 'Calle Misti 321, Arequipa', '1998-02-22', 'Av. Salaverry 555, Arequipa', 'F', '6', 'M', 5, 9, 6],
            ['Diego', 'Ortiz', '73920485', '934561223', 'Jr. Ica 432, Piura', '1997-10-10', 'Av. Sucre 123, Piura', 'M', '1', 'T', 6, 10, 1],
        ];

        $rows = [];
        foreach ($data as $i => $alumno) {
            $rows[] = [
                'nombres'             => $alumno[0],
                'apellidos'           => $alumno[1],
                'dni'                 => $alumno[2],
                'telefono'            => $alumno[3],
                'direccion_nac'       => $alumno[4],
                'fecha_nac'           => $alumno[5],
                'domicilio'           => $alumno[6],
                'sexo'                => $alumno[7],
                'ciclo'               => $alumno[8],
                'turno'               => $alumno[9],
                'programa_estudio_id' => $alumno[10],
                'religion_id'         => $alumno[11],
                'estado_civil_id'     => $alumno[12],
                'created_at'          => date('Y-m-d H:i:s', $baseTime + ($i + 1)),
                'updated_at'          => null,
                'deleted_at'          => null,
            ];
        }

        $this->db->table('alumnos')->insertBatch($rows);
    }
}