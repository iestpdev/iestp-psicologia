<?php

namespace App\Controllers;

use Config\AblyConfig;

class AblyTokenController extends BaseController
{
    /**
     * Genera un token de solicitud de Ably para que el cliente JS se conecte de forma segura.
     * El token solo permite 'subscribe' (suscripción) al canal.
     */
    public function getToken()
    {
        $config = new AblyConfig();

        // 1. Separar Key ID y Key Secret: el formato es 'ID:Secret'
        if (!str_contains($config->apiKey, ':')) {
            // Manejo de error si la clave no tiene el formato correcto.
            return $this->response->setStatusCode(500)->setJSON(['error' => 'Configuración de Ably incorrecta.']);
        }

        [$keyId, $keySecret] = explode(':', $config->apiKey, 2);

        // 2. Inicializar el cliente cURL para comunicarnos con el API REST de Ably
        $client = \Config\Services::curlrequest([
            'baseURI' => 'https://rest.ably.io',
            // La autenticación Basic se hace con el ID de la clave como usuario y el SECRET como password.
            'auth' => [$keyId, $keySecret, 'basic'],
            'timeout' => 5,
        ]);

        // 3. Definir las capacidades (IMPORTANTE: Solo 'subscribe' para el canal)
        $requestData = [
            'keyId' => $keyId,
            'capability' => json_encode([
                // Restringimos el token para que SOLO pueda suscribirse al canal.
                $config->channelName => ['subscribe']
            ]),
            'clientId' => uniqid('user-'), // Un ID de cliente único
            'timestamp' => time() * 1000,
        ];

        try {
            $response = $client->post('/keys/' . $keyId . '/requestTokens', [
                'json' => $requestData,
                'headers' => ['Content-Type' => 'application/json'],
            ]);

            $responseData = json_decode($response->getBody(), true);

            if ($response->getStatusCode() === 201 && isset($responseData['token'])) {
                // Devolvemos el token.
                return $this->response->setJSON(['token' => $responseData['token']]);
            }

            // Manejo de errores de Ably
            return $this->response->setStatusCode(401)->setJSON(['error' => 'No se pudo generar el token de Ably: ' . ($responseData['message'] ?? 'Error desconocido')]);

        } catch (\Throwable $e) {
            // **TEMPORAL: Cambiamos la respuesta para incluir el mensaje exacto de la excepción.**
            log_message('error', 'Ably Token Fatal Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());

            return $this->response->setStatusCode(500)->setJSON([
                'error' => 'Error interno al comunicarse con Ably.',
                // Esta línea nos dará la pista clave
                'debug_info' => 'Excepción: ' . $e->getMessage() . ' (Línea: ' . $e->getLine() . ')'
            ]);
        }
    }
}