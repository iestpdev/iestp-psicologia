<?php

namespace App\Services;

use CodeIgniter\Config\Services;
use Config\TextBeeConfig;

/**
 * Servicio para el envío de mensajes SMS utilizando la API de TextBee.dev.
 */
class SmsService
{
    /**
     * Configuración del servicio TextBee.
     *
     * @var TextBeeConfig
     */
    protected $config;

    public function __construct()
    {
        $this->config = config(TextBeeConfig::class);
    }

    /**
     * Envía un mensaje SMS a uno o varios destinatarios mediante la API de TextBee.
     *
     * @param string|array $recipients Número(s) de teléfono en formato E.164 
     *                                (ejemplo: "+51924747851" o array de números).
     * @param string $message Contenido del mensaje a enviar.
     * @return bool True si el SMS se envió correctamente, False si falló la solicitud o conexión.
     */
    public function sendSms($recipients, string $message): bool
    {
        // Normalizar destinatarios a un array
        if (!is_array($recipients)) {
            $recipients = [$recipients];
        }

        // URL completa del endpoint
        $url = $this->config->apiUrl;

        // Cuerpo de la solicitud
        $body = [
            'recipients' => $recipients,
            'message'    => $message,
        ];

        try {
            $client = Services::curlrequest([
                'baseURI' => $this->config->apiUrl,
                'timeout' => 5,
            ]);

            // Enviar la solicitud POST
            $response = $client->post($url, [
                'headers' => [
                    'Content-Type' => 'application/json',
                    'x-api-key'    => $this->config->apiKey,
                ],
                'json' => $body,
            ]);

            // Verificar el código de estado (200 OK, 201 Created)
            if ($response->getStatusCode() >= 200 && $response->getStatusCode() < 300) {
                log_message('info', 'SMS enviado exitosamente a: ' . implode(', ', $recipients));
                return true;
            }

            // Registrar el fallo de la API
            log_message('error', 'Fallo al enviar SMS. Código de estado: ' . $response->getStatusCode() . '. Respuesta: ' . $response->getBody());
            return false;

        } catch (\Exception $e) {
            log_message('critical', 'Error fatal al conectar con TextBee API: ' . $e->getMessage());
            return false;
        }
    }
}