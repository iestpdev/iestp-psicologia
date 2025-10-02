<?php

namespace App\Controllers;

use App\Models\Alumno;
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
}
