<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

/**
 * Configuración para el servicio de envío de SMS TextBee.dev.
 */
class TextBeeConfig extends BaseConfig
{
    /**
     * ID del dispositivo (tu teléfono) registrado en TextBee.
     * @var string
     */
    public string $deviceId = '';

    /**
     * Clave de API proporcionada por TextBee para autenticación.
     * @var string
     */
    public string $apiKey = '';

    /**
     * URL base de la API de TextBee.
     * @var string
     */
    public string $apiUrl = '';

    public function __construct()
    {
        parent::__construct();

        $this->deviceId = env('textbee.deviceId', '');
        $this->apiKey = env('textbee.apiKey', '');
        $this->apiUrl = "https://api.textbee.dev/api/v1/gateway/devices/{$this->deviceId}/send-sms";
    }
}
