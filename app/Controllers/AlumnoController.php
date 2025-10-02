<?php

namespace App\Controllers;

use App\Models\Alumno;
use App\Models\Mantenimiento\EstadoCivil;
use App\Models\Mantenimiento\ProgramaEstudio;
use App\Models\Mantenimiento\Religion;

class AlumnoController extends BaseController
{
    public function index(): string
    {
        return view('modules/alumnos/index');
    }

    public function crear(): string
    {
        $programaEstudioModel = new ProgramaEstudio();
        $data['programas_estudios'] = $programaEstudioModel->listar();

        $religionModel = new Religion();
        $data['religiones'] = $religionModel->listar();

        $estadoCivilModel = new EstadoCivil();
        $data['estados_civiles'] = $estadoCivilModel->listar();

        return view('modules/alumnos/crear', $data);
    }

    public function editar($usuarioId): string
    {
        return view('modules/alumnos/editar');
    }

    public function saveAlumno()
    {
        helper('validation');
        $errors = runValidation('alumno_create', $this->request);
        if (!empty($errors)) return redirect()->to('/alumnos/crear')->withInput()->with('errors', $errors);

        try {
            $alumnoModel = new Alumno();
            $alumnoId = $alumnoModel->crear([
                'dni'                   => $this->request->getPost('dni'),
                'nombres'               => $this->request->getPost('nombres'),
                'apellidos'             => $this->request->getPost('apellidos'),
                'programa_estudio_id'   => $this->request->getPost('programa_estudio'),
                'ciclo'                 => $this->request->getPost('ciclo'),
                'turno'                 => $this->request->getPost('turno'),
                'telefono'              => $this->request->getPost('telefono'),
                'domicilio'             => $this->request->getPost('domicilio'),
                'sexo'                  => $this->request->getPost('sexo'),
                'direccion_nac'         => $this->request->getPost('direccion_nac'),
                'fecha_nac'             => $this->request->getPost('fecha_nac'),
                'religion_id'           => $this->request->getPost('religion'),
                'estado_civil_id'       => $this->request->getPost('estado_civil'),
            ]);
            if (!$alumnoId) throw new \Exception("Error al crear Alumno");
            return redirect()->to('/alumnos')->with('success', 'Alumno registrado con éxito');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function obtenerAlumnos()
    {
        $dni = $this->request->getGet('dni');
        $programa_estudio_id = $this->request->getGet('programa_estudio_id');
        $ciclo = $this->request->getGet('ciclo');
        $turno = $this->request->getGet('turno');

        $alumnoModel = new Alumno();
        $alumnos = $alumnoModel->obtenerAlumnos($dni, $programa_estudio_id, $ciclo, $turno);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $alumnos
        ]);
    }
}
