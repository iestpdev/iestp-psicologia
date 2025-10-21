<?php

namespace App\Controllers;

use App\Models\Alumno;
use App\Models\Cita;
use App\Models\Derivacion;
use App\Models\DetalleCita;
use App\Models\Familiar;
use App\Models\Mantenimiento\ProgramaEstudio;
use App\Models\Usuario;

class CitaController extends BaseController
{
    public function index(): string
    {
        return view('modules/citas/index');
    }

    public function infoCita($citaId): string
    {
        $citaModel = new Cita();
        $citaEncontrada = $citaModel->obtenerPorId($citaId);
        if (!$citaEncontrada) {
            return view('errors/html/error_404', [
                'message' => 'Cita no encontrada'
            ]);
        }
        $data['cita'] = $citaEncontrada;

        $alumnoModel = new Alumno();
        $data['alumno'] = $alumnoModel->obtenerPorId($citaEncontrada['alumno_id']);

        $usuarioModel = new Usuario();
        $data['usuario'] = $usuarioModel->obtenerPorId($citaEncontrada['usuario_id']);

        if ($citaEncontrada['familiar_id']) {
            $familiarModel = new Familiar();
            $data['familiar'] = $familiarModel->obtenerPorId($citaEncontrada['familiar_id']);
        }

        if ($citaEncontrada['derivacion_id']) {
            $derivacionModel = new Derivacion();
            $data['derivacion'] = $derivacionModel->obtenerPorId($citaEncontrada['derivacion_id']);
        }

        if($citaEncontrada['asistencia']==='ASISTIDO') {
            $detalleCitaModel = new DetalleCita();
            $data['detalleCita'] = $detalleCitaModel->obtenerPorCitaId($citaEncontrada['id']);
        }

        return view('modules/citas/details', $data);
    }

    public function crear(): string
    {
        $usuarioModel = new Usuario();
        $data['psicologos'] = $usuarioModel->obtenerPsicologos();

        $programaEstudioModel = new ProgramaEstudio();
        $data['programaEstudios'] = $programaEstudioModel->listar();

        $alumnoModel = new Alumno();
        $data['alumnos'] = $alumnoModel->obtenerAlumnos();

        $derivacionModel = new Derivacion();
        $data['derivaciones_pendientes'] = $derivacionModel->obtenerPendientes();

        return view('modules/citas/crear', $data);
    }

    public function editar($citaId): string
    {
        $citaModel = new Cita();
        $citaEncontrada = $citaModel->obtenerPorId($citaId);
        if (!$citaEncontrada) {
            return view('errors/html/error_404', [
                'message' => 'Cita no encontrada'
            ]);
        }
        $data['cita'] = $citaEncontrada;

        $alumnoModel = new Alumno();
        $alumnoEncontrado = $alumnoModel->obtenerPorId($citaEncontrada['alumno_id']);
        $data['alumno'] = $alumnoEncontrado;

        if ($citaEncontrada['familiar_id']) {
            $familiarModel = new Familiar();
            $data['familiares'] = $familiarModel->listarPorAlumnoId($alumnoEncontrado['id']);
        }

        if ($citaEncontrada['derivacion_id']) {
            $derivacionModel = new Derivacion();
            $data['derivacion'] = $derivacionModel->obtenerPorId($citaEncontrada['derivacion_id']);
        }

        $usuarioModel = new Usuario();
        $data['psicologos'] = $usuarioModel->obtenerPsicologos();

        return view('modules/citas/editar', $data);
    }

    public function generarAsistidasPdf()
    {
        $fechaFiltro = $this->request->getPost('fechaFiltro');
        if (empty($fechaFiltro))
            return $this->response->setStatusCode(400)->setBody('Selecciona un mes y año');

        [$year, $month] = explode('-', $fechaFiltro);

        $db = \Config\Database::connect();
        $builder = $db->table('view_citas_full_info');
        $builder->where("asistencia = 'ASISTIDO' AND MONTH(atencion_fech) = $month AND YEAR(atencion_fech) = $year", null, false);
        $builder->where('deleted_at', null);
        $rows = $builder->get()->getResultArray();

        $data = [
            'estilos' => view('reports/estilos'),
            'rows' => $rows,
            'year' => $year,
            'month' => $month,
        ];

        $html = view('reports/citas/reporteCitasAsistidas', $data);

        try {
            $html2pdf = new \Spipu\Html2Pdf\Html2Pdf('P', 'A4', 'es', true, 'UTF-8', [10, 10, 10, 10]);
            $html2pdf->writeHTML($html);
            $this->response->setHeader('Content-Type', 'application/pdf');
            $html2pdf->output('Reporte-citas-asistidas.pdf');
            exit();
        } catch (\Spipu\Html2Pdf\Exception\Html2PdfException $e) {
            if (isset($html2pdf)) {
                $html2pdf->clean();
            }
            $formatter = new \Spipu\Html2Pdf\Exception\ExceptionFormatter($e);
            return $this->response->setStatusCode(500)->setBody($formatter->getMessage());
        }
    }

