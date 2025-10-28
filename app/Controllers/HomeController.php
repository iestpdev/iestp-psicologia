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

    public function getHomeData()
    {
        $session = session();
        $user = $session->get('user');

        $citaModel = new Cita();

        if($user && $user['rol'] === 'PSICOLOGO') {
            $citas = $citaModel->obtenerPendientes($user['id']);
        } else {
            $citas = $citaModel->obtenerPendientes();
        }

        $derivacionModel = new Derivacion();
        $derivaciones = $derivacionModel->obtenerPendientesParaHome();

        return $this->response->setJSON([
            'citas' => $citas,
            'derivaciones' => $derivaciones,
            'citas_count' => count($citas),
            'derivaciones_count' => count($derivaciones)
        ]);
    }
}
