<?php

namespace App\Controllers;

use App\Models\Familiar;

class FamiliarController extends BaseController
{
    public function listarPorAlumnoId($alumnoId)
    {
        $familiarModel = new Familiar();
        return $this->response->setJSON($familiarModel->listarPorAlumnoId((int)$alumnoId));
    }
}