    public function saveCita()
    {
        helper(['validation', 'input', 'cache']);
        $errors = runValidation('cita_create', $this->request);
        if (!empty($errors))
            return redirect()->to('/citas/crear')->withInput()->with('errors', $errors);

        $asistencia = $this->request->getPost('asistencia');
        $tipoDerivacion = $this->request->getPost('tipo_derivacion');
        $derivacionId = $this->request->getPost('derivacion');
        $derivacionModel = new Derivacion();
        $derivacionEncontrada = null;

        if ($derivacionId)
            $derivacionEncontrada = $derivacionModel->obtenerPorId($derivacionId);

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $citaData = normalize_input([
                'tipo_derivacion' => $tipoDerivacion,
                'usuario_id' => $this->request->getPost('usuario_id'), //psicologo(a)
                'atencion_fech' => $this->request->getPost('fecha_atencion'),
                'hora_inicio' => $this->request->getPost('hora_inicio'),
                'hora_fin' => $this->request->getPost('hora_fin'),
                'motivo' => $this->request->getPost('motivo'),
                'familiar_id' => $this->request->getPost('familiar'),
                'derivacion_id' => $derivacionId,
                'alumno_id' => $derivacionEncontrada ? $derivacionEncontrada['alumno_id'] : $this->request->getPost('alumno'),
                'asistencia' => $asistencia,
            ]);
            $citaModel = new Cita();
            $citaId = $citaModel->crear($citaData);
            if (!$citaId)
                throw new \Exception("Error al crear Consulta");

            if ($derivacionEncontrada && isset($derivacionEncontrada['id'])) {
                $derivacionModel->marcarComoRecibido($derivacionEncontrada['id']);
            }

            if ($asistencia == 'ASISTIDO') {
                $detalleCitaData = normalize_input([
                    'cita_id' => $citaId,
                    'problema' => $this->request->getPost('problema'),
                    'recomendacion' => $this->request->getPost('recomendacion'),
                    'aspecto_fisico' => $this->request->getPost('aspecto_fisico'),
                    'aseo_personal' => $this->request->getPost('aseo_personal'),
                    'conducta' => $this->request->getPost('conducta'),
                ]);
                $detalleCitaModel = new DetalleCita();
                $detalleCitaId = $detalleCitaModel->crear($detalleCitaData);
                if (!$detalleCitaId)
                    throw new \Exception("Error al crear los detalles de la cita");
            }

            $db->transCommit();
            clear_datatable_cache('CitaFullInfo');
            return redirect()->to(uri: '/citas')->with('success', 'Consulta registrada con éxito');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }

    public function updateCita($id)
    {
        helper(['validation', 'input', 'cache']);
        $errors = runValidation('cita_update', $this->request);
        if (!empty($errors))
            return redirect()->back()->withInput()->with('errors', $errors);

        $asistencia = $this->request->getPost('asistencia');

        $db = \Config\Database::connect();
        $db->transBegin();

        try {
            $citaModel = new Cita();
            $citaActual = $citaModel->obtenerPorId($id);

            if (!$citaActual)
                throw new \Exception("Cita no encontrada");
            if ($citaActual['asistencia'] === 'ASISTIDO')
                throw new \Exception("No puedes editar una Consulta ya asistida");

            $data = normalize_input([
                'usuario_id' => $this->request->getPost('usuario_id'),
                'atencion_fech' => $this->request->getPost('fecha_atencion'),
                'hora_inicio' => $this->request->getPost('hora_inicio'),
                'hora_fin' => $this->request->getPost('hora_fin'),
                'motivo' => $this->request->getPost('motivo'),
                'asistencia' => $asistencia,
            ]);
            $citaModel->actualizar($id, $data);

            if ($asistencia === 'ASISTIDO') {
                $detalleCitaModel = new DetalleCita();

                $detalleData = normalize_input([
                    'problema' => $this->request->getPost('problema'),
                    'recomendacion' => $this->request->getPost('recomendacion'),
                    'aspecto_fisico' => $this->request->getPost('aspecto_fisico'),
                    'aseo_personal' => $this->request->getPost('aseo_personal'),
                    'conducta' => $this->request->getPost('conducta'),
                ]);
                $detalleData['cita_id'] = $id;
                $detalleCitaModel->crear($detalleData);
            }

            $db->transCommit();
            clear_datatable_cache('CitaFullInfo');
            return redirect()->to('/citas')->with('success', 'Consulta actualizada con éxito');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->back()->withInput()->with('error', 'Error al actualizar: ' . $e->getMessage());
        }
    }

    public function deleteCita($id)
    {
        helper('cache');

        $db = \Config\Database::connect();
        $db->transBegin();
        try {
            $citaModel = new Cita();
            $cita = $citaModel->obtenerPorId($id);
            if (!$cita)
                throw new \Exception("Consulta no encontrada");

            if (!$citaModel->eliminar($id))
                throw new \Exception("Error al eliminar Consulta");

            $db->transCommit();
            clear_datatable_cache('CitaFullInfo');
            return redirect()->to('/citas')->with('success', 'Consulta eliminada correctamente');
        } catch (\Throwable $e) {
            $db->transRollback();
            return redirect()->to('/citas')->with('error', 'Hubo un error: ' . $e->getMessage());
        }
    }
}