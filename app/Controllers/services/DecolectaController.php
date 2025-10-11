<?php

namespace App\Controllers\services;

use App\Services\DecolectaService;
use App\Controllers\BaseController;

class DecolectaController extends BaseController
{
    public function getDataByDni($dni)
    {
        try {
            $decolecta = new DecolectaService();
            $data = $decolecta->consultarDni($dni);

            return $this->response->setJSON($data);
        } catch (\Throwable $e) {
            return $this->response->setStatusCode(500)
                ->setJSON(['error' => $e->getMessage()]);
        }
    }
}
