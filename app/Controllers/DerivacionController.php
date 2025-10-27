<?php

namespace App\Controllers;

use App\Models\Alumno;
use App\Models\Cita;
use App\Models\Derivacion;
use App\Models\Mantenimiento\ProgramaEstudio;
use App\Models\Notificacion;
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

        $alumnoId = $this->request->getGet('alumnoId');
        $data['alumnoEnviado'] = $alumnoId ? (int) $alumnoId : null;

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
        $derivacionEncontrada = $derivacionModel->obtenerPorId((int) $derivacionId);

        if ($derivacionEncontrada['estado']) {
            $citaModel = new Cita();
            $citaEncontrada = $citaModel->obtenerPorDerivacionId((int) $derivacionId);
            return $this->response->setJSON([
                'derivacion' => $derivacionEncontrada,
                'cita' => $citaEncontrada
            ]);
        }

        return $this->response->setJSON([
            'derivacion' => $derivacionEncontrada
        ]);
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
        helper(['validation', 'input']);
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

            $derivacion = $derivacionModel->obtenerPorId($derivacionId);

            $notificacionModel = new Notificacion();
            $notificacionModel->crear([
                "tipoNotificacion" => "CREACIÓN",
                "entidad" => "DERIVACIÓN",
                "emisor" => $this->request->getPost('docente'),
                "receptor" => null,
                "descripcion" => "El docente {$derivacion['docente_nombres_completos']} ha derivado al alumno {$derivacion['alumno_nombres_completos']}",
                "leido" => false
            ]);

            return redirect()->to('/derivaciones')->with('success', 'Derivación registrada con éxito');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function updateDerivacion($id)
    {
        helper(['validation', 'input']);
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
            return redirect()->to('/derivaciones')->with('success', 'Derivación actualizada correctamente');
        } catch (\Throwable $e) {
            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function deleteDerivacion($id)
    {
        $derivacionModel = new Derivacion();
        try {
            $derivacion = $derivacionModel->obtenerPorId($id);
            if (!$derivacion)
                throw new \Exception("Derivación no encontrada");

            if (!$derivacionModel->eliminar($id))
                throw new \Exception("Error al eliminar Derivación");

            return redirect()->to('/derivaciones')->with('success', 'Derivación eliminada correctamente');
        } catch (\Throwable $e) {
            return redirect()->to('/derivaciones')->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

}
