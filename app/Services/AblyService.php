<?php

namespace App\Services;

use Ably\AblyRest;
use Ably\Models\ClientOptions;
use Ably\Models\TokenRequest;
use \Config\AblyConfig;

class AblyService
{
    protected $ably;
    protected $config;

    public function __construct()
    {
        $this->config = new AblyConfig();

        // Inicializar ClientOptions usando la clave de la config
        $options = new ClientOptions(['key' => $this->config->apiKey]);

        // Inicializar el SDK de Ably con el objeto Options
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
            $channel->publish($this->config->eventName, [
                'event_data' => $eventData,
                'timestamp' => date('Y-m-d H:i:s'),
            ]);
            return true;
        } catch (\Throwable $e) {
            log_message('error', 'Error Ably Publish: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Genera un TokenRequest seguro para el frontend.
     * @return \Ably\Models\TokenRequest|null 
     */
    public function createTokenRequest(): ?TokenRequest
    {
        try {
            $tokenParams = [
                'capability' => [
                    $this->config->channelName => ['subscribe']
                ],
                'clientId' => uniqid('user-'),
            ];
            return $this->ably->auth->createTokenRequest($tokenParams);

        } catch (\Throwable $e) {
            log_message('error', 'Error Ably Token Request - Falla del SDK: ' . $e->getMessage() . ' en línea ' . $e->getLine());
            return null;
        }
    }
}