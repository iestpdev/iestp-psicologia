<?php

namespace App\Services;

use Config\Services;
use CodeIgniter\HTTP\Exceptions\HTTPException;

class DecolectaService
{
    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        $this->baseUrl = 'https://api.decolecta.com/v1/';
        $this->token = getenv('DECOLECTA_TOKEN');
    }

    public function consultarDni(string $dni): array
    {
        $cacheKey = "decolecta_dni_{$dni}";
        $cache = cache($cacheKey);

        if ($cache !== null) {
            return [
                'status' => 200,
                'data' => $cache,
                'fromCache' => true,
            ];
        }

        $client = Services::curlrequest();
        $url = $this->baseUrl . 'reniec/dni?numero=' . $dni;

        try {
            $response = $client->get($url, [
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->token,
                    'Accept' => 'application/json',
                ],
                'http_errors' => false,
            ]);

            $statusCode = $response->getStatusCode();
            $body = json_decode($response->getBody(), true);

            switch ($statusCode) {
                case 200:
                    cache()->save($cacheKey, $body, 2592000); // 30 días
                    return [
                        'status' => 200,
                        'data' => $body,
                    ];

                case 404:
                    return [
                        'status' => 404,
                        'error' => 'DNI no encontrado en RENIEC',
                    ];

                case 401:
                case 403:
                    return [
                        'status' => 401,
                        'error' => 'Token inválido o expirado',
                    ];

                default:
                    return [
                        'status' => 502,
                        'error' => "Error en la API Decolecta (código {$statusCode})",
                    ];
            }
        } catch (\Throwable $e) {
            return [
                'status' => 500,
                'error' => 'Error de conexión con Decolecta: ' . $e->getMessage(),
            ];
        }
    }
}
