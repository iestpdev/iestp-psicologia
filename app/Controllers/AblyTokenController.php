<?php

namespace App\Controllers;

use App\Services\AblyService;
use CodeIgniter\Controller;

class AblyTokenController extends Controller
{
    /**
     * Genera un token request seguro para que el cliente (frontend)
     */
    public function getToken()
    {
        $service = new AblyService();
        $tokenRequest = $service->createTokenRequest();

        if ($tokenRequest === null) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Fallo interno al generar el token de autenticación.',
            ]);
        }
        $tokenArray = json_decode(json_encode($tokenRequest), true);
        return $this->response->setJSON($tokenArray);
    }
}