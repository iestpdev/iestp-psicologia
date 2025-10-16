<?php

namespace App\Controllers;

use App\Models\Alumno;
use App\Models\Familiar;
use App\Models\Mantenimiento\EstadoCivil;
use App\Models\Mantenimiento\Parentesco;
use App\Models\Mantenimiento\ProgramaEstudio;
use App\Models\Mantenimiento\Religion;

class AlumnoController extends BaseController
{
    public function index(): string
    {
        return view('modules/alumnos/index');
    }

    public function info($alumnoId): string
    {
        $alumnoModel = new Alumno();
        $alumno = $alumnoModel->obtenerPorId($alumnoId);
        if (!$alumno) {
            return view('errors/html/error_404', [
                'message' => 'Alumno no encontrado'
            ]);
        }

        $familiarModel = new Familiar();
        $familiares = $familiarModel->listarPorAlumnoId($alumnoId);

        $parentescoModel = new Parentesco();
        $parentescos = $parentescoModel->listar();

        return view('modules/alumnos/details/index', [
            'alumno' => $alumno,
            'familiares' => $familiares,
            'parentescos' => $parentescos
        ]);
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

    public function editar($alumnoId): string
    {
        $alumnoModel = new Alumno();
        $alumno = $alumnoModel->find($alumnoId);

        if (!$alumno) {
            return view('errors/html/error_404', [
                'message' => 'Alumno no encontrado'
            ]);
        }

        $programaEstudioModel = new ProgramaEstudio();
        $religionModel = new Religion();
        $estadoCivilModel = new EstadoCivil();

        return view('modules/alumnos/editar', [
            'alumno' => $alumno,
            'programas_estudios' => $programaEstudioModel->listar(),
            'religiones' => $religionModel->listar(),
            'estados_civiles' => $estadoCivilModel->listar(),
        ]);
    }

    public function deleteAlumno($id)
    {
        helper('cache');

        $alumnoModel = new Alumno();
        try {
            $alumno = $alumnoModel->obtenerPorId($id);
            if (!$alumno)
                throw new \Exception("Alumno no encontrado");
            if (!$alumnoModel->eliminar($id))
                throw new \Exception("Error al eliminar usuario");

            clear_datatable_cache('AlumnoFullInfo');
            return redirect()->to('/alumnos')->with('success', 'Alumno eliminado correctamente');
        } catch (\Throwable $e) {
            return redirect()->to('/alumnos')->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function saveAlumno()
    {
        helper(['validation', 'input', 'cache']);
        $errors = runValidation('alumno_create', $this->request);
        if (!empty($errors))
            return redirect()->to('/alumnos/crear')->withInput()->with('errors', $errors);

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $alumnoData = normalize_input([
                'dni' => $this->request->getPost('dni'),
                'nombres' => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'programa_estudio_id' => $this->request->getPost('programa_estudio'),
                'ciclo' => $this->request->getPost('ciclo'),
                'turno' => $this->request->getPost('turno'),
                'telefono' => $this->request->getPost('telefono'),
                'domicilio' => $this->request->getPost('domicilio'),
                'sexo' => $this->request->getPost('sexo'),
                'direccion_nac' => $this->request->getPost('direccion_nac'),
                'fecha_nac' => $this->request->getPost('fecha_nac'),
                'religion_id' => $this->request->getPost('religion'),
                'estado_civil_id' => $this->request->getPost('estado_civil'),
            ]);
            $alumnoModel = new Alumno();
            $alumnoId = $alumnoModel->crear($alumnoData);
            if (!$alumnoId)
                throw new \Exception("Error al crear Alumno");

            $db->transCommit();
            clear_datatable_cache('AlumnoFullInfo');
            return redirect()->to('/alumnos')->with('success', 'Alumno registrado con éxito');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function updateAlumno($id)
    {
        helper(['validation', 'input', 'cache']);
        $errors = runValidation('alumno_update', $this->request);

        if (!empty($errors))
            return redirect()->back()->withInput()->with('errors', $errors);

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $alumnoModel = new Alumno();
            $alumnoActual = $alumnoModel->obtenerPorId($id);

            if (!$alumnoActual)
                throw new \Exception("Alumno no encontrado");

            $alumnoData = normalize_input([
                'dni' => $this->request->getPost('dni'),
                'nombres' => $this->request->getPost('nombres'),
                'apellidos' => $this->request->getPost('apellidos'),
                'programa_estudio_id' => $this->request->getPost('programa_estudio'),
                'ciclo' => $this->request->getPost('ciclo'),
                'turno' => $this->request->getPost('turno'),
                'telefono' => $this->request->getPost('telefono'),
                'domicilio' => $this->request->getPost('domicilio'),
                'sexo' => $this->request->getPost('sexo'),
                'direccion_nac' => $this->request->getPost('direccion_nac'),
                'fecha_nac' => $this->request->getPost('fecha_nac'),
                'religion_id' => $this->request->getPost('religion'),
                'estado_civil_id' => $this->request->getPost('estado_civil'),
            ]);

            $alumnoModel->actualizar($id, $alumnoData);

            $db->transCommit();
            clear_datatable_cache('AlumnoFullInfo');
            return redirect()->to('/alumnos')->with('success', 'Alumno actualizado correctamente');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
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
            'data' => $alumnos
        ]);
    }
}
