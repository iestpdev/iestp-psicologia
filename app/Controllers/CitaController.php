<?php

namespace App\Controllers;

use App\Models\Alumno;
use App\Models\Derivacion;
use App\Models\Mantenimiento\ProgramaEstudio;
use App\Models\Usuario;

class CitaController extends BaseController
{
    public function index(): string
    {
        return view('modules/citas/index');
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

    public function editar($usuarioId): string
    {
        return view('modules/citas/editar');
    }

    public function generarAsistidasPdf()
    {
        $fechaFiltro = $this->request->getPost('fechaFiltro');
        if (empty($fechaFiltro)) return $this->response->setStatusCode(400)->setBody('Selecciona un mes y año');

        [$year, $month] = explode('-', $fechaFiltro);

        $db = \Config\Database::connect();
        $builder = $db->table('view_citas_full_info');
        $builder->where("asistencia = 'ASISTIDO' AND MONTH(atencion_fech) = $month AND YEAR(atencion_fech) = $year", null, false);

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
}
