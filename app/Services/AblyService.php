<?php

namespace App\Services;

use Ably\AblyRest;
use Ably\Models\ClientOptions;
use Ably\Models\TokenRequest;

class AblyService
{
    /**
     * @var \Ably\AblyRest
     */
    protected $ably;

    /**
     * @var \Config\AblyConfig
     */
    protected $config;

    public function __construct()
    {
        $this->config = new \Config\AblyConfig();

        // 1. Inicializar ClientOptions usando la clave de la config
        $options = new ClientOptions(['key' => $this->config->apiKey]);

        // 2. Inicializar el SDK de Ably con el objeto Options
        $this->ably = new AblyRest($options);
    }

    /**
     * Publica una actualización en el canal de dashboard.
     * @param string $data El contenido de la actualización.
     */
    public function publishUpdate(string $eventData): bool
    {
        try {
            $channel = $this->ably->channels->get($this->config->channelName);

            // Publica el evento con el nombre del evento y los datos.
            $channel->publish($this->config->eventName, [
                'event_data' => $eventData,
                'timestamp' => date('Y-m-d H:i:s'),
            ]);
            return true;
        } catch (\Throwable $e) {
            // Registrar el error para depuración
            log_message('error', 'Error Ably Publish: ' . $e->getMessage());
            return false;
        }
    }

    // En app/Services/AblyService.php

    /**
     * Genera un TokenRequest seguro para el frontend.
     * @return \Ably\Models\TokenRequest|null 
     */
    public function createTokenRequest(): ?TokenRequest
    {
        try {
            // 1. Usar un array asociativo simple, que el SDK maneja internamente.
            $tokenParams = [
                'capability' => [
                    $this->config->channelName => ['subscribe']
                ],
                'clientId' => uniqid('user-'), // ID único para el cliente
            ];

            // 2. Pasar el array asociativo al método. ¡Esto soluciona el error!
            return $this->ably->auth->createTokenRequest($tokenParams);

        } catch (\Throwable $e) {
            // Loguear el error real para futuras depuraciones
            log_message('error', 'Error Ably Token Request - Falla del SDK: ' . $e->getMessage() . ' en línea ' . $e->getLine());
            return null;
        }
    }
}