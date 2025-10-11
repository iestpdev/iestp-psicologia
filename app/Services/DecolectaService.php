<?php

namespace App\Services;

use Config\Services;

class DecolectaService
{
    private string $baseUrl;
    private string $token;

    public function __construct()
    {
        $this->baseUrl = 'https://api.decolecta.com/v1/';
        $this->token = getenv('DECOLECTA_TOKEN');
    }

    public function consultarDni(string $dni)
    {
        $cacheKey = "decolecta_dni_{$dni}";
        $cache = cache($cacheKey);

        if ($cache !== null) {
            return $cache;
        }

        $client = Services::curlrequest();
        $url = $this->baseUrl . 'reniec/dni?numero=' . $dni;

        $response = $client->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $this->token,
                'Accept' => 'application/json',
            ],
        ]);

        if ($response->getStatusCode() !== 200) {
            throw new \RuntimeException('Error en la API RENIEC: ' . $response->getStatusCode());
        }

        $data = json_decode($response->getBody(), true);
        cache()->save($cacheKey, $data, 2592000); // 30 dias

        return $data;
    }
}
