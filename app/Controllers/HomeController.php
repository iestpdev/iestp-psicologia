<?php

namespace App\Controllers;

use App\Models\Cita;
use App\Models\Derivacion;

class HomeController extends BaseController
{
    public function index(): string
    {
        $session = session();
        $user = $session->get('user');

        $citaModel = new Cita();
        
        if ($user && $user['rol'] === 'PSICOLOGO') {
            $data['citas'] = $citaModel->obtenerPendientes($user['id']);
        } else {
            $data['citas'] = $citaModel->obtenerPendientes();
        }

        $derivacionModel = new Derivacion();
        $data['derivaciones'] = $derivacionModel->obtenerPendientesParaHome();
        return view('modules/home/index', $data);
    }
}
