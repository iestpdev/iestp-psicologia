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

    public function editar($usuarioId): string
    {
        return view('modules/derivaciones/editar');
    }

    public function obtenerPorId($derivacionId)
    {
        $derivacionModel = new Derivacion();
        return $this->response->setJSON($derivacionModel->getById((int)$derivacionId));
    }

    public function obtenerPendientes()
    {
        $derivacionModel = new Derivacion();
        $pendientes = $derivacionModel->obtenerPendientes();

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $pendientes
        ]);
    }

    public function saveDerivacion()
    {
        helper('validation');
        $errors = runValidation('derivacion_create', $this->request);
        if (!empty($errors)) return redirect()->to('/derivaciones/crear')->withInput()->with('errors', $errors);

        try {
            $derivacionModel = new Derivacion();
            $derivacionId = $derivacionModel->crear([
                'usuario_id' => $this->request->getPost('docente'),
                'alumno_id'  => $this->request->getPost('alumno'),
                'motivo'     => $this->request->getPost('motivo'),
                'urgencia'   => $this->request->getPost('urgencia'),
                'recibido'   => false
            ]);

            if (!$derivacionId) throw new \Exception("Error al registrar la derivación");
            return redirect()->to('/derivaciones')->with('success', 'Derivación registrada con éxito');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }
}
