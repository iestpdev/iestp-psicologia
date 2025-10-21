<?php

namespace App\Controllers;

use App\Models\Alumno;
use App\Models\Derivacion;
use App\Models\Mantenimiento\ProgramaEstudio;
use App\Models\Usuario;

class DerivacionController extends BaseController
{
    public function index(): string
    {
        return view('modules/derivaciones/index');
    }

    public function crear(): string
    {
        $usuarioModel = new Usuario();
        $data['docentes'] = $usuarioModel->obtenerDocentes();

        $programaEstudioModel = new ProgramaEstudio();
        $data['programaEstudios'] = $programaEstudioModel->listar();

        $alumnoModel = new Alumno();
        $data['alumnos'] = $alumnoModel->obtenerAlumnos();

        return view('modules/derivaciones/crear', $data);
    }

    public function editar($derivacionId): string
    {
        $usuarioModel = new Usuario();
        $data['docentes'] = $usuarioModel->obtenerDocentes();

        $programaEstudioModel = new ProgramaEstudio();
        $data['programaEstudios'] = $programaEstudioModel->listar();

        $alumnoModel = new Alumno();
        $data['alumnos'] = $alumnoModel->obtenerAlumnos();

        $derivacionModel = new Derivacion();
        $data['derivacion'] = $derivacionModel->obtenerPorId($derivacionId);

        return view('modules/derivaciones/editar', $data);
    }

    public function obtenerPorId($derivacionId)
    {
        $derivacionModel = new Derivacion();
        return $this->response->setJSON($derivacionModel->obtenerPorId((int) $derivacionId));
    }

    public function obtenerPendientes()
    {
        $derivacionModel = new Derivacion();
        $pendientes = $derivacionModel->obtenerPendientes();

        return $this->response->setJSON([
            'status' => 'success',
            'data' => $pendientes
        ]);
    }

    public function saveDerivacion()
    {
        helper(['validation', 'input', 'cache']);
        $errors = runValidation('derivacion_create', $this->request);
        if (!empty($errors))
            return redirect()->to('/derivaciones/crear')->withInput()->with('errors', $errors);

        try {
            $derivacionData = normalize_input([
                'usuario_id' => $this->request->getPost('docente'),
                'alumno_id' => $this->request->getPost('alumno'),
                'motivo' => $this->request->getPost('motivo'),
                'urgencia' => $this->request->getPost('urgencia'),
                'recibido' => false
            ]);
            $derivacionModel = new Derivacion();
            $derivacionId = $derivacionModel->crear($derivacionData);

            if (!$derivacionId)
                throw new \Exception("Error al registrar la derivación");
            clear_datatable_cache('DerivacionFullInfo');
            return redirect()->to('/derivaciones')->with('success', 'Derivación registrada con éxito');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function updateDerivacion($id)
    {
        helper(['validation', 'input', 'cache']);
        $errors = runValidation('derivacion_update', $this->request);
        if (!empty($errors))
            return redirect()->back()->withInput()->with('errors', $errors);

        try {
            $derivacionModel = new Derivacion();
            $derivacionActual = $derivacionModel->obtenerPorId($id);
            if (!$derivacionActual)
                throw new \Exception("Derivación no encontrada");

            if ($derivacionActual['estado'])
                throw new \Exception("No se puede editar una derivación que ya fue recibida");

            $data = normalize_input([
                'usuario_id' => $this->request->getPost('docente'),
                'alumno_id' => $this->request->getPost('alumno'),
                'motivo' => $this->request->getPost('motivo'),
                'urgencia' => $this->request->getPost('urgencia'),
            ]);

            $derivacionModel->actualizar($id, $data);
            clear_datatable_cache('DerivacionFullInfo');
            return redirect()->to('/derivaciones')->with('success', 'Derivación actualizada correctamente');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function deleteDerivacion($id)
    {
        helper('cache');

        $derivacionModel = new Derivacion();
        try {
            $derivacion = $derivacionModel->obtenerPorId($id);
            if (!$derivacion)
                throw new \Exception("Derivación no encontrada");

            if (!$derivacionModel->eliminar($id))
                throw new \Exception("Error al eliminar Derivación");

            clear_datatable_cache('DerivacionFullInfo');
            return redirect()->to('/derivaciones')->with('success', 'Derivación eliminada correctamente');
        } catch (\Throwable $e) {
            return redirect()->to('/derivaciones')->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

}
