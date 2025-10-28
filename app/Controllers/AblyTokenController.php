<?php

namespace App\Controllers;

use App\Services\AblyService;
use CodeIgniter\Controller;

class AblyTokenController extends Controller
{
    /**
     * Genera un token request seguro para que el cliente (frontend)
     * pueda conectarse a Ably sin exponer la clave API.
     */
    // En app/Controllers/AblyTokenController.php, dentro de getToken()

    public function getToken()
    {
        $service = new AblyService();
        $tokenRequest = $service->createTokenRequest();

        if ($tokenRequest === null) {
            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Fallo interno al generar el token de autenticación. Revisa los logs de CodeIgniter.',
            ]);
        }

        // 💡 SOLUCIÓN ROBUSTA: Convertir el objeto TokenRequest a array asociativo simple.
        $tokenArray = json_decode(json_encode($tokenRequest), true);

        // Devolver el array convertido a JSON (que es lo que el frontend espera)
        return $this->response->setJSON($tokenArray);
    }
}