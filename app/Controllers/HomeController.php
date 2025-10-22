<?php

namespace App\Controllers;

use App\Models\Cita;
use App\Models\Derivacion;

class HomeController extends BaseController
{
    public function index(): string
    {
        $citaModel = new Cita();
        $data['citas'] = $citaModel->obtenerPendientes();

        $derivacionModel = new Derivacion();
        $data['derivaciones'] = $derivacionModel->obtenerPendientesParaHome();
        return view('modules/home/index', $data);
    }
}
