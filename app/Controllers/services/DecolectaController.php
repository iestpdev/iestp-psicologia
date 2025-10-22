<?php

namespace App\Controllers\Services;

use App\Services\DecolectaService;
use App\Controllers\BaseController;

class DecolectaController extends BaseController
{
    public function getDataByDni(string $dni)
    {
        $service = new DecolectaService();
        $result = $service->consultarDni($dni);

        return $this->response
            ->setStatusCode($result['status'])
            ->setJSON($result['data'] ?? ['error' => $result['error'] ?? 'Error desconocido']);
    }
}
