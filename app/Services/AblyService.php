<?php

namespace App\Services;

class AblyService
{
    protected \Config\AblyConfig $config;
    protected \CodeIgniter\HTTP\CURLRequest $client;

    public function __construct()
    {
        $this->config = new \Config\AblyConfig();
        
        // Inicializa el cliente CURLRequest con la URL base y la autenticación
        $this->client = \Config\Services::curlrequest([
            'baseURI' => 'https://rest.ably.io',
            'auth' => [$this->config->apiKey, '', 'basic'], // [key, secret, type] -> basic auth con la API Key completa
            'timeout' => 5,
        ]);
    }

    /**
     * Publica un mensaje en el canal configurado de Ably.
     * @param string $context Un contexto para el mensaje (ej: 'citas', 'derivaciones', 'home')
     * @param string $message El mensaje a enviar (opcional)
     * @return bool
     */
    public function publishUpdate(string $context = 'general', string $message = 'Update needed'): bool
    {
        // El endpoint es /channels/{channelName}/messages
        $url = "/channels/{$this->config->channelName}/messages";
        
        $payload = [
            'name' => $this->config->eventName, // 'dashboard_update'
            'data' => [
                'context' => $context,
                'message' => $message,
                'timestamp' => time()
            ]
        ];

        try {
            $response = $this->client->post($url, [
                'json' => $payload, // Content-Type: application/json se maneja automáticamente
            ]);

            // Ably REST API devuelve 201 Created al publicar con éxito.
            return $response->getStatusCode() === 201;
        } catch (\Throwable $e) {
            // Loguea el error, pero no bloquea la ejecución de la app principal
            log_message('error', 'Ably Publish Error: ' . $e->getMessage());
            return false; 
        }
    }
}